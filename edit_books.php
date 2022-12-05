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
if (isset($_POST['submit'])) {
    $booknameedit = htmlspecialchars($_POST['booknameedit']);
    $bookauthoredit = htmlspecialchars($_POST['bookauthoredit']);
    $bookdescedit = htmlspecialchars($_POST['bookdescedit']);
    $bookpriceedit = htmlspecialchars($_POST['bookpriceedit']);
    $book_publish_dateedit = htmlspecialchars($_POST['bookpublishDateedit']);
    $id = htmlspecialchars($_POST['id']);
    if (empty($booknameedit)) {
        echo json_encode(["errorNameedit" => "Please enter your book name!"]);
    } elseif (empty($bookauthoredit)) {
        echo json_encode(["errorAuthoredit" => "Please enter your book Author Name!"]);
    } elseif (empty($bookdescedit)) {
        echo json_encode(["errorDescedit" => "Please enter your book Description!"]);
    } elseif (empty($bookpriceedit)) {
        echo json_encode(["errorPriceedit" => "Please enter your book Price!"]);
    } elseif (empty($book_publish_dateedit)) {
        echo json_encode(["errorPublishDateedit" => "Please enter your book Publish Date!"]);
    } else {

        $sql = "SELECT * FROM `books` WHERE `title` = '$booknameedit' AND `id` != '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
            $sql = "UPDATE `books` SET `title`='$booknameedit',`description`=
            '$bookdescedit',`Author`='$bookauthoredit',`price`='$bookpriceedit',`img`='',`publishing_date`='$book_publish_dateedit' WHERE `id` = '$id'";
            if ($conn->query($sql)) {
                echo json_encode(["success" => "User successfully updated!"]);
            } else {
                echo json_encode(["error" => "User has failed to updated!"]);
            }
        } else {
            echo json_encode(["error" => "Book already Exist!"]);
        }
    }
}