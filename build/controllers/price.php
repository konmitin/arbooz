<?php 

if (file_exists("./../price.json")) {
    $prices = file_get_contents("./../price.json");
    $prices = json_decode($prices, true);
}


$fuelType = $_REQUEST['fuel_type'];

echo json_encode(['price' => $prices[$fuelType]]);
