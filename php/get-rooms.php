<?php

declare(strict_types=1);

require_once(__DIR__ . '/../autoload.php');

// Get room info for all rooms, from rooms table in hotel.db
$db = new SQLite3(__DIR__ . '/../hotel.db');
$statement = $db->prepare('SELECT * FROM rooms');
$result = $statement->execute();
// Fetch all results from the database into an associative array
$rooms = array();
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $rooms[] = $row;
}
