<?php
session_start();

function isAuthenticated() {
    return isset($_SESSION['user_authenticated']) && $_SESSION['user_authenticated'] === true;
}

function authenticateUser($email, $password, $conn) {
    $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (md5($password, $hashedPassword)) {
            $_SESSION['user_authenticated'] = true;
            
            if (!isset($_SESSION['alert_shown'])) {
                $_SESSION['alert_shown'] = true;
                $_SESSION['show_alert'] = true;
            } else {
                $_SESSION['show_alert'] = false;
            }
            return true; 
        }
    }

    return false; 
}
?>
