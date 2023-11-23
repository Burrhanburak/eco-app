<?php

namespace App\Helpers;

use App\Models\CreditCard;
use Iyzipay\Model\PaymentCard;

class IyzicoPaymentCardHelper
{
    /**
     * @param CreditCard $card
     * @return PaymentCard
     */
    public static function getPaymentCard(CreditCard $card): PaymentCard
    {
//        dd($card);
        $paymentCard = new PaymentCard();
        $paymentCard->setCardHolderName($card->getName());
        $paymentCard->setCardNumber($card->getCardNo());
        $paymentCard->setExpireMonth(sprintf('%02d', $card->getExpireMonth()));
        $paymentCard->setExpireYear($card->getExpireYear());
        $paymentCard->setCvc($card->getCvc());
        $paymentCard->setRegisterCard(0);

        return $paymentCard;
    }
}
