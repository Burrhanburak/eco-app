<?php

namespace App\Helpers;



use Illuminate\Support\Facades\Log;
use Iyzipay\Options;

class IyzicoOptionsHelper
{
    /**
     * @return Options
     */
    public static function getTestOptions(): Options
    {
        $options = new Options();
        $options->setApiKey(env("TEST_IYZI_API_KEY"));
        $options->setSecretKey(env("TEST_IYZI_SECRET_KEY"));
        $options->setBaseUrl(env("TEST_IYZI_BASE_URL"));

//        $options->setCallbackUrl(route('checkout.threeds.callback'));
//        $options->setCallbackUrl(env("YOUR_3D_SECURE_CALLBACK_URL"));
        return $options;
    }

    /**
     * @return Options
     */
    public static function getProdOptions(): Options
    {
        $options = new Options();
        $options->setApiKey(env("IYZI_API_KEY"));
        $options->setSecretKey(env("IYZI_SECRET_KEY"));
        $options->setBaseUrl(env("IYZI_BASE_URL"));
        return $options;
    }
}
