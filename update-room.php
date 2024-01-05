<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');

// Get posted data
$roomId = $_POST['update-room-id'];
$comfortLevel = $_POST['update-comfort-level'];
$comfortLevel = sanVal($comfortLevel);
$updateDescription = $_POST['update-description'];
$updateDescription = sanVal($updateDescription);
$updatePrice = $_POST['update-price'];
$updatePrice = sanVal($updatePrice);

// Update room in database
$db = connect('hotel.db');
$sql = 'UPDATE rooms SET comfort_level = :comfortLevel, description = :description, price = :price WHERE id = :roomId;';
$stmt = $db->prepare($sql);
$stmt->bindParam(':comfortLevel', $comfortLevel, PDO::PARAM_STR);
$stmt->bindParam(':description', $updateDescription, PDO::PARAM_STR);
$stmt->bindParam(':price', $updatePrice, PDO::PARAM_INT);
$stmt->bindParam(':roomId', $roomId, PDO::PARAM_INT);
$stmt->execute();

// Redirect to admin.php and display success message
$_SESSION['update-success'] = 'Room updated successfully';
$_SESSION['updated-room-id'] = $roomId;
header('Location: admin.php');
