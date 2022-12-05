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

        $sql = "DELETE FROM `comments` WHERE `id` = '$id'";
        if($conn->query($sql)){
            echo json_encode(["success"=>"Feedback has successfully deleted!"]);
        }else{
            echo json_encode(["error"=>"Feedback has failed to delete!"]);

        }

    }



?>