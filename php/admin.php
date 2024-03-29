<?php

require_once(__DIR__ . '/../autoload.php');
require_once(__DIR__ . '/get-rooms.php');
require_once(__DIR__ . '/get-features.php');
require_once(__DIR__ . '/get-reservations.php');

// Check if user is logged in
if (!isset($_SESSION['loggedIn'])) {
    // User is not logged in
    // Redirect to login.php
    header('Location: login.php');
}

// Unset roomId session variable
unset($_SESSION['roomId']);
// Unset calendar session variable
unset($_SESSION['calendar']);

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

// Check if feature id is set in session variable
if (isset($_SESSION['updated-feature-id'])) {
    $featureToUpdate = intval($_SESSION['updated-feature-id']) - 1;
    unset($_SESSION['updated-feature-id']);
}
// Check if feature id is set from select-feature dropdown
else if (isset($_POST['select-feature']) && $_POST['select-feature'] != 'x') {
    $featureToUpdate = intval($_POST['select-feature']) - 1;
} else {
    // feature id is not set, default to feature index 0
    $featureToUpdate = 0;
}
?>

<?php
$ROOT = '../';
require __DIR__ . '/header.php';
?>
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
<main class="admin">


    <section class="admin-rooms">
        <h2>Rooms</h2>
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
            <label for="update-price">Price</label>
            <input type="text" name="update-price" id="update-price" value="<?= $rooms[$roomToUpdate]['price']; ?>" placeholder="Price" required>
            <input type="submit" value="Update">
        </form>
    </section>

    <section class="admin-features">
        <h2>Features</h2>
        <form action="admin.php" method="post">
            <select id="select-feature" name="select-feature">
                <option value="x" disabled selected>Select feature</option>
                <?php
                foreach ($features as $feature) { ?>
                    <option value="<?= $feature['id']; ?>">
                        <?= $feature['feature']; ?>
                    </option>
                <?php
                } ?>
            </select>
            <input type="submit" value="Select">
        </form>
        <form name="update-feature" id="update-feature" action="update-feature.php" method="post">
            <input type="hidden" name="update-feature-id" id="update-feature-id" value="<?= $features[$featureToUpdate]['id']; ?>">
            <label for="update-feature-name">Feature</label>
            <input type="text" name="update-feature-name" id="update-feature-name" value="<?= $features[$featureToUpdate]['feature']; ?>" placeholder="Feature" required>
            <textarea name="update-feature-description" id="update-feature-description" rows="4" placeholder="Description" required><?= $features[$featureToUpdate]['description']; ?></textarea>
            <label for="update-feature-price">Price</label>
            <input type="text" name="update-feature-price" id="update-feature-price" value="<?= $features[$featureToUpdate]['price']; ?>" placeholder="Price" required>
            <input type="submit" value="Update">
        </form>
    </section>

    <section class="admin-reservations">

        <h2>Reservations</h2>
        <table>
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Guest</th>
                    <th>Arrival</th>
                    <th>Departure</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?= $reservationsHtml; ?>
            </tbody>
        </table>
        <form action="purge-reservations.php" method="post">
            <input id="purge-btn" type="submit" value="Purge all">
        </form>
    </section>
    <form name="logout" action="logout.php" method="post">
        <input type="submit" value="Log out">
    </form>

</main>
<script src="../js/admin.js"></script>
<?php require __DIR__ . '/footer.php'; ?>