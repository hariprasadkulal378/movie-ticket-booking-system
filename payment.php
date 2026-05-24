<?php
$pageTitle = 'Payment Status';
require_once 'includes/header.php';
requireLogin();

$bookingId = isset($_GET['booking_id']) ? (int) $_GET['booking_id'] : 0;
$statement = $pdo->prepare('
    SELECT bookings.*, movies.title, shows.show_date, shows.show_time
    FROM bookings
    JOIN shows ON bookings.show_id = shows.show_id
    JOIN movies ON shows.movie_id = movies.movie_id
    WHERE bookings.booking_id = ? AND bookings.user_id = ?
');
$statement->execute([$bookingId, $_SESSION['user_id']]);
$booking = $statement->fetch();

if (!$booking) {
    die('Payment record not found.');
}
?>

<section class="section narrow">
    <div class="status-card">
        <p class="eyebrow">Payment Status</p>
        <h1><?php echo clean(ucfirst($booking['payment_status'])); ?></h1>
        <p><?php echo clean($booking['title']); ?> on <?php echo clean($booking['show_date']); ?> at <?php echo clean(substr($booking['show_time'], 0, 5)); ?></p>
        <div class="ticket-details">
            <p><strong>Booking ID:</strong> #<?php echo (int) $booking['booking_id']; ?></p>
            <p><strong>Amount:</strong> Rs. <?php echo number_format($booking['total_amount'], 2); ?></p>
            <p><strong>Seats:</strong> <?php echo clean($booking['seat_numbers']); ?></p>
        </div>
        <a class="btn primary" href="history.php">Back to History</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
