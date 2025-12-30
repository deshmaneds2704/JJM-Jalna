<?php 
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
require_once('include/sweetAlert.php');

// Function to clean and format numbers
function cleanNumber($value) {
    // Remove commas, spaces, and non-numeric characters except decimal point
    $value = str_replace(',', '', $value);
    $value = preg_replace('/[^0-9\.]/', '', $value);
    
    // Convert to float
    $value = floatval($value);
    
    // Format to 2 decimal places
    return number_format($value, 2, '.', '');
}

if(isset($_POST['submit'])){
    // Sanitize text inputs
    $yojanaId = mysqli_real_escape_string($con, $_POST['yojanaId']);
    $contractor = mysqli_real_escape_string($con, $_POST['contractor']);
    $argeementNo = mysqli_real_escape_string($con, $_POST['argeementNo']);
    $timeLimit = mysqli_real_escape_string($con, $_POST['timeLimit']);
    $dateWorkOrder = mysqli_real_escape_string($con, $_POST['dateWorkOrder']);
    
    // Clean and format numeric values
    $tenderCost = cleanNumber($_POST['tenderCost']);
    $acceptedCost = cleanNumber($_POST['acceptedCost']);
    $percentage = cleanNumber($_POST['percentage']);
    
    $above_below = mysqli_real_escape_string($con, $_POST['above_below']);
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    // Debug (uncomment to see values)
    /*
    echo "<pre>";
    echo "Tender Cost: $tenderCost\n";
    echo "Accepted Cost: $acceptedCost\n";
    echo "Percentage: $percentage\n";
    echo "</pre>";
    die();
    */
    
    $query = mysqli_query($con, "INSERT INTO `agreement`(`contractor`, `yojanaId`, `agreementNo`, `timeLimit`, `dateOfWorkOrder`, `tenderCost`, `acceptedCost`, `percentage`, `above_below`, `userId`, `dateTime`) VALUES ('$contractor', '$yojanaId', '$argeementNo', '$timeLimit', '$dateWorkOrder', '$tenderCost', '$acceptedCost', '$percentage', '$above_below', '$userId', '$dateTime')");
    
    if(!$query) {
        // Show detailed error
        echo "MySQL Error: " . mysqli_error($con) . "<br>";
        echo "Query: INSERT INTO agreement VALUES(...)<br>";
        die();
    }
    
    //Msg
    if($query){
        $status = true;
        $msg = "Agreement data submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, data could not be submitted. Please try again";
    }
    
    setSession($status, $msg);
    header('location: agreement');
}

// Similar fix for update section
if(isset($_POST['update'])){
    $id = $_POST['update'];
    
    // Sanitize inputs (same as above)
    $yojanaId = mysqli_real_escape_string($con, $_POST['yojanaId']);
    $contractor = mysqli_real_escape_string($con, $_POST['contractor']);
    $argeementNo = mysqli_real_escape_string($con, $_POST['argeementNo']);
    $timeLimit = mysqli_real_escape_string($con, $_POST['timeLimit']);
    $dateWorkOrder = mysqli_real_escape_string($con, $_POST['dateWorkOrder']);
    
    $tenderCost = cleanNumber($_POST['tenderCost']);
    $acceptedCost = cleanNumber($_POST['acceptedCost']);
    $percentage = cleanNumber($_POST['percentage']);
    
    $above_below = mysqli_real_escape_string($con, $_POST['above_below']);
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    $query = mysqli_query($con, "UPDATE `agreement` SET `contractor`='$contractor', `yojanaId`='$yojanaId',`agreementNo`='$argeementNo',`timeLimit`='$timeLimit',`dateOfWorkOrder`='$dateWorkOrder',`tenderCost`='$tenderCost',`acceptedCost`='$acceptedCost',`percentage`='$percentage',`above_below`='$above_below',`userId`='$userId',`dateTime`='$dateTime' WHERE id = '$id'");
    
    if(!$query) {
        echo "MySQL Error: " . mysqli_error($con);
        die();
    }
    
    //Msg
    if($query){
        $status = true;
        $msg = "Agreement data updated successfully";
    } else {
        $status = false;
        $msg = "Sorry, data could not be updated. Please try again";
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
        $msg = "Agreement data deleted successfully";
    } else {
        $status = false;
        $msg = "Sorry, agreement could not be deleted. Please try again";
    }
    
    setSession($status, $msg);
    header('location: agreementReport');
}
?>