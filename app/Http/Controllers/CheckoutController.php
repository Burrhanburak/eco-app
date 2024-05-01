<?php

namespace App\Http\Controllers;

use App\Models\InvoiceDetail;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\IyzicoAddressHelper;
use App\Helpers\IyzicoBuyerHelper;
use App\Helpers\IyzicoOptionsHelper;
use App\Helpers\IyzicoPaymentCardHelper;
use App\Helpers\IyzicoRequestHelper;
use App\Models\Cart;
use App\Models\CreditCard;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\UserDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Payment;
use Iyzipay\Model\ThreedsInitialize;

class CheckoutController extends Controller
{/**
 * Shows the payment form
 *
 * @return View
 */
    public function showCheckoutForm(): View
    {
        return view("frontend.cart.checkout_form");
    }

    public function checkout(Request $request): \Illuminate\Http\Response
    {
        $creditCard = new CreditCard();
        $data = $request->only($creditCard->getFillable());
        $creditCard->fill($data);

        // Kullanıcıyı al
        $user = Auth::user();
        // Sepetteki ürünlerin toplam tutarını hesapla
        $total = $this->calculateCartTotal();

        // Sepeti getir
        $cart = $this->getOrCreateCart();
        \Illuminate\Support\Facades\Log::info('Chechout Sepet oluşturuldu: ' . $cart);

        // Ödeme isteği oluştur
        $request = IyzicoRequestHelper::createRequest($cart, $total);
        $request->setCallbackUrl(URL::route('checkout.threeds.callback'));
        // PaymentCard Nesnesini oluştur.
        $paymentCard = IyzicoPaymentCardHelper::getPaymentCard($creditCard);
        $request->setPaymentCard($paymentCard);

        // Buyer nesnesini oluştur
        $buyer = IyzicoBuyerHelper::getBuyer();
        $request->setBuyer($buyer);


        // Kargo adresi nesnelerini oluştur.
        $shippingAddress = IyzicoAddressHelper::getAddress();
        $request->setShippingAddress($shippingAddress);

        // Fatura adresi nesnelerini oluştur.
        $billingAddress = IyzicoAddressHelper::getAddress();
        $request->setBillingAddress($billingAddress);

//        // Kargo adresi nesnelerini oluştur.
//        $shippingAddress = IyzicoAddressHelper::getAddress();
//        $request->setShippingAddress($shippingAddress);
//
//        // Fatura adresi nesnelerini oluştur.
//        $billingAddress = IyzicoAddressHelper::getAddress();
//        $request->setBillingAddress($billingAddress);

        // Sepetteki ürünleri (CartDetails) BasketItem listesi olarak hazırla
        $basketItems = $this->getBasketItems();
        $request->setBasketItems($basketItems);

        //Options Nesnesi Oluştur
        $options = IyzicoOptionsHelper::getTestOptions();


        try {
           // Make the payment request with 3D Secure
            $payment = Payment::create($request, $options);

            $threedsInitialize = ThreedsInitialize::create($request, $options);


            if ($payment->getStatus() != 'success' ) {

//                $this->finalizeCart($cart);
//                $order = $this->createOrderWithDetails($cart);
//                $this->createInvoiceWithDetails($order);
                // Redirect to 3D Secure page (provided by Iyzico)
                $redirectUrl = $threedsInitialize->getHtmlContent();
                return response($redirectUrl);
            } else {
                return response($threedsInitialize->getErrorMessage(), 500);
            }
        }
          catch (\Exception $e) {
            Log::error($e->getMessage());
            return response($e->getMessage(), 500);
        }

    }
    public function iyzicoCallback(Request $httpRequest)
    {
        // Kullanıcıyı al
        $user = Auth::user();

        // Sepeti getir
        $cart = $this->getOrCreateCart();
        \Illuminate\Support\Facades\Log::info('İyziCallback cart : ' . $cart);
        try {
            // Retrieve the parameters sent by Iyzico callback
            $conversationId = $httpRequest->input('conversationId');
            $paymentId = $httpRequest->input('paymentId');
            $conversationData = $httpRequest->input('conversationData');

            // Create a request object for 3D Secure payment
            $threedsPaymentRequest = new \Iyzipay\Request\CreateThreedsPaymentRequest();
            $threedsPaymentRequest->setLocale(\Iyzipay\Model\Locale::TR);
            $threedsPaymentRequest->setConversationId($conversationId);
            $threedsPaymentRequest->setPaymentId($paymentId);
            $threedsPaymentRequest->setConversationData($conversationData);

            // Get options for the Iyzico request
            $options = IyzicoOptionsHelper::getTestOptions();

            // Make the 3D Secure payment request
            $threedsPayment = \Iyzipay\Model\ThreedsPayment::create($threedsPaymentRequest, $options);


            // Log the status of the payment
            Log::info('ThreedsPayment object: ', (array) $threedsPayment);

            if ($threedsPayment->getStatus() === 'success') {
                try {
                    Log::info('Creating order...');
                    $order = $this->createOrderWithDetails($cart);
                    Log::info('Order created successfully.');

                    Log::info('Creating invoice...');
                    $this->createInvoiceWithDetails($order);
                    Log::info('Invoice created successfully.');

                    Log::info('Finalizing cart...');
                    $this->finalizeCart($cart);
                    Log::info('Cart finalized successfully.');

                    return view("frontend.checkout.success", ["order" => $order]);
                } catch (\Exception $e) {
                    Log::error('Error in success block: ' . $e->getMessage());
                    return redirect()->route('payment.failure')->with('error', 'An error occurred while processing the payment.');
                }
            } else {
                // Payment failed, handle the failure scenario
                // Log the error or perform any necessary actions
                $errorMessage = $threedsPayment->getErrorMessage();
                return view("frontend.checkout.error", ["message" => $errorMessage]);
            }
        } catch (\Exception $e) {
            // Log any unexpected errors
            Log::error('Error in iyzico callback: ' . $e->getMessage());

            // Redirect the user to a failure page or return an error response
            return redirect()->route('payment.failure')->with('error', 'An unexpected error occurred');
        }
    }



