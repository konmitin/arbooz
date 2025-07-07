<?php

include_once "./../functions.php";

$promoAll = getFromJSON("./../promo.json");

$fuel = $_REQUEST['fuel'];

$input = $fuel['input'];
$type = $fuel['type'];

$tariff = [];
$return = "";

if ($type == 'gasoline') {


    if ($input < 100) {

        $tariff = [
            "title" => "Эконом",
            "type" => "economy"
        ];
    } else if ($input >= 100 && $input < 300) {

        $tariff = [
            "title" => "Избранный",
            "type" => "favorite"
        ];
    } else if ($input >= 300) {

        $tariff = [
            "title" => "Премиум",
            "type" => "premium"
        ];
    }
} else if ($type == 'gas') {
    if ($input < 200) {

        $tariff = [
            "title" => "Эконом",
            "type" => "economy"
        ];
    } else if ($input >= 200 && $input < 700) {

        $tariff = [
            "title" => "Избранный",
            "type" => "favorite"
        ];
    } else if ($input >= 700) {

        $tariff = [
            "title" => "Премиум",
            "type" => "premium"
        ];
    }
} else if ($type == 'dizel') {
    if ($input < 150) {

        $tariff = [
            "title" => "Эконом",
            "type" => "economy"
        ];
    } else if ($input >= 150 && $input < 350) {

        $tariff = [
            "title" => "Избранный",
            "type" => "favorite"
        ];
    } else if ($input >= 350) {

        $tariff = [
            "title" => "Премиум",
            "type" => "premium"
        ];
    }
}

$tariff['promo'] = $promoAll[$tariff['type']];

echo json_encode($tariff);
