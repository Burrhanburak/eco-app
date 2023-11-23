<?php

namespace App\Helpers;

use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Iyzipay\Model\Address;

class IyzicoAddressHelper
{
    /**
     * @return Address
     */
    public static function getAddress(): Address
    {
//        $user = Auth::user();
//        $details = UserDetail::where('user_id', $user->id)->first();
//
//        $address = new Address();
//        $address->setContactName(($details->id ?? '') . ' ' . ($details->name ?? ''));
//        $address->setCity(($details->city ?? 'Default City'));
//        $address->setCountry(($details->country ?? 'Default Country'));
//        $address->setAddress(($details->address ?? 'Default Address'));
//        $address->setZipCode(($details->zipcode ?? 'Default Zipcode'));
//        return $address;
        $address = new Address();
        $address->setContactName("John Doe");
        $address->setCity("Istanbul");
        $address->setCountry("Turkey");
        $address->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $address->setZipCode("34742");
        return $address;
    }
}
