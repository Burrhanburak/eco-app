<?php

namespace App\Helpers;

use App\Models\Cart;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;

class IyzicoBasketItemsHelper
{
    /**
     * @param Cart $cart
     * @return array
     */
    public static function getBasketItems(Cart $cart): array
    {
        $basketItems = array();
        foreach ($cart->details as $detail) {
            $basketItem = new BasketItem();
            $basketItem->setId($detail->product->id);
            $basketItem->setName($detail->product->name);
            $category1 = optional($detail->product->category)->name ?? 'kazak';
            $basketItem->setCategory1($category1);
            $basketItem->setItemType(BasketItemType::PHYSICAL);
            $basketItem->setPrice($detail->product->price);

            for ($i = 0; $i < $detail->quantity; $i++) {
                //array_push($basketItems, $basketItem);
                $basketItems[] = $basketItem;
            }
        }

        return $basketItems;
    }
}
