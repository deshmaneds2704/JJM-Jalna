<?php
function tpiVisit($con, $yojanaId){
    require_once('include/con.php');
    
    $totalDiv = 0;
    $stepOne = 0;
    $stepTwo = 0;
    $stepThree = 0;
    $stepFour = 0;
    $stepFive = 0;
    
    $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
    $row = mysqli_fetch_assoc($query);
    if($row['stepOne'] == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query);
        $stepOne = $result['completionPercentage'];
        $count1=mysqli_num_rows($query);
        if($count1==0){
            $stepOne=0;
        }
        if($stepOne != ""){
            $stepOneCompleted = "is-complete pointer";
            $stepOneLink = "stepOne";
            $percentage = $stepOne;
        } else {
            $stepOneCompleted = "pointer current";
            $stepOneLink = "stepOne";
        }
        
        if(mysqli_num_rows($query)>0){
            if($percentage < 100 ){
                $stepOneCompleted = "is-incomplete";
            }  
        }
        $totalDiv = $totalDiv + 100;
    }
    
    if($row['stepTwo'] == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query);
        $stepTwo = $result['completionPercentage'];
        $count2 = mysqli_num_rows($query);
        if($count2==0){
            $stepTwo=0;
        }
        if($stepTwo != ""){
            $stepTwoCompleted = "is-complete pointer";
            $stepTwoLink = "stepTwo";
            $percentage = $stepTwo;
        } else {
            $percentage = $stepOne;
            if($stepOne != ""){
                $stepTwoCompleted = "pointer";
                $stepTwoLink = "stepTwo";
            } else {
                $stepTwoCompleted = "";
                $stepTwoLink = "stepTwo";
            }
        }
        
        if(mysqli_num_rows($query)>0){
            if($percentage < 100 ){
                $stepTwoCompleted = "is-incomplete pointer";
            }
        }
        $totalDiv = $totalDiv + 100;
    }
    
    
    if($row['stepThree'] == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query);
        $stepThree = $result['completionPercentage'];
        $count3=mysqli_num_rows($query);
        if($count3==0){
            $stepThree=0;
        }
        if($stepThree != ""){
            $stepThreeCompleted = "is-complete pointer";
            $stepThreeLink = "stepThree";
            $percentage = $stepThree;
        } else {
            $percentage = $stepTwo;
            if($stepTwo != ""){
                $stepThreeCompleted = "pointer";
                $stepThreeLink = "stepThree";
            } else {
                $stepThreeCompleted = "";
                $stepThreeLink = "stepThree";
            }
        }
        
        if(mysqli_num_rows($query)>0){
            if($percentage < 100 ){
                $stepThreeCompleted = "is-incomplete pointer";
            }
        }
        $totalDiv = $totalDiv + 100;
    }
    
    
    if($row['stepFour'] == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query);
        $stepFour = $result['completionPercentage'];
        $count4 = mysqli_num_rows($query);
        if($count4==0){
            $stepFour=0;
        }
        if($stepFour != ""){
            $stepFourCompleted = "is-complete pointer";
            $stepFourLink = "stepFour";
            $percentage = $stepFour;
        } else {
            $percentage = $stepThree;
            if($stepThree != ""){
                $stepFourCompleted = "pointer";
                $stepFourLink = "stepFour";
            } else {
                $stepFourCompleted = "";
                $stepFourLink = "stepFour";
            }
        }
        
        if(mysqli_num_rows($query)>0){
            if($percentage < 100 ){
                $stepFourCompleted = "is-incomplete pointer";
            }
        }
        $totalDiv = $totalDiv + 100;
    }
    
    
    
    if($row['stepFive'] == "Yes"){
        $query = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'");
        $result = mysqli_fetch_assoc($query);
        $stepFive = $result['completionPercentage'];
        $count5 = mysqli_num_rows($query);
        if($count5==0){
            $stepFive=0;
        }
        $datesOfTpiVisit1 = $result['datesOfTpiVisit1'];
        $datesOfTpiVisit2 = $result['datesOfTpiVisit2'];
        $datesOfTpiVisit3 = $result['datesOfTpiVisit3'];
        if($stepFive != ""){
            $stepFiveCompleted = "is-complete pointer";
            $stepFiveLink = "stepFive";
            $percentage = $stepFive;
        } else {
            $percentage = $stepFour;
            if($stepTwo != ""){
                $stepFiveCompleted = "pointer";
                $stepFiveLink = "stepFive";
            } else {
                $stepFiveCompleted = "";
                $stepFiveLink = "stepFive";
            }
        }
        
        
        if(mysqli_num_rows($query)>0){
            if($percentage < 100 ){
                $stepFiveCompleted = "is-incomplete pointer";
            }
        }
        $totalDiv = $totalDiv + 100;
    }
    
    $percentage = (($stepOne + $stepTwo + $stepThree + $stepFour + $stepFive) / $totalDiv) * 100;
    
    
    $q5 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
    $r5 = mysqli_fetch_assoc($q5);
    if($r5['totalSanctionedCost'] <= '3000000'){
        if($percentage >= 50 && $percentage <=100){
            $date = date('Y-m-d');
            if($r5['tpiVisit1'] == '' || $r5['tpiVisit1'] == '0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else {
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '' WHERE yojanaId = '$yojanaId'");
        }
    } else if($r5['totalSanctionedCost'] > '3000000' && $r5['totalSanctionedCost'] <= '20000000'){
        if($percentage >= 30 && $percentage <70){
            $date = date('Y-m-d');
            if($r5['tpiVisit1'] =='' || $r5['tpiVisit1'] =='0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else if($percentage >= 70 && $percentage <=100){
            if($r5['tpiVisit2'] =='' || $r5['tpiVisit2'] =='0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else {
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '' WHERE yojanaId = '$yojanaId'");
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit2 = '' WHERE yojanaId = '$yojanaId'");
        }
    } else if($r5['totalSanctionedCost'] > '20000000' && $r5['totalSanctionedCost'] <= '50000000'){
        if($percentage >= 30 && $percentage <60){
            if($r5['tpiVisit1'] =='' || $r5['tpiVisit1'] =='0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else if($percentage >= 60 && $percentage <90) {
            if($r5['tpiVisit2'] =='' || $r5['tpiVisit2'] =='0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit2 = '$date' WHERE yojanaId = '$yojanaId'");
            }
        } else if($percentage >= 90 && $percentage <100){
            if($r5['tpiVisit3'] =='' || $r5['tpiVisit3'] =='0000-00-00'){
                $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit3 = '$date' WHERE yojanaId = '$yojanaId'");
            }    
        } else {
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit1 = '' WHERE yojanaId = '$yojanaId'");
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit2 = '' WHERE yojanaId = '$yojanaId'");
            $q6 = mysqli_query($con, "UPDATE yojanaMaster SET tpiVisit3 = '' WHERE yojanaId = '$yojanaId'");
        }
    }
}
?>