-- Movie Ticket Booking System database
-- Import this file in phpMyAdmin from XAMPP.

CREATE DATABASE IF NOT EXISTS movie_ticket_booking;
USE movie_ticket_booking;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS shows;
DROP TABLE IF EXISTS theaters;
DROP TABLE IF EXISTS movies;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE movies (
    movie_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    genre VARCHAR(80) NOT NULL,
    duration INT NOT NULL,
    release_date DATE NOT NULL,
    description TEXT NOT NULL,
    poster_url VARCHAR(500) NOT NULL
);

CREATE TABLE theaters (
    theater_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    location VARCHAR(160) NOT NULL,
    total_seats INT NOT NULL
);

CREATE TABLE shows (
    show_id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    theater_id INT NOT NULL,
    show_date DATE NOT NULL,
    show_time TIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 180.00,
    FOREIGN KEY (movie_id) REFERENCES movies(movie_id) ON DELETE CASCADE,
    FOREIGN KEY (theater_id) REFERENCES theaters(theater_id) ON DELETE CASCADE
);

CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    show_id INT NOT NULL,
    seat_numbers VARCHAR(120) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed') NOT NULL DEFAULT 'pending',
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(show_id) ON DELETE CASCADE
);

-- Demo accounts. Password for both accounts is: password
INSERT INTO users (name, email, phone, password, role) VALUES
('Admin User', 'admin@example.com', '9999999999', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'admin'),
('Demo User', 'user@example.com', '8888888888', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi', 'user');

INSERT INTO movies (title, genre, duration, release_date, description, poster_url) VALUES
('Interstellar', 'Sci-Fi', 169, '2014-11-07', 'A team travels through a wormhole to search for a new home for humanity.', 'https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?auto=format&fit=crop&w=700&q=80'),
('The Dark Knight', 'Action', 152, '2008-07-18', 'Batman faces a criminal mastermind who throws Gotham into chaos.', 'https://images.unsplash.com/photo-1531259683007-016a7b628fc3?auto=format&fit=crop&w=700&q=80'),
('La La Land', 'Musical', 128, '2016-12-09', 'A jazz musician and an aspiring actress chase love and dreams in Los Angeles.', 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=700&q=80'),
('The Grand Adventure', 'Adventure', 132, '2025-04-10', 'A group of friends discover a hidden island full of mystery and danger.', 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=700&q=80'),
('City Lights', 'Drama', 118, '2025-02-14', 'A heartfelt story about ambition, family, and second chances in a busy city.', 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=700&q=80'),
('Laugh Riot', 'Comedy', 105, '2025-03-21', 'Three unlikely roommates create confusion, chaos, and comedy in one apartment.', 'https://images.unsplash.com/photo-1527224857830-43a7acc85260?auto=format&fit=crop&w=700&q=80');

INSERT INTO theaters (name, location, total_seats) VALUES
('PVR Central', 'Downtown Mall', 40),
('INOX Galaxy', 'City Center', 40),
('CineMax Plaza', 'North Avenue', 40);

INSERT INTO shows (movie_id, theater_id, show_date, show_time, price) VALUES
(1, 1, '2026-06-01', '10:30:00', 220.00),
(1, 2, '2026-06-01', '18:30:00', 250.00),
(2, 1, '2026-06-02', '14:00:00', 200.00),
(3, 3, '2026-06-02', '19:00:00', 180.00),
(4, 2, '2026-06-03', '12:30:00', 190.00),
(5, 3, '2026-06-03', '16:45:00', 170.00),
(6, 1, '2026-06-04', '20:15:00', 160.00);
