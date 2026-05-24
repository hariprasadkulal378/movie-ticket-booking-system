<?php
$pageTitle = 'Manage Theaters';
require_once '../includes/admin_header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add_theater') {
        $statement = $pdo->prepare('INSERT INTO theaters (name, location, total_seats) VALUES (?, ?, ?)');
        $statement->execute([trim($_POST['name']), trim($_POST['location']), (int) $_POST['total_seats']]);
        $message = 'Theater added successfully.';
    }

    if ($_POST['action'] === 'add_show') {
        $statement = $pdo->prepare('INSERT INTO shows (movie_id, theater_id, show_date, show_time, price) VALUES (?, ?, ?, ?, ?)');
        $statement->execute([
            (int) $_POST['movie_id'],
            (int) $_POST['theater_id'],
            $_POST['show_date'],
            $_POST['show_time'],
            (float) $_POST['price']
        ]);
        $message = 'Show added successfully.';
    }
}

$theaters = $pdo->query('SELECT * FROM theaters ORDER BY name')->fetchAll();
$movies = $pdo->query('SELECT * FROM movies ORDER BY title')->fetchAll();
$shows = $pdo->query('
    SELECT shows.*, movies.title, theaters.name AS theater_name
    FROM shows
    JOIN movies ON shows.movie_id = movies.movie_id
    JOIN theaters ON shows.theater_id = theaters.theater_id
    ORDER BY shows.show_date, shows.show_time
')->fetchAll();
?>

<section class="page-banner">
    <h1>Theater Management</h1>
    <p>Create theaters and schedule shows for movies.</p>
</section>

<section class="admin-grid three">
    <form class="form-card" method="POST">
        <h2>Add Theater</h2>
        <?php if ($message) : ?><div class="alert success"><?php echo clean($message); ?></div><?php endif; ?>
        <input type="hidden" name="action" value="add_theater">
        <label>Name</label>
        <input type="text" name="name" required>
        <label>Location</label>
        <input type="text" name="location" required>
        <label>Total Seats</label>
        <input type="number" name="total_seats" value="40" required>
        <button class="btn primary full" type="submit">Add Theater</button>
    </form>

    <form class="form-card" method="POST">
        <h2>Add Show</h2>
        <input type="hidden" name="action" value="add_show">
        <label>Movie</label>
        <select name="movie_id" required>
            <?php foreach ($movies as $movie) : ?>
                <option value="<?php echo (int) $movie['movie_id']; ?>"><?php echo clean($movie['title']); ?></option>
            <?php endforeach; ?>
        </select>
        <label>Theater</label>
        <select name="theater_id" required>
            <?php foreach ($theaters as $theater) : ?>
                <option value="<?php echo (int) $theater['theater_id']; ?>"><?php echo clean($theater['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <label>Date</label>
        <input type="date" name="show_date" required>
        <label>Time</label>
        <input type="time" name="show_time" required>
        <label>Price</label>
        <input type="number" name="price" value="180" step="0.01" required>
        <button class="btn primary full" type="submit">Add Show</button>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Movie</th>
                    <th>Theater</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shows as $show) : ?>
                    <tr>
                        <td><?php echo clean($show['title']); ?></td>
                        <td><?php echo clean($show['theater_name']); ?></td>
                        <td><?php echo clean($show['show_date']); ?></td>
                        <td><?php echo clean(substr($show['show_time'], 0, 5)); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once '../includes/admin_footer.php'; ?>
