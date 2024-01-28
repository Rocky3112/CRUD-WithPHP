<?php
$conn = new mysqli('localhost', 'root', '', 'authsystem','3307');

if ($conn->connect_error) {
    die('Error: ' . $conn->connect_error);
}

$firstName = $lastName = $email = $password = '';
$successMessage = '';
$errorMessage = '';

if (isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($firstName && $lastName && $email && $password && $confirmPassword) {
        // Validate email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/^[a-zA-Z_][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            // Check if the email is already registered
            $checkEmailSql = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $checkEmailSql->bind_param("s", $email);
            $checkEmailSql->execute();
            $checkEmailResult = $checkEmailSql->get_result();
            $emailCount = $checkEmailResult->fetch_row()[0];
            $checkEmailSql->close();
    
            if ($emailCount == 0) {
                if ($password === $confirmPassword) {
                    $uppercase = preg_match('/[A-Z]/', $password);
                    $lowercase = preg_match('/[a-z]/', $password);
                    $number = preg_match('/[0-9]/', $password);
                    $specialChar = preg_match('/[@$!%*?&]/', $password);
    
                    $regexCondition = $uppercase && $lowercase && $number && $specialChar && strlen($password) >= 8;
    
                    if ($regexCondition) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                        $sql = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
                        $sql->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
    
                        if ($sql->execute()) {
                            echo '<script>alert("Registration successful");</script>';
                            $successMessage = header('location: login.php?userCreated');
                        } else {
                            $errorMessage = "Error: " . $sql->error;
                        }
    
                        $sql->close();
                    } else {
                        $errorMessage = "Password should be 8 characters with at least one uppercase letter, one lowercase letter, one digit, and one special character.";
                    }
                } else {
                    $errorMessage = 'Passwords do not match.';
                }
            } else {
                $errorMessage = 'This email is already registered.';
            }
        } else {
            $errorMessage = 'Invalid email format.';
        }
    } else {
        $errorMessage = 'All fields are required.';
    }
    
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>

<section class="mainContainer">
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signUp.php" method="POST">
            <input type="text" name="firstName" placeholder="First Name" required>
            <br>
            <input type="text" name="lastName" placeholder="Last Name" required>
            <br>
            <input type="email" name="email" placeholder="Email" required>
            <br>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <input type="password" name="confirmPassword" placeholder="Confirm Password" required>
            <br>
            <button type="submit" name="submit">Sign Up</button>
        </form>
        <a href="login.php">Already have an account? Log In</a>

        <?php
        if ($successMessage) {
            echo '<div style="color: green;">' . $successMessage . '</div>';
        }
        if ($errorMessage) {
            echo '<div style="color: red;">' . $errorMessage . '</div>';
        }
        ?>
    </div>
</section>

</body>
</html>