    private function calculateCartTotal(): float
    {
        $total = 0;
        $cart = $this->getOrCreateCart();

        if ($cart) {
            $cartDetails = $cart->details;
            foreach ($cartDetails as $detail) {
                $total += $detail->product->price * $detail->quantity;
            }
        }

        return $total;
    }

    private function getOrCreateCart(): ?Cart
    {
        if (Auth::check()) {
            $user =  User::find(Auth::user()->id);
            $cart = Cart::firstOrCreate(
                ['user_id' => $user->id, 'is_active' => true],
                ['code' => Str::random(8)]
            );
            return $cart;
        }

        return null;
    }


    private function getBasketItems(): array
    {
        $basketItems = array();
        $cart = $this->getOrCreateCart();
        $cartDetails = $cart->details;



        foreach ($cartDetails as $detail) {
            $item = new BasketItem();
            $item->setId(optional($detail->product)->id);
            $item->setName(optional($detail->product)->name);
//            $item->setCategory1(optional('kazak', optional($detail->product)->category)->name);
            $category1 = optional($detail->product->category)->name ?? 'kazak';
            $item->setCategory1($category1);
            $item->setItemType(BasketItemType::PHYSICAL);
            $item->setPrice(optional($detail->product)->price);

            for ($i = 0; $i < $detail->quantity; $i++) {
                array_push($basketItems, $item);
            }
        }

        return $basketItems;
    }

    private function finalizeCart(Cart $cart)
    {
        $cart->is_active = false;
        // Remove all items from the cart
        $cart->details()->delete();
        $cart->save();
    }

    private function createOrderWithDetails(Cart $cart): Order
    {
        $order = new Order([
            "cart_id" => $cart->cart_id,
            "code" => $cart->code,
//            "shipping_price"=>$cart->shipping_price,
        ]);
//
//        dd($order);

        $order->save();



        foreach ($cart->details as $detail) {
//            dd($order->details());  buraya kesin bakılacak
            $order->details()->create([
                'order_id' => $order->order_id,
                'product_id' => $detail->product_id,
                'quantity' => $detail->quantity,
            ]);

        }

        return $order;
    }

    private function createInvoiceWithDetails(Order $order)
    {
        try {
            $invoice = Invoice::create([
                'order_id' => $order->order_id,
                'code' => $order->code,
            ]);

//            $invoiceId = $invoice->id;
//            dd($invoiceId);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
//        dd($invoice->details());
//        $invoice->save();
        //Fatura Detaylarını Ekle
        foreach ($order->details as $detail) {
            $invoice->details()->create([
                'invoice_id' => $invoice->id,
                'product_id' => $detail->product_id,
                'quantity' => $detail->quantity,
                'unit_price' => $detail->product->price,
                'total' => ($detail->quantity * $detail->product->price),
            ]);
        }
    }

}



