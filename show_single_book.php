<?php require_once './database/connection.php'; ?>

<?php 
session_start();
// print_r($_SESSION['admin']);

if (isset($_SESSION['admin'])) {
} else {
    header('location: ./login.php');
}


$form_input = file_get_contents("php://input");
$_POST = json_decode($form_input, true);     //This is a method to get data from JS and decode it for php use.
    
    // var_dump($_POST);
    
    // echo json_encode($_POST);
    if (isset ($_POST['submit'])){
        $id = htmlspecialchars($_POST['id']);

        $sql = "SELECT * FROM `books` WHERE `id` = '$id'";
        $result= $conn->query($sql);
        $book = $result->fetch_assoc();
        echo json_encode($book);

    }