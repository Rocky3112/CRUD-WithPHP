<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli('localhost', 'root', '', 'authsystem', '3307');

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];


    $picture = $_FILES['picture']['name'];
    $temp = $_FILES['picture']['tmp_name'];
    $file = 'images/' . $picture;

    move_uploaded_file($temp, $file);


    if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
        echo '<script>alert("Invalid name format. Name should contain only letters and spaces");</script>';
        echo '<script>window.location.href = document.referrer;</script>';
        $conn->close();
        exit();
    }

    if (!is_numeric($phone)) {
        echo '<script>alert("Invalid phone number format. Please enter only numeric characters.");</script>';
        echo '<script>window.location.href = document.referrer;</script>';
        $conn->close();
        exit();
    }

    if ($result->num_rows > 0) {
        echo '<script>alert("Error: Email already exists. Please choose a different email.");</script>';
        echo '<script>window.location.href = document.referrer;</script>';
        $conn->close();
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[^0-9]*[a-zA-Z0-9._-]*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
        echo '<script>alert("Invalid Email format.");</script>';
        echo '<script>window.location.href = document.referrer;</script>';
        $conn->close();
        exit();
    }


    $sql = "INSERT INTO employeeInfo (name, email, phone, age, gender,picture) VALUES (?, ?, ?, ?, ?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone, $age, $gender, $picture);

    if ($stmt->execute()) {
        // Data inserted successfully
        echo '<script> alert("User information stored successfully.");</script>';
        header('Location: index.php');
        exit();
    } else {
        // Error in SQL execution
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
?>