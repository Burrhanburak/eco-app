<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Iyzipay\Model\Buyer;
use App\Models\UserDetail;

class IyzicoBuyerHelper
{
    public static function getBuyer(): Buyer
    {
        $user = Auth::user();
        $details = UserDetail::where('user_id', $user->id)->first();

        $buyer = new Buyer();
        $buyer->setId($user->id);

        if ($details) {
            $buyer->setName($details->name);
            $buyer->setSurname($details->name); // Assuming you have a 'surname' field in your user details
            $buyer->setGsmNumber($details->phone);
            $buyer->setRegistrationAddress($details->address);
            $buyer->setCity($details->city);
            $buyer->setCountry($details->country);
            $buyer->setZipCode($details->zipcode);
        } else {
            // Handle the case when details are not found, set default values or throw an error.
            // For now, let's set some default values.
            $buyer->setName("John");
            $buyer->setSurname("Doe");
            $buyer->setGsmNumber("+905350000000");
            $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
            $buyer->setCity("Istanbul");
            $buyer->setCountry("Turkey");
            $buyer->setZipCode("34732");
        }

        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate(Carbon::parse(now())->format("Y-m-d h:i:s"));
        $buyer->setRegistrationDate(Carbon::parse($user->created_at)->format("Y-m-d h:i:s"));
        $buyer->setIp(request()->ip());

        return $buyer;
    }
}
