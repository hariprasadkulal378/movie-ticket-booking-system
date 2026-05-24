<?php
$pageTitle = 'Booking Confirmation';
require_once 'includes/header.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: movies.php');
    exit;
}

$showId = (int) $_POST['show_id'];
$seatNumbers = trim($_POST['selected_seats']);
if ($seatNumbers === '') {
    die('Please select at least one seat.');
}

$showStatement = $pdo->prepare('SELECT price FROM shows WHERE show_id = ?');
$showStatement->execute([$showId]);
$show = $showStatement->fetch();

if (!$show) {
    die('Show not found.');
}

$requestedSeats = array_map('trim', explode(',', $seatNumbers));
$bookedSeatsStatement = $pdo->prepare('SELECT seat_numbers FROM bookings WHERE show_id = ? AND payment_status != "failed"');
$bookedSeatsStatement->execute([$showId]);
$alreadyBooked = [];

foreach ($bookedSeatsStatement->fetchAll() as $booking) {
    $alreadyBooked = array_merge($alreadyBooked, array_map('trim', explode(',', $booking['seat_numbers'])));
}

// Check again on the server because browser-side seat disabling can be bypassed.
if (count(array_intersect($requestedSeats, $alreadyBooked)) > 0) {
    die('One or more selected seats were just booked. Please go back and choose different seats.');
}

$seatCount = count($requestedSeats);
$totalAmount = $seatCount * $show['price'];

// In a real project, payment gateway response would decide this status.
$paymentStatus = 'paid';

$statement = $pdo->prepare('INSERT INTO bookings (user_id, show_id, seat_numbers, total_amount, payment_status) VALUES (?, ?, ?, ?, ?)');
$statement->execute([$_SESSION['user_id'], $showId, $seatNumbers, $totalAmount, $paymentStatus]);
$bookingId = $pdo->lastInsertId();
?>

<section class="confirmation">
    <div class="confirmation-card">
        <div class="success-mark">✓</div>
        <h1>Booking Confirmed</h1>
        <p>Your seats are reserved and payment status is marked as paid.</p>
        <div class="ticket-details">
            <p><strong>Booking ID:</strong> #<?php echo (int) $bookingId; ?></p>
            <p><strong>Seats:</strong> <?php echo clean($seatNumbers); ?></p>
            <p><strong>Total Amount:</strong> Rs. <?php echo number_format($totalAmount, 2); ?></p>
            <p><strong>Payment Status:</strong> <?php echo clean(ucfirst($paymentStatus)); ?></p>
        </div>
        <div class="hero-actions centered">
            <a class="btn primary" href="payment.php?booking_id=<?php echo (int) $bookingId; ?>">View Payment Status</a>
            <a class="btn secondary" href="history.php">Booking History</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
