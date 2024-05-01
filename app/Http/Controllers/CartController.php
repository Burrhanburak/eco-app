<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private string $return_url = "/basket";

    public function index(): View
    {
        $cart = $this->getOrCreateCart();
        return view("frontend.cart.index", ["cart" => $cart]);
    }

    /**
     *
     * Lists the cart content
     *
     * @return Cart
     */
    private function getOrCreateCart(): Cart
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cart = Cart::firstOrCreate(
                ['user_id' => $user->id, 'is_active' => true],
                ['code' => Str::random(8)]
            );
            return $cart;
        } else {
            // Handle the case where the user is not authenticated
            // You might want to redirect them to the login page or take appropriate action
            // For now, I'll return a new Cart instance, but you should adjust this based on your application logic.
            return new Cart();
        }
    }

    /**
     * Add product as cart detail
     *
     * @param Product $product
     * @param int $quantity
     * @return RedirectResponse
     */
    public function add(Product $product, int $quantity = 1): RedirectResponse
    {

        try {
            $cart = $this->getOrCreateCart();

            // Log or dump values for debugging
            info('Product ID: ' . $product->product_id);
            info('Cart ID: ' . $cart->cart_id);

            $cartDetail = new CartDetail([

                'cart_id' => $cart->cart_id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
//            dd($cartDetail);
            $cart->details()->save($cartDetail);

            return redirect($this->return_url);
        } catch (\Exception $e) {
            dd($e->getMessage());

        }
    }


    public function remove(Request $request, CartDetail $cartDetail): RedirectResponse
    {
        try {

            $cartDetail->delete();
            return redirect($this->return_url);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function orders(): View
    {

        $orders = OrderDetail::with('product')->get();
        return view("frontend.cart.orders", ["orders" => $orders]);
    }
}
