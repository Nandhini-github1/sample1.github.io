<?php
session_start();

// Check if registration was successful
if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
    $registration_success = true;
    unset($_SESSION['registration_success']);
}

// Database connection
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
    } else {
        $login_error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
</head>
<body>
    <?php if (isset($registration_success) && $registration_success) { ?>
        <p>Registration successful. You can now log in.</p>
    <?php } ?>
    <h2>Login Form</h2>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" name="login" value="Login">
    </form>
    <?php if (isset($login_error)) { echo "<p>$login_error</p>"; } ?>
</body>
</html>
