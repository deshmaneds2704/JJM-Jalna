<?php 
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
require_once('include/sweetAlert.php');

if(isset($_POST['submit'])){
    $yojanaId = $_POST['yojanaId'] ?? '';
    $userId = $_SESSION['userId'];
    $dateTime = date('Y-m-d H:i:s');
    
    // Initialize variables with default values
    $typeOfSource = $_POST['typeOfSource'] ?? '';
    $diameter = $_POST['diameter'] ?? '';
    $depth = $_POST['depth'] ?? '';
    $yearOfConstruction = $_POST['yearOfConstruction'] ?? date('Y');
    $typeOfStructure = $_POST['typeOfStructure'] ?? 'RCC';
    $completionPercentage = $_POST['completionPercentage'] ?? 0;
    $remark = addslashes($_POST['remark'] ?? '');
    $video_link = $_POST['video_link'] ?? '';
    
    // Initialize document array
    $document = array(1 => '', 2 => '', 3 => '', 4 => '');
    for($i=1;$i<=4;$i++){
        if(isset($_FILES['photo'.$i]['name']) && !empty($_FILES['photo'.$i]['name'])){
            $document[$i] = addslashes($_FILES['photo'.$i]['name']);
            $tmp = $_FILES['photo'.$i]['tmp_name'];
            move_uploaded_file($tmp, "uploadedDoc/".$document[$i]);
        }
    }
    
    // Initialize longitude and latitude variables
    $longitudes = '';
    $latitudes = '';
    for($i=1;$i<=4;$i++){
        $lon = $_POST['longitude'.$i] ?? '0';
        $lat = $_POST['latitude'.$i] ?? '0';
        if($i == 1){
            $longitudes = $lon;
            $latitudes = $lat;
        } else {
            $longitudes .= "@" . $lon;
            $latitudes .= "@" . $lat;
        }
    }
    
    // Check for existing source certificate
    if(empty($document[2])){
        $q3 = mysqli_query($con, "SELECT * FROM uploadDoc WHERE docName = 'Source Certificate' AND yojanaId = '$yojanaId' AND document !='' ");
        if(mysqli_num_rows($q3) > 0){
            $r3 = mysqli_fetch_assoc($q3);
            $document[2] = $r3['document'] ?? '';
        }
    }
    
    $q = mysqli_query($con, "SELECT * FROM `stepOne` WHERE yojanaId = '$yojanaId'");
    $r = mysqli_fetch_assoc($q) ?? array();
    
    if(mysqli_num_rows($q) <= 0){
        // INSERT new record
        if(isset($_POST['subWorkId']) && is_array($_POST['subWorkId'])){
            foreach ($_POST['subWorkId'] as $subWorkId){
                $subWorkDiameter = $_POST['diameter'.$subWorkId] ?? $diameter;
                $subWorkDepth = $_POST['depth'.$subWorkId] ?? $depth;
                $subWorkTypeOfSource = $_POST['typeOfSource'.$subWorkId] ?? $typeOfSource;
                $subWorkTypeOfStructure = $_POST['typeOfStructure'.$subWorkId] ?? $typeOfStructure;
                
                $query = mysqli_query($con, "INSERT INTO `stepOne` (`subWorkId`, `typeOfSource`, `diameter`, `depth`, `yearOfConstruction`, `typeOfStructure`, `photo1`, `photo2`, `photo3`, `photo4`, `longitude`, `latitude`, `completionPercentage`, `remark`, `video_link`, `yojanaId`, `userId`, `dateTime`) 
                VALUES ('$subWorkId', '$subWorkTypeOfSource', '$subWorkDiameter', '$subWorkDepth', '$yearOfConstruction', '$subWorkTypeOfStructure', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$longitudes', '$latitudes', '$completionPercentage', '$remark', '$video_link', '$yojanaId', '$userId', '$dateTime')");
            }
        } else {
            // Insert without subWorkId
            $query = mysqli_query($con, "INSERT INTO `stepOne` (`typeOfSource`, `diameter`, `depth`, `yearOfConstruction`, `typeOfStructure`, `photo1`, `photo2`, `photo3`, `photo4`, `longitude`, `latitude`, `completionPercentage`, `remark`, `video_link`, `yojanaId`, `userId`, `dateTime`) 
            VALUES ('$typeOfSource', '$diameter', '$depth', '$yearOfConstruction', '$typeOfStructure', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$longitudes', '$latitudes', '$completionPercentage', '$remark', '$video_link', '$yojanaId', '$userId', '$dateTime')");
        }
        
        // Handle Trial Bore
        if(isset($_POST['delayTrial'])){
            $delayTrial = $_POST['delayTrial'];
            if($delayTrial == "Yes"){
                $reason = $_POST['reasonTrial'] ?? '';
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonTrial'] ?? '';
                }
                
                $delayDoc = $_FILES['delayDocumentTrial']['name'] ?? '';
                if(!empty($delayDoc)){
                    $tmp = $_FILES['delayDocumentTrial']['tmp_name'];
                    move_uploaded_file($tmp, "uploadedDoc/".$delayDoc);
                }
                
                // FIXED: Check if scheduleId column exists and handle accordingly
                $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
                $hasScheduleId = false;
                while($col = mysqli_fetch_assoc($tableCheck)){
                    if($col['Field'] == 'scheduleId'){
                        $hasScheduleId = true;
                        break;
                    }
                }
                
                if($hasScheduleId){
                    // Table has scheduleId column - include it with value 0
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) 
                    VALUES ('$delayTrial', '$reason', '$otherReason', 'Trial Bore', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    // Table doesn't have scheduleId column
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) 
                    VALUES ('$delayTrial', '$reason', '$otherReason', 'Trial Bore', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                }
                
            } else {
                if(isset($_POST['trialBoreSchedule'])){
                    $trialBore = $_POST['trialBoreSchedule'] ?? '';
                    if(!empty($trialBore)){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$trialBore'");
                        if(mysqli_num_rows($q3) > 0){
                            $r3 = mysqli_fetch_assoc($q3);
                            $percentage = $r3['percentage'] ?? 0;
                            $documentTrial = $_FILES['documentTrial']['name'] ?? '';
                            if(!empty($documentTrial)){
                                $tmp = $_FILES['documentTrial']['tmp_name'];
                                move_uploaded_file($tmp, "uploadedDoc/".$documentTrial);
                            }
                            
                            // Check if delay record exists
                            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                            if(mysqli_num_rows($q0) <= 0){
                                // Check if scheduleId column exists
                                $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
                                $hasScheduleId = false;
                                while($col = mysqli_fetch_assoc($tableCheck)){
                                    if($col['Field'] == 'scheduleId'){
                                        $hasScheduleId = true;
                                        break;
                                    }
                                }
                                
                                if($hasScheduleId){
                                    // Include scheduleId with value from scheduleMaster
                                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) 
                                    VALUES ('$delayTrial', 'Trial Bore', '$trialBore', '$yojanaId', '$userId', '$dateTime')");
                                } else {
                                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) 
                                    VALUES ('$delayTrial', 'Trial Bore', '$yojanaId', '$userId', '$dateTime')");
                                }
                            }
                            
                            // Insert into schedule table
                            $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) 
                            VALUES ('$trialBore', 'Trial Bore', '$percentage', '$delayTrial', '', '$documentTrial', '1', '$yojanaId', '$userId', '$dateTime')");
                        }
                    }
                }
            }
        }
        
        // Handle Percolation Well
        if(isset($_POST['delayPercolation'])){
            $delayPercolation = $_POST['delayPercolation'];
            if($delayPercolation == "Yes"){
                $reason = $_POST['reasonPercolation'] ?? '';
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonPercolation'] ?? '';
                }
                
                $delayDoc = $_FILES['delayDocumentPercolation']['name'] ?? '';
                if(!empty($delayDoc)){
                    $tmp = $_FILES['delayDocumentPercolation']['tmp_name'];
                    move_uploaded_file($tmp, "uploadedDoc/".$delayDoc);
                }
                
                // Check if scheduleId column exists
                $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
                $hasScheduleId = false;
                while($col = mysqli_fetch_assoc($tableCheck)){
                    if($col['Field'] == 'scheduleId'){
                        $hasScheduleId = true;
                        break;
                    }
                }
                
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) 
                    VALUES ('$delayPercolation', '$reason', '$otherReason', 'Percolation Well', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) 
                    VALUES ('$delayPercolation', '$reason', '$otherReason', 'Percolation Well', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                }
                
            } else {
                // Update delay status
                $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPercolation' WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                
                if(isset($_POST['percolationWellSchedule']) && is_array($_POST['percolationWellSchedule'])){
                    $i = 0;
                    // Insert delay record if not exists
                    $qCheck = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                    if(mysqli_num_rows($qCheck) <= 0){
                        // Check if scheduleId column exists
                        $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
                        $hasScheduleId = false;
                        while($col = mysqli_fetch_assoc($tableCheck)){
                            if($col['Field'] == 'scheduleId'){
                                $hasScheduleId = true;
                                break;
                            }
                        }
                        
                        if($hasScheduleId){
                            $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) 
                            VALUES ('$delayPercolation', 'Percolation Well', 0, '$yojanaId', '$userId', '$dateTime')");
                        } else {
                            $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) 
                            VALUES ('$delayPercolation', 'Percolation Well', '$yojanaId', '$userId', '$dateTime')");
                        }
                    }
                    
                    foreach ($_POST['percolationWellSchedule'] as $percolationWellSchedule){
                        if(!empty($percolationWellSchedule)){
                            $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$percolationWellSchedule'");
                            if(mysqli_num_rows($q3) > 0){
                                $r3 = mysqli_fetch_assoc($q3);
                                $percentage = $r3['percentage'] ?? 0;
                                
                                $documentPercolation = $_FILES['documentPercolation']['name'][$i] ?? '';
                                if(!empty($documentPercolation)){
                                    $tmp = $_FILES['documentPercolation']['tmp_name'][$i];
                                    move_uploaded_file($tmp, "uploadedDoc/".$documentPercolation);
                                }
                                
                                // Insert into schedule table
                                $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) 
                                VALUES ('$percolationWellSchedule', 'Percolation Well', '$percentage', '$delayPercolation', '', '$documentPercolation', '1', '$yojanaId', '$userId', '$dateTime')");
                            }
                            $i++;
                        }
                    }
                }
            }
        }
        
        // Handle Approach Bund
        if(isset($_POST['delayApproach'])){
            $delayApproach = $_POST['delayApproach'];
            if($delayApproach == "Yes"){
                $reason = $_POST['reasonApproach'] ?? '';
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonApproach'] ?? '';
                }
                
                $delayDoc = $_FILES['delayDocumentApproach']['name'] ?? '';
                if(!empty($delayDoc)){
                    $tmp = $_FILES['delayDocumentApproach']['tmp_name'];
                    move_uploaded_file($tmp, "uploadedDoc/".$delayDoc);
                }
                
                // Check if scheduleId column exists
                $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
                $hasScheduleId = false;
                while($col = mysqli_fetch_assoc($tableCheck)){
                    if($col['Field'] == 'scheduleId'){
                        $hasScheduleId = true;
                        break;
                    }
                }
                
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) 
                    VALUES ('$delayApproach', '$reason', '$otherReason', 'Approach Bund', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) 
                    VALUES ('$delayApproach', '$reason', '$otherReason', 'Approach Bund', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                }
                
            } else {
                // Update delay status
                $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayApproach' WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                
                if(isset($_POST['approachBundSchedule']) && is_array($_POST['approachBundSchedule'])){
                    $i = 0;
                    // Insert delay record if not exists
                    $qCheck = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                    if(mysqli_num_rows($qCheck) <= 0){
                        // Check if scheduleId column exists
                        $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
                        $hasScheduleId = false;
                        while($col = mysqli_fetch_assoc($tableCheck)){
                            if($col['Field'] == 'scheduleId'){
                                $hasScheduleId = true;
                                break;
                            }
                        }
                        
                        if($hasScheduleId){
                            $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) 
                            VALUES ('$delayApproach', 'Approach Bund', 0, '$yojanaId', '$userId', '$dateTime')");
                        } else {
                            $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) 
                            VALUES ('$delayApproach', 'Approach Bund', '$yojanaId', '$userId', '$dateTime')");
                        }
                    }
                    
                    foreach ($_POST['approachBundSchedule'] as $approachBundSchedule){
                        if(!empty($approachBundSchedule)){
                            $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$approachBundSchedule'");
                            if(mysqli_num_rows($q3) > 0){
                                $r3 = mysqli_fetch_assoc($q3);
                                $percentage = $r3['percentage'] ?? 0;
                                
                                $documentApproach = $_FILES['documentApproach']['name'][$i] ?? '';
                                if(!empty($documentApproach)){
                                    $tmp = $_FILES['documentApproach']['tmp_name'][$i];
                                    move_uploaded_file($tmp, "uploadedDoc/".$documentApproach);
                                }
                                
                                // Insert into schedule table
                                $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) 
                                VALUES ('$approachBundSchedule', 'Approach Bund', '$percentage', '$delayApproach', '', '$documentApproach', '1', '$yojanaId', '$userId', '$dateTime')");
                            }
                            $i++;
                        }
                    }
                }
            }
        }
        
    } else {
        // UPDATE existing record
        if(isset($_POST['subWorkId']) && is_array($_POST['subWorkId'])){
            foreach ($_POST['subWorkId'] as $subWorkId){
                $subWorkDiameter = $_POST['diameter'.$subWorkId] ?? $diameter;
                $subWorkDepth = $_POST['depth'.$subWorkId] ?? $depth;
                $subWorkTypeOfSource = $_POST['typeOfSource'.$subWorkId] ?? $typeOfSource;
                $subWorkTypeOfStructure = $_POST['typeOfStructure'.$subWorkId] ?? $typeOfStructure;
                
                $query = mysqli_query($con, "UPDATE `stepOne` SET `diameter` = '$subWorkDiameter', `depth` = '$subWorkDepth', `video_link` = '$video_link', `typeOfStructure` = '$subWorkTypeOfStructure', `typeOfSource` = '$subWorkTypeOfSource' WHERE subWorkId = '$subWorkId' AND yojanaId = '$yojanaId'");
            }
        }
        
        // Update other fields
        $updateFields = array();
        if(!empty($document[1])) $updateFields[] = "photo1 = '{$document[1]}'";
        if(!empty($document[2])) $updateFields[] = "photo2 = '{$document[2]}'";
        if(!empty($document[3])) $updateFields[] = "photo3 = '{$document[3]}'";
        if(!empty($document[4])) $updateFields[] = "photo4 = '{$document[4]}'";
        if(!empty($longitudes)) $updateFields[] = "longitude = '$longitudes'";
        if(!empty($latitudes)) $updateFields[] = "latitude = '$latitudes'";
        if(!empty($remark)) $updateFields[] = "remark = '$remark'";
        if(!empty($video_link)) $updateFields[] = "video_link = '$video_link'";
        $updateFields[] = "completionPercentage = '$completionPercentage'";
        $updateFields[] = "yearOfConstruction = '$yearOfConstruction'";
        $updateFields[] = "dateTime = '$dateTime'";
        
        if(!empty($updateFields)){
            $updateQuery = "UPDATE `stepOne` SET " . implode(", ", $updateFields) . " WHERE yojanaId = '$yojanaId'";
            $query = mysqli_query($con, $updateQuery);
        }
        
        // Handle Trial Bore updates
        if(isset($_POST['delayTrial'])){
            $delayTrial = $_POST['delayTrial'];
            if($delayTrial == "Yes"){
                $reason = $_POST['reasonTrial'] ?? '';
                $otherReason = "";
                if($reason == "Other"){
                    $otherReason = $_POST['otherReasonTrial'] ?? '';
                }
                
                $delayDoc = $_FILES['delayDocumentTrial']['name'] ?? '';
                if(!empty($delayDoc)){
                    $tmp = $_FILES['delayDocumentTrial']['tmp_name'];
                    move_uploaded_file($tmp, "uploadedDoc/".$delayDoc);
                }
                
                $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                if(mysqli_num_rows($q0) <= 0){
                    // Check if scheduleId column exists
                    $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
                    $hasScheduleId = false;
                    while($col = mysqli_fetch_assoc($tableCheck)){
                        if($col['Field'] == 'scheduleId'){
                            $hasScheduleId = true;
                            break;
                        }
                    }
                    
                    if($hasScheduleId){
                        $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) 
                        VALUES ('$delayTrial', '$reason', '$otherReason', 'Trial Bore', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                    } else {
                        $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) 
                        VALUES ('$delayTrial', '$reason', '$otherReason', 'Trial Bore', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                    }
                } else {
                    $photoUpdate = !empty($delayDoc) ? "`photo` = '$delayDoc', " : "";
                    $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayTrial', `reason` = '$reason', `otherReason` = '$otherReason', $photoUpdate `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                }
                
            } else {
                if(isset($_POST['trialBoreSchedule'])){
                    $trialBore = $_POST['trialBoreSchedule'] ?? '';
                    if(!empty($trialBore)){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$trialBore'");
                        if(mysqli_num_rows($q3) > 0){
                            $r3 = mysqli_fetch_assoc($q3);
                            $percentage = $r3['percentage'] ?? 0;
                            $documentTrial = $_FILES['documentTrial']['name'] ?? '';
                            if(!empty($documentTrial)){
                                $tmp = $_FILES['documentTrial']['tmp_name'];
                                move_uploaded_file($tmp, "uploadedDoc/".$documentTrial);
                            }
                            
                            // Update delay record
                            $q0 = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayTrial' WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                            
                            // Check if schedule exists
                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$trialBore' AND yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                            if(mysqli_num_rows($q1) > 0){
                                $r1 = mysqli_fetch_assoc($q1);
                                if(empty($documentTrial) && !empty($r1['document'])){
                                    $documentTrial = $r1['document'];
                                }
                                
                                $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `delay` = '$delayTrial', `reason` = '', `document` = '$documentTrial' WHERE scheduleId = '$trialBore' AND yojanaId = '$yojanaId' AND subWork = 'Trial Bore'");
                            } else {
                                $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `delay`, `reason`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) 
                                VALUES ('$trialBore', 'Trial Bore', '$percentage', '$delayTrial', '', '$documentTrial', '1', '$yojanaId', '$userId', '$dateTime')");
                            }
                        }
                    }
                }
            }
        }
    }
    
    // Include TPI visit tracking
    if(file_exists('tpiVisit.php')){
        include('tpiVisit.php');
        if(function_exists('tpiVisit')){
            tpiVisit($con, $yojanaId);
        }
    }
    
    // Set success/error message
    if(isset($query) && $query){
        $status = true;
        $msg = "Step one (source) data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submitted. Please try again";
    }
    
    setSession($status, $msg);
    header('location: stepOne.php?yojanaId='.$yojanaId);
    exit();
}
?>