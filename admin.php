<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');

// Check if user is logged in
if (!isset($_SESSION['loggedIn'])) {
    // User is not logged in
    // Redirect to login.php
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gilda+Display&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/success-style.css">
    <title><?= $_ENV['HOTEL_NAME']; ?> - Admin</title>
</head>

<body>
    <header>
        <a href="index.php">
            <h1><?= $_ENV['HOTEL_NAME']; ?></h1>
        </a>
    </header>
    <main class="admin">

        <h2>Admin</h2>

    </main>
</body>

</html>