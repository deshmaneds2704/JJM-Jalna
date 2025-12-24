<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobileDevice()){
    $mobile = "col-12 p-1";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
else {
    $mobile = "col-4 p-0";
    $step = "Stage (Tappa)";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Show Taluka Report</title>
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
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <style>
    .card .card-body {
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
        .ribbon {
            max-width: 100% !important;
            padding: 15px;
            height: 70px;
            background: #6a8ab8;
            -webkit-clip-path: polygon(100% 0, 95% 50%, 100% 100%, 0% 100%, 5% 50%, 0% 0%);
                  clip-path: polygon(100% 0, 95% 50%, 100% 100%, 0% 100%, 5% 50%, 0% 0%);
            font-family: "font_condensed";
            text-transform: uppercase;
            color: #fff;
            letter-spacing: 0.18em;
            display: flex;
            justify-content: center;
            align-items: center;
        }
       @media screen and (max-width: 600px) {
            .ribbon{
                font-size: 100%;
            }
       }
       
       .table-responsive{
           padding-bottom: 17px;
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
        zoom: 65%;
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
    ?>
    
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" style="padding:17px;display: flex;justify-content: center;">
                                <div class="col-md-6">
                                    <center style="padding-bottom:30px;text-align:center">
                                        <h3 class="ribbon">Taluka Wise Scheme Report</h3>
                                    </center>
                                </div>
                               
                            </div>
                            <form action="agreementReport_sk" method="POST">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Taluka</label>
                                            <select class="js-example-basic-single" id="taluka" name="taluka" style="width: 100%;">
                                                <option value="" selected="">All Taluka</option>
                                                <?php
                                                
                                                $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                                                while($result = mysqli_fetch_assoc($query)){
                                                    $taluka = $result['taluka'];
                                                    if($taluka == $_REQUEST['taluka']){
                                                        $selected = "selected";
                                                    } else {
                                                        $selected = "";
                                                    }
                                                ?>
                                                <option value="<?php echo $taluka ?>" <?php echo $selected; ?>><?php echo $taluka ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2" style="display: flex;align-items: center;">
                <button type="submit" class="btn btn-primary me-2" name="show">Show</button>
                <button type="button" id="printBtn" class="btn btn-primary me-2" onclick="printFun()">Print</button>
                                    </div>
                                </div>
                            </form>
                                
                            <?php $taluka = $_POST['taluka'];?>
            
                            <div class="table-responsive">
                                <table class="table table-striped" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="font-weight: bold;">Scheme Name</th>
                                            <th style="font-weight: bold;">Taluka</th>
                                            <th style="font-weight: bold;">Date of Work Order</th>
                                            <th style="font-weight: bold;">Duration</th>
                                            <th style="font-weight: bold;">Expected Date</th>
                                            <th style="font-weight: bold;">Cost</th>
                                            <th style="font-weight: bold;">Expenditure</th>
                                            <th style="font-weight: bold;">Financial Progress</th>
                                            <th style="font-weight: bold;">Physical Progress</th>
                                            <th style="font-weight: bold;">Extended Date</th>
                                        </tr>
                                    </thead>

                                    <tbody id="yojanatable">
                                        <?php
                                        if(!empty($taluka)){
                                            $sql="SELECT * FROM yojanaMaster where taluka='$taluka'";
                                        } else{
                                            $sql="SELECT * FROM yojanaMaster ";
                                        }
                                        $query = mysqli_query($con,$sql);
                                        $i= 1;
                                        while($result = mysqli_fetch_assoc($query)){
                                            
                                            $id = $result['yojanaId'];
                                            $yojanaName = $result['yojanaName'];
                                            $taluka = $result['taluka'];
                                        
                                            
                                            $q = mysqli_query($con, "SELECT * FROM agreement WHERE yojanaId = '{$result['yojanaId']}'");
                                            $r = mysqli_fetch_assoc($q);
                                            $dateOfWorkOrder = $r['dateOfWorkOrder'];

                                            $q0 = mysqli_query($con, "select datediff(expectedDate,exectedStartDate) as 'duration' from yojanaMaster WHERE yojanaId='$id'");
                                            $r0 = mysqli_fetch_assoc($q0);
                                            $duration = $r0['duration'].' days';

                                            $q1 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId ='$id'") or die($con -> error);
                                            $r1 = mysqli_fetch_assoc($q1);
                                            $expectedDate = $r1['expectedDate'];
                                            
                                            $q3 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '{$result['yojanaId']}'");
                                            $r3 = mysqli_fetch_assoc($q3);
                                            $totalSanctionedCost = $r3['totalSanctionedCost'];
                                            
                                            $q4 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '{$result['yojanaId']}'");
                                            $r4 = mysqli_fetch_assoc($q4);
                                            $totalSanctionedCost = $r4['totalSanctionedCost'];
                                            
                                            $q5 = mysqli_query($con, "SELECT SUM(amount) as Expenditure FROM `finance` WHERE yojanaId='$id'");
                                            $r5 = mysqli_fetch_assoc($q5);
                                            $Expenditure = $r5['Expenditure'];
                                            
                                            $query6 = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$id'");
                                            $result = mysqli_fetch_assoc($query6);
                                            $stepOne = $result['completionPercentage'];
                                            $count1=mysqli_num_rows($query6);
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
                                            
                                            if(mysqli_num_rows($query6)>0){
                                                $check_one = 0;
                                                $array_one = array("typeOfSource","diameter","depth","yearOfConstruction","typeOfStructure","completionPercentage","yojanaId");
                                                for($i1 = 0; $i1 <= (count($array_one)-1); $i1++){
                                                    if(empty($result[$array_one[$i1]]) || $percentage < 100 ){
                                                        $stepOneCompleted = "is-incomplete";
                                                    }
                                                }     
                                            }
                                            
                                            $query6 = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$id'");
                                            $result = mysqli_fetch_assoc($query6);
                                            $stepTwo = $result['completionPercentage'];
                                            $count2 = mysqli_num_rows($query6);
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
                                            
                                            if(mysqli_num_rows($query6)>0){
                                                $check_two = 0;
                                                $array_two = array("pumpNumber","power","installationYear","pumpingHours","pumpHouse","diameter","length","material","yojanaId");
                                                for($i1 = 0; $i1 <= (count($array_two)-1); $i1++){
                                                    if(empty($result[$array_two[$i1]]) || $percentage < 100 ){
                                                        $stepTwoCompleted = "is-incomplete pointer";
                                                    }
                                                } 
                                            }
                                           
                                            
                                            $query6 = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$id'");
                                            $result = mysqli_fetch_assoc($query6);
                                            $stepThree = $result['completionPercentage'];
                                            $count3=mysqli_num_rows($query6);
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
                                            
                                            if(mysqli_num_rows($query6)>0){
                                                $check_three = 0;
                                                $array_three = array("surveyNo","capacity","yearOfConstruction","height","typeOfConstruction","yojanaId");
                                                for($i1 = 0; $i1 <= (count($array_three)-1); $i1++){
                                                    if(empty($result[$array_three[$i1]]) || $percentage < 100 ){
                                                        $stepThreeCompleted = "is-incomplete pointer";
                                                    }
                                                } 
                                            }
                                       
                                            
                                            $query6 = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$id'");
                                            $result = mysqli_fetch_assoc($query6);
                                            $stepFour = $result['completionPercentage'];
                                            $count4 = mysqli_num_rows($query6);
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
                                            
                                            if(mysqli_num_rows($query6)>0){
                                                $check_four = 0;
                                                $array_four = array("length","material","yojanaId");
                                                for($i1 = 0; $i1 <= (count($array_four)-1); $i1++){
                                                    if(empty($result[$array_four[$i1]]) || $percentage < 100 ){
                                                        $stepFourCompleted = "is-incomplete pointer";
                                                    }
                                                }
                                            }
                                            
                                            
                                            $query6 = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$id'");
                                            $result = mysqli_fetch_assoc($query6);
                                            $stepFive = $result['completionPercentage'];
                                            $count5 = mysqli_num_rows($query6);
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

                                            if(mysqli_num_rows($query6)>0){
                                                $check_five = 0;
                                                $array_five = array("dateOfCommissioning", "dateOfHandingOver", "datesOfTpiVisit1", "datesOfTpiVisit2", "datesOfTpiVisit3", "dateOfCompletion","yojanaId");
                                                for($i1 = 0; $i1 <= (count($array_five)-1); $i1++){
                                                    if(empty($result[$array_five[$i1]]) || $percentage < 100 ){
                                                        $stepFiveCompleted = "is-incomplete pointer";
                                                    }
                                                }
                                            }
                                            $percentage = (($stepOne + $stepTwo + $stepThree + $stepFour + $stepFive) / 500) * 100;
                                            

                                            $financial = ($Expenditure/$totalSanctionedCost)*100;
                                        ?>
                                        <tr>
                                            <td> <?php echo $i ?></td>
                                            <td> <?php echo $yojanaName ?></td>
                                            <td> <?php echo $taluka ?></td>
                                            <td> <?php 
                                                if ($dateOfWorkOrder=="") {
                                                    echo "-";
                                                } else {
                                                    echo $dateOfWorkOrder = date('d-m-Y', strtotime($dateOfWorkOrder));
                                                }
                                                ?>
                                            </td>
                                            <td> <?php echo $duration ?></td>
                                            <td> <?php 
                                                if ($expectedDate=="") {
                                                    echo "-";
                                                } else {
                                                    echo $expectedDate = date('d-m-Y', strtotime($expectedDate));
                                                }
                                                ?>
                                            </td>
                                            <td> <?php echo $totalSanctionedCost; ?> </td>
                                            <td> <?php 
                                                if ($Expenditure=="") {
                                                    echo "-";
                                                } else {
                                                    echo $Expenditure;
                                                }
                                                ?>
                                            </td>
                                            <td> <?php echo(round($financial,0)); ?> </td>
                                            <td> <?php echo $percentage ?> </td>
                                            <td> <?php 
                                                if ($extendedDate=="") {
                                                    echo "-";
                                                } else {
                                                    echo $extendedDate;
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
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
    <script>
        
        function printFun(){
            window.print();
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
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    
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
        $(document).ready(function () {
            $('#dataTable').DataTable();
        })
    </script>
    
</body>

</html>