<?php
$pageTitle = 'Home';
require_once 'includes/header.php';

$movies = $pdo->query('SELECT * FROM movies ORDER BY release_date DESC LIMIT 6')->fetchAll();
?>

<section class="hero">
    <div class="hero-content">
        <p class="eyebrow">Book tickets in minutes</p>
        <h1>Find your next big-screen moment.</h1>
        <p>Browse movies, choose a theater, select seats, and track bookings from one clean dashboard.</p>
        <div class="hero-actions">
            <a class="btn primary" href="movies.php">Browse Movies</a>
            <?php if (!isLoggedIn()) : ?>
                <a class="btn secondary" href="register.php">Create Account</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <p class="eyebrow">Now showing</p>
        <h2>Popular Movies</h2>
    </div>
    <div class="movie-grid">
        <?php foreach ($movies as $movie) : ?>
            <article class="movie-card">
                <img src="<?php echo clean($movie['poster_url']); ?>" alt="<?php echo clean($movie['title']); ?>">
                <div class="movie-card-body">
                    <h3><?php echo clean($movie['title']); ?></h3>
                    <p><?php echo clean($movie['genre']); ?> • <?php echo (int) $movie['duration']; ?> min</p>
                    <a class="btn small" href="seats.php?movie_id=<?php echo (int) $movie['movie_id']; ?>">Book Now</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
