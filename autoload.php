<?php

declare(strict_types=1);
session_start();

// Always require autoload when using packages
require(__DIR__ . '/vendor/autoload.php');

// Always requre hotelFunctions
require(__DIR__ . '/php/hotelFunctions.php');

// Tell PHP to use this fine package
use Dotenv\Dotenv;

// "Connect" to .env and load it's content into $_ENV
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
