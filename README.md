# Vertigo Island

Vertigo is a mesmerizing island. As you approach from the azure waters, the island unveils its lush, verdant tropical forests that stretch out in a rich tapestry of greens, inviting exploration beneath the canopy of ancient trees. The air is alive with the symphony of exotic birds and the rustle of leaves, creating a sensory feast for every nature enthusiast. Venture towards the island's center, and a breathtaking transformation unfolds. Majestic snow-clad mountain peaks pierce the sky, crowned with glistening white caps that stand in stark contrast to the tropical paradise below.

# Overview Hotel

Welcome to Overview Hotel. Perched high above the ground, our unique retreat invites you to experience a stay like no other, where each room is meticulously designed to offer unrivaled panoramic views that will leave you spellbound. We take pride in our elevated accommodations that promise an escape into the skies. Three distinct rooms, each offering a different vantage point, allow you to immerse yourself in the mesmerizing beauty of Vertigo.

## Project info

This project is an assignment for first-year web development students at Yrgo, Gothenburg, Sweden.

## Requirements

-   PHP 8.2 or higher
-   Dependencies: Composer, Guzzle, vlucas/phpdotenv

## Installation

1. Clone the repository: `git clone https://github.com/admwln/yrgopelag.git`
2. Install dependencies
3. Configure settings in `.env` file. See `.env.example`. Your username is your first name, with the initial letter capitalized. Get an API-key from the Yrgopelag Central Bank: https://yrgopelag.se/centralbank/

### Install dependencies

Install Composer

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Install Guzzle

```
composer require guzzlehttp/guzzle
```

Install vlucas/phpdotenv

```
composer require vlucas/phpdotenv
```

## Database structure

The sqlite database `hotel.db` consists of four tables.

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

1. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
2. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
3. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
4. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
5. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
6. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
7. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
8. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
9. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
10. example.js:10-15 - Remember to think about X and this could be refactored using the amazing Y function.
