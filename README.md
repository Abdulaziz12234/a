# Hotel Reservation System

A simple and interactive hotel reservation system built with PHP, MySQL, HTML, CSS, and JavaScript. This project allows users to browse available rooms, filter them based on price or availability, and book a room.

## Features

- **User Authentication**: Registration and login system with secure session handling.
- **Room Management**: Display rooms with descriptions, prices, and availability.
- **Filtering**: Filter rooms by price, availability, and keywords.
- **Booking System**: Users can reserve available rooms directly.
- **Responsive Design**: The website is optimized for various screen sizes.

## Project Structure

The project includes the following key files and directories:

index.php # Main page displaying rooms and filters. login.php # User registration and login page. book.php # Handles booking functionality. logout.php # Log out functionality for users. css/ # Contains the styling files. sql/ # MySQL dump file for setting up the database (reg.sql).

markdown
نسخ
تحرير

## Installation

### Requirements

- A local server environment (e.g., XAMPP, MAMP, WAMP).
- PHP 7.4 or higher.
- MySQL database server.

### Steps

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Abdulaziz12234/a.git
Move files to your server: Place the files in the htdocs folder (if using XAMPP).

Start XAMPP:

Start Apache and MySQL from the XAMPP Control Panel.
Import the database:

Open phpMyAdmin (http://localhost/phpmyadmin).
Create a new database named reg.
Import the reg.sql file into the reg database.
Access the website: Open your browser and go to:

bash
نسخ
تحرير
http://localhost/a
Database Structure
The reg.sql file creates the following tables:

registration Table
Field	Type	Description
id	INT	Primary key, Auto-increment
Username	VARCHAR(100)	Stores the username
Email	VARCHAR(100)	Stores the email address
Password	VARCHAR(255)	Stores the hashed password
rooms Table
Field	Type	Description
id	INT	Primary key, Auto-increment
name	VARCHAR(100)	Room name
price	DECIMAL(10, 2)	Room price per night
description	TEXT	Room description
available	INT	Room availability (1 for available, 0 for unavailable)
How to Use
Visit the homepage: Open the site in your browser.
Log in or register if you're a new user.
Browse rooms and use filters to refine your search.
Click on "Book Now" to reserve a room.
