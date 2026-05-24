<?php
$pageTitle = 'Manage Movies';
require_once '../includes/admin_header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add') {
        $statement = $pdo->prepare('INSERT INTO movies (title, genre, duration, release_date, description, poster_url) VALUES (?, ?, ?, ?, ?, ?)');
        $statement->execute([
            trim($_POST['title']),
            trim($_POST['genre']),
            (int) $_POST['duration'],
            $_POST['release_date'],
            trim($_POST['description']),
            trim($_POST['poster_url'])
        ]);
        $message = 'Movie added successfully.';
    }

    if ($_POST['action'] === 'delete') {
        $statement = $pdo->prepare('DELETE FROM movies WHERE movie_id = ?');
        $statement->execute([(int) $_POST['movie_id']]);
        $message = 'Movie deleted successfully.';
    }
}

$movies = $pdo->query('SELECT * FROM movies ORDER BY movie_id DESC')->fetchAll();
?>

<section class="page-banner">
    <h1>Movie Management</h1>
    <p>Add movies that users can search and book.</p>
</section>

<section class="admin-grid">
    <form class="form-card" method="POST">
        <h2>Add Movie</h2>
        <?php if ($message) : ?><div class="alert success"><?php echo clean($message); ?></div><?php endif; ?>
        <input type="hidden" name="action" value="add">
        <label>Title</label>
        <input type="text" name="title" required>
        <label>Genre</label>
        <input type="text" name="genre" required>
        <label>Duration (minutes)</label>
        <input type="number" name="duration" required>
        <label>Release Date</label>
        <input type="date" name="release_date" required>
        <label>Poster URL</label>
        <input type="url" name="poster_url" required>
        <label>Description</label>
        <textarea name="description" rows="4" required></textarea>
        <button class="btn primary full" type="submit">Add Movie</button>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Duration</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movies as $movie) : ?>
                    <tr>
                        <td><?php echo clean($movie['title']); ?></td>
                        <td><?php echo clean($movie['genre']); ?></td>
                        <td><?php echo (int) $movie['duration']; ?> min</td>
                        <td>
                            <form method="POST" onsubmit="return confirm('Delete this movie?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="movie_id" value="<?php echo (int) $movie['movie_id']; ?>">
                                <button class="btn danger small" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once '../includes/admin_footer.php'; ?>
