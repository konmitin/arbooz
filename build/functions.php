<?php

function calcEconomy($fuelType, $fuelValue, $tariff, $promo)
{

    $prices = getFromJSON("./../price.json");
    $promoAll = getFromJSON("./../promo.json");

    $tariffDiscount = [
        'economy' => 3,
        'favorite' => 5,
        'premium' => 7,
    ];

    $amountNotDiscount = $prices[$fuelType] * $fuelValue;

    $discountTariff = $tariffDiscount[$tariff] / 100;
    $discountPromo = $promoAll[$tariff][$promo]['discount'] / 100;

    $discount = $amountNotDiscount * $discountTariff + $amountNotDiscount * $discountPromo;

    $economy = [
        'year' => 0,
        'month' => 0,
    ];

    $economy['month'] = $discount;
    $economy['year'] = $economy['month'] * 12;

    return ['economy' => $economy, "price" => $amountNotDiscount];
}

function getFromJSON($path) {

    if (file_exists($path)) {
        $data = file_get_contents($path);
        $data = json_decode($data, true);

        return $data;
    } else {
        return false;
    }
}
