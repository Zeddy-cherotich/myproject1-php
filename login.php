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
<link rel="stylesheet" href="style.css">
<h1>Login</h1>
<?php if ($message != "") { echo "<p style='text-align:center; color:red;'><b>$message</b></p>"; } ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button><br><br>
    <a href="register.php">No account? Register</a>
</form>