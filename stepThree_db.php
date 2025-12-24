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
    $surveyNo = $_POST['surveyNo'];
    $capacity = $_POST['capacity'];
    $yearOfConstruction = $_POST['yearOfConstruction'];
    $height = $_POST['height'];
    $typeOfConstruction = $_POST['typeOfConstruction'];
    $completionPercentage = $_POST['completionPercentage'];
    $video_link = $_POST['video_link'];
    $remarks = $_POST['remark'];
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    
    for($i=1;$i<=4;$i++){
        $docNames[$i] = addslashes($_POST['docName'.$i]);
        echo $document[$i] = addslashes($_FILES['photo'.$i]['name']);
        $tmp = $_FILES['photo'.$i]['tmp_name'];
        move_uploaded_file($tmp,"uploadedDoc/".$document[$i]);
        if($i==0){
            $longitudes .= $_POST['longitude'][$i];
            $latitudes .= $_POST['latitude'][$i];
        } else {
            $longitudes .= "@".$_POST['longitude'][$i];
            $latitudes .= "@".$_POST['latitude'][$i];
        }
    }
    
    //Elevated Service Reservoir
        if(isset($_POST['delayEsr'])){
            $delayEsr = $_POST['delayEsr'];
            if($delayEsr == "Yes"){
                
                $reason = $_POST['reasonEsr'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonEsr'];
                }
                
                $document = $_FILES['delayDocumentEsr']['name'];
                $tmp = $_FILES['delayDocumentEsr']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $photo = "";
                if(isset($_FILES['delayDocumentEsr']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Elevated Service Reservoir'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayEsr', '$reason', '$otherReason', 'Elevated Service Reservoir', '$document', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayEsr', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Elevated Service Reservoir'");
                }
                
            } else {
                $esr = $_POST['esrSchedule'];
                // $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayEsr' WHERE yojanaId = '$yojanaId' AND subWork = 'Elevated Service Reservoir'");
                
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayEsr', 'Elevated Service Reservoir', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayEsr' WHERE yojanaId = '$yojanaId' AND subWork = 'Elevated Service Reservoir'");
                }
                
                if(isset($_POST['esrSchedule'])){
                    $i = 0;
                    foreach ($_POST['esrSchedule'] as $esr){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$esr'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentEsr']['name'][$i];
                        $tmp = $_FILES['documentEsr']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$esr' AND yojanaId = '$yojanaId'");
                        if(mysqli_num_rows($q1) > 0){
                            $r1 = mysqli_fetch_assoc($q1);
                            if($document == ''){
                                $document = $r1['document'];
                            } else {
                                unlink($r1['document']);
                            }
                            $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delay', `reason` = '$reason', `document` = '$document' WHERE scheduleId = '$esr' AND yojanaId = '$yojanaId' ");   
                        } else {
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$esr', 'Elevated Service Reservoir', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Esr ".$con->error);
                        }
                        $exitSchedule .= "scheduleId !='" .$esr. "' AND ";
                        $i++;
                    }
                }
                $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'Elevated Service Reservoir'");
            }
        }
    
    $q = mysqli_query($con, "SELECT * FROM `stepThree` WHERE yojanaId = '$yojanaId'");
    $r = mysqli_fetch_assoc($q);
    
    if(mysqli_num_rows($q)<=0){
        foreach ($_POST['subWorkId'] as $subWorkId){
            $surveyNo = $_POST['surveyNo'.$subWorkId];
            $capacity = $_POST['capacity'].$subWorkId;
            $height = $_POST['height'.$subWorkId];
            $query = mysqli_query($con, "INSERT INTO `stepThree`(`subWorkId`, `surveyNo`, `capacity`, `yearOfConstruction`, `height`, `typeOfConstruction`, `docName1`, `docName2`, `docName3`,`docName4`, `photo1`, `photo2`, `photo3`, `photo4`, `longitude`, `latitude`, `completionPercentage`, `video_link`, `remark`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWorkId', '$surveyNo', '$capacity', '$yearOfConstruction', '$height', 'RCC', '{$docNames[1]}', '{$docNames[2]}', '{$docNames[3]}', '{$docNames[4]}', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$longitudes', '$latitudes', '$completionPercentage', '$video_link', '$remarks', '$yojanaId', '$userId', '$dateTime')");
        }
        
    } else {   
        $q2 = mysqli_query($con, "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='stepThree' AND COLUMN_NAME != 'id' AND COLUMN_NAME != 'yojanaId' AND COLUMN_NAME != 'surveyNo' AND COLUMN_NAME != 'subWorkId' AND COLUMN_NAME != 'capacity' AND COLUMN_NAME != 'height'");
        while($r2 = mysqli_fetch_assoc($q2)){
            $columnName = $r2['COLUMN_NAME'];
            $val = $_POST[$columnName];
            if($r2['DATA_TYPE'] == "text"){
                if($columnName == "remark"){
                    $val = $remarks;   
                    
                } else {
                    $val = $_FILES[$columnName]['name'];
                    $tmp = $_FILES[$columnName]['tmp_name'];
                    move_uploaded_file($tmp,"uploadedDoc/".$val);   
                }
            } else if($r2[$columnName] == "userId"){
                $val = $userId;
            } else if($r2[$columnName] == "dateTime"){
                $val = $dateTime;
            }
            
            if(!empty($val) && $val != $r[$columnName]){
                // echo "UPDATE `stepThree` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId' <br>";
                $query = mysqli_query($con, "UPDATE `stepThree` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId'");
            }
        }
        
        foreach ($_POST['subWorkId'] as $subWorkId){
            $surveyNo = $_POST['surveyNo'.$subWorkId];
            $capacity = $_POST['capacity'].$subWorkId;
            $height = $_POST['height'.$subWorkId];
            $query = mysqli_query($con, "UPDATE `stepThree` SET `surveyNo`='$surveyNo',`capacity`='$capacity',`video_link` = '$video_link',`height`='$height' WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'");
        }
        
        $query = mysqli_query($con, "UPDATE `stepThree` SET completionPercentage = '$completionPercentage' WHERE yojanaId = '$yojanaId'");
    }
    
    
    include('tpiVisit.php');
    tpiVisit($con, $yojanaId);
    
    //Msg
    if($query){
        $status = true;
        $msg = "Step three (ESR) data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: stepThree?yojanaId='.$yojanaId);
}
?>