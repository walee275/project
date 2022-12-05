<?php require_once './database/connection.php'; ?>

<?php
session_start();
// print_r($_SESSION['admin']);

if (isset($_SESSION['admin'])) {
} else {
    header('location: ./login.php');
}

$form_input = file_get_contents("php://input");    //receiving data
$_POST = json_decode($form_input, true);
// var_dump($_POST);
// echo json_encode(['postValue' => `{$_POST['0']}`]);

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($name)) {
        echo json_encode(['emptyName' => 'Please enter your name!']);
    } elseif (empty($email)) {
        echo json_encode(['emptyEmail' => 'Please enter your email!']);
    } elseif (empty($password)) {
        echo json_encode(['emptyPassword' => 'Please enter your Password!']);
    }else {
        $sql = "SELECT * FROM `users` WHERE `email` = '${email}'";
        $result = $conn->query($sql);
        $new_password = md5($password);
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name','$email','$new_password')";
            if ($conn->query($sql)) {
                echo json_encode(['success' => 'User has been successfully added!']);
            } else {
                echo json_encode(['failed' => 'User has failed to add!']);
            }
        } else {
            echo json_encode(['emptyEmail' => 'Email already exists!']);
        }
    }
}
