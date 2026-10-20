<?php
session_start();
if(!isset($_SESSION['userId'])){ 
    header('location:login');
    die();
}

function isMobileDevice() {
    $ua = $_SERVER["HTTP_USER_AGENT"] ?? '';
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $ua);
}

if(isMobileDevice()){
    $mobile = "col-12 p-1";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
else {
    $mobile = "col-2 p-0";
    $step = "Stage (Tappa)";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
 
    <title>Scheme Progress</title>
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

    <style>
    .card {
        margin:5px;
    }
        .card-body {
    padding: 0px 28px;
}
        .range-slider {
            margin: 2px 0 0 0;
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
        
        /*.pointer{
            cursor: pointer;
        }*/
        .center{
            text-align: center;
        }
       
        #border{
            border-right: 1px solid #c9c8c8;
        }
        
        @media only screen and (max-width: 600px) {
  #mobdiv{
    /*margin-left:-80px;*/
    overflow-x:hidden;
  }
  #border{
            border-bottom: 1px solid #c9c8c8;
              border-right:none;
        }
}

    </style>
        <style>
    @media print{
        .btn, .bottom-navbar>.contain, .mdi-menu, .footer, .no-print, .horizontal-menu {
                display: none;
            }
        @page {size: landscape}
        
        #subWorkDiv, #stepDiv{
                    width: 100%;
                }
    body {
    zoom: 90%;
  }

        
    }
    @media print {
       .main-panel
        {
            margin-top:10px;
        }
        .content-text h2
        {
            margin-top: 0px !important;
        }
        }
        
        .col-md-4 {
            font-size: 14px;
        }

        .color {
            color: #212529;
            font-weight: bold;
            font-size: 18px;
        }

        .tablehead {
            background: #0033c4;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        .table thead th {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }
        
        @media screen and (max-width: 600px) {
                #printBtn
                {
                    display:none;
                }
                .color{
                    font-size:12px;
                }
                .fon
                {
                    font-size:11px;
                }
            }
        
        @media print{
            .btn, .bottom-navbar>.contain, .mdi-menu, .footer, .no-print {
                display: none;
            }
            .break {
                margin-top: 2rem;
            }
        }
        hr{
            margin : 0.5rem 0;
            width: 100%;
        }
        .table-bordered>:not(caption)>*>*, .table-bordered>:not(caption)>*{
            border-color: #000;
        }
    </style>



</head>

<body>
    <div class="container-scroller">
        <?php
        include("include/con.php");
        include('header.php');
        
        if(!isset($_GET['toDate']) && !isset($_GET['fromDate'])){
        
            $q = mysqli_query($con, "SELECT MIN(createdDate) as 'fromDateC', MIN(updatedDate) as 'fromDateU' FROM yojanaMaster");
            $r = mysqli_fetch_assoc($q) ?: [];
            
            
            $_GET['toDate'] = date('Y-m-d');
            
            $fromDateU = $r['fromDateU'] ?? '';
            $fromDateC = $r['fromDateC'] ?? '';
            
            if($fromDateU > $fromDateC){
                $_GET['fromDate'] = date('Y-m-d', strtotime($fromDateU));
            } else {
                $_GET['fromDate'] = date('Y-m-d', strtotime($fromDateC));
            }
        }
        
        // safe defaults so the form never shows "undefined key" warnings
        $_GET['fromDate'] = $_GET['fromDate'] ?? date('Y-m-d');
        $_GET['toDate']   = $_GET['toDate'] ?? date('Y-m-d');
        $selectedTaluka   = $_GET['taluka'] ?? '';
        ?>
    
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body"  style="padding: 0px 28px; ">
                            <div class="row" style="padding:17px">
                                <div class="col-md-12">
                                    <center>
                                        <h3 class="ribbon">Scheme Progress </h3>
                                    </center>
                                </div>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fromDate">From</label>
                                            <input type="date" id="fromDate" value="<?php echo $_GET['fromDate'] ?>" min="<?php echo $_GET['fromDate'] ?>" max="<?php echo date('Y-m-d') ?>" name="fromDate" class="form-control" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="toDate">To</label>
                                            <input type="date" id="toDate" value="<?php echo $_GET['toDate'] ?>" min="<?php echo $_GET['fromDate'] ?>" max="<?php echo date('Y-m-d') ?>" name="toDate" class="form-control" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group"> 
                                            <label for="taluka">Taluka</label>
                                            <select class="js-example-basic-single" id="taluka" name="taluka" style="width: 100%;">
                                                <option value="" selected="">All Taluka</option>
                                                <?php
                                                
                                                $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                                                while($result = mysqli_fetch_assoc($query)){
                                                    $talukaName = $result['taluka'];
                                                    if($talukaName == $selectedTaluka){
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                ?>
                                                <option value="<?php echo $talukaName ?>" <?php echo $selected; ?>><?php echo $talukaName ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1" style="display: flex;align-items: center;">
                                        <button type="submit" class="btn btn-primary me-2" name="show">Show</button>
                <button type="button" id="printBtn" class="btn btn-primary me-2" onclick="printFun()">Print</button>
                                    </div>
                                </div>
                            </form>
                            
                            <?php
                            // ---------- FILTERS ----------
                            $date = "";
                            if(isset($_GET['show'])){
                                $fromDate = date("Y-m-d", strtotime($_GET['fromDate']));
                                $toDate = date("Y-m-d", strtotime($_GET['toDate']));
                                $date = "AND (createdDate BETWEEN '$fromDate' AND '$toDate' or updatedDate BETWEEN '$fromDate' AND '$toDate')";
                            }
                            
                            $talukaFilter = "";
                            if($selectedTaluka != ''){
                                $t = mysqli_real_escape_string($con, $selectedTaluka);
                                $talukaFilter = "AND taluka = '$t'";
                            }
                            
                            $sql = "SELECT * FROM yojanaMaster WHERE 1 $date $talukaFilter ORDER BY id DESC";
                            
                            $result1 = mysqli_query($con, $sql);
                            $i = 1;
                            $a = 0;
                            $b = 0;
                            $c = 0;
                            $d = 0;
                            $e = 0;
                            $f = 0;
                            
                            // ---------- INITIALISE ID LISTS ----------
                            $yojanaIds = '';
                            $yoj = '';
                            $yoja = '';
                            $yojan = '';
                            $yojana = '';
                            $yojanai = '';
                            $comm = '';
                            $comms = '';
                            $hand = '';
                            
                            while($row = mysqli_fetch_assoc($result1)){
                                $status = "";
                                $percentage = 0;
                                $yojanaId = $row['yojanaId'];
                                
                                // ---------- STEP ONE ----------
                                $query = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'");
                                $result = mysqli_fetch_assoc($query) ?: [];
                                $stepOne = $result['completionPercentage'] ?? '';
                                $count1 = mysqli_num_rows($query);
                                if($count1 == 0){
                                    $stepOne = 0;
                                }
                                if($stepOne != ""){
                                    $stepOneCompleted = "is-complete pointer";
                                    $stepOneLink = "stepOne";
                                    $percentage = $stepOne;
                                } else {
                                    $stepOneCompleted = "pointer current";
                                    $stepOneLink = "stepOne";
                                }
                                
                                if(mysqli_num_rows($query) > 0){
                                    $check_one = 0;
                                    $array_one = array("typeOfSource","diameter","depth","yearOfConstruction","typeOfStructure","completionPercentage","yojanaId");
                                    for($i1 = 0; $i1 <= (count($array_one)-1); $i1++){
                                        if(empty($result[$array_one[$i1]]) || $percentage < 100 ){
                                            $stepOneCompleted = "is-incomplete";
                                        }
                                    }     
                                }
                                
                                // ---------- STEP TWO ----------
                                $query = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'");
                                $result = mysqli_fetch_assoc($query) ?: [];
                                $stepTwo = $result['completionPercentage'] ?? '';
                                $count2 = mysqli_num_rows($query);
                                if($count2 == 0){
                                    $stepTwo = 0;
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
                                
                                if(mysqli_num_rows($query) > 0){
                                    $check_two = 0;
                                    $array_two = array("pumpNumber","power","installationYear","pumpingHours","pumpHouse","diameter","length","material","yojanaId");
                                    for($i1 = 0; $i1 <= (count($array_two)-1); $i1++){
                                        if(empty($result[$array_two[$i1]]) || $percentage < 100 ){
                                            $stepTwoCompleted = "is-incomplete pointer";
                                        }
                                    } 
                                }
                                
                                // ---------- STEP THREE ----------
                                $query = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'");
                                $result = mysqli_fetch_assoc($query) ?: [];
                                $stepThree = $result['completionPercentage'] ?? '';
                                $count3 = mysqli_num_rows($query);
                                if($count3 == 0){
                                    $stepThree = 0;
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
                                
                                if(mysqli_num_rows($query) > 0){
                                    $check_three = 0;
                                    $array_three = array("surveyNo","capacity","yearOfConstruction","height","typeOfConstruction","yojanaId");
                                    for($i1 = 0; $i1 <= (count($array_three)-1); $i1++){
                                        if(empty($result[$array_three[$i1]]) || $percentage < 100 ){
                                            $stepThreeCompleted = "is-incomplete pointer";
                                        }
                                    } 
                                }
                                
                                // ---------- STEP FOUR ----------
                                $query = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'");
                                $result = mysqli_fetch_assoc($query) ?: [];
                                $stepFour = $result['completionPercentage'] ?? '';
                                $count4 = mysqli_num_rows($query);
                                if($count4 == 0){
                                    $stepFour = 0;
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
                                
                                if(mysqli_num_rows($query) > 0){
                                    $check_four = 0;
                                    $array_four = array("length","material","yojanaId");
                                    for($i1 = 0; $i1 <= (count($array_four)-1); $i1++){
                                        if(empty($result[$array_four[$i1]]) || $percentage < 100 ){
                                            $stepFourCompleted = "is-incomplete pointer";
                                        }
                                    } 
                                }
                                
                                // ---------- STEP FIVE ----------
                                $query = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'");
                                $result = mysqli_fetch_assoc($query) ?: [];
                                $stepFive = $result['completionPercentage'] ?? '';
                                $count5 = mysqli_num_rows($query);
                                if($count5 == 0){
                                    $stepFive = 0;
                                }
                                $datesOfTpiVisit1 = $result['datesOfTpiVisit1'] ?? '';
                                $datesOfTpiVisit2 = $result['datesOfTpiVisit2'] ?? '';
                                $datesOfTpiVisit3 = $result['datesOfTpiVisit3'] ?? '';
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

                                if(mysqli_num_rows($query) > 0){
                                    $check_five = 0;
                                    $array_five = array("dateOfCommissioning", "dateOfHandingOver", "datesOfTpiVisit1", "datesOfTpiVisit2", "datesOfTpiVisit3", "dateOfCompletion","yojanaId");
                                    for($i1 = 0; $i1 <= (count($array_five)-1); $i1++){
                                        if(empty($result[$array_five[$i1]]) || $percentage < 100 ){
                                            $stepFiveCompleted = "is-incomplete pointer";
                                        }
                                    }
                                }
                                
                                // ---------- OVERALL PERCENTAGE ----------
                                $percentage = (((float)$stepOne + (float)$stepTwo + (float)$stepThree + (float)$stepFour + (float)$stepFive) / 500) * 100;
                                        
                                if($percentage == 0 ){  
                                    $yojanaIds .= $yojanaId.','; 
                                    $a++;
                                }
                                if($percentage >= 1 && $percentage <= 25 ){
                                    $yoj .= $yojanaId.',';
                                    $b++;
                                }
                                if($percentage >= 26 && $percentage <= 50 ){
                                    $yoja .= $yojanaId.',';
                                    $c++;
                                }
                                if($percentage >= 51 && $percentage <= 75 ){
                                    $yojan .= $yojanaId.',';
                                    $d++;
                                }
                                if($percentage >= 76 && $percentage <= 100 ){ 
                                    $yojana .= $yojanaId.',';  
                                    $e++;
                                }
                                if($percentage == 100 ){
                                    $yojanai .= $yojanaId.',';
                                    $f++;
                                }
                            };
                            ?>
                            <div class="row" style="padding: 10px;justify-content:center" id="mobdiv">
                                <div class="col-sm-2" style="text-align:center;">
                                    <div class="card">
                                        <div class="card-body" style="padding:2px;padding-top: 15px; padding-bottom: 15px;">
                                            <h5 class="card-title"><i class="mdi mdi-close-circle-outline" style="font-size:30px;color:red"></i>
                                            </h5>
                            
                                            <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $yojanaIds ?>&" value=""
                                                style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                <?php echo $a; ?>
                                            </a>
                                            <p class="card-text" style="font-size:15px;font-weight:300">Not Started </p>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-sm-2" style="text-align:center;">
                                    <div class="card">
                                        <div class="card-body" style="padding:2px;padding-top: 15px; padding-bottom: 15px;">
                                            <h5 class="card-title"><i class="mdi mdi-timer-sand" style="font-size:30px;color:blue"></i></h5>
                            
                                            <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $yoj ?>&" value=""
                                                style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                <?php echo $b; ?>
                                            </a>
                                            <p class="card-text" style="font-size:15px;font-weight:300">0-25% </p>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-sm-2" style="text-align:center;">
                                    <div class="card">
                                        <div class="card-body" style="padding:2px;padding-top: 15px; padding-bottom: 15px;">
                                            <h5 class="card-title"><i class="mdi mdi-clock" style="font-size:30px;color:grey"></i></h5>
                            
                                            <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $yoja ?>&" value=""
                                                style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                <?php echo $c; ?>
                                            </a>
                                            <p class="card-text" style="font-size:15px;font-weight:300">25-50% </p>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-sm-2" style="text-align:center;">
                                    <div class="card">
                                        <div class="card-body" style="padding:2px;padding-top: 15px; padding-bottom: 15px;">
                                            <h5 class="card-title"><i class="mdi mdi-check" style="font-size:30px;color:orange"></i></h5>
                            
                                            <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $yojan ?>&" value=""
                                                style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                <?php echo $d; ?>
                                            </a>
                                            <p class="card-text" style="font-size:15px;font-weight:300">50-75% </p>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-sm-2" style="text-align:center;">
                                    <div class="card">
                                        <div class="card-body" style="padding:2px;padding-top: 15px; padding-bottom: 15px;">
                                            <h5 class="card-title"><i class="mdi mdi-check-all" style="font-size:30px;color:green"></i></h5>
                            
                                            <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $yojana ?>&" value=""
                                                style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                <?php echo $e; ?>
                                            </a>
                                            <p class="card-text" style="font-size:15px;font-weight:300">75-100% </p>
                                        </div>
                                    </div>
                                </div>
                           
                                    <?php 
                                    // ---------- COMMISSIONED ----------
                                    $commissionedCount = 0;
                                    $query = mysqli_query($con, "SELECT * FROM stepFive");
                                    while($result = mysqli_fetch_assoc($query)){
                                        $commission = $result['dateOfCommissioning'] ?? '';
                                        $yojanaId = $result['yojanaId'];
                                    
                                        if($commission != '0000-00-00'){ 
                                            $comm .= $yojanaId.',';
                                            $commissionedCount++;
                                        } 
                                    }
                                    
                                    // ---------- FINANCIALLY COMPLETED ----------
                                    $z = 0;
                                    $query1 = mysqli_query($con, "SELECT * FROM yojanaMaster");
                                    while($result1 = mysqli_fetch_assoc($query1)){
                                        $yojanaid = $result1['yojanaId'];
                                        $finance = $result1['totalSanctionedCost'];
                                        $yojanaId = $result1['yojanaId'];
                                        
                                        $query2 = mysqli_query($con, "SELECT sum(amount) as ex FROM `finance` where yojanaId='$yojanaid'");
                                        if(mysqli_num_rows($query2) > 0){
                                            $result2 = mysqli_fetch_assoc($query2);
                                            $cost = $result2['ex'] ?? 0;
                                            if($cost == ""){
                                                $cost = 0;
                                            }
                                            
                                            if($cost >= $finance){
                                                $comms .= $yojanaId.',';
                                                $z++;
                                            }
                                        }
                                    }
                                    
                                    // ---------- HANDED OVER ----------
                                    $handed = 0;
                                    $query = mysqli_query($con, "SELECT * FROM stepFive");
                                    while($result = mysqli_fetch_assoc($query)){
                                        $commission = $result['dateOfHandingOver'] ?? '';
                                        $yojanaId = $result['yojanaId'];
                                        if($commission != '0000-00-00'){
                                            $hand .= $yojanaId.',';
                                            $handed++;
                                        }
                                    }
                                    ?>

                                        <div class="col-sm-2" style="text-align:center;;">
                                            <div class="card">
                                                <div class="card-body" style="padding:2px;padding-top: 15px; padding-bottom: 15px;">
                                                    <h5 class="card-title"><i class="mdi mdi-calendar-check" style="font-size:30px;color:#03cffc"></i></h5>
                            
                                                    <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $comm ?>&" style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                        <?php echo $commissionedCount; ?>
                                                    </a>
                            
                                                    <p class="card-text" style="font-size:15px;font-weight:300">Commissioned </p>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="col-sm-2" style="text-align:center;">
                                            <div class="card">
                                                <div class="card-body" style="padding:2px;padding-top: 15px; padding-bottom: 15px;">
                                                    <h5 class="card-title"><i class="mdi mdi-account-multiple" style="font-size:30px;color:purple"></i></h5>
                                                    <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $hand ?>&" value="" style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                        <?php echo $handed; ?>
                                                    </a>
                                                    <p class="card-text" style="font-size:15px;font-weight:300">Handed over </p>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-4" style="text-align:center">
                                            <div class="card">
                                                <div class="row">
                                                    <div class="col-sm-6 p-0" >
                                                        <div class="card-body" style="padding-top: 15px; padding-bottom: 0px;" id="border">
                                                            <h5 class="card-title m-0"><i class="mdi mdi-account" style="font-size:30px;color:#fc1c03;"></i></h5>
                                                            <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $yojanai ?>&" style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                                <?php echo $f; ?>
                                                            </a>
                                                            <p class="card-text" style="font-size:15px;font-weight:300;padding-bottom:5px">Physically <span style="font-size:11px">
                                                                <br>
                                                                (Completed)</span></p>
                                                        </div>
                                                    </div>
                            
                                                    <div class="col-sm-6">
                                                        <div class="card-body" style="padding-top: 15px;padding-bottom: 0px;">
                                                            <h5 class="card-title m-0"><i class="mdi mdi-currency-inr" style="font-size:30px;color:grey"></i></h5>
                                                            <a href="notstarted?back=schemeprogress&yojanaid=<?php echo $comms ?>&" style="text-decoration:none;color:black;font-size:20px;font-weight:500;">#
                                                                <?php echo $z; ?>
                                                            </a>
                                                            <p class="card-text" style="font-size:15px;font-weight:300;padding-bottom:5px">Financially <span style="font-size:11px">
                                                                <br>
                                                                (Completed)</span> </p>                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <?php 
    include('footer.php');
    ?>
    <script>
        
        function printFun(){
            window.print();
            // $('#subWorkDiv').removeClass()
        }
    </script>
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
    <!-- End custom js for this page -->
    
    <?php 
    
    require_once('include/sweetAlert.php');
    if(isset($_SESSION['status'])){
        $status = $_SESSION['status'];
        $msg = $_SESSION['msg'];
        if($status != true){
            toastMsg('error', $msg);
        } else {
            toastMsg('success', $msg);
        }
        unset($_SESSION['status']);
        unset($_SESSION['msg']);
    }
    
    ?>
    
    <script>
        $("#fromDate").on('change', function(){
            $("#toDate").attr('min', $(this).val());
        })
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
</body>

</html>