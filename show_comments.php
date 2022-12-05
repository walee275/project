<?php require_once './database/connection.php' ?>


<?php
session_start();
// print_r($_SESSION['admin']);

if (isset($_SESSION['admin'])) {
} else {
    header('location: ./login.php');
}

$sql = "SELECT * FROM `comments`";
$result = $conn->query($sql);


$comments = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($comments);