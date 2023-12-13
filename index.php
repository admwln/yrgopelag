<?php
require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/get-rooms.php');
require_once(__DIR__ . '/get-features.php');

$selectedRoomId = (isset($_SESSION['roomId'])) ? $_SESSION['roomId'] : 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'>
    <link rel="stylesheet" href="css/style.css">
    <title><?= $_ENV['HOTEL_NAME']; ?></title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        const selectedRoomId = <?= $selectedRoomId; ?>;
    </script>
</head>

<body>
    <header>
        <a href="index.php">
            <h1><?= $_ENV['HOTEL_NAME']; ?></h1>
        </a>
    </header>
    <main>

        <h2>Our Rooms</h2>
        <div class="choose-comfort">
            <form id="choose-comfort-form" action="get-calendar.php" method="post">
                <label for="choose-budget">Budget
                    <input class="comfort-radio" type="radio" name="choose-comfort" id="choose-budget" value="1">
                </label>
                <label for="choose-standard">
                    Standard
                    <input class="comfort-radio" type="radio" name="choose-comfort" id="choose-standard" value="2">
                </label>

                <label for="choose-luxury">
                    Luxury
                    <input class="comfort-radio" type="radio" name="choose-comfort" id="choose-luxury" value="3">
                </label>

            </form>
            <?php
            foreach ($rooms as $key => $room) { ?>
                <div class="room-info">
                    <h3><?= $room['comfort_level']; ?></h3>
                    <p><?= $room['description']; ?></p>
                    <p>Room rate: <span class="room-price"><?= $room['price'] . '.00'; ?></span> USD</p>
                    <button class="btn show-availability" type="submit" form="choose-comfort-form">Show availability</button>
                </div>
            <?php
            } ?>
        </div>
        <?php
        if (isset($_SESSION['calendar'])) {
            echo $_SESSION['calendar'];
            unset($_SESSION['calendar']);
        }
        ?>

        <form class="booking-form" action="make-reservation.php" method="post">
            <h2>Optional Extras</h2>
            <div class="features-slider">
                <div class="features-slides">
                    <?= $featuresHtml; ?>
                </div>
            </div>
            <h2>Your Reservation</h2>
            <label for="first-name">First name</label>
            <input type="text" name="first-name" id="first-name" required>
            <label for="last-name">Last name</label>
            <input type="text" name="last-name" id="last-name" required>
            <label for="room-type">Room</label>
            <select name="room-type" id="room-type">
                <?php
                foreach ($rooms as $key => $room) { ?>
                    <option value="<?= $room['id']; ?>" <?= ($room['id'] == $selectedRoomId) ? 'selected' : ''; ?>><?= $room['comfort_level']; ?></option>
                <?php

                } ?>
            </select>
            <label for="arrival">Arrival</label>
            <input type="date" name="arrival" id="arrival" min="2024-01-01" max="2024-01-31">
            <label for="departure">Departure</label>
            <input type="date" name="departure" id="departure" min="2024-01-01" max="2024-01-31">
            <label for="room-price">Room subtotal, <span class="number-of-days">1</span> days (USD)</label>
            <input type="text" name="room-price" id="room-price" value="0" disabled>
            <label for="features-price">Extras subtotal (USD)</label>
            <ul id="selected-features">

            </ul>
            <input type="text" name="features-price" id="features-price" value="0" disabled>
            <label for="total-price">Total price (USD)</label>
            <input type="text" name="total-price" id="total-price" value="0">
            <label for="transfer-code">Transfer code</label>
            <input type="text" name="transfer-code" id="transfer-code">
            <button type="submit">Book</button>
        </form>
    </main>
    <footer></footer>
    <script src="js/script.js"></script>
</body>

</html>