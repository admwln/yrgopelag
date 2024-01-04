<?php

declare(strict_types=1);

require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/get-rooms.php');

// Check if user is logged in
if (!isset($_SESSION['loggedIn'])) {
    // User is not logged in
    // Redirect to login.php
    header('Location: login.php');
}

// Check if room id is set in session variable
if (isset($_SESSION['updated-room-id'])) {
    $roomToUpdate = intval($_SESSION['updated-room-id']) - 1;
    unset($_SESSION['updated-room-id']);
}
// Check if room id is set from select-room dropdown
else if (isset($_POST['select-room']) && $_POST['select-room'] != 'x') {
    $roomToUpdate = intval($_POST['select-room']) - 1;
} else {
    // Room id is not set, default to room index 0
    $roomToUpdate = 0;
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
    <link rel="stylesheet" href="css/admin-style.css">
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

        <section class="update-message-container">
            <?php
            if (isset($_SESSION['update-success'])) { ?>
                <p class="update-message">
                    <?= $_SESSION['update-success']; ?>
                </p>
            <?php
                unset($_SESSION['update-success']);
            }
            ?>
        </section>

        <section class="admin-rooms">
            <h3>Rooms</h3>
            <form action="admin.php" method="post">
                <select id="select-room" name="select-room">
                    <option value="x" disabled selected>Select room</option>
                    <?php
                    foreach ($rooms as $room) { ?>
                        <option value="<?= $room['id']; ?>">
                            <?= $room['comfort_level']; ?>
                        </option>
                    <?php
                    } ?>
                </select>
                <input type="submit" value="Select">
            </form>

            <form name="update-room" id="update-room" action="update-room.php" method="post">
                <input type="hidden" name="update-room-id" id="update-room-id" value="<?= $rooms[$roomToUpdate]['id']; ?>">
                <label for="update-comfort-level">Room name</label>
                <input type="text" name="update-comfort-level" id="update-comfort-level" value="<?= $rooms[$roomToUpdate]['comfort_level']; ?>" placeholder="Room name" required>
                <textarea name="update-description" id="update-description" rows="12" placeholder="Description" required><?= $rooms[$roomToUpdate]['description']; ?></textarea>
                <label for="update-price">Rate</label>
                <input type="text" name="update-price" id="update-price" value="<?= $rooms[$roomToUpdate]['price']; ?>" placeholder="Rate" required>
                <input type="submit" value="Update">
            </form>
        </section>

        <section class="admin-features">
            <h3>Features</h3>
        </section>

    </main>
    <footer>
        <form name="logout" action="logout.php" method="post">
            <input type="submit" value="Log out">
        </form>
    </footer>
    <script src="js/admin.js"></script>
</body>

</html>