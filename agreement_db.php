<?php 
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
require_once('include/sweetAlert.php');
if(isset($_POST['submit'])){
    $yojanaId = $_POST['yojanaId'];
    $contractor = $_POST['contractor'];
    $argeementNo = $_POST['argeementNo'];
    $timeLimit = $_POST['timeLimit'];
    $dateWorkOrder = $_POST['dateWorkOrder'];
    $tenderCost = $_POST['tenderCost'];
    $acceptedCost = $_POST['acceptedCost'];
    $percentage = $_POST['percentage'];
    $above_below = $_POST['above_below'];
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    
    $query = mysqli_query($con, "INSERT INTO `agreement`(`contractor`, `yojanaId`, `agreementNo`, `timeLimit`, `dateOfWorkOrder`, `tenderCost`, `acceptedCost`, `percentage`, `above_below`, `userId`, `dateTime`) VALUES ('$contractor', '$yojanaId', '$argeementNo', '$timeLimit', '$dateWorkOrder', '$tenderCost', '$acceptedCost', '$percentage', '$above_below', '$userId', '$dateTime')");
    
    //Msg
    if($query){
        $status = true;
        $msg = " Argeement data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: agreement');
}

if(isset($_POST['update'])){
    $yojanaId = $_POST['yojanaId'];
    $contractor = $_POST['contractor'];
    $argeementNo = $_POST['argeementNo'];
    $timeLimit = $_POST['timeLimit'];
    $dateWorkOrder = $_POST['dateWorkOrder'];
    $tenderCost = $_POST['tenderCost'];
    $acceptedCost = $_POST['acceptedCost'];
    $percentage = $_POST['percentage'];
    $above_below = $_POST['above_below'];
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    $id = $_POST['update'];
    
    $query = mysqli_query($con, "UPDATE `agreement` SET `contractor`='$contractor', `yojanaId`='$yojanaId',`agreementNo`='$argeementNo',`timeLimit`='$timeLimit',`dateOfWorkOrder`='$dateWorkOrder',`tenderCost`='$tenderCost',`acceptedCost`='$acceptedCost',`percentage`='$percentage',`above_below`='$above_below',`userId`='$userId',`dateTime`='$dateTime' WHERE id = '$id'") or die($con->error);
    
    //Msg
    if($query){
        $status = true;
        $msg = " Argeement data is updated successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be update. Please try again";
    }
    
    setSession($status, $msg);
    header('location: agreementReport');
    
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $query = mysqli_query($con, "DELETE FROM `agreement` WHERE id = '$id'");
    
    //Msg
    if($query){
        $status = true;
        $msg = " Argeement data is deleted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Argeement can't be delete. Please try again";
    }
    
    setSession($status, $msg);
    header('location: agreementReport');
}
?>