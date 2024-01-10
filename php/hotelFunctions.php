<?php

/* 
Here's something to start your career as a hotel manager.

One function to connect to the database you want (it will return a PDO object which you then can use.)
    For instance: $db = connect('hotel.db');
                  $db->prepare("SELECT * FROM bookings");
                  
one function to create a guid,
and one function to control if a guid is valid.
*/

function connect(string $dbName): object
{
    $dbPath = __DIR__ . '/' . $dbName;
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database";
        throw $e;
    }
    return $db;
}

function guidv4(string $data = null): string
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isValidUuid(string $uuid): bool
{
    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }
    return true;
}

function sanVal(string $myString): string
{
    $myString = trim($myString);
    $myString = strip_tags($myString);
    $myString = htmlspecialchars($myString, ENT_QUOTES);
    $myString = trim($myString);
    return $myString;
}

function displayStars(int $stars): string
{
    $starIcons = '';
    for ($i = 0; $i < $stars; $i++) {
        $starIcons .= '<i class="fa-solid fa-star"></i> ';
    }
    return $starIcons;
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
    // If arrival and departure are empty, set price to 0
    if ($arrival == '' || $departure == '') {
        $totalPrice = 0;
    }

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
