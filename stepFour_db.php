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
    $material = $_POST['material'] ?? '';
    $length = $_POST['length'] ?? 0;
    $completionPercentage = $_POST['completionPercentage'] ?? 0;
    $remarks = addslashes($_POST['remark'] ?? '');
    $video_link = $_POST['video_link'] ?? '';
    
    // Initialize document arrays
    $docNames = array(1 => '', 2 => '', 3 => '', 4 => '');
    $document = array(1 => '', 2 => '', 3 => '', 4 => '');
    
    // Initialize longitude and latitude variables
    $longitudes = '';
    $latitudes = '';
    
    // Create upload directory if it doesn't exist
    $uploadDir = "uploadedDoc/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Handle document uploads
    for($i=1;$i<=4;$i++){
        $docNames[$i] = addslashes($_POST['docName'.$i] ?? '');
        
        if(isset($_FILES['photo'.$i]['name']) && !empty($_FILES['photo'.$i]['name'])){
            $document[$i] = addslashes($_FILES['photo'.$i]['name']);
            $tmp = $_FILES['photo'.$i]['tmp_name'];
            // Sanitize filename
            $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $document[$i]);
            $uploadPath = $uploadDir . $filename;
            
            if(move_uploaded_file($tmp, $uploadPath)){
                $document[$i] = $filename; // Store sanitized filename
            } else {
                $document[$i] = ''; // Failed to upload
            }
        }
        
        // Handle longitude and latitude
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
    
    // Check if scheduleId column exists in delayYojanas table
    $tableCheck = mysqli_query($con, "SHOW COLUMNS FROM delayYojanas");
    $hasScheduleId = false;
    while($col = mysqli_fetch_assoc($tableCheck)){
        if($col['Field'] == 'scheduleId'){
            $hasScheduleId = true;
            break;
        }
    }
    
    // Handle Distribution System
    if(isset($_POST['delayDistribution'])){
        $delayDistribution = $_POST['delayDistribution'];
        if($delayDistribution == "Yes"){
            $reason = $_POST['reasonDistribution'] ?? '';
            $otherReason = "";
            if($reason == "Other"){
                $otherReason = $_POST['otherReasonDistribution'] ?? '';
            }
            
            $delayDoc = $_FILES['delayDocumentDistribution']['name'] ?? '';
            if(!empty($delayDoc)){
                $tmp = $_FILES['delayDocumentDistribution']['tmp_name'];
                $delayDoc = preg_replace('/[^a-zA-Z0-9._-]/', '_', $delayDoc);
                $uploadPath = $uploadDir . $delayDoc;
                if(move_uploaded_file($tmp, $uploadPath)){
                    // File uploaded successfully
                } else {
                    $delayDoc = '';
                }
            }
            
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayDistribution', '$reason', '$otherReason', 'Distribution System', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayDistribution', '$reason', '$otherReason', 'Distribution System', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $photoUpdate = !empty($delayDoc) ? "`photo` = '$delayDoc', " : "";
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayDistribution', `reason` = '$reason', `otherReason` = '$otherReason', $photoUpdate `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
            }
            
        } else {
            // Check if delay record exists
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayDistribution', 'Distribution System', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayDistribution', 'Distribution System', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayDistribution' WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
            }
            
            // Handle schedule items
            if(isset($_POST['distributionSchedule']) && is_array($_POST['distributionSchedule'])){
                $i = 0;
                $exitSchedule = "";
                foreach ($_POST['distributionSchedule'] as $distributionSchedule){
                    if(!empty($distributionSchedule)){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$distributionSchedule'");
                        if(mysqli_num_rows($q3) > 0){
                            $r3 = mysqli_fetch_assoc($q3);
                            $percentage = $r3['percentage'] ?? 0;
                            
                            $documentDistribution = $_FILES['documentDistribution']['name'][$i] ?? '';
                            if(!empty($documentDistribution)){
                                $tmp = $_FILES['documentDistribution']['tmp_name'][$i];
                                $documentDistribution = preg_replace('/[^a-zA-Z0-9._-]/', '_', $documentDistribution);
                                $uploadPath = $uploadDir . $documentDistribution;
                                if(move_uploaded_file($tmp, $uploadPath)){
                                    // File uploaded successfully
                                } else {
                                    $documentDistribution = '';
                                }
                            }
                            
                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$distributionSchedule' AND yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
                            if(mysqli_num_rows($q1) > 0){
                                $r1 = mysqli_fetch_assoc($q1);
                                if(empty($documentDistribution) && !empty($r1['document'])){
                                    $documentDistribution = $r1['document'];
                                }
                                $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `document` = '$documentDistribution' WHERE scheduleId = '$distributionSchedule' AND yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
                            } else {
                                $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUES ('$distributionSchedule', 'Distribution System', '$percentage', '$documentDistribution', '4', '$yojanaId', '$userId', '$dateTime')");
                            }
                            $exitSchedule .= "scheduleId !='" . $distributionSchedule . "' AND ";
                        }
                        $i++;
                    }
                }
                
                // Delete schedules not in current selection
                if(!empty($exitSchedule)){
                    $exitSchedule = rtrim($exitSchedule, " AND ");
                    $q4 = mysqli_query($con, "DELETE FROM schedule WHERE $exitSchedule AND yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
                }
            }
        }
    }
    
    // Handle stepFour table operations
    $q = mysqli_query($con, "SELECT * FROM `stepFour` WHERE yojanaId = '$yojanaId'");
    $r = mysqli_fetch_assoc($q) ?? array();
    
    // Validate and sanitize input values
    $length = is_numeric($length) ? floatval($length) : 0;
    $completionPercentage = is_numeric($completionPercentage) ? floatval($completionPercentage) : 0;
    
    if(mysqli_num_rows($q) <= 0){
        // INSERT new records
        if(isset($_POST['subWorkId']) && is_array($_POST['subWorkId'])){
            foreach ($_POST['subWorkId'] as $subWorkId){
                $subWorkLength = isset($_POST['length'.$subWorkId]) && is_numeric($_POST['length'.$subWorkId]) ? floatval($_POST['length'.$subWorkId]) : $length;
                $subWorkMaterial = $_POST['material'.$subWorkId] ?? $material;
                
                $query = mysqli_query($con, "INSERT INTO `stepFour`(`subWorkId`, `length`, `material`, `completionPercentage`, `docName1`, `docName2`, `docName3`, `docName4`, `photo1`, `photo2`, `photo3`, `photo4`, `longitude`, `latitude`, `video_link`, `remark`, `yojanaId`, `userId`, `dateTime`) 
                VALUES ('$subWorkId', '$subWorkLength', '$subWorkMaterial', '$completionPercentage', '{$docNames[1]}', '{$docNames[2]}', '{$docNames[3]}', '{$docNames[4]}', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$longitudes', '$latitudes', '$video_link', '$remarks', '$yojanaId', '$userId', '$dateTime')");
            }
        } else {
            // Insert without subWorkId
            $query = mysqli_query($con, "INSERT INTO `stepFour`(`length`, `material`, `completionPercentage`, `docName1`, `docName2`, `docName3`, `docName4`, `photo1`, `photo2`, `photo3`, `photo4`, `longitude`, `latitude`, `video_link`, `remark`, `yojanaId`, `userId`, `dateTime`) 
            VALUES ('$length', '$material', '$completionPercentage', '{$docNames[1]}', '{$docNames[2]}', '{$docNames[3]}', '{$docNames[4]}', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$longitudes', '$latitudes', '$video_link', '$remarks', '$yojanaId', '$userId', '$dateTime')");
        }
        
    } else {
        // UPDATE existing records
        if(isset($_POST['subWorkId']) && is_array($_POST['subWorkId'])){
            foreach ($_POST['subWorkId'] as $subWorkId){
                $subWorkLength = isset($_POST['length'.$subWorkId]) && is_numeric($_POST['length'.$subWorkId]) ? floatval($_POST['length'.$subWorkId]) : $length;
                $subWorkMaterial = $_POST['material'.$subWorkId] ?? $material;
                
                $query = mysqli_query($con, "UPDATE `stepFour` SET `length` = '$subWorkLength', `video_link` = '$video_link', `material` = '$subWorkMaterial' WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'");
            }
        }
        
        // Update other fields
        $updateFields = array();
        if(!empty($docNames[1])) $updateFields[] = "docName1 = '{$docNames[1]}'";
        if(!empty($docNames[2])) $updateFields[] = "docName2 = '{$docNames[2]}'";
        if(!empty($docNames[3])) $updateFields[] = "docName3 = '{$docNames[3]}'";
        if(!empty($docNames[4])) $updateFields[] = "docName4 = '{$docNames[4]}'";
        if(!empty($document[1])) $updateFields[] = "photo1 = '{$document[1]}'";
        if(!empty($document[2])) $updateFields[] = "photo2 = '{$document[2]}'";
        if(!empty($document[3])) $updateFields[] = "photo3 = '{$document[3]}'";
        if(!empty($document[4])) $updateFields[] = "photo4 = '{$document[4]}'";
        if(!empty($longitudes)) $updateFields[] = "longitude = '$longitudes'";
        if(!empty($latitudes)) $updateFields[] = "latitude = '$latitudes'";
        if(!empty($remarks)) $updateFields[] = "remark = '$remarks'";
        if(!empty($video_link)) $updateFields[] = "video_link = '$video_link'";
        $updateFields[] = "completionPercentage = '$completionPercentage'";
        $updateFields[] = "dateTime = '$dateTime'";
        
        if(!empty($updateFields)){
            $updateQuery = "UPDATE `stepFour` SET " . implode(", ", $updateFields) . " WHERE yojanaId = '$yojanaId'";
            $query = mysqli_query($con, $updateQuery);
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
        $msg = "Step four (distribution) data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submitted. Please try again";
    }
    
    setSession($status, $msg);
    header('location: stepFour.php?yojanaId='.$yojanaId);
    exit();
}
?>