<?php
$pageTitle = 'Movies';
require_once 'includes/header.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search) {
    $statement = $pdo->prepare('SELECT * FROM movies WHERE title LIKE ? OR genre LIKE ? ORDER BY release_date DESC');
    $statement->execute(["%$search%", "%$search%"]);
    $movies = $statement->fetchAll();
} else {
    $movies = $pdo->query('SELECT * FROM movies ORDER BY release_date DESC')->fetchAll();
}
?>

<section class="page-banner">
    <h1>Movies</h1>
    <form class="search-bar" method="GET">
        <input type="search" name="search" id="movieSearch" value="<?php echo clean($search); ?>" placeholder="Search by title or genre">
        <button class="btn primary" type="submit">Search</button>
    </form>
</section>

<section class="section">
    <div class="movie-grid">
        <?php foreach ($movies as $movie) : ?>
            <article class="movie-card searchable-movie" data-title="<?php echo clean(strtolower($movie['title'] . ' ' . $movie['genre'])); ?>">
                <img src="<?php echo clean($movie['poster_url']); ?>" alt="<?php echo clean($movie['title']); ?>">
                <div class="movie-card-body">
                    <h3><?php echo clean($movie['title']); ?></h3>
                    <p><?php echo clean($movie['description']); ?></p>
                    <div class="meta-row">
                        <span><?php echo clean($movie['genre']); ?></span>
                        <span><?php echo (int) $movie['duration']; ?> min</span>
                    </div>
                    <a class="btn small" href="seats.php?movie_id=<?php echo (int) $movie['movie_id']; ?>">Select Seats</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if (count($movies) === 0) : ?>
        <p class="empty-state">No movies found.</p>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>
