<?php
$pageTitle = 'Register';
require_once 'includes/header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $statement = $pdo->prepare('INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, "user")');
        $statement->execute([$name, $email, $phone, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['name'] = $name;
        $_SESSION['role'] = 'user';
        header('Location: movies.php');
        exit;
    } catch (PDOException $error) {
        $message = 'This email is already registered.';
    }
}
?>

<section class="auth-page">
    <form class="form-card" method="POST">
        <h1>Create account</h1>
        <p>Register once and book your favorite seats anytime.</p>
        <?php if ($message) : ?><div class="alert error"><?php echo clean($message); ?></div><?php endif; ?>
        <label>Full Name</label>
        <input type="text" name="name" required>
        <label>Email</label>
        <input type="email" name="email" required>
        <label>Phone</label>
        <input type="text" name="phone" required>
        <label>Password</label>
        <input type="password" name="password" minlength="6" required>
        <button class="btn primary full" type="submit">Register</button>
        <p class="form-note">Already registered? <a href="login.php">Login</a></p>
    </form>
</section>

<?php require_once 'includes/footer.php'; ?>
