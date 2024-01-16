# Vertigo Island

Vertigo is a mesmerizing island. As you approach from the azure waters, the island unveils its lush, verdant tropical forests that stretch out in a rich tapestry of greens, inviting exploration beneath the canopy of ancient trees. The air is alive with the symphony of exotic birds and the rustle of leaves, creating a sensory feast for every nature enthusiast. Venture towards the island's center, and a breathtaking transformation unfolds. Majestic snow-clad mountain peaks pierce the sky, crowned with glistening white caps that stand in stark contrast to the tropical paradise below.

# Overview Hotel

Welcome to Overview Hotel. Perched high above the ground, our unique retreat invites you to experience a stay like no other, where each room is meticulously designed to offer unrivaled panoramic views that will leave you spellbound. We take pride in our elevated accommodations that promise an escape into the skies. Three distinct rooms, each offering a different vantage point, allow you to immerse yourself in the mesmerizing beauty of Vertigo.

## Project info

This project is an assignment for first-year web development students at Yrgo, Gothenburg, Sweden.

## Requirements

-   PHP 8.2 or higher
-   Dependencies: Composer, Guzzle, vlucas/phpdotenv, sqlite3, pdo_sqlite

## Installation

1. Clone the repository: `git clone https://github.com/admwln/yrgopelag.git`
2. Install dependencies
3. Configure settings in `.env` file. See `.env.example`. Your username is your first name, with the initial letter capitalized. Get an API-key from the Yrgopelag Central Bank: https://yrgopelag.se/centralbank/

### Install dependencies

#### Install Composer

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

#### Install Guzzle

```
composer require guzzlehttp/guzzle
```

#### Install vlucas/phpdotenv

```
composer require vlucas/phpdotenv
```

#### Install sqlite3

Please refer to the following instructions:
https://www.quackit.com/sqlite/tutorial/sqlite_installation.cfm

#### Install pdo_sqlite

Pdo_sqlite should be enabled by default:
https://www.php.net/manual/en/ref.pdo-sqlite.php

## Database

The sqlite database `hotel.db` is included in the root directory of this project. It consists of four tables: rooms, features, bookings, and booking_feature. Included below are the `create table` statements used.

```
CREATE TABLE rooms (
    id INTEGER PRIMARY KEY,
    comfort_level VARCHAR,
    price INTEGER NOT NULL,
    description VARCHAR
);

CREATE TABLE features (
    id INTEGER PRIMARY KEY,
    feature VARCHAR,
    description VARCHAR,
    price INTEGER NOT NULL
);

CREATE TABLE bookings (
    id INTEGER PRIMARY KEY,
    room_id INTEGER NOT NULL,
    guest_firstname TEXT NOT NULL,
    guest_lastname TEXT NOT NULL,
    arrival TEXT NOT NULL,
    departure TEXT NOT NULL,
    price INTEGER NOT NULL,
    transfer_code TEXT NOT NULL,
	FOREIGN KEY(room_id) REFERENCES rooms(id),
    CHECK(length(arrival) = 10),
    CHECK(length(departure) = 10)
);

CREATE TABLE booking_feature (
	id INTEGER PRIMARY KEY,
	booking_id INTEGER NOT NULL,
	feature_id INTEGER NOT NULL,
	FOREIGN KEY(booking_id) REFERENCES bookings(id),
	FOREIGN KEY(feature_id) REFERENCES features(id)
);
```

# Code review

1. Firstly, I want to compliment the styling of your webpage, it is very appealing, and you can tell that time and effort went into it!
2. On the same note it is very smart to separate the CSS files to keep the styling organized and easy to look over/change.
3.The comments in your PHP code result in structured code that is easy to read.
4. Your project contains a lot of PHP files, which on one hand is positive since you can tell that there is a lot of thought and coherence in your code. Although I think that some of these files could be combined so it is easier for an “outsider” to understand how your code operates. For example, the files: “get-calendar.php”, “get-features.php”, “get-price.php”, “get-reservations.php” and “get-rooms.php” are examples of files that all require “autoload.php”, and the ladder four all contain between 15-30 lines of code each. Since these files all require the same “autoload.php” file and have similar function or a similar “theme” of functions (if that make sense) the shorter ones could be combined. 
5. In the “get-reservations.php” file on lines 25 – 38 I really liked your solution for checking if a room is reserved using if (count($reservations) === 0){…}. I thought it was a clean way to check if any room is booked (I use the same solution so I’m a bit subjective here).
6. In “make-reservations.php” lines 199 – 215 you choose to redirect the user to “success.php” even if the deposit or the connection to the bank doesn’t work. I wonder why this is. I could assume it is because it is not a problem that the “customer” directly interferes with, but there is also no error message for you as admin to inform you that the connection isn’t working. .
7. I am intrigued by your usage of sessions. I can admit that I am not as familiar with using sessions as you seem to be so I would love if you would explain it to me😊 If this just seems like extra work for you, you of course don’t have to I am just interested as to what advantages there are with using sessions this way. 
8. In “make-reservations.php” through lines 8-22 you use the “sanVal” function which you created in lines 45-52 in “hotelFunctions.php”. This is a great way to make sure that all data from “customers” is sanitated and protects your code!
9. The booking calendar has a graphical presentation of what rooms are booked and not. I think that it would be nice if a user could book a room by also typing in dates, not only selecting from the calendar. This is just a suggestion that would further elevate the design of your website.
10. In conclusion your project is well executed and some of the things I take with me for my upcoming projects is your styling and usage of sessions. Well done Adam!
