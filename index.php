<?php

declare(strict_types=1);

// Always require autoload when using packages
require(__DIR__ . '/vendor/autoload.php');

// Tell PHP to use this fine package
use Dotenv\Dotenv;

// "Connect" to .env and load it's content into $_ENV
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once(__DIR__ . '/hotelFunctions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?= $_ENV['HOTEL_NAME']; ?></title>
</head>

<body>
    <header>
        <h1><?= $_ENV['HOTEL_NAME']; ?></h1>
    </header>
    <main>
        <?php
        $januaryBasic = new Calendar();
        echo $januaryBasic->generateCalendar();
        $januaryDeluxe = new Calendar();
        echo $januaryDeluxe->generateCalendar();

        ?>

    </main>
    <footer></footer>
    <script src="js/script.js"></script>
</body>

</html>