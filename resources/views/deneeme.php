<?php
// Replace these lines with the appropriate namespace imports for your application
use Illuminate\Http\Request;
use App\Order;
use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Payment;
use Iyzipay\Options;

class CheckoutController extends Controller
{
    // ...

    public function checkout3D()
    {
        // Create the payment gateway options
        $options = new Options();
        $options->setApiKey('your_api_key');
        $options->setSecretKey('your_secret_key');
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');

        // Prepare the buyer information
        $buyer = new Buyer();
        $buyer->setId(Auth::user()->id);
        $buyer->setName(Auth::user()->name);
        $buyer->setSurname(Auth::user()->surname);
        $buyer->setEmail(Auth::user()->email);
        $buyer->setIdentityNumber(Auth::user()->identity_number);
        $buyer->setPhoneNumber(Auth::user()->phone_number);
        $buyer->setRegistrationDate(Auth::user()->created_at);

        // Prepare the buyer's billing and shipping addresses
        $billingAddress = new Address();
        $billingAddress->setContactName(Auth::user()->name . ' ' . Auth::user()->surname);
        $billingAddress->setCity(Auth::user()->address->city);
        $billingAddress->setCountry(Auth::user()->address->country);
        $billingAddress->setAddress(Auth::user()->address->address);
        $billingAddress->setZipCode(Auth::user()->address->zip_code);

        $shippingAddress = new Address();
        $shippingAddress->setContactName(Auth::user()->name . ' ' . Auth::user()->surname);
        $shippingAddress->setCity(Auth::user()->address->city);
        $shippingAddress->setCountry(Auth::user()->address->country);
        $shippingAddress->setAddress(Auth::user()->address->address);
        $shippingAddress->setZipCode(Auth::user()->address->zip_code);

        // Create the payment request
        $request = new \Iyzipay\Request\CreatePaymentRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId(uniqid());
        $request->setPrice($this->calculateCartTotal());
        $request->setPaidPrice($this->calculateCartTotal());
        $request->setCurrency(Currency::TL);
        $request->setBasketId($this->getOrCreateCart()->cart_id);
        $request->setPaymentChannel(Payment\PaymentChannel::WEB);
        $request->setPaymentGroup(Payment\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('checkout.callback'));
        $request->setEnabledInstallments(array(2, 3, 6, 9));
        $request->setBuyer($buyer);
        $request->setShippingAddress($shippingAddress);
        $request->setBillingAddress($billingAddress);
        $request->setBasketItems($this->getBasketItems());

        // Execute the payment request
        $payment = \Iyzipay\Model\Payment::create($request, $options);

        // Check the result and return the appropriate response
        if ($payment->getStatus() === 'success') {
            // If the payment was successful, redirect the user to the payment URL
            return redirect()->to($payment->getPaymentUrl());
        } else {
            // If the payment failed, return an error view
            return view("frontend.checkout.error", ["message" => "Payment failed."]);
        }
    }

    // ...
}
