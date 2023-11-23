<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\InvoiceDetail;
//use App\Models\OrderDetail;
//use Illuminate\Http\Request;
//use App\Helpers\IyzicoAddressHelper;
//use App\Helpers\IyzicoBuyerHelper;
//use App\Helpers\IyzicoOptionsHelper;
//use App\Helpers\IyzicoPaymentCardHelper;
//use App\Helpers\IyzicoRequestHelper;
//use App\Models\Cart;
//use App\Models\CreditCard;
//use App\Models\Invoice;
//use App\Models\Order;
//use App\Models\UserDetail;
//use Illuminate\Contracts\View\View;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Str;
//use Iyzipay\Model\BasketItem;
//use Iyzipay\Model\BasketItemType;
//use Iyzipay\Model\Payment;
//
//class CheckoutController extends Controller
//{/**
// * Shows the payment form
// *
// * @return View
// */
//    public function showCheckoutForm(): View
//    {
//        return view("frontend.cart.checkout_form");
//    }
//    public function checkout(Request $request): View
//    {
//        $creditCard = new CreditCard();
////        $data = $this->prepare($request, $creditCard->getFillable());
//        $data = $request->only($creditCard->getFillable());
//        $creditCard->fill($data);
//
//        // Kullanıcıyı al
//        $user = Auth::user();
//
//        // Sepetteki ürünlerin toplam tutarını hesapla
//        $total = $this->calculateCartTotal();
//
//        // Sepeti getir
//        $cart = $this->getOrCreateCart();
//
//
//        // Ödeme isteği oluştur
//        $request = IyzicoRequestHelper::createRequest($cart, $total);
//
//        // PaymentCard Nesnesini oluştur.
//        $paymentCard = IyzicoPaymentCardHelper::getPaymentCard($creditCard);
//        $request->setPaymentCard($paymentCard);
//
//        // Buyer nesnesini oluştur
//        $buyer = IyzicoBuyerHelper::getBuyer();
//        $request->setBuyer($buyer);
//
//        // Kargo adresi nesnelerini oluştur.
//        $shippingAddress = IyzicoAddressHelper::getAddress();
//        $request->setShippingAddress($shippingAddress);
//
//        // Fatura adresi nesnelerini oluştur.
//        $billingAddress = IyzicoAddressHelper::getAddress();
//        $request->setBillingAddress($billingAddress);
//
////        // Kargo adresi nesnelerini oluştur.
////        $shippingAddress = IyzicoAddressHelper::getAddress();
////        $request->setShippingAddress($shippingAddress);
////
////        // Fatura adresi nesnelerini oluştur.
////        $billingAddress = IyzicoAddressHelper::getAddress();
////        $request->setBillingAddress($billingAddress);
//
//        // Sepetteki ürünleri (CartDetails) BasketItem listesi olarak hazırla
//        $basketItems = $this->getBasketItems();
//        $request->setBasketItems($basketItems);
//
//        //Options Nesnesi Oluştur
//        $options = IyzicoOptionsHelper::getTestOptions();
//
//        // Ödeme yap
//        $payment = Payment::create($request, $options);
//
//        // İşlem başarılı ise sipariş ve fatura oluştur.
//        if ($payment->getStatus() == "success") {
//
//            // Sepeti sona erdir.
//            $this->finalizeCart($cart);
//
//            // Sipariş oluştur
//            $order = $this->createOrderWithDetails($cart);
//
//            //Fatura Oluştur
//            $this->createInvoiceWithDetails($order);
//
//            return view("frontend.checkout.success");
//
//        } else {
//            $errorMessage = $payment->getErrorMessage();
//            return view("frontend.checkout.error", ["message" => $errorMessage]);
//        }
//    }
//
//    private function calculateCartTotal(): float
//    {
//        $total = 0;
//        $cart = $this->getOrCreateCart();
//        $cartDetails = $cart->details;
//        foreach ($cartDetails as $detail) {
//            $total += $detail->product->price * $detail->quantity;
//        }
//
//        return $total;
//    }
//
//    private function getOrCreateCart(): Cart
//    {
//        $user = Auth::user();
//        $cart = Cart::firstOrCreate(
//            ['user_id' => $user->id, 'is_active' => true],
//            ['code' => Str::random(8)]
//        );
//        return $cart;
//    }
//
//    private function getBasketItems(): array
//    {
//        $basketItems = array();
//        $cart = $this->getOrCreateCart();
//        $cartDetails = $cart->details;
//
//
//
//        foreach ($cartDetails as $detail) {
//            $item = new BasketItem();
//            $item->setId(optional($detail->product)->id);
//            $item->setName(optional($detail->product)->name);
////            $item->setCategory1(optional('kazak', optional($detail->product)->category)->name);
//            $category1 = optional($detail->product->category)->name ?? 'kazak';
//            $item->setCategory1($category1);
//            $item->setItemType(BasketItemType::PHYSICAL);
//            $item->setPrice(optional($detail->product)->price);
//
//            for ($i = 0; $i < $detail->quantity; $i++) {
//                array_push($basketItems, $item);
//            }
//        }
//
//        return $basketItems;
//    }
//
//    private function finalizeCart(Cart $cart)
//    {
//        $cart->is_active = false;
//        $cart->save();
//    }
//
//    private function createOrderWithDetails(Cart $cart): Order
//    {
//        $order = new Order([
//            "cart_id" => $cart->cart_id,
//            "code" => $cart->code,
////            "shipping_price"=>$cart->shipping_price,
//        ]);
////
////        dd($order);
//
//        $order->save();
//
//
//
//        foreach ($cart->details as $detail) {
////            dd($order->details());  buraya kesin bakılacak
//            $order->details()->create([
//                'order_id' => $order->order_id,
//                'product_id' => $detail->product_id,
//                'quantity' => $detail->quantity,
//            ]);
//
//        }
//
//        return $order;
//    }
//
//    private function createInvoiceWithDetails(Order $order)
//    {
//        try {
//            $invoice = Invoice::create([
//                'order_id' => $order->order_id,
//                'code' => $order->code,
//            ]);
//
////            $invoiceId = $invoice->id;
////            dd($invoiceId);
//        } catch (\Exception $e) {
//            dd($e->getMessage());
//        }
////        dd($invoice->details());
////        $invoice->save();
//        //Fatura Detaylarını Ekle
//        foreach ($order->details as $detail) {
//            $invoice->details()->create([
//                'invoice_id' => $invoice->id,
//                'product_id' => $detail->product_id,
//                'quantity' => $detail->quantity,
//                'unit_price' => $detail->product->price,
//                'total' => ($detail->quantity * $detail->product->price),
//            ]);
//        }
//    }
//
//}

