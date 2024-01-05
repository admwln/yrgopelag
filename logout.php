<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');

// Unset loggedIn session variable
unset($_SESSION['loggedIn']);

// Redirect to index.php
header('Location: index.php');
