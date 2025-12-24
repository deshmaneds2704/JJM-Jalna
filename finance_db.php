<?php 
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
require_once('include/sweetAlert.php');
if(isset($_POST['submit'])){
    $taluka = $_POST['taluka'];
    $yojanaId = $_POST['yojanaId'];
    $subWork = $_POST['subWork'];
    $gst = $_POST['gst'];
    $q = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND name = '$subWork'");
    $r = mysqli_fetch_assoc($q);
    $remaining = $r['actualPrice'] - $amount;
    
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    foreach ($_POST['subWorkId'] as $subWork){
        echo "<br>".$subWork;
        echo "<br>".$amount = $_POST['amount'.$subWork];
        echo "<br>".$remarks = addslashes($_POST['remark'.$subWork]);
        $query = mysqli_query($con, "INSERT INTO `finance`(`subWorkId`, `remainingAmount`, `remark`, `amount`, `gst`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWork', '$remaining', '$remarks', '$amount', '$gst', '$yojanaId', '$userId', '$dateTime')") or die($con->error);    
    }
    // $query = mysqli_query($con, "INSERT INTO `finance`(`subWorkId`, `remainingAmount`, `remark`, `amount`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWork', '$remaining', '$remarks', '$amount', '$yojanaId', '$userId', '$dateTime')") or die($con->error);    
    
    
    //Msg
    if($query){
        $status = true;
        $msg = "Expenditure data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, expenditure data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: finance?taluka='.$taluka.'&yojanaId='.$yojanaId);
}
?>