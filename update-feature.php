<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');

// Get posted data
$featureId = $_POST['update-feature-id'];
$featureId = sanVal($featureId);
$featureName = $_POST['update-feature-name'];
$featureName = sanVal($featureName);
$featureDescription = $_POST['update-feature-description'];
$featureDescription = sanVal($featureDescription);
$featurePrice = $_POST['update-feature-price'];
$featurePrice = sanVal($featurePrice);

// Update feature in database
$db = connect('hotel.db');
$sql = 'UPDATE features SET feature = :featureName, description = :featureDescription, price = :featurePrice WHERE id = :featureId;';
$stmt = $db->prepare($sql);
$stmt->bindParam(':featureName', $featureName, PDO::PARAM_STR);
$stmt->bindParam(':featureDescription', $featureDescription, PDO::PARAM_STR);
$stmt->bindParam(':featurePrice', $featurePrice, PDO::PARAM_INT);
$stmt->bindParam(':featureId', $featureId, PDO::PARAM_INT);
$stmt->execute();

// Redirect to admin.php and display success message
$_SESSION['update-success'] = 'Feature updated successfully';
$_SESSION['updated-feature-id'] = $featureId;
header('Location: admin.php');
