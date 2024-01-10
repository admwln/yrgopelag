<?php

require_once(__DIR__ . '/../autoload.php');

// Get booking details array from session variable
$bookingDetails = $_SESSION['bookingDetails'];
$bookingId = $_SESSION['bookingId'];

// Unset session variables
unset($_SESSION['calendar']);
unset($_SESSION['bookingDetails']);
unset($_SESSION['bookingId']);
unset($_SESSION['roomId']);
?>

<?php
$ROOT = '../';
require __DIR__ . '/header.php';
?>
<main class="success">

    <h2>Booking Confirmation</h2>
    <p>Thank you for choosing <?= $_ENV['HOTEL_NAME']; ?>!</p>
    <p>Here are your booking details:</p>
    <a href="../success/success-<?= $bookingId ?>.json" target="_blank">Show details <i class="fa-solid fa-up-right-from-square"></i></a>
</main>
<?php require __DIR__ . '/footer.php'; ?>