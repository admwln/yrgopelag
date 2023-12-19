<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/hotelFunctions.php');

// Get all features from features table in hotel.db

$db = new SQLite3(__DIR__ . '/hotel.db');
$statement = $db->prepare('SELECT * FROM features');
$result = $statement->execute();

// Fetch all results from the database into an associative array
$features = array();
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $features[] = $row;
}

// Loop through all features and create html for each
$featuresHtml = '';
foreach ($features as $feature) {
    $featuresHtml .= '<div class="feature"><div>';
    $featuresHtml .= '<h3>' . $feature['feature'] . '</h3>';
    $featuresHtml .= '<img src="images/feature-' . $feature['id'] . '.png" alt="' . $feature['feature'] . '">';
    $featuresHtml .= '<p>' . $feature['description'] . '</p></div>';
    $featuresHtml .= '<div><p><span class="feature-price">' . $feature['price'] . '</span>.00 USD</p>';
    $featuresHtml .= '<div class="checkbox-container"><input type="checkbox" name="feature[]" id="feature-' . $feature['id'] . '" value="' . $feature['id'] . '"><label for="feature-' . $feature['id'] . '">Add to reservation</label></div></div>';
    $featuresHtml .= '</div>';
}
