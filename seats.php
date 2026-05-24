<?php
$pageTitle = 'Select Seats';
require_once 'includes/header.php';
requireLogin();

$movieId = isset($_GET['movie_id']) ? (int) $_GET['movie_id'] : 0;
$movieStatement = $pdo->prepare('SELECT * FROM movies WHERE movie_id = ?');
$movieStatement->execute([$movieId]);
$movie = $movieStatement->fetch();

if (!$movie) {
    die('Movie not found.');
}

$showsStatement = $pdo->prepare('
    SELECT shows.*, theaters.name AS theater_name
    FROM shows
    JOIN theaters ON shows.theater_id = theaters.theater_id
    WHERE shows.movie_id = ?
    ORDER BY shows.show_date, shows.show_time
');
$showsStatement->execute([$movieId]);
$shows = $showsStatement->fetchAll();

$selectedShow = isset($_GET['show_id']) ? (int) $_GET['show_id'] : ($shows[0]['show_id'] ?? 0);

$bookedSeats = [];
if ($selectedShow) {
    $seatStatement = $pdo->prepare('SELECT seat_numbers FROM bookings WHERE show_id = ? AND payment_status != "failed"');
    $seatStatement->execute([$selectedShow]);
    foreach ($seatStatement->fetchAll() as $booking) {
        $bookedSeats = array_merge($bookedSeats, explode(',', $booking['seat_numbers']));
    }
}
?>

<section class="booking-layout">
    <div class="booking-info">
        <img src="<?php echo clean($movie['poster_url']); ?>" alt="<?php echo clean($movie['title']); ?>">
        <h1><?php echo clean($movie['title']); ?></h1>
        <p><?php echo clean($movie['genre']); ?> • <?php echo (int) $movie['duration']; ?> min</p>
    </div>

    <form class="seat-panel" action="booking.php" method="POST">
        <input type="hidden" name="movie_id" value="<?php echo (int) $movieId; ?>">
        <input type="hidden" name="selected_seats" id="selectedSeats">

        <label>Choose Show</label>
        <select name="show_id" id="showSelect" required>
            <?php foreach ($shows as $show) : ?>
                <option value="<?php echo (int) $show['show_id']; ?>" data-price="<?php echo clean($show['price']); ?>" <?php echo $selectedShow == $show['show_id'] ? 'selected' : ''; ?>>
                    <?php echo clean($show['theater_name']); ?> - <?php echo clean($show['show_date']); ?> at <?php echo clean(substr($show['show_time'], 0, 5)); ?> - Rs. <?php echo number_format($show['price'], 2); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <div class="screen">Screen</div>
        <div class="seat-grid">
            <?php
            $rows = ['A', 'B', 'C', 'D', 'E'];
            foreach ($rows as $row) {
                for ($number = 1; $number <= 8; $number++) {
                    $seat = $row . $number;
                    $isBooked = in_array($seat, $bookedSeats);
                    echo '<button type="button" class="seat ' . ($isBooked ? 'booked' : '') . '" data-seat="' . clean($seat) . '" ' . ($isBooked ? 'disabled' : '') . '>' . clean($seat) . '</button>';
                }
            }
            ?>
        </div>

        <div class="seat-summary">
            <p>Selected: <strong id="seatList">None</strong></p>
            <p>Total: Rs. <strong id="seatTotal">0</strong></p>
        </div>
        <button class="btn primary full" type="submit" <?php echo count($shows) === 0 ? 'disabled' : ''; ?>>Confirm Booking</button>
        <?php if (count($shows) === 0) : ?>
            <p class="empty-state">No shows are available for this movie yet.</p>
        <?php endif; ?>
    </form>
</section>

<?php require_once 'includes/footer.php'; ?>
