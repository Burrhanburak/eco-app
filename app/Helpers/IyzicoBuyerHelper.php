<?php

namespace App\Helpers;

use App\Models\CreditCard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Iyzipay\Model\Buyer;
use Illuminate\Support\Facades\Log;
use App\Models\UserDetail;

class IyzicoBuyerHelper
{
    public static function getBuyer(): Buyer
    {
        $user = Auth::user();
        if (!$user) {
            // Handle unauthenticated user here
            // For example, throw an exception or return a default Buyer
            throw new \Exception('User not authenticated');
        }

        $detailNumbber = Auth::user()->detail->phone;
        $detailAdress = Auth::user()->detail->address;
        $detailCity = Auth::user()->detail->city;
        $detailCoutnry = Auth::user()->detail->country;
        $detailZipCode = Auth::user()->detail->zipcode;


        $buyer = new Buyer();
        $buyer->setId($user->id);
        $buyer->setName($user->name);
        $buyer->setSurname($user->name);
        $buyer->setGsmNumber($detailNumbber);
        $buyer->setRegistrationAddress($detailAdress );
        $buyer->setCity($detailCity);
        $buyer->setCountry($detailCoutnry ? $detailCoutnry : "Turkey");
        $buyer->setZipCode($detailZipCode);
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate(Carbon::parse(now())->format("Y-m-d h:i:s"));
        $buyer->setRegistrationDate(Carbon::parse($user->created_at)->format("Y-m-d h:i:s"));
        $buyer->setIp(request()->ip());

        return $buyer;
    }
}
