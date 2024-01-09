<?php

declare(strict_types=1);

require_once(__DIR__ . '/../autoload.php');

// Get posted data
$roomId = $_POST['room-type'];
$firstName = $_POST['first-name'];
$firstName = sanVal($firstName);
$lastName = $_POST['last-name'];
$lastName = sanVal($lastName);
$arrival = $_POST['arrival'];
$departure = $_POST['departure'];
$featureIds = array();
if (isset($_POST['feature'])) {
    $featureIds = $_POST['feature'];
}
$totalPrice = $_POST['total-price'];
$totalPrice = sanVal($totalPrice);
$transferCode = $_POST['transfer-code'];
$transferCode = sanVal($transferCode);



function isRoomAvailable(string $roomId, string $arrival, string $departure): bool
{
    // Check if there are any bookings for the selected room and dates
    $db = connect('../hotel.db');
    $sql = 'SELECT * FROM bookings WHERE room_id = :roomId AND (arrival >= :arrival AND departure <= :departure);';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':arrival', $arrival, PDO::PARAM_STR);
    $stmt->bindParam(':departure', $departure, PDO::PARAM_STR);
    $stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();
    if (count($result) > 0) {
        return false;
    }
    return true;
}

// Double check that the room is available
if (!isRoomAvailable($roomId, $arrival, $departure, $featureIds)) {
    // If the room is not available, redirect the user error.php with a message saying that the room is not available
    $_SESSION['user-error'] = 'The room is not available for the selected dates.';
    header('Location: error.php');
    exit;
}
// Double check that the posted total price is correct
function getTotalPrice(string $roomId, string $arrival, string $departure, array $featureIds): int
{
    // Get the number of days between arrival and departure, including arrival and departure
    $in = new DateTime($arrival);
    $out = new DateTime($departure);
    $interval = $in->diff($out);
    $days = $interval->format('%a');
    $days += 1;

    $db = connect('../hotel.db');
    $sql = 'SELECT price FROM rooms WHERE id = :roomId;';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalPrice = $result['price'];
    $totalPrice *= $days;

    foreach ($featureIds as $featureId) {
        $sql = 'SELECT price FROM features WHERE id = :featureId;';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':featureId', $featureId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalPrice += $result['price'];
    }
    return $totalPrice;
}

if ($totalPrice != getTotalPrice($roomId, $arrival, $departure, $featureIds)) {
    // If the total price is incorrect, redirect the user to error.php with a message saying that the total price is incorrect
    $_SESSION['user-error'] = 'The total price is incorrect.';
    header('Location: error.php');
    exit;
}

// Check with bank if the user's transfer code is valid, relative to the total price
function checkTransferCodeWithBank(string $transferCode, string $totalPrice): void
{
    // Check transfer code further by posting{'transferCode': $transferCode} to the Central bank API
    // https://www.yrgopelag.se/centralbank/transferCode
    $client = new \GuzzleHttp\Client();
    try {
        $response = $client->request('POST', 'https://www.yrgopelag.se/centralbank/transferCode', [
            'form_params' => [
                'transferCode' => $transferCode,
                'totalcost' => $totalPrice
            ],
        ]);
        $responseData = json_decode($response->getBody()->getContents(), true);
        if (isset($responseData['error'])) {
            // Redirect user to error.php with a message saying that the transfer code is invalid
            $_SESSION['user-error'] = 'The transfer code was not accepted by the Yrgopelag Central Bank.';
            header('Location: error.php');
            exit;
        }

        if (isset($responseData['transferCode'])) {
            // Trasfer code is valid, create a reservation in database
            return;
        }
    } catch (GuzzleHttp\Exception\ServerException $e) {
        $response = $e->getResponse();
        $responseBodyAsString = $response->getBody()->getContents();
        // Redirect user to error.php with an error message
        $_SESSION['user-error'] = 'We are currently unable to establish a connection to the Yrgopelag Central Bank.';
        header('Location: error.php');
        exit;
    }
}

