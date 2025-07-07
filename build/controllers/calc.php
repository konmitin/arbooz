<?php

include_once "./../functions.php";

$data = $_REQUEST['data'];

if (isset($_REQUEST['data'])) {
    echo json_encode(calcEconomy(
        $data['fuel_type'],
        $data['oil_value'],
        $data['tariff'],
        $data['promo']
    ));
}
