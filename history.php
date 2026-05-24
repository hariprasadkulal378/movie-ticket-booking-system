<?php
$pageTitle = 'Booking History';
require_once 'includes/header.php';
requireLogin();

$statement = $pdo->prepare('
    SELECT bookings.*, movies.title, theaters.name AS theater_name, shows.show_date, shows.show_time
    FROM bookings
    JOIN shows ON bookings.show_id = shows.show_id
    JOIN movies ON shows.movie_id = movies.movie_id
    JOIN theaters ON shows.theater_id = theaters.theater_id
    WHERE bookings.user_id = ?
    ORDER BY bookings.booking_date DESC
');
$statement->execute([$_SESSION['user_id']]);
$bookings = $statement->fetchAll();
?>

<section class="page-banner">
    <h1>Booking History</h1>
    <p>Review your tickets and payment status.</p>
</section>

<section class="section">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Theater</th>
                    <th>Show</th>
                    <th>Seats</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking) : ?>
                    <tr>
                        <td><?php echo clean($booking['title']); ?></td>
                        <td><?php echo clean($booking['theater_name']); ?></td>
                        <td><?php echo clean($booking['show_date']); ?> <?php echo clean(substr($booking['show_time'], 0, 5)); ?></td>
                        <td><?php echo clean($booking['seat_numbers']); ?></td>
                        <td>Rs. <?php echo number_format($booking['total_amount'], 2); ?></td>
                        <td><a class="status-pill" href="payment.php?booking_id=<?php echo (int) $booking['booking_id']; ?>"><?php echo clean(ucfirst($booking['payment_status'])); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (count($bookings) === 0) : ?>
        <p class="empty-state">No bookings yet. <a href="movies.php">Book a movie</a>.</p>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>
