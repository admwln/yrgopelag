<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/hotelFunctions.php');

// Get posted data
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize data
    $username = sanVal($username);
    $password = sanVal($password);

    // Check agains env variables
    if ($username === $_ENV['USER_NAME'] && $password === $_ENV['API_KEY']) {
        // Valid credentials
        // Set loggedIn session variable to true
        $_SESSION['loggedIn'] = true;
        // Redirect to admin.php
        header('Location: admin.php');
    } else {
        // Invalid credential
        echo '<pre>';
        die(var_dump('Invalid credentials'));
    }
} else {
    header('Location: login.php');
}
