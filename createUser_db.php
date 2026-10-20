<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
require_once('include/sweetAlert.php');
if(isset($_POST['submit'])){
    $userId = uniqid('jjm');
    $fullName = addslashes($_POST['fullName']);
    $mobileNumber = $_POST['mobileNumber'];
    $designation = $_POST['designation'];
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['confirmPassword']);
    $createdDate = date('Y-m-d H:i:s');
    $email = '';
    
    //Create User Query
    $query = mysqli_query($con, "INSERT INTO `users`(`userId`, `fullName`, `email`, `mobileNo`, `designation`, `department`, `username`, `password`, `createdDate`, `level`) VALUES ('$userId', '$fullName', '$email', '$mobileNumber', '$designation', '', '$username', '$password', '$createdDate', 0)");
    
    if($query){
        $status = true;
        $msg = "User has been created successfully";
    } else {
        $status = false;
        $msg = "Sorry, User can't be created. Please try again";
    }
    
    setSession($status, $msg);
    
    header('location:createUser');
}
if(isset($_POST['update'])){
    $userId = $_POST['userId'];
    $fullName = addslashes($_POST['fullName']);
    $mobileNumber = $_POST['mobileNumber'];
    $designation = $_POST['designation'];
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['confirmPassword']);
    $updatedDate = date('Y-m-d H:i:s');
    
    $query = mysqli_query($con, "UPDATE `users` SET `fullName`= '$fullName', `mobileNo`='$mobileNumber', `designation`='$designation', `username`='$username', `password`='$password', `createdDate` = '$updatedDate' WHERE userId = '$userId' ");
    
    if($query){
        $status = true;
        $msg = "User has been updated successfully";
    } else {
        $status = false;
        $msg = "Sorry, User can't be update. Please try again";
    }
    
    setSession($status, $msg);
    
    header('location:createUser');
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $query = mysqli_query($con, "DELETE FROM `users` WHERE id = '$id'");
    
    if($query){
        $status = true;
        $msg = "User has been deleted successfully";
    } else {
        $status = false;
        $msg = "Sorry, User can't be delete. Please try again";
    }
    
    setSession($status, $msg);
    
    header('location:createUser');
}
?>