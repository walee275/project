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

// echo json_encode($_POST);
if (isset($_POST['submit'])) {
    $bookname = htmlspecialchars($_POST['bookname']);
    $bookauthor = htmlspecialchars($_POST['bookauthor']);
    $bookdesc = htmlspecialchars($_POST['bookdesc']);
    $bookprice = htmlspecialchars($_POST['bookprice']);
    $book_publish_date = htmlspecialchars($_POST['bookpublishDate']);

    if (empty($bookname)) {
        echo json_encode(["errorName" => "Please enter your book name!"]);
    } elseif (empty($bookauthor)) {
        echo json_encode(["errorAuthor" => "Please enter your book Author Name!"]);
    } elseif (empty($bookdesc)) {
        echo json_encode(["errorDesc" => "Please enter your book Description!"]);
    } elseif (empty($bookprice)) {
        echo json_encode(["errorPrice" => "Please enter your book Price!"]);
    } elseif (empty($book_publish_date)) {
        echo json_encode(["errorPublishDate" => "Please enter your book Publish Date!"]);
    } else {
        $sql = "INSERT INTO `books`(`title`, `description`, `Author`, `price`, `img`, `publishing_date`) VALUES 
        ('$bookname','$bookdesc','$bookauthor','$bookprice','','$book_publish_date')";
        if ($conn->query($sql)) {
            echo json_encode(["success" => "Successfully submitted"]);
        } else {
            json_encode(["errorQuery" => "Book has failed to Add!"]);

            // echo json_encode(["success" => "Successfully submitted"]);
        }
    }
}
