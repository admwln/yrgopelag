<?php

declare(strict_types=1);

require_once(__DIR__ . '/../autoload.php');

// If no room ID is set, 1 is default
$roomId = 1;
$roomName = 'Budget';
// Get calendar for chosen room type, from bookings table in hotel.db
if (isset($_POST['choose-comfort'])) {
    // 1 = budget, 2 = standard, 3 = luxury
    $roomName = $_POST['choose-comfort'];
    // Store room ID in session variable
    if ($roomName === 'Budget') {
        $roomId = 1;
    } elseif ($roomName === 'Standard') {
        $roomId = 2;
    } elseif ($roomName === 'Luxury') {
        $roomId = 3;
    }
}
$_SESSION['roomId'] = $roomId;

// Connect to hotel.db SQLite database, and check room availability in bookings table
$db = connect('../hotel.db');
$statement = $db->prepare('SELECT arrival, departure FROM bookings WHERE room_id = :roomId');
$statement->bindValue(':roomId', $roomId, PDO::PARAM_INT);
$result = $statement->execute();

// Fetch all results from the database into an associative array
$bookings = array();
while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
    $bookings[] = $row;
}

// Loop through all bookings and create an array of all booked dates, including arrival and departure and in between
$occupancy = array();
foreach ($bookings as $booking) {
    $arrival = $booking['arrival'];
    // Extract only the day from the arrival date
    $arrival = (int)substr($arrival, 8, 2);
    $departure = $booking['departure'];
    // Extract only the day from the departure date
    $departure = (int)substr($departure, 8, 2);
    // Loop through all days between arrival and departure, and add them to the occupancy array
    for ($i = $arrival; $i <= $departure; $i++) {
        $occupancy[] = $i;
    }
}

// Create a new calendar object
$calendar = new Calendar();
// Generate the HTML for the calendar
$calendarHtml = $calendar->generateCalendar($occupancy, $roomName);
// Store in session variable
$_SESSION['calendar'] = $calendarHtml;

if (!isset($_POST['choose-comfort'])) {
    // return $_SESSION['calendar'];
    return $calendarHtml;
}

if (isset($_POST['choose-comfort'])) {
    // Redirect back to index.php
    header("Location: ../index.php");
}

// Calendar class, for hotel bookings
class Calendar
{
    public $weekdays;
    public $dates;

    public function __construct()
    {
        $this->weekdays = [
            'Mon',
            'Tue',
            'Wed',
            'Thur',
            'Fri',
            'Sat',
            'Sun',
        ];
        $this->dates = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22,
            23, 24, 25, 26, 27, 28, 29, 30, 31,
        ];
    }
    public function generateCalendar(array $occupancy, string $roomName): string
    {
        $html = '<div class="calendar-body"><ul class="calendar-weekdays">';
        foreach ($this->weekdays as $weekday) {
            $html .= '<li>' . $weekday . '</li>';
        }
        $html .= '</ul>
           <ul class="calendar-dates">';
        foreach ($this->dates as $date) {
            if (in_array($date, $occupancy)) {
                $html .= '<li class="booked">' . $date . '</li>';
            } else {
                $html .= '<li class="available" data="' . $date . '">' . $date . '<input type="checkbox" name="checkbox-' . $date . '"/></li>';
            }
        }
        $html .= '</ul></div>';

        return $html;
    }
}
