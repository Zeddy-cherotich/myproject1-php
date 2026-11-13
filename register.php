<?php
include 'db.php';
$message = "";
$message_type = "error";
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        $message = "Username already taken! Try another one or Login.";
    } else {
        $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
        $message = "Registered! Redirecting to Login...";
        $message_type = "success";
        echo "<script>setTimeout(function(){ window.location.href='login.php'; }, 1500);</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account | Student Portal</title>
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
            <h1>Create your account</h1>
            <p>Sign up to start managing student records.</p>
        </div>
        <?php if ($message !== "") { ?>
            <p class="alert <?php echo $message_type === 'success' ? 'alert-success' : ''; ?>" role="alert"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php } ?>
        <form class="auth-form" method="POST">
            <div class="field">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Choose a username" autocomplete="username" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Create a password" autocomplete="new-password" required>
            </div>
            <button class="button" type="submit" name="register">Create account</button>
        </form>
        <p class="auth-footer">Already have an account? <a href="login.php">Log in</a></p>
    </section>
</main>
</body>
</html>