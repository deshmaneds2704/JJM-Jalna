<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
include("include/con.php"); 

function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobileDevice()){
    $mobile = "col-12 p-1";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
else {
    $mobile = "col-4 p-0";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <title>Dashboard</title>
    
    <!-- plugins:css -->
    <link rel="stylesheet" href="template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="template/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="template/assets/vendors/select2/select2.min.css" />
    <link rel="stylesheet" href="template/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="template/assets/css/demo_2/style.css" />
    <!-- End layout styles -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .range-slider {
            margin: 2px 0 0 0;
        }
           
           .fade {
   
    transition: opacity 0.0s linear !important;
}

        .range-slider input[type="range"] {
            width: calc(100% - (68px));
            height: 10px;
            border-radius: 5px;
            background: #d7dcdf;
            outline: none;
            float: left;
            -webkit-appearance: none;
        }

        .range-slider input[type="range"]::-webkit-slider-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #2c3e50;
            cursor: pointer;
            transition: background .15s ease-in-out;
            -webkit-appearance: none;
            appearance: none;
        }

        .range-slider input[type="range"]::-webkit-slider-thumb:hover,
        .range-slider input[type="range"]:active::-webkit-slider-thumb {
            background: #4cb2ef;
        }

        .range-slider input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border: 0;
            border-radius: 50%;
            background: #2c3e50;
            cursor: pointer;
            transition: background .15s ease-in-out;
        }

        .range-slider input[type="range"]::-moz-range-thumb:hover,
        .range-slider input[type="range"]:active::-moz-range-thumb {
            background: #4cb2ef;
        }

        .range-slider .range-value {
            display: inline-block;
            width: 60px;
            background: #2c3e50;
            border-radius: 3px;
            padding: 5px 10px;
            margin-left: 8px;
            line-height: 20px;
            color: #fff;
            text-align: center;
            position: relative;
            top: -10px;
        }

        .range-slider .range-value:after {
            content: "";
            border-right: 7px solid #2c3e50;
            border-top: 7px solid transparent;
            border-bottom: 7px solid transparent;
            position: absolute;
            top: 8px;
            left: -7px;
        }

        ::-moz-range-track {
            background: #d7dcdf;
            border: 0;
        }


        .steps {
            list-style: none;
            margin: 0;
            padding: 0;
            display: table;
            table-layout: fixed;
            width: 100%;
            color: #929292;
            height: 4rem;
        }

        .steps>.step {
            position: relative;
            display: table-cell;
            text-align: center;
            font-size: 0.875rem;
            color: #6D6875;
        }

        .steps>.step:before {
            content: attr(data-step);
            display: block;
            margin: 0 auto;
            background: #ffffff;
            border: 2px solid #e6e6e6;
            color: #e6e6e6;
            width: 2rem;
            height: 2rem;
            text-align: center;
            margin-bottom: -4.2rem;
            line-height: 1.9rem;
            border-radius: 100%;
            position: relative;
            z-index: 1;
            font-weight: 700;
            font-size: 1rem;
        }

        .steps>.step:after {
            content: "";
            position: absolute;
            display: block;
            background: #e6e6e6;
            width: 100%;
            height: 0.125rem;
            top: 1rem;
            left: 50%;
        }

        .steps>.step:last-child:after {
            display: none;
        }

        .steps>.step.is-complete {
            color: #6D6875;
        }

        .steps>.step.is-complete:before {
            content: "✓";
            color: #3CB371;
            background: #e2fefb;
            border: 2px solid #3CB371;
        }
        
        .steps>.step.is-incomplete:before {
                content: "!";
                color: red;
                background: yellow;
                border: 2px solid red;
        }          

        .steps>.step.is-complete:after {
            background: #3CB371;
        }

        .steps>.step.is-active {
            font-weight: bold;

        }

        .steps>.step.is-active:before {
            color: #FFF;
            border: 2px solid #0033c4;
            background: #0033c4;
            margin-bottom: -4.9rem;
        }

        .steps {
            margin-top: 3em;
        }



        .can-toggle {
            position: relative;
        }

        .can-toggle *,
        .can-toggle *:before,
        .can-toggle *:after {
            box-sizing: border-box;
        }

        .can-toggle input[type=checkbox] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
        }

        .can-toggle input[type=checkbox][disabled]~label {
            pointer-events: none;
        }

        .can-toggle input[type=checkbox][disabled]~label .can-toggle__switch {
            opacity: 0.4;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:before {
            content: attr(data-unchecked);
            left: 0;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            content: attr(data-checked);
        }

        .can-toggle label {
            user-select: none;
            position: relative;
            display: flex;
            align-items: center;
        }

        .can-toggle label .can-toggle__label-text {
            flex: 1;
            padding-left: 32px;
        }

        .can-toggle label .can-toggle__switch {
            position: relative;
        }

        .can-toggle label .can-toggle__switch:before {
            content: attr(data-checked);
            position: absolute;
            top: 0;
            text-transform: uppercase;
            text-align: center;
        }

        .can-toggle label .can-toggle__switch:after {
            content: attr(data-unchecked);
            position: absolute;
            z-index: 5;
            text-transform: uppercase;
            text-align: center;
            background: white;
            transform: translate3d(0, 0, 0);
        }

        .can-toggle input[type=checkbox][disabled]~label {
            color: rgba(234, 0, 48, 0.5);
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch {
            background-color: #ea0030;
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
            color: #b70026;
        }

        .can-toggle input[type=checkbox]:hover~label {
            color: #d1002b;
        }

        .can-toggle input[type=checkbox]:checked~label:hover {
            color: #55bc49;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch {
            background-color: #70c767;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            color: #4fb743;
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch {
            background-color: #5fc054;
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            color: #47a43d;
        }

        .can-toggle label .can-toggle__label-text {
            flex: 1;
        }

        .can-toggle label .can-toggle__switch {
            transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
            background: #ff0538;
        }

        .can-toggle label .can-toggle__switch:before {
            color: rgba(255, 255, 255, 0.5);
        }

        .can-toggle label .can-toggle__switch:after {
            -webkit-transition: -webkit-transform 0.3s cubic-bezier(0, 1, 0.5, 1);
            transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
            color: #ea0030;
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            transform: translate3d(65px, 0, 0);
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle label {
            font-size: 14px;
        }

        .can-toggle label .can-toggle__switch {
            height: 36px;
            flex: 0 0 134px;
            border-radius: 4px;
        }

        .can-toggle label .can-toggle__switch:before {
            left: 67px;
            font-size: 12px;
            line-height: 36px;
            width: 67px;
            padding: 0 12px;
        }

        .can-toggle label .can-toggle__switch:after {
            top: 2px;
            left: 2px;
            border-radius: 2px;
            width: 65px;
            line-height: 32px;
            font-size: 12px;
        }

        .can-toggle label .can-toggle__switch:hover:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle.can-toggle--size-small input[type=checkbox]:hover~label .can-toggle__switch:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:checked~label .can-toggle__switch:after {
            transform: translate3d(44px, 0, 0);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle.can-toggle--size-small input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small label {
            font-size: 13px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch {
            height: 28px;
            flex: 0 0 90px;
            border-radius: 2px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:before {
            left: 45px;
            font-size: 10px;
            line-height: 28px;
            width: 45px;
            padding: 0 12px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:after {
            top: 1px;
            left: 1px;
            border-radius: 1px;
            width: 44px;
            line-height: 26px;
            font-size: 10px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:hover:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }
        
        .pointer{
            cursor: pointer;
        }
        
        .steps>.current:befor{
            background: #ff0854!important;
        }
        /* for progress bar tooltip*/
        
        
.speech-bubble {
  background: #eebf3fc2;
  color: #fff;
  font-weight: bold;
  display: inline-block;
	font-size: 14px;
  line-height: 1.5em;
  margin-bottom: 1em;
	padding: 0 1em;
	position: relative;
	text-align: center;
	vertical-align: top;
		min-width: auto;
		border-radius: 3px;
}
.speech-bubble:after {
    font-size: smaller;
	border: 1em solid transparent;
	border-top-color: #eebf3fc2;
	content: '';
	margin-left: -1em;
	position: absolute;
		top: 100%;
		left: 50%;
	width: 0;
	height: 0;
}

        
        /*****/

section{
  margin:100px auto; 
  height:1000px;
}
.progress{
  border-radius:0;
  overflow:visible;
}
.progress-bar{
   background:rgb(23,44,60); 
  -webkit-transition: width 1.5s ease-in-out;
  transition: width 1.5s ease-in-out;
}
.card .card-body {
    padding: 0px 28px;
}
.step-span{
            font-size: 11px;
        }
    </style>



</head>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
    ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" style="padding:17px">
                                <div class="col-md-6" >
                                    <!--<center style="padding-bottom:30px;float:left;">
                                        <h4 class="card-title">Hello,
                                        <?php
                                        $query = mysqli_query($con, "SELECT * FROM users WHERE  userId = '{$_SESSION['userId']}'");
                                        $result = mysqli_fetch_assoc($query);
                                        echo $result['fullName'];
                                        ?> </h4>
                                    </center>-->
                                    <span class="step-span">( <b>1</b> - Source, </span>
                                    <span class="step-span"><b> &nbsp;2</b> - Pump & Rising Main, </span>
                                    <span class="step-span"><b> &nbsp;3a</b> - ESR, </span>
                                    <span class="step-span"><b> &nbsp;3b</b> - Distribution System, </span>
                                    <span class="step-span"><b> &nbsp;4</b> - Trial Run )</span>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Search..."
                                        id="search_field">
                                </div>
                            </div>
                            <?php
                            $result=mysqli_query($con,"SELECT * FROM yojanaMaster ORDER BY id DESC") ;
                            
                            if(mysqli_num_rows($result)>0){
                            ?>

                            <div class="table-responsive">
                                <table class="table table-striped" id="yojanaTableDT">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="font-weight: bold;">Scheme Id</th>
                                            <th style="font-weight: bold;">Name of Scheme</th>
                                            <th style="font-weight: bold;">Taluka</th>
                                            <th style="font-weight: bold;" class="text-center">Progress</th>
                                            <th style="font-weight: bold;" class="text-center"><?php echo $step ?></th>
                                            <th style="font-weight: bold;">Expected End Date</th>
                                            <th style="font-weight: bold;">Remaining</th>
                                            <th style="font-weight: bold;">Request Extension</th>
                                            <th style="font-weight: bold;">TPI Visit</th>
                                            <th style="font-weight: bold;"></th>
                                        </tr>
                                    </thead>

                                    <tbody id="yojanatable">
                                        <?php
                                        $sql="SELECT * FROM allocatedYojana WHERE userId = '{$_SESSION['userId']}' ORDER BY id DESC";
                                // 		$sql="SELECT * FROM yojanaMaster ORDER BY id DESC";
                                        $result1=mysqli_query($con,$sql);
                                        $i= 1;
                                        while ($row1 =mysqli_fetch_assoc($result1) ){
                                            $status = "";
                                            $expectedDate = "";
                                            $percentage = 0;
                                            $yojanaId = $row1['yojanaId'];
                                            $q = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
                                            $row = mysqli_fetch_assoc($q);
                                            $totalPer = 0;
                                            $stepOne = 0;
                                            $stepTwo = 0;
                                            $stepThree = 0;
                                            $stepFour = 0;
                                            $stepFive = 0;
                                            if($row['stepOne'] == "Yes"){
                                                $totalPer = $totalPer + 100;
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
                                                    $check_one = 0;
                                                    $array_one = array("typeOfSource","diameter","depth","yearOfConstruction","typeOfStructure","completionPercentage","yojanaId");
                                                    for($i1 = 0; $i1 <= (count($array_one)-1); $i1++){
                                                        // if(empty($result[$array_one[$i1]])  || $percentage < 100 ){
                                                        if($percentage < 100 ){
                                                            $stepOneCompleted = "is-incomplete";
                                                        }
                                                    }     
                                                }
                                            }
                                            /*if($stepOne != ""){
                                                $stepOneCompleted = "is-complete";
                                                $stepOneLink = "";
                                            } else {
                                                $stepOneCompleted = "";
                                                $stepOneLink = "stepOne";
                                            }*/
                                            
                                            if($row['stepTwo'] == "Yes"){
                                                $totalPer = $totalPer + 100;
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
                                                    $check_two = 0;
                                                    $array_two = array("pumpNumber","power","installationYear","pumpingHours","pumpHouse","diameter","length","material","yojanaId");
                                                    for($i1 = 0; $i1 <= (count($array_two)-1); $i1++){
                                                        // if(empty($result[$array_two[$i1]])  || $percentage < 100 ){
                                                        if($percentage < 100 ){
                                                            $stepTwoCompleted = "is-incomplete pointer";
                                                        }
                                                    } 
                                                }
                                            }
                                            /*if($stepTwo != ""){
                                                $stepTwoCompleted = "is-complete pointer";
                                                $stepTwoLink = "";
                                            } else {
                                                $stepTwoCompleted = "";
                                                if($stepOneCompleted != ""){
                                                    $stepTwoLink = "stepTwo";
                                                } else {
                                                    $stepTwoLink = "";
                                                }
                                            }*/
                                            
                                            
                                            if($row['stepThree'] == "Yes"){
                                                $totalPer = $totalPer + 100;
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
                                                    $check_three = 0;
                                                    $array_three = array("surveyNo","capacity","yearOfConstruction","height","typeOfConstruction","yojanaId");
                                                    for($i1 = 0; $i1 <= (count($array_three)-1); $i1++){
                                                        // if(empty($result[$array_three[$i1]])  || $percentage < 100 ){
                                                        if($percentage < 100 ){
                                                            $stepThreeCompleted = "is-incomplete pointer";
                                                        }
                                                    } 
                                                }
                                            }
                                            
                                            /*if($stepThree != ""){
                                                $stepThreeCompleted = "is-complete pointer";
                                                $stepThreeLink = "";
                                            } else {
                                                $stepThreeCompleted = "";
                                                if($stepTwoCompleted != ""){
                                                    $stepThreeLink = "stepThree";    
                                                } else {
                                                    $stepThreeLink = "";
                                                }
                                                
                                            }*/
                                            
                                            if($row['stepFour'] == "Yes"){
                                                $totalPer = $totalPer + 100;
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
                                                    $check_four = 0;
                                                    $array_four = array("length","material","yojanaId");
                                                    for($i1 = 0; $i1 <= (count($array_four)-1); $i1++){
                                                        // if(empty($result[$array_four[$i1]])  || $percentage < 100 ){
                                                        if($percentage < 100 ){
                                                            $stepFourCompleted = "is-incomplete pointer";
                                                        }
                                                    } 
                                                }
                                            }
                                            
                                            /*if($stepFour != ""){
                                                $stepFourCompleted = "is-complete pointer";
                                                $stepFourLink = "";
                                            } else {
                                                $stepFourCompleted = "";
                                                if($stepThreeCompleted != ""){
                                                    $stepFourLink = "stepFour";   
                                                } else {
                                                    $stepFourLink = "";
                                                }
                                            }*/
                                            
                                            
                                            // if($row['stepFive'] == "Yes"){
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
                                                
                                                $totalPer = $totalPer + 100;    
                                                
                                                
                                                /*if($stepFive != ""){
                                                    $stepFiveCompleted = "is-complete pointer";
                                                    $stepFiveLink = "";
                                                } else {
                                                    $stepFiveCompleted = "";
                                                    if($stepFourCompleted != ""){
                                                        $stepFiveLink = "stepFive";   
                                                    } else {
                                                        $stepFiveLink = "";
                                                    }
                                                }*/
    
                                                if(mysqli_num_rows($query)>0){
                                                    $check_five = 0;
                                                    $array_five = array("dateOfCommissioning", "dateOfHandingOver", "datesOfTpiVisit1", "datesOfTpiVisit2", "datesOfTpiVisit3", "dateOfCompletion","yojanaId");
                                                    for($i1 = 0; $i1 <= (count($array_five)-1); $i1++){
                                                        // if(empty($result[$array_five[$i1]])  || $percentage < 100 ){
                                                        if($percentage < 100 ){
                                                            $stepFiveCompleted = "is-incomplete pointer";
                                                        }
                                                    }
                                                }
                                            // }
                                            $percentage = (($stepOne + $stepTwo + $stepThree + $stepFour + $stepFive) / $totalPer) * 100;
                                            
                                            $expectedDate = $row['expectedDate'];
                                            $q2 = mysqli_query($con, "SELECT * FROM `extension` WHERE yojanaId = '$yojanaId' ORDER BY id DESC");
                                            $r2 = mysqli_fetch_assoc($q2);
                                            if(!empty($r2['extensionDate'])){
                                                if($r2['status'] != "processing"){
                                                    $expectedDate = $r2['extensionDate'];
                                                    $show = true;
                                                } else {
                                                    $status = "Processing";
                                                    $show = false;
                                                }
                                            } else {
                                                $show = true;
                                            }
                                            if($r2['status'] == "processing"){
                                                $status = "Processing";
                                            } else if($r2['status'] == "approved") {
                                                $status = "Approved";
                                            } else if($r2['status'] == "rejected") {
                                                $status = "Rejected";
                                            }
                                            if($expectedDate <= date('Y-m-d')){
                                                $expectedDate = date('Y-m-d');
                                            }
                                            
                                            $q3 = mysqli_query($con, "SELECT * FROM `subWork` WHERE (plannedDate ='' OR plannedEndDate ='' ) AND yojanaId = '$yojanaId' AND subWork != 'Year - Population' AND subWork != 'Year - Demand'; ");
                                            // $r3 = mysqli_fetch_assoc($q3)
                                            
                                            if($row1 = mysqli_num_rows($q3) >0){
                                                $stepZero = "is-incomplete";
                                            } else {
                                                $stepZero = "is-complete";
                                            }
                                        ?>

                                        <tr>
                                            <td>
                                                <?php echo  $i++; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['yojanaId']; ?>
                                            </td>
                                            <td style="width:400px;">
                                                <?php echo $row['yojanaName']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['taluka']; ?>
                                            </td>                                            
                                            <td>
                                              <!-- Tooltip -->
                                                <div class="speech-bubble">
                                                <?php echo round($percentage) ?>%
                                                </div>
                                                  <!-- End Tooltip -->
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: <?php echo $percentage ?>%;" aria-valuenow="<?php echo $percentage ?>" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </td>
                                            
                                            <td style="width:250px;">
                                                <ol class="steps">
                                                    <li class="step <?php echo $stepZero ?> pointer" onclick="redirect('createYojana', '<?php echo $yojanaId ?>')" data-step="1">
                                                        0
                                                    </li>
                                                    
                                                    <?php
                                                    if($row['stepOne'] == "Yes"){
                                                    ?>
                                                    <li class="step <?php echo $stepOneCompleted ?> pointer" onclick="redirect('<?php echo $stepOneLink ?>', '<?php echo $yojanaId ?>')" data-step="1">
                                                        1
                                                        <br><br><br>
                                                        <?php echo $stepOne; ?>%
                                                    </li>
                                                    <?php 
                                                    }
                                                    
                                                    if($row['stepTwo'] == "Yes"){
                                                    ?>
                                                    <li class="step <?php echo $stepTwoCompleted ?> pointer" onclick="redirect('<?php echo $stepTwoLink ?>', '<?php echo $yojanaId ?>')" data-step="2">
                                                        2
                                                        <br><br><br>
                                                        <?php echo $stepTwo; ?>%
                                                    </li>
                                                    <?php 
                                                    }
                                                    
                                                    if($row['stepThree'] == "Yes"){
                                                    ?>
                                                    
                                                    <li class="step <?php echo $stepThreeCompleted ?> pointer" onclick="redirect('<?php echo $stepThreeLink ?>', '<?php echo $yojanaId ?>')" data-step="3a">
                                                        3a
                                                        <br><br><br>
                                                        <?php echo $stepThree; ?>%
                                                    </li>
                                                    <?php 
                                                    }
                                                    
                                                    if($row['stepFour'] == "Yes"){
                                                    ?>
                                                    
                                                    <li class="step <?php echo $stepFourCompleted ?> pointer" onclick="redirect('<?php echo $stepFourLink ?>', '<?php echo $yojanaId ?>')" data-step="3b">
                                                        3b
                                                        <br><br><br>
                                                        <?php echo $stepFour; ?>%
                                                    </li>
                                                    <?php
                                                    }
                                                    // if($row['stepFive'] == "Yes"){
                                                    ?>
                                                    <li class="step <?php echo $stepFiveCompleted ?> pointer" onclick="redirect('<?php echo $stepFiveLink ?>', '<?php echo $yojanaId ?>')" data-step="4">
                                                        4
                                                        <br><br><br>
                                                        <?php echo $stepFive; ?>%
                                                    </li>
                                                    <?php 
                                                    // }
                                                    ?>
                                                </ol>
                                            </td>
                                            
                                            <td>
                                                <?php
                                                if($expectedDate != "0000-00-00" && !empty($expectedDate)){
                                                    $q2 = mysqli_query($con, "SELECT * FROM `extension` WHERE yojanaId = '$yojanaId' ORDER BY id DESC");
                                                    while($r2 = mysqli_fetch_assoc($q2)){
                                                    
                                                        echo date('d-m-Y', strtotime($r2['extensionDate']));
                                                        if($r2['status'] == "processing"){
                                                            echo "<span style='color:red;font-size: 12px;'> (Processing) </span>";
                                                        } else if($r2['status'] == "rejected"){
                                                            echo "<span style='color:red;font-size: 12px;'> (Rejected) </span>";
                                                        } else if($r2['status'] == "approved"){
                                                            echo "<span style='color:#3CB371;font-size: 12px;'> (Approved) </span>";
                                                        }
                                                        echo "<hr style='margin:0.5rem 0'>";
                                                    }
                                                    echo date('d-m-Y', strtotime($row['expectedDate']));
                                                } else {
                                                    echo "<div style='text-align:center'>-</div>";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if( $expectedDate != "0000-00-00" && !empty($expectedDate)){
                                                    
                                                    
                                                    $date1 = strtotime($expectedDate);
                                                    $date2 = time();
                                                     
                                                    // Formulate the Difference between two dates
                                                    $diff = abs($date2 - $date1);
                                                    // echo "<br>".$years = floor($diff / (365*60*60*24));
                                                    // echo "<br>".$months = floor(( ($years * 365*60*60*24)) / (30*60*60*24));
                                                    
                                                    
                                                    $years  = floor($diff / (365 * 60 * 60 * 24));
                                                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                    $days   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
                                                    echo $years." y, ".$months." m, ".$days." d";
                                                    /*if($months>0){
                                                        echo $months." month";
                                                    } else {
                                                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                        echo $days." days";
                                                    }*/
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if( $expectedDate != "0000-00-00" && !empty($expectedDate) && $show == true){
                                                    if($months<=0 && $years<=0){
                                                ?>
                                                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $i ?>">Request</button>
                                                <div class="modal fade" id="exampleModal<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form action="createYojana_db" method="POST">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Request Extension</h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="date" required min="<?php echo $expectedDate ?>" class="form-control" name="expectionDate">
                                                                    <input type="hidden" value="<?php echo $row['yojanaId']; ?>" name="yojanaId">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary" name="expectionSubmit" >Submit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($row['totalCost'] <= 300000){
                                                    if($datesOfTpiVisit1 != "0000-00-00" && !empty($datesOfTpiVisit1)){
                                                        
                                                        echo "1. ".$datesOfTpiVisit1; 
                                                    } else if($row['tpiVisit1'] != "0000-00-00" && !empty($row['tpiVisit1'])){
                                                        echo "<span style='color:red'>1. ".date("d-m-Y", strtotime($row['tpiVisit1']))."</span>";
                                                    } else {
                                                        echo "1. -";
                                                    }
                                                } else if($row['totalCost'] > 300000 && $row['totalCost'] <= 20000000){
                                                    if($datesOfTpiVisit1 != "0000-00-00" && !empty($datesOfTpiVisit1)){
                                                        echo "1. ".$datesOfTpiVisit1; 
                                                    } else if($row['tpiVisit1'] != "0000-00-00" && !empty($row['tpiVisit1'])){
                                                        echo "<span style='color:red'>1. ".date("d-m-Y", strtotime($row['tpiVisit1']))."</span>";
                                                    } else {
                                                        echo "1. -";
                                                    }
                                                    
                                                    if($datesOfTpiVisit2 != "0000-00-00" && !empty($datesOfTpiVisit2)){
                                                        echo "<br>2. ".$datesOfTpiVisit2; 
                                                    } else if($row['tpiVisit2'] != "0000-00-00" && !empty($row['tpiVisit2'])){
                                                        echo "<span style='color:red'>2. ".date("d-m-Y", strtotime($row['tpiVisit2']))."</span>";
                                                    } else {
                                                        echo "<br>2. -";
                                                    }
                                                } else if($row['totalCost'] > 20000000 && $row['totalCost'] <= 50000000){
                                                    if($datesOfTpiVisit1 != "0000-00-00" && !empty($datesOfTpiVisit1)){
                                                        echo "1. ".$datesOfTpiVisit1; 
                                                    } else if($row['tpiVisit1'] != "0000-00-00" && !empty($row['tpiVisit1'])){
                                                        echo "<span style='color:red'>1. ".date("d-m-Y", strtotime($row['tpiVisit1']))."</span>";
                                                    } else {
                                                        echo "1. -";
                                                    }
                                                    
                                                    if($datesOfTpiVisit2 != "0000-00-00" && !empty($datesOfTpiVisit2)){
                                                        echo "<br>2. ".$datesOfTpiVisit2; 
                                                    } else if($row['tpiVisit2'] != "0000-00-00" && !empty($row['tpiVisit2'])){
                                                        echo "<span style='color:red'>2. ".date("d-m-Y", strtotime($row['tpiVisit2']))."</span>";
                                                    } else {
                                                        echo "<br>2. -";
                                                    }
                                                    
                                                    if($datesOfTpiVisit3 != "0000-00-00" && !empty($datesOfTpiVisit3)){
                                                        echo "<br>3. ".$datesOfTpiVisit3; 
                                                    } else if($row['tpiVisit3'] != "0000-00-00" && !empty($row['tpiVisit3'])){
                                                        echo "<span style='color:red'>3. ".date("d-m-Y", strtotime($row['tpiVisit3']))."</span>";
                                                    } else {
                                                        echo "<br>3. -";
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                            };  
                                        }
                            else{
                                echo "<div class='card-body' style='text-align:center' ><img src='img/no-records.png' id='norecord' class='img-fluid'></div>";
                            }
                                            ?>
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- content-wrapper ends -->
                <?php 
          include('footer.php');
          ?>
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="template/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="template/assets/vendors/select2/select2.min.js"></script>
    <script src="template/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="template/assets/js/off-canvas.js"></script>
    <script src="template/assets/js/hoverable-collapse.js"></script>
    <script src="template/assets/js/misc.js"></script>
    <script src="template/assets/js/settings.js"></script>
    <script src="template/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="template/assets/js/file-upload.js"></script>
    <script src="template/assets/js/typeahead.js"></script>
    <script src="template/assets/js/select2.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script>
    $(function () { 
  $('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
});  

// $( window ).scroll(function() {   
 // if($( window ).scrollTop() > 10){  // scroll down abit and get the action   
  $(".progress-bar").each(function(){
    each_bar_width = $(this).attr('aria-valuenow');
    $(this).width(each_bar_width + '%');
  });
       
 //  }  
// });


        $('#search_field').on('keyup', function () {
            var value = $(this).val();
            var patt = new RegExp(value, "i");

            $('#yojanatable').find('tr').each(function () {
                var $table = $(this);

                if (!($table.find('td').text().search(patt) >= 0)) {
                    $table.not('#t_head').hide();
                }
                if (($table.find('td').text().search(patt) >= 0)) {
                    $(this).show();
                }

            });

        });
    </script>
    <script>
    
        $(document).ready(function(){
            $('#yojanaTableDT').DataTable({
                'columnDefs': [ {

                    'targets': [5,6,7], /* column index */
                
                    'orderable': false, /* true or false */
                
                 }],
                "pageLength": 100
            });
        })
        
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location+"?yojanaId="+yojanaId;   
            }
        }
        var count = 2;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var type = $('#element').val();
                // $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>दस्तऐवजाचा प्रकार </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='img[]' class='file-upload-default' /><div class='input-group col-xs-12'><input type='text' class='form-control file-upload-info' disabled placeholder='Upload Image' /><span class='input-group-append'> <button class='file-upload-browse btn btn-primary' type='button'> Upload </button></span></div></div></div>");
                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>दस्तऐवजाचा प्रकार </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='document[]' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div></div>");
                count = count + 1;
                count2 = count - 1;
                $("#remove").show();
                if (count - 1 == suspected) {
                    $("#add").hide();
                } else {
                    $("#add").show();
                }
            }
        });

        $("#remove").on("click", function () {
            if (count > 2) {
                $("#textboxDiv").children().last().remove();
                count = count - 1;
                count2 = count - 1;
                // document.getElementById("total_member").value = count2;
                $("#add").show();
                if (count == 2) {
                    $("#remove").hide();
                }
            } else {
                $("#remove").hide();
            }
        });
    </script>
</body>

</html>