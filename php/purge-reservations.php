<?php

declare(strict_types=1);

require_once(__DIR__ . '/../autoload.php');

// Delete all rows from bookings table AND booking_feature table
$db = connect('../hotel.db');
$sql = 'DELETE FROM bookings;';
$statement = $db->prepare($sql);
$statement->execute();
$sql = 'DELETE FROM booking_feature;';
$statement = $db->prepare($sql);
$statement->execute();

// Delete all files in success folder
$files = glob('../success/*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

// Redirect to admin.php
header('Location: admin.php');
exit;
