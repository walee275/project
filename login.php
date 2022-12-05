<?php require_once './database/connection.php' ?>

<?php
session_start();
// print_r($_SESSION['admin']);

if (isset($_SESSION['admin'])) {
    header('location: ./admin.php');
}
$email = $error = $success = "";





if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email)) {
        $error = "Please provide your email!";
    } elseif (empty($password)) {
        $error = "Please provide your password!";
    } else {
        // $new_password = md5($password);
        // $sql = "SELECT * FROM `users` WHERE `email` = '${email}'"; //AND `password` = '${new_password}';
        // $result = $conn->query($sql);
        // if($result->num_rows==1){
        $new_password = md5($password);
        $sql = "SELECT * FROM `admin` WHERE `email` = '$email'"; //AND `password` = '${new_password}'
        $result = $conn->query($sql);
        // $user = $result->fetch_assoc();

        // echo $new_password;
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $sql = "SELECT * FROM `admin` WHERE `password` = '$new_password'";
            $result = $conn->query($sql);
            if ($result->num_rows == 1) {
                $_SESSION['admin'] = [ "user-type"=>"admin"];
                // var_dump($user);
                header("location: ./admin.php");
                    // var_dump($_SESSION['admin']) ;
            } else {
                $error = "E-mail or password is incorrect";
            }
        } else {
            $error = "E-mail or password is incorrect";
        }
        // }else{

        //     echo $new_password;
        // }
        // $user = $result->fetch_assoc();
        // $_SESSION['email'] = $user['email'];
        // echo $_SESSION['email'];
        // 
        // }else{
        //     $error = "E-mail or password incorrect!";
        // }
    }
}

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL</title>
    <link rel="stylesheet" href="./login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="bg-dark">
    <div class="container" >
            <div class="row mt-5">
                <div class="col">
                    <div class="card shadow mt-5 col-5 mx-auto">
                        <!-- <div class="card-header text-dark text-center">ADMIN</div> -->
                        <div class="card-body">
                            <div class="container mb-1">
                                <div class="card-title text-center display-4">Admin Log In</div>
                                <p class="text-danger"><?php echo $error; ?></p>
                                <p class="text-success"><?php echo $success; ?></p>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control mb-3 shadow" placeholder="Please Enter Your E-mail" value="<?php echo $email; ?>">

                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control mb-2 shadow" placeholder="Please Enter Your Password">

                                    <div class="row">
                                        <input type="submit" value="Log In" name="submit" class="btn btn-dark text-light mt-4 mb-4 w-50 mx-auto">
                                    </div>
                                </form>
                            </div>
                            <!-- <p>Not registered?<a href="./my file.php" target="_blank">Register</a></p> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>













</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</html>