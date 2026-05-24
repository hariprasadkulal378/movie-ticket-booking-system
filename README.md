# Movie Ticket Booking System

A beginner-friendly movie ticket booking project built with HTML, CSS, JavaScript, PHP, and MySQL.

## Features

- User registration and login
- Admin dashboard
- Movie listing and search
- Theater and show management
- Seat selection and booking confirmation
- Booking history
- Payment status page
- Responsive modern UI

## Folder Structure

```text
movie-ticket-booking-system/
├── admin/
├── css/
├── database/
├── images/
├── includes/
├── js/
├── index.php
├── login.php
├── register.php
├── movies.php
├── seats.php
├── booking.php
├── payment.php
├── history.php
└── config.php
```

## How To Run With XAMPP

1. Install and open XAMPP.
2. Start `Apache` and `MySQL`.
3. Copy this project folder to `C:\xampp\htdocs\movie-ticket-booking-system`.
4. Open `http://localhost/phpmyadmin` in your browser.
5. Click `Import`, choose `database/movie_ticket_booking.sql`, then click `Go`.
6. Open `http://localhost/movie-ticket-booking-system` in your browser.

## Demo Login

- Admin: `admin@example.com`
- User: `user@example.com`
- Password for both: `password`

## Database Settings

The database connection is in `config.php`.

```php
$host = 'localhost';
$database = 'movie_ticket_booking';
$username = 'root';
$password = '';
```

These are the default XAMPP MySQL settings. Change them only if your local setup uses a different username or password.
