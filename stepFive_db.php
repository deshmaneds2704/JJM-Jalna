<?php 
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
require_once('include/sweetAlert.php');

if(isset($_POST['submit'])){
    // Initialize all variables
    $yojanaId = $_POST['yojanaId'] ?? '';
    $yojanaComplete = $_POST['yojanaComplete'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $dateOfCommissioning = $_POST['dateOfCommissioning'] ?? '';
    $dateOfHandingOver = $_POST['dateOfHandingOver'] ?? '';
    $datesOfTpiVisit1 = $_POST['datesOfTpiVisit1'] ?? '';
    $datesOfTpiVisit2 = $_POST['datesOfTpiVisit2'] ?? '';
    $datesOfTpiVisit3 = $_POST['datesOfTpiVisit3'] ?? '';
    $dateOfCompletion = $_POST['dateOfCompletion'] ?? '';
    $video_link = $_POST['video_link'] ?? '';
    $completionPercentage = $_POST['completionPercentage'] ?? 0;
    $remarks = $_POST['remark'] ?? '';
    $userId = $_SESSION['userId'] ?? '';
    $dateTime = date('Y-m-d H:i:s');
    
    // Initialize document arrays
    $docNames = [];
    $document = [];
    
    // Process uploaded files
    for($i=1; $i<=4; $i++){
        $docNames[$i] = addslashes($_POST['docName'.$i] ?? '');
        
        if(isset($_FILES['photo'.$i]) && !empty($_FILES['photo'.$i]['name'])){
            $document[$i] = addslashes($_FILES['photo'.$i]['name']);
            $tmp = $_FILES['photo'.$i]['tmp_name'];
            move_uploaded_file($tmp, "uploadedDoc/".$document[$i]);
        } else {
            $document[$i] = '';
        }
    }
    
    // Set default values
    $docName1 = $docNames[1] ?? '';
    $docName2 = $docNames[2] ?? '';
    $docName3 = $docNames[3] ?? '';
    $docName4 = $docNames[4] ?? '';
    
    $photo1 = $document[1] ?? '';
    $photo2 = $document[2] ?? '';
    $photo3 = $document[3] ?? '';
    $photo4 = $document[4] ?? '';
    
    // Handle longitude/latitude - simplified approach
    $longitudes = '';
    $latitudes = '';
    
    // MSEDC Work - FIXED VERSION
    if(isset($_POST['delayMsedc'])){
        $delayMsedc = $_POST['delayMsedc'];
        
        if($delayMsedc == "Yes"){
            // Handle delay with reason
            $reasonMsedc = $_POST['reasonMsedc'] ?? '';
            $otherReason = ($reasonMsedc == "Other") ? ($_POST['otherReasonMsedc'] ?? '') : '';
            
            $delayDocument = '';
            if(isset($_FILES['delayDocumentMsedc']) && !empty($_FILES['delayDocumentMsedc']['name'])){
                $delayDocument = $_FILES['delayDocumentMsedc']['name'];
                $tmp = $_FILES['delayDocumentMsedc']['tmp_name'];
                move_uploaded_file($tmp, "uploadedDoc/".$delayDocument);
            }
            
            // Check if record exists
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
            
            if(mysqli_num_rows($q0) <= 0){
                // Get a scheduleId for MSEDC Work if needed
                $scheduleId = 0;
                $scheduleQuery = mysqli_query($con, "SELECT id FROM scheduleMaster WHERE subWork = 'MSEDC Work' LIMIT 1");
                if(mysqli_num_rows($scheduleQuery) > 0){
                    $scheduleRow = mysqli_fetch_assoc($scheduleQuery);
                    $scheduleId = $scheduleRow['id'];
                }
                
                // INSERT with scheduleId
                $q = mysqli_query($con, "INSERT INTO delayYojanas (scheduleId, delay, reason, otherReason, subWork, photo, yojanaId, userId, dateTime) 
                                        VALUES ('$scheduleId', '$delayMsedc', '$reasonMsedc', '$otherReason', 'MSEDC Work', '$delayDocument', '$yojanaId', '$userId', '$dateTime')");
            } else {
                // UPDATE existing record
                $q = mysqli_query($con, "UPDATE delayYojanas SET delay = '$delayMsedc', reason = '$reasonMsedc', otherReason = '$otherReason', photo = '$delayDocument', dateTime = '$dateTime' 
                                        WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
            }
            
        } else {
            // Handle no delay - process schedules
            // Update delayYojanas table
            $q0 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
            
            if(mysqli_num_rows($q0) <= 0){
                // Get a scheduleId for MSEDC Work
                $scheduleId = 0;
                $scheduleQuery = mysqli_query($con, "SELECT id FROM scheduleMaster WHERE subWork = 'MSEDC Work' LIMIT 1");
                if(mysqli_num_rows($scheduleQuery) > 0){
                    $scheduleRow = mysqli_fetch_assoc($scheduleQuery);
                    $scheduleId = $scheduleRow['id'];
                }
                
                $q = mysqli_query($con, "INSERT INTO delayYojanas (scheduleId, delay, subWork, yojanaId, userId, dateTime) 
                                        VALUES ('$scheduleId', '$delayMsedc', 'MSEDC Work', '$yojanaId', '$userId', '$dateTime')");
            } else {
                $q = mysqli_query($con, "UPDATE delayYojanas SET delay = '$delayMsedc' WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
            }
            
            // Process schedules if any
            if(isset($_POST['msedcSchedule']) && is_array($_POST['msedcSchedule'])){
                $exitSchedule = '';
                $i = 0;
                
                foreach ($_POST['msedcSchedule'] as $esr){
                    $esr = mysqli_real_escape_string($con, $esr);
                    
                    // Get schedule details
                    $q3 = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE id = '$esr'");
                    $r3 = mysqli_fetch_assoc($q3);
                    $percentage = $r3['percentage'] ?? 0;
                    
                    // Handle document upload
                    $documentFile = '';
                    if(isset($_FILES['documentMsedc']['name'][$i]) && !empty($_FILES['documentMsedc']['name'][$i])){
                        $documentFile = $_FILES['documentMsedc']['name'][$i];
                        $tmp = $_FILES['documentMsedc']['tmp_name'][$i];
                        move_uploaded_file($tmp, "uploadedDoc/".$documentFile);
                    }
                    
                    // Check if schedule exists
                    $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$esr' AND yojanaId = '$yojanaId'");
                    
                    if(mysqli_num_rows($q1) > 0){
                        // Update existing
                        $r1 = mysqli_fetch_assoc($q1);
                        if(empty($documentFile)){
                            $documentFile = $r1['document'] ?? '';
                        }
                        $q = mysqli_query($con, "UPDATE schedule SET percentage = '$percentage', document = '$documentFile' 
                                                WHERE scheduleId = '$esr' AND yojanaId = '$yojanaId'");
                    } else {
                        // Insert new
                        $q = mysqli_query($con, "INSERT INTO schedule (scheduleId, subWork, percentage, document, step, yojanaId, userId, dateTime) 
                                                VALUES ('$esr', 'MSEDC Work', '$percentage', '$documentFile', '5', '$yojanaId', '$userId', '$dateTime')");
                    }
                    
                    $exitSchedule .= "scheduleId != '$esr' AND ";
                    $i++;
                }
                
                // Clean up old schedules
                if(!empty($exitSchedule)){
                    $exitSchedule = rtrim($exitSchedule, ' AND ');
                    $q4 = mysqli_query($con, "DELETE FROM schedule WHERE $exitSchedule AND yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
                }
            }
        }
    }
    
    // Handle stepFive table
    $q = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'");
    
    if(mysqli_num_rows($q) <= 0){
        // Insert new record
        $query = mysqli_query($con, "INSERT INTO stepFive (yojanaComplete, reason, dateOfCommissioning, dateOfHandingOver, datesOfTpiVisit1, datesOfTpiVisit2, datesOfTpiVisit3, dateOfCompletion, completionPercentage, docName1, docName2, docName3, docName4, photo1, photo2, photo3, photo4, video_link, remark, yojanaId, userId, dateTime) 
                                     VALUES ('$yojanaComplete', '$reason', '$dateOfCommissioning', '$dateOfHandingOver', '$datesOfTpiVisit1', '$datesOfTpiVisit2', '$datesOfTpiVisit3', '$dateOfCompletion', '$completionPercentage', '$docName1', '$docName2', '$docName3', '$docName4', '$photo1', '$photo2', '$photo3', '$photo4', '$video_link', '$remarks', '$yojanaId', '$userId', '$dateTime')");
    } else {
        // Update existing record
        $updateFields = [];
        $r = mysqli_fetch_assoc($q);
        
        // Fields to check for updates
        $fieldsToCheck = [
            'yojanaComplete' => $yojanaComplete,
            'reason' => $reason,
            'dateOfCommissioning' => $dateOfCommissioning,
            'dateOfHandingOver' => $dateOfHandingOver,
            'datesOfTpiVisit1' => $datesOfTpiVisit1,
            'datesOfTpiVisit2' => $datesOfTpiVisit2,
            'datesOfTpiVisit3' => $datesOfTpiVisit3,
            'dateOfCompletion' => $dateOfCompletion,
            'completionPercentage' => $completionPercentage,
            'docName1' => $docName1,
            'docName2' => $docName2,
            'docName3' => $docName3,
            'docName4' => $docName4,
            'video_link' => $video_link,
            'remark' => $remarks,
            'userId' => $userId,
            'dateTime' => $dateTime
        ];
        
        // Add photo fields if they have values
        if(!empty($photo1)) $fieldsToCheck['photo1'] = $photo1;
        if(!empty($photo2)) $fieldsToCheck['photo2'] = $photo2;
        if(!empty($photo3)) $fieldsToCheck['photo3'] = $photo3;
        if(!empty($photo4)) $fieldsToCheck['photo4'] = $photo4;
        
        foreach($fieldsToCheck as $field => $value){
            if($value != ($r[$field] ?? '')){
                $updateFields[] = "`$field` = '" . addslashes($value) . "'";
            }
        }
        
        if(!empty($updateFields)){
            $updateQuery = "UPDATE stepFive SET " . implode(', ', $updateFields) . " WHERE yojanaId = '$yojanaId'";
            $query = mysqli_query($con, $updateQuery);
        } else {
            $query = true;
        }
    }
    
    // Set response
    if($query){
        $_SESSION['status'] = true;
        $_SESSION['msg'] = "Step five (trial run) data submitted successfully";
    } else {
        $_SESSION['status'] = false;
        $_SESSION['msg'] = "Error: " . mysqli_error($con);
    }
    
    header('location: stepFive?yojanaId='.$yojanaId);
    exit();
}
?>