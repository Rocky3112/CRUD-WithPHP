<?php
$conn = new mysqli('localhost', 'root', '', 'authsystem', '3307');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $employeeId = $_GET['id'];
    $sql = "DELETE FROM employeeInfo WHERE id = $employeeId";

    if ($conn->query($sql) === TRUE) {
        echo 'Record deleted successfully';
        header('Location: index.php');
    } else {
        echo 'Error deleting record: ' . $conn->error;
    }
} else {
    echo 'Invalid request.';
}

$conn->close();
?>
