<?php require_once './Database/connection.php' ?>


<?php
session_start();
// print_r($_SESSION['admin']);

if (isset($_SESSION['admin'])) {
} else {
    header('location: ./login.php');
}


$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);


$users = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($users);