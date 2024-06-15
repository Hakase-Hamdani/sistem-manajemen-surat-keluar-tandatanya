<?php
session_start();
include 'db.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize inputs
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['level'] = $row['level'];

        if ($row['status'] == 0) {
            header("Location: 404.php");
            exit();
        } else if ($row['status'] == 1) {
            if ($row['level'] == 0) {
                header("Location: plain_page.php?id=" . $row['id']);
                exit();
            } else if ($row['level'] == 1) {
                header("Location: edit_page.php?id=" . $row['id']);
                exit();
            } else if ($row['level'] == 2) {
            	 header("Location: atasan_page.php?id=" . $row['id']);
                exit();
        		}
    } else {
        echo "Invalid username or password.";
    }

    $result->free();
    $conn->close();
	 }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="themes/midnight-green.css">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
