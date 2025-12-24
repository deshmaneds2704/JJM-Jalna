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
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    /*$i=0;
    foreach ($_POST['docName'] as $docName){
        $document[$i] = addslashes(time().$_FILES['document']['name'][$i]);
        $tmp = $_FILES['document']['tmp_name'][$i];
        move_uploaded_file($tmp,"uploadedDoc/".$document[$i]);
        if($i==0){
            $longitudes .= $_POST['longitude'][$i];
            $latitudes .= $_POST['latitude'][$i];
        } else {
            $longitudes .= "@".$_POST['longitude'][$i];
            $latitudes .= "@".$_POST['latitude'][$i];
        }
        $i++;
    }*/
    
    $i=0;
    foreach ($_POST['subWork'] as $subWork){
        $subWork = addslashes($subWork);
        $amount = $_POST['amount'][$i];
        $remarks = addslashes($_POST['remark'][$i]);
        $query = mysqli_query($con, "INSERT INTO `finance`(`subWorkId`, `remark`, `amount`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWork', '$remarks', '$amount', '$yojanaId', '$userId', '$dateTime')");
        $i++;
    }
    
    
    //Msg
    if($query){
        $status = true;
        $msg = "Your finance data is submit sucessfully";
    } else {
        $status = false;
        $msg = "Sorry, your finance data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: finance');
}
?>