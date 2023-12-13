<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/hotelFunctions.php');

// Get posted data
$roomId = $_POST['room-type'];
$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$arrival = $_POST['arrival'];
$departure = $_POST['departure'];
$featureIds = array();
if (isset($_POST['feature'])) {
    $featureIds = $_POST['feature'];
}
$totalPrice = $_POST['total-price'];
$transferCode = $_POST['transfer-code'];

// Double check that the room is available
if (!isRoomAvailable($roomId, $arrival, $departure)) {
    echo '<pre>';
    die(var_dump('the room is not available for the selected dates'));
    // If the room is not available, redirect the user to index.php with a message saying that the room is not available
    // !!! BREAK
}

function isRoomAvailable($roomId, $arrival, $departure)
{
    // Check if there are any bookings for the selected room and dates
    $db = connect('hotel.db');
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


// Check if the transfer code is valid uuid
if (!isValidUuid($transferCode)) {
    echo 'not valid';
    // If the transfer code is invalid, redirect the user to index.php with a message saying that the transfer code is invalid
    // !!! BREAK
}

if (isValidUuid($transferCode)) {
    checkTransferCodeWithBank($transferCode, $totalPrice);
}

// Check if the user's transfer code is valid by using the function isValidUuid($transferCode)
function checkTransferCodeWithBank($transferCode, $totalPrice)
{

    if (isValidUuid($transferCode, $totalPrice)) {
        // If the transfer code is valid, check it further by posting{'transferCode': $transferCode} to
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
                // If the response contains an error, redirect the user to index.php with a message saying that the transfer code is invalid
                // !!! BREAK
                echo '<pre>';
                die(var_dump($responseData['error']));
            }

            if (isset($responseData['transferCode'])) {
                // Trasfer code is valid, create a reservation in database

            }
        } catch (GuzzleHttp\Exception\ServerException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            echo '<pre>';
            die(var_dump($responseBodyAsString));
        }
    }
}

// If all checks are ok, create a reservation in database
$db = connect('hotel.db');
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

echo 'Reservation created! Booking id: ' . $bookingId;

// If any extra features were selected, add them to the booking_feature table
if (count($featureIds) > 0) {
    foreach ($featureIds as $featureId) {
        $sql = 'INSERT INTO booking_feature (booking_id, feature_id) VALUES (:bookingId, :featureId);';
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':bookingId', $bookingId, PDO::PARAM_INT);
        $stmt->bindParam(':featureId', $featureId, PDO::PARAM_INT);
        $stmt->execute();
        echo ' Feature added: ' . $featureId;
    }
}
