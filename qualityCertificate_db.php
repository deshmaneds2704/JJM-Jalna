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
    $uploadedDate = date('Y-m-d H:i:s');
    $userId = $_SESSION['userId'];
    $i=0;
    foreach ($_POST['docName'] as $docName){
        $docName = addslashes($docName);
        $step = $_POST['step'.$i];
        $subWork = $_POST['subWork'][$i];
        $document = addslashes(time().$_FILES['document']['name'][$i]);
        $type = $_FILES['document']['type'][$i];
        $tmp = $_FILES['document']['tmp_name'][$i];
        move_uploaded_file($tmp,"uploadedDoc/".$document);
        $longitude = $_POST['longitude'][$i];
        $latitude = $_POST['latitude'][$i];
        $query = mysqli_query($con, "INSERT INTO `uploadDoc`( `yojanaId`, `stepNo`, `subWork`, `docName`, `document`, `type`, `longitude`, `latitude`, `userId`, `uploadedDate`) VALUES ('$yojanaId', '$step', '$subWork', '$docName', '$document', '$type', '$longitude', '$latitude', '$userId', '$uploadedDate')");
        $i++;
    }
    
    //Msg
    if($query){
        $status = true;
        $msg = "Documents are uploaded successfully";
    } else {
        $status = false;
        $msg = "Sorry, Documents can't be upload. Please try again";
    }
    
    setSession($status, $msg);
    header('location: qualityCertificate?yojanaId='.$yojanaId);
}
?>