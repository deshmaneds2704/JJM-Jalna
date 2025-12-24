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
    $pumpNumber = $_POST['pumpNumber'];
    $power = $_POST['power'];
    $installationYear = $_POST['installationYear'];
    $pumpingHours = $_POST['pumpingHours'];
    $pumpHouse = $_POST['pumpHouse'];
    $diameter = $_POST['diameter'];
    $length = $_POST['length'];
    $material = $_POST['material'];
    $completionPercentage = $_POST['completionPercentage'];
    $remarks = addslashes($_POST['remark']);
    $video_link = $_POST['video_link'];
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    $i=1;
    foreach ($_POST['docName'] as $docName){
        $document[$i] = addslashes($_FILES['photo'.$i]['name']);
        $tmp = $_FILES['photo'.$i]['tmp_name'][$i];
        move_uploaded_file($tmp,"uploadedDoc/".$document[$i]);
        if($i==0){
            $longitudes .= $_POST['longitude'][$i];
            $latitudes .= $_POST['latitude'][$i];
        } else {
            $longitudes .= "@".$_POST['longitude'][$i];
            $latitudes .= "@".$_POST['latitude'][$i];
        }
        $i++;
    }
    
    
    
    //Switch Room
        if(isset($_POST['delaySwitch'])){
            $delaySwitch = $_POST['delaySwitch'];
            if($delaySwitch == "Yes"){
                
                $reason = $_POST['reasonSwitch'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonSwitch'];
                }
                
                $document = $_FILES['delayDocumentSwitch']['name'];
                $tmp = $_FILES['delayDocumentSwitch']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $photo = "";
                if(isset($_FILES['delayDocumentSwitch']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delaySwitch', '$reason', '$otherReason', 'Switch Room', '$document', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delaySwitch', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                }
                
            } else {
                $switchRoom = $_POST['switchRoomSchedule'];
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                if(mysqli_num_rows($q0)<=0){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delaySwitch', 'Switch Room', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delaySwitch' WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                }
                
                if(isset($_POST['switchRoomSchedule'])){
                    $i = 0;
                    foreach ($_POST['switchRoomSchedule'] as $switchRoom){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$switchRoom'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentSwitch']['name'][$i];
                        $tmp = $_FILES['documentSwitch']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$switchRoom' AND yojanaId = '$yojanaId'");
                        if(mysqli_num_rows($q1) > 0){
                            $r1 = mysqli_fetch_assoc($q1);
                            if($document == ''){
                                $document = $r1['document'];
                            } else {
                                unlink($r1['document']);
                            }
                            $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delay', `reason` = '$reason', `document` = '$document' WHERE scheduleId = '$switchRoom' AND yojanaId = '$yojanaId' ");   
                        } else {
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$switchRoom', 'Switch Room', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Switch ".$con->error);
                        }
                        $exitSchedule .= "scheduleId !='" .$switchRoom. "' AND ";
                        $i++;
                    }
                }
                $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
            }
        }
        
        //Pumping Machinery
        if(isset($_POST['delayPumping'])){
            $delayPumping = $_POST['delayPumping'];
            if($delayPumping == "Yes"){
                
                $reason = $_POST['reasonPumping'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonPumping'];
                }
                
                $document = $_FILES['delayDocumentPumping']['name'];
                $tmp = $_FILES['delayDocumentPumping']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $photo = "";
                if(isset($_FILES['delayDocumentPumping']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPumping', '$reason', '$otherReason', 'Pumping Machinery', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPumping', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
                }
                
            } else {
                $pumpingMachinery = $_POST['pumpingMachinerySchedule'];
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
                if(mysqli_num_rows($q0)<=0){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPumping', 'Pumping Machinery', '$document', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPumping' WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
                }
                if(isset($_POST['pumpingMachinerySchedule'])){
                    $i = 0;
                    foreach ($_POST['pumpingMachinerySchedule'] as $pumpingMachinery){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$pumpingMachinery'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentPumping']['name'][$i];
                        $tmp = $_FILES['documentPumping']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$pumpingMachinery' AND yojanaId = '$yojanaId'");
                        if(mysqli_num_rows($q1) > 0){
                            $r1 = mysqli_fetch_assoc($q1);
                            if($document == ''){
                                $document = $r1['document'];
                            } else {
                                unlink($r1['document']);
                            }
                            $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delay', `reason` = '$reason', `document` = '$document' WHERE scheduleId = '$pumpingMachinery' AND yojanaId = '$yojanaId' ");   
                        } else {
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$pumpingMachinery', 'Pumping Machinery', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Pumping ".$con->error);
                        }
                        $exitSchedule .= "scheduleId !='" .$pumpingMachinery. "' AND ";
                        $i++;
                    }
                }
                $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
            }
        }
        
        
        //Rising Main
        if(isset($_POST['delayRising'])){
            $delayRising = $_POST['delayRising'];
            if($delayRising == "Yes"){
                
                $reason = $_POST['reasonRising'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonRising'];
                }
                
                $document = $_FILES['delayDocumentRising']['name'];
                $tmp = $_FILES['delayDocumentRising']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $photo = "";
                if(isset($_FILES['delayDocumentRising']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayRising', '$reason', '$otherReason', 'Rising Main', '$document', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayRising', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
                }
                
            } else {
                $risingMain = $_POST['risingMainSchedule'];
                $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayRising' WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayRising', 'Rising Main', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayRising' WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
                }
                if(isset($_POST['risingMainSchedule'])){
                    $i = 0;
                    foreach ($_POST['risingMainSchedule'] as $risingMain){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$risingMain'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentRising']['name'][$i];
                        $tmp = $_FILES['documentRising']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$risingMain' AND yojanaId = '$yojanaId'");
                        if(mysqli_num_rows($q1) > 0){
                            $r1 = mysqli_fetch_assoc($q1);
                            if($document == ''){
                                $document = $r1['document'];
                            } else {
                                unlink($r1['document']);
                            }
                            $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delay', `reason` = '$reason', `document` = '$document' WHERE scheduleId = '$risingMain' AND yojanaId = '$yojanaId' ");   
                        } else {
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$risingMain', 'Rising Main', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Rising ".$con->error);
                        }
                        $exitSchedule .= "scheduleId !='" .$risingMain. "' AND ";
                        $i++;
                    }
                }
                $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
            }
        }
    
    $q = mysqli_query($con, "SELECT * FROM `stepTwo` WHERE yojanaId = '$yojanaId'");
    $r = mysqli_fetch_assoc($q);
    
    if(mysqli_num_rows($q)<=0){
        $i = 0;
        foreach ($_POST['subWorkId'] as $subWorkId){
            $pumpNumber = $_POST['pumpNumber'.$subWorkId];
            $power = $_POST['power'.$subWorkId];
            $pumpingHours = $_POST['pumpingHours'.$subWorkId];
            $pumpHouse = $_POST['pumpHouse'.$subWorkId];
            $diameter = $_POST['diameter'.$subWorkId];
            $length = $_POST['length'.$subWorkId];
            $material = $_POST['material'.$subWorkId];
            
            $query = mysqli_query($con, "INSERT INTO `stepTwo`(`subWorkId`, `pumpNumber`, `power`, `installationYear`, `pumpingHours`, `pumpHouse`, `diameter`, `length`, `material`, `completionPercentage`, `photo1`, `photo2`, `photo3`, `photo4`, `video_link`, `longitude`, `latitude`, `remarks`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWorkId', '$pumpNumber', '$power', '$installationYear', '$pumpingHours', '$pumpHouse', '$diameter', '$length', '$material', '$completionPercentage', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$video_link', '$longitudes', '$latitudes', '$remarks', '$yojanaId', '$userId', '$dateTime')");
            $i++;
        }
        
    } else {
        $q2 = mysqli_query($con, "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='stepTwo' AND COLUMN_NAME != 'id' AND COLUMN_NAME != 'yojanaId' AND COLUMN_NAME != 'pumpingHours' AND COLUMN_NAME != 'pumpHouse' AND COLUMN_NAME != 'diameter' AND COLUMN_NAME != 'length' AND COLUMN_NAME != 'material' AND COLUMN_NAME != 'power' AND COLUMN_NAME != 'pumpNumber' AND COLUMN_NAME != 'subWorkId'");
        
        while($r2 = mysqli_fetch_assoc($q2)){
            $columnName = $r2['COLUMN_NAME'];
            $val = $_POST[$columnName];
            if($r2['DATA_TYPE'] == "text"){
                if($columnName == "remarks"){
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
                // echo "UPDATE `stepTwo` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId' <br>";
                $query = mysqli_query($con, "UPDATE `stepTwo` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId'");
            }
        }
        
        foreach ($_POST['subWorkId'] as $subWorkId){
            $pumpNumber = $_POST['pumpNumber'.$subWorkId];
            $power = $_POST['power'.$subWorkId];
            $pumpingHours = $_POST['pumpingHours'.$subWorkId];
            $pumpHouse = $_POST['pumpHouse'.$subWorkId];
            $diameter = $_POST['diameter'.$subWorkId];
            $length = $_POST['length'.$subWorkId];
            $material = $_POST['material'.$subWorkId];
            
            $query = mysqli_query($con, "UPDATE `stepTwo` SET `pumpNumber`='$pumpNumber',`power`='$power',`video_link` = '$video_link',`pumpingHours`='$pumpingHours',`pumpHouse`='$pumpHouse',`diameter`='$diameter',`length`='$length',`material`='$material' WHERE subWorkId = '$subWorkId' AND yojanaId = '$yojanaId'");
            $i++;
        }
        
        $query = mysqli_query($con, "UPDATE `stepTwo` SET completionPercentage = '$completionPercentage' WHERE yojanaId = '$yojanaId'");
        
    }
    
    include('tpiVisit.php');
    tpiVisit($con, $yojanaId);
    
    
    //Msg
    if($query){
        $status = true;
        $msg = "Step two (pump / rising main) data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: stepTwo?yojanaId='.$yojanaId);
}
?>