
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
    $yojanaComplete = $_POST['yojanaComplete'];
    $reason = $_POST['reason'];
    $dateOfCommissioning = $_POST['dateOfCommissioning'];
    $dateOfHandingOver = $_POST['dateOfHandingOver'];
    $datesOfTpiVisit1 = $_POST['datesOfTpiVisit1'];
    $datesOfTpiVisit2 = $_POST['datesOfTpiVisit2'];
    $datesOfTpiVisit3 = $_POST['datesOfTpiVisit3'];
    $dateOfCompletion = $_POST['dateOfCompletion'];
    $video_link = $_POST['video_link'];
    $completionPercentage = $_POST['completionPercentage'];
    $remarks = $_POST['remark'];
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    $i=1;
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
    
    
    
    //MSEDC Work
        if(isset($_POST['delayMsedc'])){
            $delayMsedc = $_POST['delayMsedc'];
            if($delayMsedc == "Yes"){
                
                $reason = $_POST['reasonMsedc'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonMsedc'];
                }
                
                $document = $_FILES['delayDocumentMsedc']['name'];
                $tmp = $_FILES['delayDocumentMsedc']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $photo = "";
                if(isset($_FILES['delayDocumentMsedc']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayMsedc', '$reason', '$otherReason', 'MSEDC Work', '$document', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayMsedc', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
                }
                
            } else {
                $esr = $_POST['msedcSchedule'];
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayMsedc', 'MSEDC Work', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayMsedc' WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
                }
                if(isset($_POST['msedcSchedule'])){
                    $i = 0;
                    foreach ($_POST['msedcSchedule'] as $esr){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$esr'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentMsedc']['name'][$i];
                        $tmp = $_FILES['documentMsedc']['tmp_name'][$i];
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
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$esr', 'MSEDC Work', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Msedc ".$con->error);
                        }
                        $exitSchedule .= "scheduleId !='" .$esr. "' AND ";
                        $i++;
                    }
                }
                $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
            }
        }
    
    $q = mysqli_query($con, "SELECT * FROM `stepFive` WHERE yojanaId = '$yojanaId'");
    $r = mysqli_fetch_assoc($q);
    
    if(mysqli_num_rows($q)<=0){
        $query = mysqli_query($con, "INSERT INTO `stepFive`(`yojanaComplete`, `reason`, `dateOfCommissioning`, `dateOfHandingOver`, `datesOfTpiVisit1`, `datesOfTpiVisit2`, `datesOfTpiVisit3`, `dateOfCompletion`, `completionPercentage`, `docName1`, `docName2`, `docName3`, `docName4`, `photo1`, `photo2`, `photo3`, `photo4`, `longitude`, `latitude`, `video_link`, `remark`, `yojanaId`, `userId`, `dateTime`) VALUES ('$yojanaComplete', '$reason', '$dateOfCommissioning', '$dateOfHandingOver', '$datesOfTpiVisit1', '$datesOfTpiVisit2', '$datesOfTpiVisit3', '$dateOfCompletion', '$completionPercentage', '{$docNames[1]}', '{$docNames[2]}', '{$docNames[3]}', '{$docNames[4]}', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$longitudes', '$latitudes', '$video_link', '$remarks', '$yojanaId', '$userId', '$dateTime')");
    } 
    
    else {   
        $q2 = mysqli_query($con, "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='stepFive' AND COLUMN_NAME != 'id' AND COLUMN_NAME != 'yojanaId'");
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
            } else if($columnName == "userId"){
                $val = $userId;
            } else if($columnName == "dateTime"){
                $val = $dateTime;
            }
            
            if(!empty($val) && $val != $r[$columnName]){
                // echo "UPDATE `stepThree` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId' <br>";
                $query = mysqli_query($con, "UPDATE `stepFive` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId'");
            }
        }
        
        $query = mysqli_query($con, "UPDATE `stepFive` SET completionPercentage = '$completionPercentage', `video_link` = '$video_link', WHERE yojanaId = '$yojanaId'");
    }
    
    //Msg
    if($query){
        $status = true;
        $msg = "Step five (trial run) data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: stepFive?yojanaId='.$yojanaId);
    
    //msg
    /*$query1=mysqli_query($con,"select * from stepFive where completionPercentage=100");
    if($query1){
        $status = true;
        $msg = "Yojana has been completed";
    } else {
        $status = false;
        $msg = "Yojana has not been completed";
    }
    
    setSession($status, $msg);
    header('location: stepFive?yojanaId='.$yojanaId);
    */
    
}
?>
