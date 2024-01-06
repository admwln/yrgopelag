<?php

declare(strict_types=1);

require_once(__DIR__ . '/../autoload.php');

// Unset roomId session variable
unset($_SESSION['roomId']);

// Check if user is logged in
if (isset($_SESSION['loggedIn'])) {
    // User IS logged in
    // Redirect to admin.php
    header('Location: admin.php');
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
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin-style.css">
    <title><?= $_ENV['HOTEL_NAME']; ?> | Login</title>
</head>

<body>
    <header>
        <a href="../index.php">
            <?php
            echo displayStars(intval($_ENV['STARS']));
            ?>
            <h1><?= $_ENV['HOTEL_NAME']; ?></h1>
        </a>
    </header>
    <section class="update-message-container">
        <?php
        if (isset($_SESSION['login-error'])) { ?>
            <p class="update-message error">
                <?= $_SESSION['login-error']; ?>
            </p>
        <?php
            unset($_SESSION['login-error']);
        }
        ?>
    </section>

    <main>

        <h2>Login</h2>

        <form action="verify.php" method="post">
            <div>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
            <div>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <input type="submit" value="Login">
        </form>
    </main>
</body>

</html>