namespace App\Http\Controllers;
use Illuminate\Support\Facades\URL;
use Iyzipay\Model\ThreedsInitialize;
use Iyzipay\Request\CreatePaymentRequest;

use App\Models\InvoiceDetail;
use App\Models\OrderDetail;
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
use Iyzipay\Model\Locale;
use App\Models\UserDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Payment;
use Iyzipay\Request\CreateThreedsPaymentRequest;

class CheckoutController extends Controller
{
    /**
     * Shows the payment form
     *
     * @return View
     */
    public function showCheckoutForm(): View
    {
        return view("frontend.cart.checkout_form");
    }
    public function checkout(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        try {
            // Extract credit card data from the request
            $creditCard = new CreditCard();
            $data = $request->only($creditCard->getFillable());
            $creditCard->fill($data);

            // Retrieve user, cart, and total
            $user = Auth::user();
            $total = $this->calculateCartTotal();
            $cart = $this->getOrCreateCart();

            // Create Iyzico payment request
            $iyzicoRequest = IyzicoRequestHelper::createRequest($cart, $total);
            $paymentCard = IyzicoPaymentCardHelper::getPaymentCard($creditCard);
            $iyzicoRequest->setPaymentCard($paymentCard);

            $buyer = IyzicoBuyerHelper::getBuyer();
            $iyzicoRequest->setBuyer($buyer);
            $shippingAddress = IyzicoAddressHelper::getAddress();
            $iyzicoRequest->setShippingAddress($shippingAddress);
            $billingAddress = IyzicoAddressHelper::getAddress();
            $iyzicoRequest->setBillingAddress($billingAddress);
            $basketItems = $this->getBasketItems();
            $iyzicoRequest->setBasketItems($basketItems);
            $options = IyzicoOptionsHelper::getTestOptions();

            // Create Iyzico payment
            $payment = Payment::create($iyzicoRequest, $options);
            $iyzicoRequest->setCallbackUrl(URL::route('checkout.threeds.callback'));
//            dd($payment);

            // 3D payment
            if ($payment->getStatus() == 'success') {
                // Check if 3D Secure is required
                if ($payment->getPaymentStatus() == '3DS_ENROLLED') {
                    // Use the correct request instance
                    $threedsInitialize = ThreedsInitialize::create($payment, $options);
                    dd($threedsInitialize);
                    // Use the correct request instance
                    log::info('3D Secure is required');
                    // Redirect the user to the 3D Secure page
                    $redirectUrl = $threedsInitialize->getHtmlContent();
                    return redirect()->away($redirectUrl);
                }

                // 3D Secure is not required, continue with order processing
                Log::info('Iyzico Payment Request Data: ' . json_encode($payment->getStatus()));

                $order = $this->createOrderWithDetails($cart);
                $this->createInvoiceWithDetails($order);
                $this->finalizeCart($cart);

                return view("frontend.checkout.success", ["message" => "Payment successful."]);
            } else {
                return view("frontend.checkout.error", ["message" => "Payment failed."]);
            }
        } catch (\Exception $e) {
            return view("frontend.checkout.error", ["message" => $e->getMessage()]);
        }
    }
    public function iyzicoCallback(Request $request)
    {
        try {
            // Retrieve Iyzico 3D Secure response
            $iyzicoResponse = $request->input('iyzipay_response');

            // Log the 3D Secure response for debugging
            Log::info('3D Secure Response: ' . json_encode($iyzicoResponse));

            // Process the 3D Secure callback response
            $options = IyzicoOptionsHelper::getTestOptions();
            $payment = Payment::retrieve($iyzicoResponse, $options);

            // Log the payment status for debugging
            Log::info('Payment Status: ' . $payment->getStatus());


            // Check if payment status is successful
            if ($payment->getStatus() == "success") {
                // Get the order ID from the 3D Secure response
                $orderId = $payment->getBasketId(); // Use getBasketId instead of getMerchantOrderId

                // Log the order ID for debugging
                Log::info('Order ID: ' . $orderId);

                // Retrieve the order from the database
                $order = Order::findOrFail($orderId);

                // Log the order details for debugging
                Log::info('Order Details: ' . json_encode($order));
                // Update the order status or perform other necessary actions
                $order->update([
                    'status' => 'completed', // Modify this according to your application logic
                ]);

                // Redirect to the success page
                return redirect()->route('checkout.success');
            } else {
                // Handle payment failure
                Log::error('Payment failed. Status: ' . $payment->getStatus());
                // Handle payment failure
                return view("frontend.checkout.error", ["message" => "Payment failed."]);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return view("frontend.checkout.error", ["message" => $e->getMessage()]);
        }
    }

    private function calculateCartTotal(): float
    {
        $total = 0;
        $cart = $this->getOrCreateCart();
        $cartDetails = $cart->details;
        foreach ($cartDetails as $detail) {
            $total += $detail->product->price * $detail->quantity;
        }

        return $total;
    }

    private function getOrCreateCart(): Cart
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(
            ['user_id' => $user->id, 'is_active' => true],
            ['code' => Str::random(8)]
        );
        return $cart;
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
        $cart->save();
    }

    private function createOrderWithDetails(Cart $cart): Order
    {
        $order = new Order([
            "cart_id" => $cart->cart_id,
            "code" => $cart->code,
        ]);

        $order->save();

        foreach ($cart->details as $detail) {
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
        } catch (\Exception $e) {
            return view("frontend.checkout.error", ["message" => $e->getMessage()]);
        }

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
