<?php
require_once(__DIR__ . '/autoload.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/water.css@2/out/water.css'>
    <link rel="stylesheet" href="css/style.css">
    <title><?= $_ENV['HOTEL_NAME']; ?></title>
</head>

<body>
    <header>
        <h1><?= $_ENV['HOTEL_NAME']; ?></h1>
    </header>
    <main>

        <form class="choose-comfort-form" action="get-calendar.php" method="post">
            <label for="choose-budget">Budget</label>
            <input type="radio" name="choose-comfort" id="choose-budget" value="1" <label for="choose-standard">Standard</label>
            <input type="radio" name="choose-comfort" id="choose-standard" value="2">
            <label for="choose-luxury">Luxury</label>
            <input type="radio" name="choose-comfort" id="choose-luxury" value="3">
            <button type="submit">Show availability</button>
        </form>

        <?php
        if (isset($_SESSION['calendar'])) {
            echo $_SESSION['calendar'];
            unset($_SESSION['calendar']);
        }
        ?>

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

<?php
// $januaryBasic = new Calendar();
// echo $januaryBasic->generateCalendar();
?>