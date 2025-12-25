<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/_con.php');
require_once('include/sweetAlert.php');
if(isset($_POST['submit'])){
    
    $contractor = addslashes($_POST['contractor']);
    $yojanaId = $_POST['yojanaId'];
    $dateOrder = $_POST['dateOrder'];
    $photo = $_FILES['photo']['name'];
    $video = $_POST['video'];
    $expenditureGross = $_POST['expenditureGross'];
    $expenditureNet = $_POST['expenditureNet'];
    $remark = $_POST['remark'];
    $billDetails = $_POST['billDetails'];
    $dateTime = date('Y-m-d H:i:s');
    
    $i=0;
    foreach($_FILES['photo']['name'] as $photo){
        $photo = addslashes($_FILES['photo']['name'][$i]);
        $type = $_FILES['photo']['type'][$i];
        $tmp = $_FILES['photo']['tmp_name'][$i];
        move_uploaded_file($tmp,"uploadedDoc/".$photo);
        if($i > 0){
            $photos .= "<br>".$photo;
        } else {
            $photos .= $photo;
        }
        $i++;
    }
    
    $i=1;
    foreach($_POST['video'] as $video){
        if($i > 1){
            $videos .= "<br>".$video;
        } else {
            $videos .= $video;
        }
        
        $i++;
    }
    
    $userId = $_SESSION['userId'];
    
    //Create User Query
    $query = mysqli_query($con, "INSERT INTO `bill_details` (`contractor`, `bill_details`, `photo`, `video`, `expenditureGross`, `expenditureNet`, `remarks`, `dateofWorkorder`, `yojanaId`, `userId`, `dateTime`) VALUES ('$contractor', '$billDetails', '$photos', '$videos', '$expenditureGross', '$expenditureNet', '$remark', '$dateOrder', '$yojanaId', '$userId', '$dateTime')") or die($con->error);
    
    if($query){
        $status = true;
        $msg = "Bill Details uploaded successfully";
    } else {
        $status = false;
        $msg = "Sorry, Bill Details can't be uploaded. Please try again";
    }
    
    setSession($status, $msg);
    
    header('location:uploadBillDetails');
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
    $query = mysqli_query($con, "DELETE FROM `bill_details` WHERE id = '$id'") or die($con->error);
    
    if($query){
        $status = true;
        $msg = "Bill Details has been deleted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Bill Details can't be delete. Please try again";
    }
    
    setSession($status, $msg);
    
    header('location:uploadBillDetails');
}
?>