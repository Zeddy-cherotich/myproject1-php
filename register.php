<?php
include 'db.php';
$message = "";
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        $message = "Username already taken! Try another one or Login.";
    } else {
        $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
        $message = "Registered! Redirecting to Login...";
        echo "<script>setTimeout(function(){ window.location.href='login.php'; }, 1500);</script>";
    }
}
?>
<link rel="stylesheet" href="style.css">
<h1>Register</h1>
<?php if ($message != "") { echo "<p style='text-align:center; color:green;'><b>$message</b></p>"; } ?>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="register">Register</button><br><br>
    <a href="login.php">Already have account? Login</a>
</form>