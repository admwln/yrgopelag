<?php
require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/get-rooms.php');
require_once(__DIR__ . '/get-features.php');

$selectedRoomId = (isset($_SESSION['roomId'])) ? $_SESSION['roomId'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'>
    <link rel="stylesheet" href="css/style.css">
    <title><?= $_ENV['HOTEL_NAME']; ?></title>
    <script>
        const selectedRoomId = <?= $selectedRoomId; ?>;
    </script>
</head>

<body>
    <header>
        <h1><?= $_ENV['HOTEL_NAME']; ?></h1>
    </header>
    <main>

        <h2>Our Rooms</h2>
        <div class="choose-comfort">
            <form id="choose-comfort-form" action="get-calendar.php" method="post">
                <label for="choose-budget">Budget <input type="radio" name="choose-comfort" id="choose-budget" value="1">
                </label>
                <label for="choose-standard">Standard</label>
                <input type="radio" name="choose-comfort" id="choose-standard" value="2">
                <label for="choose-luxury">Luxury</label>
                <input type="radio" name="choose-comfort" id="choose-luxury" value="3">
            </form>
            <?php
            foreach ($rooms as $key => $room) { ?>
                <div class="room-info">
                    <h3><?= $room['comfort_level']; ?></h3>
                    <p><?= $room['description']; ?></p>
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

        <h2>Your Stay</h2>
        <form class="booking-form" action="" method="post">
            <label for="arrival">Arrival</label>
            <input type="text" name="arrival" id="arrival" disabled>
            <label for="departure">Departure</label>
            <input type="text" name="departure" id="departure" disabled>
            <button type="submit">Book</button>
        </form>
    </main>
    <footer></footer>
    <script src="js/script.js"></script>
</body>

</html>