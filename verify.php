<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');

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
        // Invalid credentials, redirect to login.php and add error message to session variable
        $_SESSION['login-error'] = 'Invalid credentials!';
        header('Location: login.php');
    }
} else {
    header('Location: login.php');
}
