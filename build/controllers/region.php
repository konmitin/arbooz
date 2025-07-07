<?php

include_once "./../functions.php";

$regionInfo = getFromJSON("./../region.json");

$regionId = $_REQUEST['region'];

$return = [
    'max_oil' => $regionInfo[$regionId]['max_oil'],
];

echo json_encode($return);
