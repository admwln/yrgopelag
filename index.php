<?php
require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/php/get-rooms.php');
require_once(__DIR__ . '/php/get-features.php');

$selectedRoomId = (isset($_SESSION['roomId'])) ? $_SESSION['roomId'] : 1;

// If $_SESSION['calendar'] is not set, set $selectedRoomId to 1
if (!isset($_SESSION['calendar'])) {
    $selectedRoomId = 1;
}
?>



<?php
$ROOT = './';
require __DIR__ . '/php/header.php';
?>
<script>
    let selectedRoomId = <?= $selectedRoomId; ?>;
</script>
<input id="get-price-btn" type="button" value="Get price" style="cursor:pointer">
<main>
    <div class="choose-comfort">
        <form id="choose-comfort-form" action="php/get-calendar.php" method="post">
            <input type="submit" class="show-availability" name="choose-comfort" value="Budget"></input>
            <input type="submit" class="show-availability" name="choose-comfort" value="Standard"></input>
            <input type="submit" class="show-availability" name="choose-comfort" value="Luxury"></input>
        </form>
    </div>
    <form class="booking-form" id="booking-form" action="php/make-reservation.php" method="post">
        <section class="rooms">
            <?php
            foreach ($rooms as $key => $room) {
                $imgUrl = 'images/' . $room['comfort_level'] . '.png'; ?>
                <div class="room-info">
                    <img class="room-img" src="<?= $imgUrl; ?>" alt="<?= $room['comfort_level']; ?>">
                    <h3><?= $room['comfort_level']; ?></h3>
                    <p><?= $room['description']; ?></p>
                    <p>Room rate: <span class="room-price"><?= $room['price']; ?></span> USD</p>
                </div>
            <?php
            } ?>
        </section>
        <section id="calendar" class="calendar">
            <h2>January 2024</h2>

            <div class="arrival-departure">
                <div class="date-container">
                    <label for="room-type">Room</label>
                    <select name="room-type" id="room-type" disabled>
                        <?php
                        foreach ($rooms as $key => $room) { ?>
                            <option value="<?= $room['id']; ?>" <?= ($room['id'] == $selectedRoomId) ? 'selected' : ''; ?>><?= $room['comfort_level']; ?></option>
                        <?php

                        } ?>
                    </select>
                </div>
                <div class="date-container">
                    <label for="arrival">Arrival</label>
                    <input type="text" name="arrival" id="arrival" min="2024-01-01" max="2024-01-31" readonly required>
                </div>
                <div class="date-container">
                    <label for="departure">Departure</label>
                    <input type="text" name="departure" id="departure" min="2024-01-01" max="2024-01-31" readlonly required>
                </div>
            </div>

            <?php
            // Echo the default calendar or the user-selected calendar, if it exists in the session variable
            if (isset($_SESSION['calendar'])) {
                echo $_SESSION['calendar'];
                unset($_SESSION['calendar']);
            } else {
                // Default to room 1 (budget)
                echo require_once(__DIR__ . '/php/get-calendar.php');
            }
            ?>
        </section>


        <section class="features-container" id="features-container">
            <h2>Extra Features</h2>
            <div class="feature-slider">
                <div class="features">
                    <?= $featuresHtml; ?>
                </div>
            </div>
            <button type="button" class="slider-btn left">
                <i class="fa-solid fa-circle-chevron-left"></i>
            </button>
            <button type="button" class="slider-btn right">
                <i class="fa-solid fa-circle-chevron-right"></i>
            </button>
        </section>
        <section class="reservation">
            <h2>Place Your Reservation</h2>
            <div class="reservation-flex-container">
                <div class="reservation-flex-item price">
                    <!-- <label for="room-price">Room subtotal</label>
                    <input type="text" name="room-price" id="room-price" value="0" readonly><span class="usd">USD</span>
                    <label for="features-price">Extras subtotal</label>
                    <input type="text" name="features-price" id="features-price" value="0" readonly><span class="usd">USD</span> -->
                    <label for="total-price">Total price</label>
                    <input type="text" name="total-price" id="total-price" value="0" readonly><span class="usd">USD</span>
                </div>
                <div class="reservation-flex-item personal">
                    <label for="first-name">First name</label>
                    <input type="text" name="first-name" id="first-name" required>
                    <label for="last-name">Last name</label>
                    <input type="text" name="last-name" id="last-name" required>
                    <label for="transfer-code">Transfer code</label>
                    <input type="text" name="transfer-code" id="transfer-code" required>
                    <button id="reserve-btn" type="submit" form="booking-form">Reserve</button>
                </div>
            </div>
        </section>

    </form>
</main>
<script src="./js/script.js"></script>
<script src="./js/slider.js"></script>
<?php require __DIR__ . '/php/footer.php'; ?>