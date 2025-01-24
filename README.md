# Hotel Reservation System

A simple and interactive hotel reservation system built with PHP, MySQL, HTML, CSS, and JavaScript. This project allows users to browse available rooms, filter them based on price or availability, and book a room.

---

## Features

- **User Authentication:** Registration and login system with secure session handling.
- **Room Management:** Display rooms with descriptions, prices, and availability.
- **Filtering:** Filter rooms by price, availability, and keywords.
- **Booking System:** Users can reserve available rooms directly.
- **Responsive Design:** The website is optimized for various screen sizes.

---


## Installation

### Requirements

- A local server environment (e.g., **XAMPP**, **MAMP**, **WAMP**).
- PHP 7.4 or higher.
- MySQL database server.

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Abdulaziz12234/a.git
   ```
2. **Move files to your server**: Place the files in the `htdocs` folder (if using XAMPP).
3. **Start XAMPP**:
   - Start Apache and MySQL from the XAMPP Control Panel.
4. **Import the database**:
   - Open phpMyAdmin (`http://localhost/phpmyadmin`).
   - Create a new database named `reg`.
   - Import the `reg.sql` file into the `reg` database.
5. **Access the website**: Open your browser and go to:
   ```
   http://localhost/a
   ```

---

## Database Structure

The `reg.sql` file creates the following tables:

1. register:
   - id`: Primary key.
   - Username`: Stores the username.
   - Email`: Stores the email address.
   - Password`: Stores the hashed password.
2. rooms:
   - id`: Primary key.
   - name`: Room name.
   - price`: Room price per night.
   - description`: Room description.
   - available`: Room availability (1 for available, 0 for unavailable).

---

## How to Use

1. Visit the homepage.
2. Log in or register if you're a new user.
3. Browse rooms and use filters to refine your search.
4. Click on "Book Now" to reserve a room.


