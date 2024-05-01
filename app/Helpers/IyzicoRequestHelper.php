<?php




namespace App\Helpers;

use App\Models\Cart;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentChannel;
use Iyzipay\Model\PaymentGroup;
use Illuminate\Http\Request;
use Iyzipay\Request\CreatePaymentRequest;


class IyzicoRequestHelper
{
    /**
     * @param Cart $cart
     * @param $finalPrice
     * @return CreatePaymentRequest
     */


    public static function createRequest(Cart $cart, ?float $finalPrice): CreatePaymentRequest
    {

        $request = new CreatePaymentRequest();
        $request->setLocale(Locale::TR);
        $request->setConversationId($cart->code);
        $request->setPrice($finalPrice);
        $request->setPaidPrice($finalPrice);
        $request->setCurrency(Currency::TL);
        $request->setInstallment(1);
        $request->setBasketId($cart->code);
        $request->setPaymentChannel(PaymentChannel::WEB);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);
//        $request->setCallbackUrl(URL::route('checkout.threeds.callback'));

//        $request->setCallbackUrl(URL::route('checkout.threeds.callback'));
//        /        $request->setCallbackUrl(route('checkout.threeds.callback'));/
        return $request;
    }


}
