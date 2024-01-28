<?php
$conn = new mysqli('localhost', 'root', '', 'authsystem', '3307');

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$successMessage = $errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $employeeId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $sql = "UPDATE employeeInfo SET 
            name = '$name', 
            email = '$email', 
            phone = '$phone', 
            age = '$age', 
            gender = '$gender' 
            WHERE id = $employeeId";

    if ($conn->query($sql) === TRUE) {
        $successMessage = 'Record updated successfully.';
    } else {
        $errorMessage = 'Error updating record: ' . $conn->error;
    }
}

// Fetch data for the form
$sql = "SELECT * FROM employeeInfo WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Employee</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>

    <?php
    // Display success or error message
    if (!empty($successMessage)) {
        echo '<p style="color: green;">' . $successMessage . '</p>';
    }
    if (!empty($errorMessage)) {
        echo '<p style="color: red;">' . $errorMessage . '</p>';
    }
    ?>

<form action="" method="post" enctype="multipart/form-data" class="px-10">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="age">Age:</label>
        <input type="number" class="form-control" id="age" name="age" value="<?php echo $row['age']; ?>" required>
    </div>
    
    <div class="form-group">
        <label for="gender">Gender:</label>
        <select class="form-control" id="gender" name="gender" required>
            <option value="male" <?php echo ($row['gender'] === 'male') ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo ($row['gender'] === 'female') ? 'selected' : ''; ?>>Female</option>
            <option value="other" <?php echo ($row['gender'] === 'other') ? 'selected' : ''; ?>>Other</option>
        </select>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

    </body>
    </html>
    <?php
} else {
    echo 'Record not found.';
}

// Close the connection at the end of the file
$conn->close();
?>
