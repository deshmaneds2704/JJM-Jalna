<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('include/con.php');
require_once('include/sweetAlert.php');
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    if (mysqli_num_rows($query) > 0) {
        $result = mysqli_fetch_assoc($query);
        $userId = $result['userId'];
        $dateTime = date('Y-m-d H:i:s');
        if ($result['username'] == $username && $result['password'] == $password) {
            $_SESSION['userId'] = $result['userId'];
            $_SESSION['designation'] = $result['designation'];
            $_SESSION['fullName'] = $result['fullName'];
            $query = mysqli_query($con, "INSERT INTO `loginLog`(`userId`, `dateTime`) VALUES ('$userId', '$dateTime')");

            
            // Determine redirect URL based on designation
            $redirectUrl = 'home'; // Default
            if($result['designation'] == "clerk"){
                $redirectUrl = 'createYojana';
            } else if($result['designation'] == "admin" || $result['designation'] == "executiveEng"){
                $redirectUrl = 'index';
            } else if($result['designation'] == "contractor"){
                $redirectUrl = 'agreementReport';
            }
            
            // Output JavaScript for redirection
            echo "<script>window.location.href = '$redirectUrl';</script>";
            exit();
            
        } else {
            $status = false;
            $msg = "Invalid Username or password. Please try again";
            setSession($status, $msg);
            echo "<script>window.location.href = 'login';</script>";
            exit();

            if ($result['designation'] == "clerk") {
                header('location:createYojana');
            } else if ($result['designation'] == "admin" || $result['designation'] == "executiveEng") {
                header('location:index');
            } else if ($result['designation'] == "contractor") {
                header('location:agreementReport');
            } else {
                header('location:home');
            }
        } else {

            $status = false;
            $msg = "Invalid Username or password. Please try again";

            setSession($status, $msg);

            header('location:login');

        }
    } else {
        $status = false;
        $msg = "Invalid Username or password. Please try again";
        setSession($status, $msg);
        echo "<script>window.location.href = 'login';</script>";
        exit();

        setSession($status, $msg);

        header('location:login');
    }
}
