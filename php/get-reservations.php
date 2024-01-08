<?php

declare(strict_types=1);

require_once(__DIR__ . '/../autoload.php');

// Get all rows from bookings table
$db = connect('../hotel.db');
$sql = 'SELECT 
comfort_level, 
bookings.guest_firstname || " " || bookings.guest_lastname AS guest, 
arrival, 
departure, 
bookings.price,
(SELECT SUM(bookings.price) FROM bookings JOIN rooms ON bookings.room_id = rooms.id) AS total_price
FROM bookings
JOIN rooms ON bookings.room_id = rooms.id
ORDER BY room_id ASC, arrival ASC;';
$stmt = $db->prepare($sql);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reservationsHtml = '';

if (count($reservations) === 0) {
    $reservationsHtml .= '<tr><td colspan="5">No reservations</td></tr>';
} else {
    foreach ($reservations as $reservation) {
        $reservationsHtml .= '<tr>';
        $reservationsHtml .= '<td>' . $reservation['comfort_level'] . '</td>';
        $reservationsHtml .= '<td>' . $reservation['guest'] . '</td>';
        $reservationsHtml .= '<td>' . $reservation['arrival'] . '</td>';
        $reservationsHtml .= '<td>' . $reservation['departure'] . '</td>';
        $reservationsHtml .= '<td>' . $reservation['price'] . '</td>';
        $reservationsHtml .= '</tr>';
    }
    $reservationsHtml .= '<tr><td colspan="4">Total price</td><td>' . $reservation['total_price'] . '</td></tr>';
}
