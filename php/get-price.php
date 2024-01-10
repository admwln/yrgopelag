<?php

declare(strict_types=1);

require_once(__DIR__ . '/../autoload.php');

// Recieve data from get price js script
$roomId = $_POST['roomType'];
$roomId = sanVal($roomId);
$arrival = $_POST['arrivalDate'];
$arrival = sanVal($arrival);
$departure = $_POST['departureDate'];
$departure = sanVal($departure);
$featureIds = $_POST['selectedFeatures'];
// If featureIds is empty, set it to an empty array
if (empty($featureIds)) {
    $featureIds = array();
} else {
    $featureIds = sanVal($featureIds);
    // Turn $featureIds into an array
    $featureIds = explode(',', $featureIds);
}

// Get the total price
$totalPrice = getTotalPrice($roomId, $arrival, $departure, $featureIds);

// Send the total price back to the js script
echo $totalPrice;
