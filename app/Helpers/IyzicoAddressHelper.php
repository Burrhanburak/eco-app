<?php

namespace App\Helpers;

use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Iyzipay\Model\Address;

class IyzicoAddressHelper
{
    /**
     * @return Address
     */
    public static function getAddress(): Address
    {
        $user = Auth::user();
        $detailName = Auth::user()->detail->name;
        $detailAdress = Auth::user()->detail->address;
        $detailCity = Auth::user()->detail->city;
        $detailCoutnry = Auth::user()->detail->country;
        $detailZipCode = Auth::user()->detail->zipcode;

                $address = new Address();
                $address->setContactName( $detailName ?? 'john');
                $address->setCity($detailCity ?? 'istanbul');
                $address->setCountry($detailCoutnry ?? 'turkey');
                $address->setAddress($detailAdress ?? 'default address');
                $address->setZipCode($detailZipCode ?? '34000');
                return $address;
            }
}
