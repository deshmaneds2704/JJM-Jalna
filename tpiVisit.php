<?php
function tpiVisit($con, $yojanaId){
    // Don't require con.php again since it's already passed as parameter
    // require_once('include/con.php');
    
    $totalDiv = 0;
    $stepOne = 0;
    $stepTwo = 0;
    $stepThree = 0;
    $stepFour = 0;
    $stepFive = 0;
    
    $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
    $row = mysqli_fetch_assoc($query) ?? []; // Initialize as empty array if null
    
    // Check if stepOne exists and get completion percentage
    if(($row['stepOne'] ?? '') == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query) ?? []; // Initialize as empty array
        $stepOne = $result['completionPercentage'] ?? 0;
        $count1 = mysqli_num_rows($query);
        if($count1 == 0){
            $stepOne = 0;
        }
        $totalDiv = $totalDiv + 100;
    }
    
    // Check if stepTwo exists and get completion percentage
    if(($row['stepTwo'] ?? '') == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query) ?? []; // Initialize as empty array
        $stepTwo = $result['completionPercentage'] ?? 0;
        $count2 = mysqli_num_rows($query);
        if($count2 == 0){
            $stepTwo = 0;
        }
        $totalDiv = $totalDiv + 100;
    }
    
    // Check if stepThree exists and get completion percentage
    if(($row['stepThree'] ?? '') == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query) ?? []; // Initialize as empty array
        $stepThree = $result['completionPercentage'] ?? 0;
        $count3 = mysqli_num_rows($query);
        if($count3 == 0){
            $stepThree = 0;
        }
        $totalDiv = $totalDiv + 100;
    }
    
    // Check if stepFour exists and get completion percentage
    if(($row['stepFour'] ?? '') == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query) ?? []; // Initialize as empty array
        $stepFour = $result['completionPercentage'] ?? 0;
        $count4 = mysqli_num_rows($query);
        if($count4 == 0){
            $stepFour = 0;
        }
        $totalDiv = $totalDiv + 100;
    }
    
    // Check if stepFive exists and get completion percentage
    if(($row['stepFive'] ?? '') == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query) ?? []; // Initialize as empty array
        $stepFive = $result['completionPercentage'] ?? 0;
        $count5 = mysqli_num_rows($query);
        if($count5 == 0){
            $stepFive = 0;
        }
        $datesOfTpiVisit1 = $result['datesOfTpiVisit1'] ?? '';
        $datesOfTpiVisit2 = $result['datesOfTpiVisit3'] ?? '';
        $datesOfTpiVisit3 = $result['datesOfTpiVisit3'] ?? '';
        $totalDiv = $totalDiv + 100;
    }
    
    // Calculate overall percentage
    if($totalDiv > 0){
        $percentage = (($stepOne + $stepTwo + $stepThree + $stepFour + $stepFive) / $totalDiv) * 100;
    } else {
        $percentage = 0;
    }
    
    // Get yojana details
    $q5 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
    $r5 = mysqli_fetch_assoc($q5) ?? [];
    
    // Initialize date
    $date = date('Y-m-d');
    
    // Get total sanctioned cost
    $totalSanctionedCost = $r5['totalSanctionedCost'] ?? 0;
    
    // Handle TPI visits based on cost and percentage
    if($totalSanctionedCost <= 3000000){
        if($percentage >= 50 && $percentage <= 100){
            $tpiVisit1 = $r5['tpiVisit1'] ?? '';
            if(empty($tpiVisit1) || $tpiVisit1 == '0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else {
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = NULL WHERE yojanaId = '$yojanaId'");
        }
    } else if($totalSanctionedCost > 3000000 && $totalSanctionedCost <= 20000000){
        if($percentage >= 30 && $percentage < 70){
            $tpiVisit1 = $r5['tpiVisit1'] ?? '';
            if(empty($tpiVisit1) || $tpiVisit1 == '0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else if($percentage >= 70 && $percentage <= 100){
            $tpiVisit2 = $r5['tpiVisit2'] ?? '';
            if(empty($tpiVisit2) || $tpiVisit2 == '0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit2 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else {
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = NULL, tpiVisit2 = NULL WHERE yojanaId = '$yojanaId'");
        }
    } else if($totalSanctionedCost > 20000000 && $totalSanctionedCost <= 50000000){
        if($percentage >= 30 && $percentage < 60){
            $tpiVisit1 = $r5['tpiVisit1'] ?? '';
            if(empty($tpiVisit1) || $tpiVisit1 == '0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else if($percentage >= 60 && $percentage < 90) {
            $tpiVisit2 = $r5['tpiVisit2'] ?? '';
            if(empty($tpiVisit2) || $tpiVisit2 == '0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit2 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else if($percentage >= 90 && $percentage <= 100){
            $tpiVisit3 = $r5['tpiVisit3'] ?? '';
            if(empty($tpiVisit3) || $tpiVisit3 == '0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit3 = '$date' WHERE yojanaId = '$yojanaId'");
            }    
        } else {
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = NULL, tpiVisit2 = NULL, tpiVisit3 = NULL WHERE yojanaId = '$yojanaId'");
        }
    }
    
    return true;
}
?>