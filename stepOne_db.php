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
    $typeOfSource = $_POST['typeOfSource'];
    $diameter = $_POST['diameter'];
    $depth = $_POST['depth'];
    $yearOfConstruction = $_POST['yearOfConstruction'];
    $typeOfStructure = $_POST['typeOfStructure'];
    $completionPercentage = $_POST['completionPercentage'];
    $remark = addslashes($_POST['remark']);
    $userId = $_SESSION['userId'];
    
    $video_link = $_POST['video_link'];
    $dateTime = date('Y-m-d H:i:s');
    
    for($i=1;$i<=4;$i++){
        $document[$i] = addslashes($_FILES['photo'.$i]['name']);
        $tmp = $_FILES['photo'.$i]['tmp_name'];
        move_uploaded_file($tmp,"uploadedDoc/".$document[$i]);
        if($i==0){
            $longitudes .= $_POST['longitude'.$i];
            $latitudes .= $_POST['latitude'.$i];
        } else {
            $longitudes .= "@".$_POST['longitude'.$i];
            $latitudes .= "@".$_POST['latitude'.$i];
        }
    }
    
    if($document[2] == ""){
        $q3 = mysqli_query($con, "SELECT * FROM uploadDoc WHERE docName = 'Source Certificate' AND yojanaId = '$yojanaId' AND document !='' ");
        $r3 = mysqli_fetch_assoc($q3);
        $document[2] = $r3['document'];
    }
    
    $q = mysqli_query($con, "SELECT * FROM `stepOne` WHERE yojanaId = '$yojanaId'");
    $r = mysqli_fetch_assoc($q);
    
    if(mysqli_num_rows($q)<=0){
        
        
        foreach ($_POST['subWorkId'] as $subWorkId){
            
            $diameter = $_POST['diameter'.$subWorkId];
            $depth = $_POST['depth'.$subWorkId];
            $typeOfSource = $_POST['typeOfSource'.$subWorkId];
            $typeOfStructure = $_POST['typeOfStructure'.$subWorkId];
            
            $query = mysqli_query($con, "INSERT INTO `stepOne` (`subWorkId`, `typeOfSource`, `diameter`, `depth`, `yearOfConstruction`, `typeOfStructure`, `photo1`, `photo2`, `photo3`, `photo4`, `longitude`, `latitude`,   `completionPercentage`, `remark`, `video_link`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWorkId', '$typeOfSource','$diameter', '$depth', '$yearOfConstruction', '$typeOfStructure', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$longitudes', '$latitudes', '$completionPercentage', '$remark', '$video_link', '$yojanaId', '$userId', '$dateTime')");
        }
        
        //Trial Bore
        if(isset($_POST['delayTrial'])){
            $delayTrial = $_POST['delayTrial'];
            if($delayTrial == "Yes"){
                
                $reason = $_POST['reasonTrial'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonTrial'];
                }
                
                $document = $_FILES['delayDocumentTrial']['name'];
                $tmp = $_FILES['delayDocumentTrial']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayTrial', '$reason', '$otherReason', 'Trial Bore', '$document', '$yojanaId', '$userId', '$dateTime')");
                
            } else {
                if(isset($_POST['trialBoreSchedule'])){
                    $trialBore = $_POST['trialBoreSchedule'];
                    $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$trialBore'");
                    $r3 = mysqli_fetch_assoc($q3);
                    $percentage = $r3['percentage'];
                    $document = $_FILES['documentTrial']['name'];
                    $tmp = $_FILES['documentTrial']['tmp_name'];
                    move_uploaded_file($tmp,"uploadedDoc/".$document);
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayTrial', 'Trial Bore', '$yojanaId', '$userId', '$dateTime')");
                    
                    // $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayTrial' WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                    $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$trialBore', 'Trial Bore', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')");
                }
            }
        }
        
        //Percolation Well
        if(isset($_POST['delayPercolation'])){
            $delayPercolation = $_POST['delayPercolation'];
            if($delayPercolation == "Yes"){
                
                $reason = $_POST['reasonPercolation'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonPercolation'];
                }
                
                $document = $_FILES['delayDocumentPercolation']['name'];
                $tmp = $_FILES['delayDocumentPercolation']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPercolation', '$reason', '$otherReason', 'Percolation Well', '$document', '$yojanaId', '$userId', '$dateTime')");
            } else {
                $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPercolation' WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                if(isset($_POST['percolationWellSchedule'])){
                    $i = 0;
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`,`yojanaId`, `userId`, `dateTime`) VALUES ('$delayPercolation', 'Percolation Well', '$yojanaId', '$userId', '$dateTime')");
                    foreach ($_POST['percolationWellSchedule'] as $percolationWellSchedule){
                        
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$percolationWellSchedule'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentPercolation']['name'][$i];
                        $tmp = $_FILES['documentPercolation']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$percolationWellSchedule', 'Percolation Well', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')");
                        $i++;
                        
                    }
                }
            }
        }
        
        //Approach Bund
        if(isset($_POST['delayApproach'])){
            $delayApproach = $_POST['delayApproach'];
            if($delayApproach == "Yes"){
                
                $reason = $_POST['reasonApproach'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonApproach'];
                }
                
                $document = $_FILES['delayDocumentApproach']['name'];
                $tmp = $_FILES['delayDocumentApproach']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayApproach', '$reason', '$otherReason', 'Approach Bund', '$document', '$yojanaId', '$userId', '$dateTime')");
            } else {
                $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayApproach' WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                if(isset($_POST['approachBundSchedule'])){
                    $i = 0;
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`,`yojanaId`, `userId`, `dateTime`) VALUES ('$delayApproach', 'Approach Bund', '$yojanaId', '$userId', '$dateTime')");
                    foreach ($_POST['approachBundSchedule'] as $approachBundSchedule){
                        
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$approachBundSchedule'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentApproach']['name'][$i];
                        $tmp = $_FILES['documentApproach']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$approachBundSchedule', '$reason', '$otherReason', 'Approach Bund', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')");
                        $i++;
                        
                    }
                }
            }
        }
        
        
    } else {
        // echo "update";
        $q2 = mysqli_query($con, "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='stepOne' AND COLUMN_NAME != 'id' AND COLUMN_NAME != 'yojanaId' AND COLUMN_NAME != 'diameter' AND COLUMN_NAME != 'depth' AND COLUMN_NAME != 'typeOfSource' AND COLUMN_NAME != 'typeOfStructure' AND COLUMN_NAME != 'subWorkId'");
        while($r2 = mysqli_fetch_assoc($q2)){
            $columnName = $r2['COLUMN_NAME'];
            $val = $_POST[$columnName];
            if($r2['DATA_TYPE'] == "text"){
                if($columnName == "remark"){
                    $val = $remark;   
                    
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
                // echo "UPDATE `stepOne` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId' <br>";
                $query = mysqli_query($con, "UPDATE `stepOne` SET ".$columnName." = '".addslashes($val)."' WHERE yojanaId = '$yojanaId'");
            }
        }
        
        
        foreach ($_POST['subWorkId'] as $subWorkId){
            $diameter = $_POST['diameter'.$subWorkId];
            $depth = $_POST['depth'.$subWorkId];
            $typeOfSource = $_POST['typeOfSource'.$subWorkId];
            $typeOfStructure = $_POST['typeOfStructure'.$subWorkId];
            
            $query = mysqli_query($con, "UPDATE `stepOne` SET `diameter` = '$diameter', `depth` = '$depth', `video_link` = '$video_link', `typeOfStructure` = '$typeOfStructure', `typeOfSource` = '$typeOfSource' WHERE subWorkId = '$subWorkId' AND yojanaId = '$yojanaId'");
        }
        
        $query = mysqli_query($con, "UPDATE `stepOne` SET completionPercentage = '$completionPercentage' WHERE yojanaId = '$yojanaId'");
        
        
        //Trial Bore
        if(isset($_POST['delayTrial'])){
            $delayTrial = $_POST['delayTrial'];
            if($delayTrial == "Yes"){
                
                $reason = $_POST['reasonTrial'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonTrial'];
                }
                
                $document = $_FILES['delayDocumentTrial']['name'];
                $tmp = $_FILES['delayDocumentTrial']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $photo = "";
                if(isset($_FILES['delayDocumentTrial']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayTrial', '$reason', '$otherReason', 'Trial Bore', '$document', '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayTrial', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                }
                
            } else {
                $trialBore = $_POST['trialBoreSchedule'];
                if(isset($_POST['trialBoreSchedule'])){
                    $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$trialBore'");
                    $r3 = mysqli_fetch_assoc($q3);
                    $percentage = $r3['percentage'];
                    $document = $_FILES['documentTrial']['name'];
                    $tmp = $_FILES['documentTrial']['tmp_name'];
                    move_uploaded_file($tmp,"uploadedDoc/".$document);
                    $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayTrial' WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                    $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$trialBore' AND yojanaId = '$yojanaId'");
                    if(mysqli_num_rows($q1) > 0){
                        $r1 = mysqli_fetch_assoc($q1);
                        if($document == ''){
                            $document = $r1['document'];
                        } else {
                            unlink($r1['document']);
                        }
                        $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delay', `reason` = '$reason', `document` = '$document' WHERE scheduleId = '$trialBore' AND yojanaId = '$yojanaId' ");   
                    } else {
                        $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$trialBore', 'Trial Bore', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Trial ".$con->error);
                    }
                    $exitSchedule .= "scheduleId !='" .$trialBore. "' AND ";
                }
                $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
            }
        }
        
        
        //Percolation Well
        if(isset($_POST['delayPercolation'])){
            $delayPercolation = $_POST['delayPercolation'];
            if($delayPercolation == "Yes"){
                
                $reason = $_POST['reasonPercolation'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonPercolation'];
                }
                
                $document = $_FILES['delayDocumentPercolation']['name'];
                $tmp = $_FILES['delayDocumentPercolation']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $photo = "";
                if(isset($_FILES['delayDocumentPercolation']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPercolation', '$reason', '$otherReason', 'Percolation Well', '$document', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPercolation', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                }
                
            } else {
                $percolationWell = $_POST['percolationWellSchedule'];
                if(isset($_POST['percolationWellSchedule'])){
                    $i = 0;
                    foreach ($_POST['percolationWellSchedule'] as $percolationWell){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$percolationWell'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentPercolation']['name'][$i];
                        $tmp = $_FILES['documentPercolation']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPercolation' WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                        $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$percolationWell' AND yojanaId = '$yojanaId'");
                        if(mysqli_num_rows($q1) > 0){
                            $r1 = mysqli_fetch_assoc($q1);
                            if($document == ''){
                                $document = $r1['document'];
                            } else {
                                // unlink($r1['document']);
                            }
                            $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delay', `reason` = '$reason', `document` = '$document' WHERE scheduleId = '$percolationWell' AND yojanaId = '$yojanaId' ");   
                        } else {
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$percolationWell', 'Percolation Well', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Percolation ".$con->error);
                        }
                        $exitSchedule .= "scheduleId !='" .$percolationWell. "' AND ";
                        $i++;
                    }
                }
                $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
            }
        }
        
        
        //Approach Bund
        if(isset($_POST['delayApproach'])){
            $delayApproach = $_POST['delayApproach'];
            if($delayApproach == "Yes"){
                
                $reason = $_POST['reasonApproach'];
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonApproach'];
                }
                
                $document = $_FILES['delayDocumentApproach']['name'];
                $tmp = $_FILES['delayDocumentApproach']['tmp_name'];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                
                $photo = "";
                if(isset($_FILES['delayDocumentApproach']['name'])){
                    $photo = " `photo` = '$document', ";
                }
                
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                if(mysqli_num_rows($q0)<=0){
                
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayApproach', '$reason', '$otherReason', 'Approach Bund', '$document', '$yojanaId', '$userId', '$dateTime')");
                    
                } else {
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPercolation', `reason` = '$reason', `otherReason` = '$otherReason', $photo `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                }
                
            } else {
                $approachBund = $_POST['approachBundSchedule'];
                if(isset($_POST['approachBundSchedule'])){
                    foreach ($_POST['approachBundSchedule'] as $approachBund){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$approachBund'");
                        $r3 = mysqli_fetch_assoc($q3);
                        $percentage = $r3['percentage'];
                        $document = $_FILES['documentApproach']['name'][$i];
                        $tmp = $_FILES['documentApproach']['tmp_name'][$i];
                        move_uploaded_file($tmp,"uploadedDoc/".$document);
                        $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayApproach' WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                        $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$approachBund' AND yojanaId = '$yojanaId'");
                        if(mysqli_num_rows($q1) > 0){
                            $r1 = mysqli_fetch_assoc($q1);
                            if($document == ''){
                                $document = $r1['document'];
                            } else {
                                // unlink($r1['document']);
                            }
                            $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delay', `reason` = '$reason', `document` = '$document' WHERE scheduleId = '$approachBund' AND yojanaId = '$yojanaId' ");   
                        } else {
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUE ('$approachBund', 'Approach Bund', '$percentage', '$delay', '$reason', '$document', '1', '$yojanaId', '$userId', '$dateTime')") or die("Approach ".$con->error);
                        }
                        $exitSchedule .= "scheduleId !='" .$approachBund. "' AND ";
                    }
                    $q4 = mysqli_query($con, "DELETE FROM schedule WHERE 1 AND $exitSchedule yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                }
            }
        }
        
    }
    
    include('tpiVisit.php');
    tpiVisit($con, $yojanaId);
    
    //Msg
    if($query){
        $status = true;
        $msg = "Step one (source) data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submit. Please try again";
    }
    
    setSession($status, $msg);
    header('location: stepOne?yojanaId='.$yojanaId);
}
?>