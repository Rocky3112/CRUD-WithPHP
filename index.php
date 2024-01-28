<?php
require_once 'auth.php';


if (!isAuthenticated()) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
    
</head>
<body>
<header>
    <nav class="navBar">
        <div>
            <h2>AHAR</h2>
        </div>
        <div class="navContainer">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="index.php">Blog</a></li>
                <button type="button" class=" btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Add Employee</button>
                <!-- <li><a href="login.php">Log In</a></li>
                <li><a href="logOut.php">Log Out</a></li> -->
                <?php
                require_once 'auth.php';
                 if(isAuthenticated()){
                    echo '<li><a href="logOut.php">Log Out</a></li>';

                 }
                 else{
                    echo '<li><a href="login.php">Log In</a></li>';
                 }
                ?>
            </ul>
        </div>
    </nav>
</header>
<div class="">
    <h1>Welcome to the Home Page</h1>
    <?php
    
    if (isset($_SESSION['show_alert']) && $_SESSION['show_alert']) {
        echo '<script>alert("Login successful");</script>';
        $_SESSION['show_alert'] = false; 
    }
    ?>
   
</div>
<div>
<?php
// Fetch data from the database
$conn = new mysqli('localhost', 'root', '', 'authsystem','3307');
$sql = "SELECT * FROM employeeInfo";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table border="1" class="table mx-5" >
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Picture</th>
                <th>Action</th>
                
            </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['name'] . '</td>
                        <td>' . $row['email'] . '</td>
                        <td>' . $row['phone'] . '</td>
                        <td>' . $row['age'] . '</td>
                        <td>' . $row['gender'] . '</td>
                        <td><img src="images/' . $row['picture'] . '" height="70" /></td>
                        <td class ="d-flex gap-2"><a href="update_data.php?id=' . $row['id'] . '"><button type="button" class="btn btn-warning">Edit</button> </a>
                        <a href="delete_data.php?id=' . $row['id'] . '"><button type="button" class="btn btn-danger">Delete</button></a>
                        </td>
                        <td></td>
                      </tr>';
            }
            

    echo '</table>';
} else {
    echo 'No records found.';
}

$conn->close();
?>
</div>

<div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form to collect user information -->
                    <form action="process.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="picture">Select Picture:</label>
                            <input type="file" class="form-control-file" id="picture" name="picture"  required>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
