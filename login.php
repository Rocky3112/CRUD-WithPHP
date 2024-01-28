<?php
require_once 'auth.php';

$conn = new mysqli('localhost', 'root', '', 'authsystem','3307');

$unsuccessfulmsg = '';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        if (authenticateUser($email, $password, $conn)) {
            header('Location: index.php');
            exit();
        } else {
            $unsuccessfulmsg = "Incorrect email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>

    <div class="main">
        <div class="formContainer">
            <h2>Login</h2>
            <form action="" method="POST">
                <input class="inputAll" type="email" name="email" required>
                <br>
                <input class="inputAll" type="password" name="password" required>
                <br>
                <button type="submit" name="submit">Login</button>
            </form>
            <a href="signUp.php">Don't have an account? Sign UP</a>
            <?php

            if ($unsuccessfulmsg) {
                echo '<div style="color: red;">' . $unsuccessfulmsg . '</div>';
            }
            ?>
        </div>
    </div>

</body>

</html>