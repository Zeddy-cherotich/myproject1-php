<?php
session_start();
include 'db.php';
$message = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    $user = $result->fetch_assoc();
    if (!$user) {
        $message = "User '$username' NOT FOUND. Please register first.";
    } elseif (!password_verify($password, $user['password'])) {
        $message = "Password WRONG for user '$username'.";
    } else {
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log in | Student Portal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card">
        <a class="brand auth-brand" href="login.php">
            <span class="brand-mark" aria-hidden="true">S</span>
            <span>STUDENT PORTAL</span>
        </a>
        <div class="auth-heading">
            <h1>Welcome back</h1>
            <p>Log in to manage your student records.</p>
        </div>
        <?php if ($message !== "") { ?>
            <p class="alert" role="alert"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php } ?>
        <form class="auth-form" method="POST">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Enter your username" autocomplete="username" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
            </div>
            <button class="button" type="submit" name="login">Log in</button>
        </form>
        <p class="auth-footer">Don't have an account? <a href="register.php">Create one</a></p>
    </section>
</main>
</body>
</html>