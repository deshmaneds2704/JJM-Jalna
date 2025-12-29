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
    $gst = $_POST['gst'];
    
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    // Initialize a flag to track if all queries succeed
    $allQueriesSuccess = true;
    
    foreach ($_POST['subWorkId'] as $subWorkId){
        $amount = $_POST['amount'.$subWorkId] ?? 0;
        $remarks = addslashes($_POST['remark'.$subWorkId] ?? '');
        
        // Get the actual price for this subwork
        $q = mysqli_query($con, "SELECT actualPrice FROM subWork WHERE id = '$subWorkId'");
        $r = mysqli_fetch_assoc($q);
        $actualPrice = $r['actualPrice'] ?? 0;
        
        // Calculate remaining amount
        $actualPrice = (float)$actualPrice;
        $amount = (float)$amount;
        $remaining = $actualPrice - $amount;
        
        $query = mysqli_query($con, "INSERT INTO `finance`(`subWorkId`, `remainingAmount`, `remark`, `amount`, `gst`, `yojanaId`, `userId`, `dateTime`) 
                                   VALUES ('$subWorkId', '$remaining', '$remarks', '$amount', '$gst', '$yojanaId', '$userId', '$dateTime')");
        
        if(!$query){
            $allQueriesSuccess = false;
        }
    }
    
    //Msg
    if($allQueriesSuccess){
        $status = true;
        $msg = "Expenditure data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, expenditure data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: finance?taluka='.$taluka.'&yojanaId='.$yojanaId);
    exit();
}
?>