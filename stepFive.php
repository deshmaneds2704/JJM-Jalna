<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
$delayReason = 10;
require_once('include/con.php');
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobileDevice()){
    $mobile = true;
    $file = "download";
}
else {
    $mobile = false;
    $file = "target='_blank'";
}
if(!isset($_GET['yojanaId'])){
?>
<script>
    window.location='home';
</script>
<?php
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <title>Step Five - Trial Run</title>
    
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
    <link rel="shortcut icon" href="template/assets/images/favicon.png" />
    
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <style>
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
            top:37%;
        }

        .steps>.step:after {
            content: "";
            position: absolute;
            display: block;
            background: #e6e6e6;
            width: 100%;
            height: 0.125rem;
            top: 2.5rem;
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
        
         ul li, ol li, dl li {
    line-height: 1.3;
}

        .steps>.step.is-active:before {
            color: #FFF;
            border: 2px solid #0033c4;
            background: #0033c4;
            /*margin-bottom: -4.9rem;*/
        }

        .steps {
            margin-top: 3em;
        }
        
        .hide {
            display: none;
        }
        
        .center {
            text-align: center;
        }
        .pointer {
            cursor: pointer;
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
        
        .center {
            text-align: center;
        }
        
        .pointer{
            cursor: pointer;
        }
         .text{
            font-size: 10px;
        }
         @media screen and (max-width: 600px) {
             .text{
                 font-size: 8px;
             }
             .font
             {
                 font-size:10px;
             }
              .steps>.step:before
             {
                 top:62%;
             }
             .steps>.step:after
             {
                 top: 3.5rem;
             }
             .card .card-title
             {
                 font-size:13px;
             }
        }
        #divcheck2, #divcheck3{
            display: none;
        }
    </style>
    

</head>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
        $yojanaId = $_GET['yojanaId'];
        $q = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
        $r = mysqli_fetch_assoc($q);
        $yojanaName = $r['yojanaName'];
        $stepOne = $r['stepOne'];
        $stepTwo = $r['stepTwo'];
        $stepThree = $r['stepThree'];
        $stepFour = $r['stepFour'];
        $stepFive = $r['stepFive'];
        
        $query = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'");
        
        if(mysqli_num_rows($query) > 0){
            $result = mysqli_fetch_assoc($query);
            $yojanaComplete =  $result['yojanaComplete'];
            $reason = $result['reason'];
            $dateOfCommissioning = $result['dateOfCommissioning'];
            $dateOfHandingOver = $result['dateOfHandingOver'];
            $datesOfTpiVisit1 = $result['datesOfTpiVisit1'];
            $datesOfTpiVisit2 = $result['datesOfTpiVisit2'];
            $datesOfTpiVisit3 = $result['datesOfTpiVisit3'];
            $dateOfCompletion = $result['dateOfCompletion'];
            $docName1 = $result['docName1'];
            $photo1 = $result['photo1'];
            $docName2 = $result['docName2'];
            $photo2 = $result['photo2'];
            $docName3 = $result['docName3'];
            $photo3 = $result['photo3'];
            $docName4 = $result['docName4'];
            $photo4 = $result['photo4'];
            $longitude = $result['longitude'];
            $latitude = $result['latitude'];
            $video_link  = $result['video_link'];
            $completionPercentage = $result['completionPercentage'];
            $remark = $result['remark'];
            $exit = true;
        } else {
            $exit = false;
            $completionPercentage = 0;
        }
        $document = 2;
        ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    if($_SESSION['designation'] != "sectionEng"){
                                        if(isset($_GET['back'])){
                                            $page = "acceptExtension";    
                                            if($_GET['back'] == "yojanaAllData"){
                                                $page = "yojanaAllData?yojanaId=".$yojanaId;    
                                            }
                                        } else {
                                            $page = "financeReportAdmin?yojanaId=".$yojanaId;
                                        }
                                        $readonly = "$('.forms-sample input').attr('disabled', 'disabled');
                                                    $('.forms-sample select').attr('disabled', 'disabled');
                                                    $('.forms-sample button').attr('disabled', 'disabled');";
                                    } else {
                                        $page = "home";
                                        $readonly = "";
                                    }
                                    ?>
                                    <a href="<?php echo $page ?>" style="float: left;margin-bottom:3rem"><button type="button" class="btn btn-primary me-2">Back</button></a>
                                    <h4 class="card-title center"><?php echo $yojanaName." (".$yojanaId.")" ?></h4>
                                    <ol class="steps">
                                        <?php
                                        
                                        //
                                        //Step One
                                        //
                                        if($stepOne == "Yes"){
                                            $stepOneCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                    					    if(mysqli_num_rows($query)>0){
                                                                $check_one = 0;
                                                                if($percentage < 100 ){
                                                                    $stepOneCompleted = "is-incomplete pointer";
                                                                }
                    					    }else{
                    					        $stepOneCompleted = "";
                    					    }                                        
                                        ?>                                       
                                        <li class="step <?php echo $stepOneCompleted; ?> pointer" onclick="redirect('stepOne', '<?php echo $yojanaId ?>')" data-step="1">
                                            <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                            <br>
                                            <span class="font">Stage 1</span>
                                            <br>
                                            <span class="text">(Source)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        
                                        //
                                        //Step Two
                                        //
                                        if($stepTwo == "Yes"){
                                            $stepTwoCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                    					    if(mysqli_num_rows($query)>0){
                                                $check_two = 0;
                                                if($percentage < 100 ){
                                                    $stepTwoCompleted = "is-incomplete pointer";
                                                }
                    					    }else{
                    					       $stepTwoCompleted = ""; 
                    					    }                                        
                                        ?>
                                        <li class="step <?php echo $stepTwoCompleted; ?> pointer" onclick="redirect('stepTwo', '<?php echo $yojanaId ?>')" data-step="2">
                                            <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                            <br>
                                            <span class="font">Stage 2</span>
                                            <br>
                                            <span class="text">(Pump/Rising Main)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        //
                                        //Step Three
                                        //
                                        if($stepThree == "Yes"){
                                            $stepThreeCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);  
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                    					    if(mysqli_num_rows($query)>0){
                                                                $check_three = 0;
                                                                if($percentage < 100 ){
                                                                    $stepThreeCompleted = "is-incomplete pointer";
                                                                }
                    					    }else{
                    					        $stepThreeCompleted = "";
                    					    }                                        
                                        ?>
                                        <li class="step <?php echo $stepThreeCompleted; ?> pointer" onclick="redirect('stepThree', '<?php echo $yojanaId ?>')" data-step="3a">
                                            <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                            <br>
                                            <span class="font"> Stage 3a</span>
                                            <br>
                                            <span class="text">(ESR)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        //
                                        //Step Four
                                        //
                                        if($stepFour == "Yes"){
                                            $stepFourCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);   
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                    					    if(mysqli_num_rows($query)>0){
                                                                $check_four = 0;
                                                                if($percentage < 100 ){
                                                                    $stepFourCompleted = "is-incomplete pointer";
                                                                }  
                    					    }else{
                    					        $stepFourCompleted = "";
                    					    }                                         
                                        ?>
                                        <li class="step <?php echo $stepFourCompleted; ?> pointer" onclick="redirect('stepFour', '<?php echo $yojanaId ?>')" data-step="3b">
                                             <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                             <br>
                                           <span class="font"> Stage 3b</span>
                                            <br>
                                            <span class="text">(Distribution)</span>
                                        </li>
                                        <?php 
                                        }
                                        
                                        
                                        //
                                        //Step Five
                                        //
                                        // if($stepFive == "Yes"){
                                            $query = mysqli_query($con,"SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);   
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                                        ?>
                                        <li class="step is-active" onclick="redirect('stepFive', '<?php echo $yojanaId ?>')" data-step="4">
                                             
                                            <p style="font-weight:bold;margin-bottom:5px;margin-top: 11px;"><?php echo $percentage ?>%</p>
                                           <span class="font"> Stage 4</span>
                                        </li>
                                        <?php 
                                        // }
                                        ?>
                                    </ol>
                                    <br>
                                    <h4 class="card-title">Trial Run</h4>
                                    <p class="card-description"></p>
                                    <form class="forms-sample" action="stepFive_db" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" value="<?php echo $yojanaId ?>" name="yojanaId">

                                        <!-- diameter depth year-->
                                        <div class="row align-items-center pb-3">
                                            <div class="col-6">
                                                <label for="diameter" class="font">Has the scheme been completed?</label>
                                            </div>
                                            <div class="col-6">
                                                <div class="can-toggle">
                                                    <?php 
                                                    if($yojanaComplete == "on"){
                                                        $checked = 'onclick="checkMe(this.checked);"';
                                                        $click =  "<script>document.getElementById('a').click();document.getElementById('divcheck').style.display = 'none';</script>";
                                                    } else {
                                                        $checked = '';
                                                    }
                                                    ?>
                                                    <input id="a" name="yojanaComplete" type="checkbox" onclick="checkMe(this.checked);percentageCal();" >
                                                    <label for="a">
                                                        <div class="can-toggle__switch" data-checked="Yes"
                                                            data-unchecked="No"></div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- upload photo-->
                                        <div class="row" style="align-items: end" >
                                            <div class="col-md-6" id="divcheck">
                                                <div class="form-group" >
                                                    <label> Reason for non-completion </label>
                                                    <input type="text" class="form-control" value="<?php echo $reason; ?>" id="reason" name="reason" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3" id="divcheck2">
                                                <div class="form-group">
                                                    <label id="dateOfCommissioning">Date of Commissioning</label>
                                                    <input type="date" class="form-control" value="<?php echo $dateOfCommissioning; ?>" id="dateOfCommissioning" name="dateOfCommissioning" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3" id="divcheck3">
                                                <div class="form-group">
                                                    <label id="dateOfHandingOver">Date of Handing Over</label>
                                                    <input type="date" class="form-control" value="<?php echo $dateOfHandingOver; ?>" id="dateOfHandingOver" name="dateOfHandingOver" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="align-items: end">
                                            
                                            <h4 class="card-title">Dates of TPI Visit </h4>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label id="datesOfTpiVisit1">1</label>
                                                    <input type="date" class="form-control" value="<?php echo $datesOfTpiVisit1; ?>" id="datesOfTpiVisit1" name="datesOfTpiVisit1" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label id="datesOfTpiVisit2">2</label>
                                                    <input type="date" class="form-control" id="datesOfTpiVisit2" value="<?php echo $datesOfTpiVisit2; ?>" name="datesOfTpiVisit2" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label id="datesOfTpiVisit3">3</label>
                                                    <input type="date" class="form-control" id="datesOfTpiVisit3"  value="<?php echo $datesOfTpiVisit3; ?>"name="datesOfTpiVisit3" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label id="dateOfCompletion">Date of completion</label>
                                                    <input type="date" class="form-control" id="dateOfCompletion" value="<?php echo $dateOfCompletion; ?>" name="dateOfCompletion" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-10">
                                                <div id="textboxDiv">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName"
                                                                    name="docName1" value="<?php echo $docName1 ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <input type="file" name="photo1"
                                                                    accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx"
                                                                    class="form-control" />
                                                                    <?php
                                                                    if($photo1){
                                                                    ?>
                                                                    Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo1 ?>"> <?php echo $photo1 ?> <i class="bi bi-arrow-right"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php 
                                                    if($docName2 != ""){
                                                        $document = 3;
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName"
                                                                    name="docName2" value="<?php echo $docName2 ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <input type="file" name="photo2"
                                                                    accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx"
                                                                    class="form-control" />
                                                                    <?php
                                                                    if($photo2){
                                                                    ?>
                                                                    Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo2 ?>"> <?php echo $photo2 ?> <i class="bi bi-arrow-right"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    if($docName3 != ""){
                                                        $document = 4;
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName"
                                                                    name="docName3" value="<?php echo $docName3 ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <input type="file" name="photo3"
                                                                    accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx"
                                                                    class="form-control" />
                                                                    <?php
                                                                    if($photo3){
                                                                    ?>
                                                                    Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo3 ?>"> <?php echo $photo3 ?> <i class="bi bi-arrow-right"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    if($docName4 != ""){
                                                        $document = 5;
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName"
                                                                    name="docName4" value="<?php echo $docName4 ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <input type="file" name="photo4"
                                                                    accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx"
                                                                    class="form-control" />
                                                                    <?php
                                                                    if($photo4){
                                                                    ?>
                                                                    Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo4 ?>"> <?php echo $photo4 ?> <i class="bi bi-arrow-right"></i></a>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <input type="hidden" value="">

                                            <div class="col-md-2">
                                                <div class="row" style="height:75px;">
                                                    <div class="col-6">
                                                        <div class="form-group ">
                                                            <button type="button" class="btn " id="add"
                                                                style="padding:0px;">
                                                                <i class="mdi mdi-plus-circle"
                                                                    style="font-size: 2.5rem;color: green;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group ">
                                                            <button type="button" class="btn " id="remove"
                                                                style="padding:0px;">
                                                                <i class="mdi mdi-minus-circle"
                                                                    style="font-size: 2.5rem;color: red;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     
                                     <div class="row">
                                            <div class="col-md-6">
                                                <?php 
                                                
                                                $q4 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
                                                if(mysqli_num_rows($q4) >0){
                                                    $msedbWork = "yes";
                                                
                                                if($exit == true){
                                                    $q2 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work'");
                                                    if(mysqli_num_rows($q2)>0){
                                                        $r2 = mysqli_fetch_assoc($q2);
                                                        $radio = '$("#delayMsedc'.$r2['delay'].'").click();';
                                                        if($r2['reason'] == "Other"){
                                                            $display = '';
                                                        } else {
                                                            $display = 'style="display:none"';
                                                        }
                                                    } else {
                                                        $radio = "";
                                                        $display = 'style="display:none"';
                                                    }
                                                } else {
                                                    $display = 'style="display:none"';
                                                }
                                                ?>
                                                
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4 class="card-title">MSEDC Work</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Delay : &nbsp;<span> &nbsp;<input type="radio" name="delayMsedc" value="Yes" id="delayMsedcYes" onclick="delayMsedcFun(this.value)"> &nbsp;<label for="delayMsedcYes">Yes</label></span><span> &nbsp;<input type="radio" name="delayMsedc" id="delayMsedcNo" value="No" onclick="delayMsedcFun(this.value)"> &nbsp;<label for="delayMsedcNo">No</label></span></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="reasonMsedcDiv" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="diameter">Reason</label>
                                                            <select class="js-example-basic-single" id="reasonMsedc" name="reasonMsedc" onchange="otherReasonMsedcFun(this.value)" style="width: 100%;">
                                                                <option selected="" disabled=""value=""></option>
                                                                <?php
                                                                $delay = 0;
                                                                $q = mysqli_query($con, "SELECT * FROM delayReasons");
                                                                while($r = mysqli_fetch_assoc($q)){
                                                                    if($r['reasons'] == $r2['reason']){
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                        $delay++;
                                                                    }
                                                                ?>
                                                                <option <?php echo $selected ?>><?php echo $r['reasons'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="otherReasonMsedcDiv" <?php echo $display; ?>>
                                                        <div class="form-group">
                                                            <label for="">Other Reason</label>     
                                                            <input type="text" class="form-control" id="otherReasonMsedc" value="<?php echo $r2['otherReason'] ?>" name="otherReasonMsedc" style="height:20px;"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="delayDocumentMsedc" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
                                                            <?php 
                                                            if($r1['document']){
                                                            ?>
                                                            Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r1['document'] ?>"> <?php echo $r1['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="checkboxMsedcDiv" style="display:none">
                                                    <?php
                                                    
                                                    $query = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE subWork = 'MSEDC Work'");
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        $i = $result['id'];
                                                        if($exit == true){
                                                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$i' AND yojanaId = '$yojanaId'");
                                                            $r1 = mysqli_fetch_assoc($q1);
                                                            if(mysqli_num_rows($q1)>0){
                                                                $check = '$("#Msedc'.$i.'").click();';
                                                            } else {
                                                                $check = "";
                                                            }
                                                            if($r1['reason'] == "Other"){
                                                                $show = "style='display:block'";
                                                            } else {
                                                                $show = "style='display:none'";
                                                            }
                                                        }else {
                                                                $show = "style='display:none'";
                                                        }
                                                        $per = $result['percentage'];
                                                    ?>
                                                
                                                    <div class="col-md-12">
                                                        <p style="display:flex"><span><input type="checkbox" onclick="percentageCal()" class="percentage" data-per="<?php echo $per; ?>" id="Msedc<?php echo $i ?>" name="msedcSchedule[]" value="<?php echo $i ?>"></span>&nbsp; <label for="Msedc<?php echo $i ?>"><?php echo $result['schedule']." (".$per."%)" ?></label></p>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentMsedc[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
                                                            <?php 
                                                            if($r1['document']){
                                                            ?>
                                                            Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r1['document'] ?>"> <?php echo $r1['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                        

                                                
                                                    <script>
                                                        <?php
                                                        if($exit == true){
                                                            // echo '$("#delayMsedc'.$r1['delay'].$i.'").click();';
                                                            echo $check;
                                                        }
                                                        ?>
                                                    </script>
                                                    <hr>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <script>
                                                    
                                                    <?php
                                                    echo $radio;
                                                    ?>
                                                    function delayMsedcFun(val){
                                                        if(val == "Yes"){
                                                            $("#reasonMsedcDiv").show();
                                                            $("#checkboxMsedcDiv").hide();
                                                        } else {
                                                            $("#checkboxMsedcDiv").show();
                                                            $("#reasonMsedcDiv").hide();
                                                        }
                                                    }
                                                    function otherReasonMsedcFun(val){
                                                        if(val == "Other"){
                                                            $("#otherReasonMsedcDiv").show();
                                                            $("#otherReasonMsedc").val('');
                                                        } else {
                                                            $("#otherReasonMsedcDiv").hide();
                                                            $("#otherReasonMsedc").val(val);
                                                        }
                                                    }
                                                </script>
                                                
                                                <?php 
                                                }
                                                ?>
                                            </div>
                                            
                                            
                                        </div>
                                     
                                        <div class="form-group">
                                            <label for="range">Work completion in percentage</label>
                                            <div class="range-slider">
                                                <input type="range" disabled="" value="<?php echo $completionPercentage ?>" min="<?php echo 0;//$stepOnePrecentage ?>" max="100" id="completionPercentage">
                                                <input type="hidden" value="<?php echo $completionPercentage ?>" min="<?php echo 0;//$stepOnePrecentage ?>" max="100" id="completionPercentageText" name="completionPercentage">
                                                <span class="range-value" id="completionPercentage2"><?php echo $completionPercentage."%" ?></span>
                                            </div>
                                        </div>
                                        <!-- -->
                                        
                                        <div class="form-group">
                                            <label for="video_link">Upload Video Link</label>
                                            <input type="url" class="form-control" id="video_link" name="video_link" value="<?php echo $video_link ?>" placeholder="Video Link" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="remark">Handing over note </label>
                                            <input type="text" class="form-control" id="remark" value="<?php echo $remark ?>" name="remark" />
                                        </div>

                                        <button type="submit" class="btn btn-primary me-2" name="submit"> Submit </button>
                                    </form>
                                </div>
                            </div>
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
    <!-- End custom js for this page -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
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
    echo $click;
    ?>
    
    <script>
        function percentageCal(){
            <?php 
            if($msedbWork == "yes"){
            ?>
            var per = 0;
            var arr = $('.percentage').map(function () {
                if(this.checked){
                    per = per + Number($(this).data('per'));
                }
                // console.log($(this).data('per'));
            }).get();
            totalPer = per;
            totalPer = totalPer.toFixed(0);
            console.log(totalPer);
            <?php 
            } else {
            ?>
            if($("#a").is(':checked')){
                totalPer = 100;
            } else {
                totalPer = 0;
            }
            <?php
            }
            ?>
            $("#completionPercentage").val(totalPer);
            $("#completionPercentageText").val(totalPer);
            $("#completionPercentage2").html(totalPer+" %");
        }
    </script>
    <script type="text/javascript">
        <?php 
        echo $readonly;
        ?>
    
        function checkMe(selected) {
            if (selected) {
                document.getElementById("divcheck").style.display = "none";
                document.getElementById("divcheck3").style.display = "block";
                document.getElementById("divcheck2").style.display = "block";
            }
            else {
                document.getElementById("divcheck").style.display = "";
                document.getElementById("divcheck3").style.display = "none";
                document.getElementById("divcheck2").style.display = "none";

            }

        }
        
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location+"?yojanaId="+yojanaId;   
            }
        }

        $(document).ready(function () {
            var rangeSlider = function () {
                var slider = $('.range-slider'),
                    range = $('.range-slider input[type="range"]'),
                    value = $('.range-value');

                slider.each(function () {
                    value.each(function () {
                        var value = $(this).prev().attr('value');
                        var v = value + "%";
                        $(this).html(v);
                    });
                    range.on('input', function () {


                        var val = this.value + "%";
                        $(this).next(value).html(val);

                    });
                });
            };
            rangeSlider();
        });

        var count = <?php echo $document; ?>;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var type = $('#element').val();

                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>Document Name </label><input type='text' onkeyup='referred()' class='form-control' required name='docName"+count+"' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='photo"+count+"' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div>");
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