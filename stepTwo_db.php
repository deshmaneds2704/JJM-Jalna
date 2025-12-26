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
    $pumpNumber = $_POST['pumpNumber'] ?? 0;
    $power = $_POST['power'] ?? '';
    $installationYear = $_POST['installationYear'] ?? date('Y');
    $pumpingHours = $_POST['pumpingHours'] ?? 0;
    $pumpHouse = $_POST['pumpHouse'] ?? '';
    $diameter = $_POST['diameter'] ?? 0;
    $length = $_POST['length'] ?? 0;
    $material = $_POST['material'] ?? '';
    $completionPercentage = $_POST['completionPercentage'] ?? 0;
    $remarks = addslashes($_POST['remark'] ?? '');
    $video_link = $_POST['video_link'] ?? '';
    
    // Initialize document array
    $document = array(1 => '', 2 => '', 3 => '', 4 => '');
    
    // Initialize longitude and latitude variables
    $longitudes = '';
    $latitudes = '';
    
    // Create upload directory if it doesn't exist
    $uploadDir = "uploadedDoc/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Check if docName array exists
    if(isset($_POST['docName']) && is_array($_POST['docName'])){
        $i = 1;
        foreach ($_POST['docName'] as $docName){
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
            $i++;
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
    
    // Handle Switch Room
    if(isset($_POST['delaySwitch'])){
        $delaySwitch = $_POST['delaySwitch'];
        if($delaySwitch == "Yes"){
            $reason = $_POST['reasonSwitch'] ?? '';
            $otherReason = "";
            if($reason == "Other"){
                $otherReason = $_POST['otherReasonSwitch'] ?? '';
            }
            
            $delayDoc = $_FILES['delayDocumentSwitch']['name'] ?? '';
            if(!empty($delayDoc)){
                $tmp = $_FILES['delayDocumentSwitch']['tmp_name'];
                $delayDoc = preg_replace('/[^a-zA-Z0-9._-]/', '_', $delayDoc);
                $uploadPath = $uploadDir . $delayDoc;
                if(move_uploaded_file($tmp, $uploadPath)){
                    // File uploaded successfully
                } else {
                    $delayDoc = '';
                }
            }
            
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delaySwitch', '$reason', '$otherReason', 'Switch Room', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delaySwitch', '$reason', '$otherReason', 'Switch Room', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $photoUpdate = !empty($delayDoc) ? "`photo` = '$delayDoc', " : "";
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delaySwitch', `reason` = '$reason', `otherReason` = '$otherReason', $photoUpdate `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
            }
            
        } else {
            // Update or insert delay record for "No" delay
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delaySwitch', 'Switch Room', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delaySwitch', 'Switch Room', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delaySwitch' WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
            }
            
            // Handle schedule items
            if(isset($_POST['switchRoomSchedule']) && is_array($_POST['switchRoomSchedule'])){
                $i = 0;
                $exitSchedule = "";
                foreach ($_POST['switchRoomSchedule'] as $switchRoom){
                    if(!empty($switchRoom)){
                        $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$switchRoom'");
                        if(mysqli_num_rows($q3) > 0){
                            $r3 = mysqli_fetch_assoc($q3);
                            $percentage = $r3['percentage'] ?? 0;
                            
                            $documentSwitch = $_FILES['documentSwitch']['name'][$i] ?? '';
                            if(!empty($documentSwitch)){
                                $tmp = $_FILES['documentSwitch']['tmp_name'][$i];
                                $documentSwitch = preg_replace('/[^a-zA-Z0-9._-]/', '_', $documentSwitch);
                                $uploadPath = $uploadDir . $documentSwitch;
                                if(move_uploaded_file($tmp, $uploadPath)){
                                    // File uploaded successfully
                                } else {
                                    $documentSwitch = '';
                                }
                            }
                            
                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$switchRoom' AND yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                            if(mysqli_num_rows($q1) > 0){
                                $r1 = mysqli_fetch_assoc($q1);
                                if(empty($documentSwitch) && !empty($r1['document'])){
                                    $documentSwitch = $r1['document'];
                                }
                                $q = mysqli_query($con, "UPDATE schedule SET `percentage` = '$percentage', `document` = '$documentSwitch' WHERE scheduleId = '$switchRoom' AND yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                            } else {
                                $q = mysqli_query($con, "INSERT INTO schedule (`scheduleId`, `subWork`, `percentage`, `document`, `step`, `yojanaId`, `userId`, `dateTime`) VALUES ('$switchRoom', 'Switch Room', '$percentage', '$documentSwitch', '2', '$yojanaId', '$userId', '$dateTime')");
                            }
                            $exitSchedule .= "scheduleId !='" . $switchRoom . "' AND ";
                        }
                        $i++;
                    }
                }
                
                // Delete schedules not in current selection
                if(!empty($exitSchedule)){
                    $exitSchedule = rtrim($exitSchedule, " AND ");
                    $q4 = mysqli_query($con, "DELETE FROM schedule WHERE $exitSchedule AND yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                }
            }
        }
    }
    
    // Handle Pumping Machinery (similar to Switch Room)
    if(isset($_POST['delayPumping'])){
        $delayPumping = $_POST['delayPumping'];
        if($delayPumping == "Yes"){
            $reason = $_POST['reasonPumping'] ?? '';
            $otherReason = "";
            if($reason == "Other"){
                $otherReason = $_POST['otherReasonPumping'] ?? '';
            }
            
            $delayDoc = $_FILES['delayDocumentPumping']['name'] ?? '';
            if(!empty($delayDoc)){
                $tmp = $_FILES['delayDocumentPumping']['tmp_name'];
                $delayDoc = preg_replace('/[^a-zA-Z0-9._-]/', '_', $delayDoc);
                $uploadPath = $uploadDir . $delayDoc;
                if(move_uploaded_file($tmp, $uploadPath)){
                    // File uploaded successfully
                } else {
                    $delayDoc = '';
                }
            }
            
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPumping', '$reason', '$otherReason', 'Pumping Machinery', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPumping', '$reason', '$otherReason', 'Pumping Machinery', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $photoUpdate = !empty($delayDoc) ? "`photo` = '$delayDoc', " : "";
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPumping', `reason` = '$reason', `otherReason` = '$otherReason', $photoUpdate `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
            }
            
        } else {
            // Similar logic as Switch Room for "No" delay
            // Update or insert delay record for "No" delay
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPumping', 'Pumping Machinery', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayPumping', 'Pumping Machinery', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayPumping' WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
            }
        }
    }
    
    // Handle Rising Main (similar to Switch Room)
    if(isset($_POST['delayRising'])){
        $delayRising = $_POST['delayRising'];
        if($delayRising == "Yes"){
            $reason = $_POST['reasonRising'] ?? '';
            $otherReason = "";
            if($reason == "Other"){
                $otherReason = $_POST['otherReasonRising'] ?? '';
            }
            
            $delayDoc = $_FILES['delayDocumentRising']['name'] ?? '';
            if(!empty($delayDoc)){
                $tmp = $_FILES['delayDocumentRising']['tmp_name'];
                $delayDoc = preg_replace('/[^a-zA-Z0-9._-]/', '_', $delayDoc);
                $uploadPath = $uploadDir . $delayDoc;
                if(move_uploaded_file($tmp, $uploadPath)){
                    // File uploaded successfully
                } else {
                    $delayDoc = '';
                }
            }
            
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayRising', '$reason', '$otherReason', 'Rising Main', '$delayDoc', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `reason`, `otherReason`, `subWork`, `photo`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayRising', '$reason', '$otherReason', 'Rising Main', '$delayDoc', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $photoUpdate = !empty($delayDoc) ? "`photo` = '$delayDoc', " : "";
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayRising', `reason` = '$reason', `otherReason` = '$otherReason', $photoUpdate `dateTime` = '$dateTime' WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
            }
            
        } else {
            // Similar logic as Switch Room for "No" delay
            // Update or insert delay record for "No" delay
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
            if(mysqli_num_rows($q0) <= 0){
                if($hasScheduleId){
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `scheduleId`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayRising', 'Rising Main', 0, '$yojanaId', '$userId', '$dateTime')");
                } else {
                    $q = mysqli_query($con, "INSERT INTO delayYojanas (`delay`, `subWork`, `yojanaId`, `userId`, `dateTime`) VALUES ('$delayRising', 'Rising Main', '$yojanaId', '$userId', '$dateTime')");
                }
            } else {
                $q = mysqli_query($con, "UPDATE delayYojanas SET `delay` = '$delayRising' WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
            }
        }
    }
    
    // Handle stepTwo table operations
    $q = mysqli_query($con, "SELECT * FROM `stepTwo` WHERE yojanaId = '$yojanaId'");
    $r = mysqli_fetch_assoc($q) ?? array();
    
    // Validate and sanitize all input values
    $installationYear = (int)$installationYear;
    $pumpNumber = (int)$pumpNumber; // Convert to integer
    $pumpingHours = is_numeric($pumpingHours) ? floatval($pumpingHours) : 0;
    $diameter = is_numeric($diameter) ? floatval($diameter) : 0;
    $length = is_numeric($length) ? floatval($length) : 0;
    $completionPercentage = is_numeric($completionPercentage) ? floatval($completionPercentage) : 0;
    
    if(mysqli_num_rows($q) <= 0){
        // INSERT new records
        if(isset($_POST['subWorkId']) && is_array($_POST['subWorkId'])){
            $i = 0;
            foreach ($_POST['subWorkId'] as $subWorkId){
                $subWorkPumpNumber = isset($_POST['pumpNumber'.$subWorkId]) ? (int)$_POST['pumpNumber'.$subWorkId] : $pumpNumber;
                $subWorkPower = $_POST['power'.$subWorkId] ?? $power;
                $subWorkPumpingHours = isset($_POST['pumpingHours'.$subWorkId]) && is_numeric($_POST['pumpingHours'.$subWorkId]) ? floatval($_POST['pumpingHours'.$subWorkId]) : $pumpingHours;
                $subWorkPumpHouse = $_POST['pumpHouse'.$subWorkId] ?? $pumpHouse;
                $subWorkDiameter = isset($_POST['diameter'.$subWorkId]) && is_numeric($_POST['diameter'.$subWorkId]) ? floatval($_POST['diameter'.$subWorkId]) : $diameter;
                $subWorkLength = isset($_POST['length'.$subWorkId]) && is_numeric($_POST['length'.$subWorkId]) ? floatval($_POST['length'.$subWorkId]) : $length;
                $subWorkMaterial = $_POST['material'.$subWorkId] ?? $material;
                
                $query = mysqli_query($con, "INSERT INTO `stepTwo`(`subWorkId`, `pumpNumber`, `power`, `installationYear`, `pumpingHours`, `pumpHouse`, `diameter`, `length`, `material`, `completionPercentage`, `photo1`, `photo2`, `photo3`, `photo4`, `video_link`, `longitude`, `latitude`, `remarks`, `yojanaId`, `userId`, `dateTime`) 
                VALUES ('$subWorkId', '$subWorkPumpNumber', '$subWorkPower', '$installationYear', '$subWorkPumpingHours', '$subWorkPumpHouse', '$subWorkDiameter', '$subWorkLength', '$subWorkMaterial', '$completionPercentage', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$video_link', '$longitudes', '$latitudes', '$remarks', '$yojanaId', '$userId', '$dateTime')");
                $i++;
            }
        } else {
            // Insert without subWorkId
            $query = mysqli_query($con, "INSERT INTO `stepTwo`(`pumpNumber`, `power`, `installationYear`, `pumpingHours`, `pumpHouse`, `diameter`, `length`, `material`, `completionPercentage`, `photo1`, `photo2`, `photo3`, `photo4`, `video_link`, `longitude`, `latitude`, `remarks`, `yojanaId`, `userId`, `dateTime`) 
            VALUES ('$pumpNumber', '$power', '$installationYear', '$pumpingHours', '$pumpHouse', '$diameter', '$length', '$material', '$completionPercentage', '{$document[1]}', '{$document[2]}', '{$document[3]}', '{$document[4]}', '$video_link', '$longitudes', '$latitudes', '$remarks', '$yojanaId', '$userId', '$dateTime')");
        }
        
    } else {
        // UPDATE existing records
        if(isset($_POST['subWorkId']) && is_array($_POST['subWorkId'])){
            foreach ($_POST['subWorkId'] as $subWorkId){
                $subWorkPumpNumber = isset($_POST['pumpNumber'.$subWorkId]) ? (int)$_POST['pumpNumber'.$subWorkId] : $pumpNumber;
                $subWorkPower = $_POST['power'.$subWorkId] ?? $power;
                $subWorkPumpingHours = isset($_POST['pumpingHours'.$subWorkId]) && is_numeric($_POST['pumpingHours'.$subWorkId]) ? floatval($_POST['pumpingHours'.$subWorkId]) : $pumpingHours;
                $subWorkPumpHouse = $_POST['pumpHouse'.$subWorkId] ?? $pumpHouse;
                $subWorkDiameter = isset($_POST['diameter'.$subWorkId]) && is_numeric($_POST['diameter'.$subWorkId]) ? floatval($_POST['diameter'.$subWorkId]) : $diameter;
                $subWorkLength = isset($_POST['length'.$subWorkId]) && is_numeric($_POST['length'.$subWorkId]) ? floatval($_POST['length'.$subWorkId]) : $length;
                $subWorkMaterial = $_POST['material'.$subWorkId] ?? $material;
                
                $query = mysqli_query($con, "UPDATE `stepTwo` SET `pumpNumber`='$subWorkPumpNumber', `power`='$subWorkPower', `video_link`='$video_link', `pumpingHours`='$subWorkPumpingHours', `pumpHouse`='$subWorkPumpHouse', `diameter`='$subWorkDiameter', `length`='$subWorkLength', `material`='$subWorkMaterial' WHERE subWorkId = '$subWorkId' AND yojanaId = '$yojanaId'");
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
        if(!empty($remarks)) $updateFields[] = "remarks = '$remarks'";
        if(!empty($video_link)) $updateFields[] = "video_link = '$video_link'";
        $updateFields[] = "completionPercentage = '$completionPercentage'";
        $updateFields[] = "installationYear = '$installationYear'";
        $updateFields[] = "dateTime = '$dateTime'";
        
        if(!empty($updateFields)){
            $updateQuery = "UPDATE `stepTwo` SET " . implode(", ", $updateFields) . " WHERE yojanaId = '$yojanaId'";
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
        $msg = "Step two (pump / rising main) data is submitted successfully";
    } else {
        $status = false;
        $msg = "Sorry, Data can't be submitted. Please try again";
    }
    
    setSession($status, $msg);
    header('location: stepTwo.php?yojanaId='.$yojanaId);
    exit();
}
?>