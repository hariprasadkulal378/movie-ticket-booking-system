<?php
$pageTitle = 'Admin Dashboard';
require_once '../includes/admin_header.php';

$movieCount = $pdo->query('SELECT COUNT(*) FROM movies')->fetchColumn();
$theaterCount = $pdo->query('SELECT COUNT(*) FROM theaters')->fetchColumn();
$bookingCount = $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
$revenue = $pdo->query('SELECT COALESCE(SUM(total_amount), 0) FROM bookings WHERE payment_status = "paid"')->fetchColumn();

$recentBookings = $pdo->query('
    SELECT bookings.*, users.name AS user_name, movies.title
    FROM bookings
    JOIN users ON bookings.user_id = users.user_id
    JOIN shows ON bookings.show_id = shows.show_id
    JOIN movies ON shows.movie_id = movies.movie_id
    ORDER BY bookings.booking_date DESC
    LIMIT 8
')->fetchAll();
?>

<section class="page-banner">
    <h1>Admin Dashboard</h1>
    <p>Manage movies, theaters, shows, and bookings.</p>
</section>

<section class="section">
    <div class="stats-grid">
        <div class="stat-card"><span>Movies</span><strong><?php echo (int) $movieCount; ?></strong></div>
        <div class="stat-card"><span>Theaters</span><strong><?php echo (int) $theaterCount; ?></strong></div>
        <div class="stat-card"><span>Bookings</span><strong><?php echo (int) $bookingCount; ?></strong></div>
        <div class="stat-card"><span>Revenue</span><strong>Rs. <?php echo number_format($revenue, 2); ?></strong></div>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <h2>Recent Bookings</h2>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Movie</th>
                    <th>Seats</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentBookings as $booking) : ?>
                    <tr>
                        <td><?php echo clean($booking['user_name']); ?></td>
                        <td><?php echo clean($booking['title']); ?></td>
                        <td><?php echo clean($booking['seat_numbers']); ?></td>
                        <td>Rs. <?php echo number_format($booking['total_amount'], 2); ?></td>
                        <td><span class="status-pill"><?php echo clean(ucfirst($booking['payment_status'])); ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once '../includes/admin_footer.php'; ?>
