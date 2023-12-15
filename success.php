<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');

// Get booking details from session variable
$bookingDetails = $_SESSION['bookingDetails'];

// Decode the JSON string into an array
$bookingDetails = json_decode($bookingDetails, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'>
    <link rel="stylesheet" href="css/style.css">
    <title><?= $_ENV['HOTEL_NAME']; ?> - Booking Confirmation</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <a href="index.php">
            <h1><?= $_ENV['HOTEL_NAME']; ?></h1>
        </a>
    </header>
    <main>
        <h2>Booking Confirmation</h2>
        <p>Thank you for choosing <?= $_ENV['HOTEL_NAME']; ?>!</p>
        <p>Here are your booking details:</p>
        <a href="success-<?= $_SESSION['bookingId']; ?>.json" target="_blank">Booking details in new tab</a>
    </main>
</body>

</html>