if (isValidUuid($transferCode)) {
    checkTransferCodeWithBank($transferCode, $totalPrice);
} else {
    // If the transfer code is invalid, redirect the user to error.php with a message saying that the transfer code is invalid
    $_SESSION['user-error'] = 'The transfer code is invalid.';
    header('Location: error.php');
    exit;
}

// If all checks are ok, create a reservation in database
$db = connect('../hotel.db');
$sql = 'INSERT INTO bookings (room_id, guest_firstname, guest_lastname, arrival, departure, price, transfer_code) VALUES (:roomId, :firstName, :lastName, :arrival, :departure, :totalPrice, :transferCode);';
$stmt = $db->prepare($sql);
$stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
$stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
$stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
$stmt->bindParam(':arrival', $arrival, PDO::PARAM_STR);
$stmt->bindParam(':departure', $departure, PDO::PARAM_STR);
$stmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_INT);
$stmt->bindParam(':transferCode', $transferCode, PDO::PARAM_STR);
$stmt->execute();
$bookingId = $db->lastInsertId();

$_SESSION['bookingId'] = $bookingId;

// Array with all selected features
$selectedFeatures = array();

// If any extra features were selected, add them to the booking_feature table
if (count($featureIds) > 0) {
    foreach ($featureIds as $featureId) {
        $sql = 'INSERT INTO booking_feature (booking_id, feature_id) VALUES (:bookingId, :featureId);';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $stmt->bindParam(':featureId', $featureId, PDO::PARAM_INT);
        $stmt->execute();

        // Get the name and cost of the selected feature
        $sql = 'SELECT * FROM features WHERE id = :featureId;';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':featureId', $featureId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $selectedFeature = [
            'name' => $result['feature'],
            'cost' => $result['price']
        ];
        array_push($selectedFeatures, $selectedFeature);
    }
}

// // Get the room name (comfort level) of the selected room
// function getComfortLevel($roomId)
// {
//     $db = connect('../hotel.db');
//     $sql = 'SELECT comfort_level FROM rooms WHERE id = :roomId;';
//     $stmt = $db->prepare($sql);
//     $stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
//     $stmt->execute();
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     return $result['comfort_level'];
// }

// $comfortLevel = getComfortLevel($roomId);

// Create a JSON object with the booking details
$bookingDetails = array(
    'island' => $_ENV['ISLAND_NAME'],
    'hotel' => $_ENV['HOTEL_NAME'],
    //'comfort_level' => $comfortLevel,
    'arrival_date' => $arrival,
    'departure_date' => $departure,
    'total_cost' => $totalPrice,
    'stars' => $_ENV['STARS'],
    'features' => $selectedFeatures,
    'additional_info' => [
        'greeting' => 'Thank you for choosing ' . $_ENV['HOTEL_NAME'] . '!',
        'imageUrl' => 'https://adamwelin.se/overview/images/success.png',
    ]
);

$_SESSION['bookingDetails'] = $bookingDetails;

// Turn it into a JSON string
$bookingDetails = json_encode($bookingDetails);

// Save string to file success-<booking id>.json
file_put_contents('../success/success-' . $bookingId . '.json', $bookingDetails);


// Deposit transfer code at the bank using Guzzle
// If the transfer code is valid, the bank will return a JSON object with the key 'balance' and the value of the balanc
$client = new \GuzzleHttp\Client();
try {
    $response = $client->request('POST', 'https://www.yrgopelag.se/centralbank/deposit', [
        'form_params' => [
            'user' => $_ENV['USER_NAME'],
            'transferCode' => $transferCode,
        ],
    ]);
    $responseData = json_decode($response->getBody()->getContents(), true);
    if (isset($responseData[0]) && str_contains($responseData[0], 'wrong')) {
        // Redirect user to success.php, even if deposit failed
        header('Location: success.php');
        exit;
    } else {
        // Redirect user to success.php
        header('Location: success.php');
        exit;
    }
} catch (GuzzleHttp\Exception\ServerException $e) {
    $response = $e->getResponse();
    $responseBodyAsString = $response->getBody()->getContents();
    // Redirect user to success.php, even if connection to bank failed
    header('Location: success.php');
    exit;
}
