<?php
$pageTitle = 'Login';
require_once 'includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepared statements protect the database from SQL injection.
    $statement = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $statement->execute([$email]);
    $user = $statement->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header('Location: ' . ($user['role'] === 'admin' ? 'admin/index.php' : 'movies.php'));
        exit;
    }

    $message = 'Invalid email or password.';
}
?>

<section class="auth-page">
    <form class="form-card" method="POST">
        <h1>Welcome back</h1>
        <p>Login to book seats and view your booking history.</p>
        <?php if ($message) : ?><div class="alert error"><?php echo clean($message); ?></div><?php endif; ?>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button class="btn primary full" type="submit">Login</button>
        <p class="form-note">New here? <a href="register.php">Create an account</a></p>
    </form>
</section>

<?php require_once 'includes/footer.php'; ?>
