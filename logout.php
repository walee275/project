<?php require_once './Database/connection.php'; ?>

<?php 
session_start();
// var_dump($_SESSION['id']);

if(isset ($_SESSION['admin'])){
unset($_SESSION['admin']);
//  echo "hi";
header("location: ./login.php");
}
?>