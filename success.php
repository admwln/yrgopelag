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
    <title><?= $_ENV['HOTEL_NAME']; ?> - Thank You</title>
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
        <div class="booking-details">
            <h3>Booking details</h3>
            <div class="island">
                <span class="label">Island:</span> <span class="value"><?= $bookingDetails['island']; ?></span>
            </div>
            <div class="hotel">
                <span class="label">Hotel:</span>
                <span class="value"> <?= $bookingDetails['hotel']; ?></span>
            </div>
            <div class="stars">
                <span class="label">Stars:</span>
                <span class="value"><?= $bookingDetails['stars']; ?></span>
            </div>
            <div class="comfort_level">
                <span class="label">Room type:</span>
                <span class="value"><?= $bookingDetails['comfort_level']; ?></span>
            </div>
            <div class="arrival">
                <span class="label">Arrival date:</span>
                <span class="value"> <?= $bookingDetails['arrival_date']; ?></span>
            </div>
            <div class="departure">
                <span class="label">Departure date:</span>
                <span class="value"><?= $bookingDetails['departure_date'] ?></span>
            </div>
            <div class="features">
                <span class="label">Optional extras:</span>
                <ul class="features-list">
                    <?php
                    foreach ($bookingDetails['features'] as $feature) { ?>
                        <li><?= $feature['name']; ?> - <?= $feature['cost']; ?>.00 USD</li>
                    <?php
                    } ?>
                </ul>
            </div>
            <div class="total-cost">
                <span class="label">Total cost:</span> <span class="value"><?= $bookingDetails['total_cost']; ?>.00 USD</span>
            </div>
            <div class="additional-info">
                <span class="greeting"><?= $bookingDetails['additional_info']['greeting']; ?></span>
                <img src="<?= $bookingDetails['additional_info']['imageUrl']; ?>" alt="Hotel image">
            </div>
        </div>
    </main>
</body>

</html>