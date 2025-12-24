<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
$delayReason = 10;
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
    
    <title>Step Two - Pump & Rising Main</title>
    
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
            top: 37%;
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

        .steps>.step.is-active:before {
            color: #FFF;
            border: 2px solid #0033c4;
            background: #0033c4;
            /*margin-bottom: -4.9rem;*/
        }

        .steps {
            margin-top: 3em;
        }
        
        .hide{
            display: none;
        }
        .center {
            text-align: center;
        }
        ul li, ol li, dl li {
            line-height: 1.3;
        }
        .pointer {
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
                 font-size: 10px;
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
        select[readonly].select2-hidden-accessible + .select2-container {
            pointer-events: none;
            touch-action: none;
            .select2-selection {
                background: #eee;
                box-shadow: none;
            }
            
            .select2-selection, .select2-selection--single{
                background-color: #e9ecef;
            }
            .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
                display: none;
            }
        }
    </style>
    
    <?php 
    $yojanaId = $_GET['yojanaId'];
    $totalSub = 0;
    $q1 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
    if(mysqli_num_rows($q1)>0){
        $totalSub = $totalSub + 100; 
    }
    $q1 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
    if(mysqli_num_rows($q1)>0){
        $totalSub = $totalSub + 100; 
    }
    $q1 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main'");
    if(mysqli_num_rows($q1)>0){
        $totalSub = $totalSub + 100; 
    }
    ?>
    
    <script>
        function percentageCal(){
            var per = 0;
            var arr = $('.percentage').map(function () {
                if(this.checked){
                    per = per + Number($(this).data('per'));
                }
                // console.log($(this).data('per'));
            }).get();
            totalPer = (per/<?php echo $totalSub ?>) * 100;
            totalPer = totalPer.toFixed(0);
            console.log(totalPer);
            $("#completionPercentage").val(totalPer);
            $("#completionPercentageText").val(totalPer);
            $("#completionPercentage2").html(totalPer+" %");
        }
    </script>

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
        
        $query = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'");
        
        if(mysqli_num_rows($query) > 0){
            $result = mysqli_fetch_assoc($query);
            $pumpNumber = $result['pumpNumber'];
            $power = $result['power'];
            $installationYear = $result['installationYear'];
            $pumpingHours = $result['pumpingHours'];
            $pumpHouse = $result['pumpHouse'];
            $diameter = $result['diameter'];
            $length = $result['length'];
            $material = $result['material'];
            $photo1 = $result['photo1'];
            $photo2 = $result['photo2'];
            $docName3 = $result['docName3'];
            $photo3 = $result['photo3'];
            $docName4 = $result['docName4'];
            $photo4 = $result['photo4'];
            $typeOfStructure = $result['typeOfStructure'];
            $completionPercentage = $result['completionPercentage'];
            $video_link  = $result['video_link'];
            $remark = $result['remarks'];
            $exit = true;
        } else {
            $exit = false;
            $completionPercentage = 0;
            $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId' ORDER BY id DESC ");
            $r3 = mysqli_fetch_assoc($q3);
            $diameter = $r3['diameter'];
            $material = $r3['typePipe'];
            $length = $r3['length'];
            
            $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId' ORDER BY id DESC ");
            $r3 = mysqli_fetch_assoc($q3);
            $power = $r3['bhp'];
            
        }
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
                                        
                                        if($stepTwo == "Yes"){
                                            $query = mysqli_query($con,"SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query); 
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                                        ?>
                                        <li class="step is-active pointer" onclick="redirect('stepTwo', '<?php echo $yojanaId ?>')" data-step="2">
                                            <p style="font-weight:bold;margin-bottom:5px;margin-top: 11px;"><?php echo $percentage ?>%</p>
                                            
                                           <span class="font">Stage 2</span> 
                                           
                                        </li>
                                        <?php
                                        }
                                        
                                        if($stepThree){
                                            $stepThreeCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);                                         
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                    					    if(mysqli_num_rows($query)>0){
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
                                            <span class="font">Stage 3b</span>
                                            <br>
                                            <span class="text">(Distribution)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        if($stepFive == "Yes"){
                                            $stepFiveCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query); 
                                            if($result['completionPercentage'] == 0 ){
                                               $percentage = 0; 
                                            } else {
                                                $percentage = $result['completionPercentage'];
                                            }
                    					    if(mysqli_num_rows($query)>0){
                                                if($percentage < 100 ){
                                                    $stepFiveCompleted = "is-incomplete pointer";
                                                }
                    					    }else{
                    					        $stepFiveCompleted = "";
                    					    }                                        
                                        ?>
                                        <li class="step <?php echo $stepFiveCompleted; ?> pointer" onclick="redirect('stepFive', '<?php echo $yojanaId ?>')" data-step="4">
                                            <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                            <br>
                                            <span class="font">Stage 4</span>
                                        <br>
                                            <span class="text">(Trial Run)</span>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ol>
                                    
                                    <br>
                                    
                                    <p class="card-description"></p>
                                    <form class="forms-sample" action="stepTwo_db" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" value="<?php echo $yojanaId ?>" name="yojanaId">
                                        <!-- diameter depth year-->
                                        <div class="row">
                                            <?php
                                            $i2 = 1;
                                            $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId' ");
                                            if(mysqli_num_rows($q3) >0 ){
                                            ?>
                                            <h4 class="card-title">Pump </h4>
                                            <?php
                                            }
                                            while($r3 = mysqli_fetch_assoc($q3)){
                                                $power = $r3['bhp'];
                                                if(!empty($power)){
                                                    $readonly2 = "readonly";
                                                }
                                                $subWorkId = $r3['id'];
                                                $q4 = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'");
                                                $r4 = mysqli_fetch_assoc($q4);
                                                $pumpNumber = $r4['pumpNumber'];
                                                $pumpHouse = $r4['pumpHouse'];
                                                $pumpingHours = $r4['pumpingHours'];
                                            ?>
                                            <input type="hidden" value="<?php echo $subWorkId ?>" name="subWorkId[]">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="pumpNumber<?php echo $i ?>">No. of Pump</label>
                                                    <input type="tel" class="form-control" id="pumpNumber<?php echo $i ?>"  onkeypress="isInputNumber(event)" value="<?php echo $pumpNumber ?>" name="pumpNumber<?php echo $subWorkId ?>" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="power<?php echo $i ?>">Power in HP</label>
                                                    <!--<input type="tel" class="form-control" id="power" onkeypress="isInputNumber(event)" name="power" value="<?php echo $power ?>" placeholder="" />-->
                                                    <input type="number" step="0.01" class="form-control" id="power<?php echo $i ?>" <?php echo $readonly2 ?> name="power<?php echo $subWorkId ?>" value="<?php echo $power ?>" placeholder="" />
                                                </div>
                                            </div>
                                                 <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="pumpHouse<?php echo $i ?>">Discharge (In Lph)</label>
                                                    <!--<input type="tel" class="form-control" onkeypress="isInputNumber(event)" id="pumpingHours" value="<?php echo $pumpingHours ?>" name="pumpingHours" placeholder="" />-->
                                                    <input type="number" step="0.01" class="form-control" id="pumpHouse<?php echo $i ?>" value="<?php echo $pumpHouse ?>" name="pumpHouse<?php echo $subWorkId ?>" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="pumpingHours<?php echo $i ?>">Pump Hours</label>
                                                    <input type="text" class="form-control" id="pumpingHours<?php echo $i ?>" name="pumpingHours<?php echo $subWorkId ?>" value="<?php echo $pumpingHours ?>" placeholder="" />
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                            <!--<div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="installationYear">Installation Year</label>
                                                    <select class="js-example-basic-single" id="installationYear"  name="installationYear" style="width: 100%;">
                                                        <?php
                                                        $currentYear = date('Y');
                                                        for($i=$currentYear;$i>=2000;$i--){
                                                            if($installationYear == $i){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option <?php echo $selected ?>><?php echo $i; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <input type="date" class="form-control" id="installationYear" value="<?php echo $installationYear ?>" name="installationYear" placeholder="" />
                                                </div>
                                            </div>-->

                                       
                                            
                                            <?php
                                            $i2 = 1;
                                            $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId' ORDER BY id DESC ");
                                            if(mysqli_num_rows($q3) >0 ){
                                            ?>
                                            <h4 class="card-title">Rising Main </h4>
                                            <?php
                                            }
                                            while($r3 = mysqli_fetch_assoc($q3)){
                                                $subWorkId = $r3['id'];
                                                $diameter = $r3['diameter'];
                                                if(!empty($diameter)){
                                                    $readonlyDia = "readonly";
                                                }
                                                $material = $r3['typePipe'];
                                                if(!empty($material)){
                                                    $readonlyMaterial = "readonly";
                                                }
                                                $length = $r3['length'];
                                                if(!empty($length)){
                                                    $readonlyLength = "readonly";
                                                }
                                                $readonly2 = "readonly";
                                                
                                            ?>
                                            <input type="hidden" value="<?php echo $subWorkId ?>" name="subWorkId[]">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="diameter<?php echo $subWorkId ?>">Dia (In MM)</label>
                                                    <!--<input type="tel" onkeypress="isInputNumber(event)" class="form-control" id="diameter" name="diameter" value="<?php echo $diameter ?>" placeholder="" />-->
                                                    <input type="number" step="0.01" class="form-control" <?php echo $readonlyDia ?> id="diameter<?php echo $subWorkId ?>" name="diameter<?php echo $subWorkId ?>" value="<?php echo $diameter ?>" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="length<?php echo $subWorkId ?>">Length (In M)</label>
                                                    <!--<input type="tel" onkeypress="isInputNumber(event)" class="form-control" id="length" value="<?php echo $length ?>" name="length" placeholder="" />-->
                                                    <input type="number" step="0.01" class="form-control" <?php echo $readonlyLength ?> id="length<?php echo $subWorkId ?>" value="<?php echo $length ?>" name="length<?php echo $subWorkId ?>" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="material<?php echo $subWorkId ?>">Material</label>
                                                    <?php 
                                                    $materialArray = array('PVC','HDPE', 'GI', 'DI');
                                                    ?>
                                                    <select class="js-example-basic-single" id="material<?php echo $subWorkId ?>" <?php echo $readonlyMaterial ?>  name="material<?php echo $subWorkId ?>" style="width: 100%;">
                                                        <option>
                                                        </option>
                                                        <?php 
                                                        foreach ($materialArray as $materials){
                                                            if($materials == $material){
                                                                $selected =  "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option <?php echo $selected ?>><?php echo $materials ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <!--<input type="text" class="form-control" id="material" value="<?php echo $material ?>" name="material" placeholder="" />-->
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <!-- -->


                                        <!-- upload photo-->
                                        <div class="row" style="align-items: end">
                                            <div class="col-md-10">
                                                <div id="textboxDiv">
                                                    <!--<div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName" value="Warranty Card" name="docName[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <input type="file" name="document[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />
                                                                <?php
                                                                if($photo1){
                                                                ?>
                                                                <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo2 ?>">View File</a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude1" name="longitude[]">
                                                                <input type="hidden" id="latitude1" name="latitude[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName" value="SGS Report" name="docName[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <input type="file" name="document[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />
                                                                <?php
                                                                if($photo2){
                                                                ?>
                                                                <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo2 ?>">View File</a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude1" name="longitude[]">
                                                                <input type="hidden" id="latitude1" name="latitude[]">
                                                            </div>
                                                        </div>
                                                    </div>-->
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 hide">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName" value="Warranty Card" name="docName[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Warranty Card</label>
                                                                <input type="file" name="photo1" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />
                                                                <?php
                                                                if($photo1){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo1 ?>"> <?php echo $photo1 ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude1" name="longitude[]">
                                                                <input type="hidden" id="latitude1" name="latitude[]">
                                                            </div>
                                                        </div>
                                                    
                                                        <div class="col-md-6 hide">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName" value="Third Party" name="docName[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Third Party</label>
                                                                <input type="file" name="photo2" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />
                                                                <?php
                                                                if($photo2){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo2 ?>"> <?php echo $photo2 ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude1" name="longitude[]">
                                                                <input type="hidden" id="latitude1" name="latitude[]">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <?php
                                                        if(isset($photo3)){
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName" value="<?php echo $docName3  ?>" name="docName3">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Upload File </label>
                                                                <input type="file" name="photo3" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />
                                                                <?php
                                                                if($photo3){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo3 ?>"> <?php echo $photo3 ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude1" name="longitude[]">
                                                                <input type="hidden" id="latitude1" name="latitude[]">
                                                            </div>
                                                        </div>
                                                        <?php 
                                                        }
                                                        
                                                        if(!empty($photo4)){
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName" value="<?php echo $docName4  ?>" name="docName4">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Upload File </label>
                                                                <input type="file" name="photo4" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />
                                                                <?php
                                                                if($photo3){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo4 ?>"> <?php echo $photo4 ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude1" name="longitude[]">
                                                                <input type="hidden" id="latitude1" name="latitude[]">
                                                            </div>
                                                        </div>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </div>
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
                                                
                                                $q4 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                                                if(mysqli_num_rows($q4) >0){
                                                
                                                if($exit == true){
                                                    $q2 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room'");
                                                    if(mysqli_num_rows($q2)>0){
                                                        $r2 = mysqli_fetch_assoc($q2);
                                                        $radio = '$("#delaySwitch'.$r2['delay'].'").click();';
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
                                                        <h4 class="card-title">Switch Room</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Delay : &nbsp;<span> &nbsp;<input type="radio" name="delaySwitch" value="Yes" id="delaySwitchYes" onclick="delaySwitchFun(this.value)"> &nbsp;<label for="delaySwitchYes">Yes</label></span><span> &nbsp;<input type="radio" name="delaySwitch" id="delaySwitchNo" value="No" onclick="delaySwitchFun(this.value)"> &nbsp;<label for="delaySwitchNo">No</label></span></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="reasonSwitchDiv" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="diameter">Reason</label>
                                                            <select class="js-example-basic-single" id="reasonSwitch" name="reasonSwitch" onchange="otherReasonSwitchFun(this.value)" style="width: 100%;">
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
                                                    
                                                    <div class="col-md-6" id="otherReasonSwitchDiv" <?php echo $display; ?>>
                                                        <div class="form-group">
                                                            <label for="">Other Reason</label>     
                                                            <input type="text" class="form-control" id="otherReasonSwitch" value="<?php echo $r2['otherReason'] ?>" name="otherReasonSwitch" style="height:20px;"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="delayDocumentSwitch" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
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
                                                
                                                <div class="row" id="checkboxSwitchDiv" style="display:none">
                                                    <?php
                                                    
                                                    $query = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE subWork = 'Switch Room'");
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        $i = $result['id'];
                                                        if($exit == true){
                                                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$i' AND yojanaId = '$yojanaId'");
                                                            $r1 = mysqli_fetch_assoc($q1);
                                                            if(mysqli_num_rows($q1)>0){
                                                                $check = '$("#Switch'.$i.'").click();';
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
                                                
                                                    <div class="col-md-8">
                                                        <p style="display:flex"><span><input type="checkbox" onclick="percentageCal()" class="percentage" data-per="<?php echo $per; ?>" id="Switch<?php echo $i ?>" name="switchRoomSchedule[]" value="<?php echo $i ?>"></span>&nbsp; <label for="Switch<?php echo $i ?>"><?php echo $result['schedule']." (".$per."%)" ?></label></p>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentSwitch[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
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
                                                            // echo '$("#delaySwitch'.$r1['delay'].$i.'").click();';
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
                                                    function delaySwitchFun(val){
                                                        if(val == "Yes"){
                                                            $("#reasonSwitchDiv").show();
                                                            $("#checkboxSwitchDiv").hide();
                                                            var arr = $('.percentage').map(function () {
                                                                console.log(this.getAttribute('name'));
                                                                if(this.getAttribute('name') == 'switchRoomSchedule[]'){
                                                                    if(this.checked){
                                                                        this.click();
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            $("#checkboxSwitchDiv").show();
                                                            $("#reasonSwitchDiv").hide();
                                                        }
                                                    }
                                                    function otherReasonSwitchFun(val){
                                                        if(val == "Other"){
                                                            $("#otherReasonSwitchDiv").show();
                                                            $("#otherReasonSwitch").val('');
                                                        } else {
                                                            $("#otherReasonSwitchDiv").hide();
                                                            $("#otherReasonSwitch").val(val);
                                                        }
                                                    }
                                                </script>
                                                
                                                <?php 
                                                }
                                                ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?php 
                                                
                                                $q4 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
                                                if(mysqli_num_rows($q4) >0){
                                                
                                                if($exit == true){
                                                    $q2 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery'");
                                                    if(mysqli_num_rows($q2)>0){
                                                        $r2 = mysqli_fetch_assoc($q2);
                                                        $radio = '$("#delayPumping'.$r2['delay'].'").click();';
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
                                                        <h4 class="card-title">Pumping Machinery</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Delay : &nbsp;<span> &nbsp;<input type="radio" name="delayPumping" value="Yes" id="delayPumpingYes" onclick="delayPumpingFun(this.value)"> &nbsp;<label for="delayPumpingYes">Yes</label></span><span> &nbsp;<input type="radio" name="delayPumping" id="delayPumpingNo" value="No" onclick="delayPumpingFun(this.value)"> &nbsp;<label for="delayPumpingNo">No</label></span></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="reasonPumpingDiv" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="diameter">Reason</label>
                                                            <select class="js-example-basic-single" id="reasonPumping" name="reasonPumping" onchange="otherReasonPumpingFun(this.value)" style="width: 100%;">
                                                                <option selected="" disabled=""value=""></option>
                                                                <?php
                                                                $delay = 0;
                                                                $q = mysqli_query($con, "SELECT * FROM delayReasons");
                                                                while($r = mysqli_fetch_assoc($q)){
                                                                    if($r['reasons'] == $r2['reason']){
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                                <option <?php echo $selected ?>><?php echo $r['reasons'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="otherReasonPumpingDiv" <?php echo $display ?>>
                                                        <div class="form-group">
                                                            <label for="">Other Reason</label>     
                                                            <input type="text" class="form-control" id="otherReasonPumping" value="<?php echo $r2['otherReason'] ?>" name="otherReasonPumping" style="height:20px;"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="delayDocumentPumping" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
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
                                                
                                                <div class="row" id="checkboxPumpingDiv" style="display:none">
                                                    <?php
                                                    
                                                    $query = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE subWork = 'Pumping Machinery'");
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        $i = $result['id'];
                                                        if($exit == true){
                                                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$i' AND yojanaId = '$yojanaId'");
                                                            $r1 = mysqli_fetch_assoc($q1);
                                                            if(mysqli_num_rows($q1)>0){
                                                                $check = '$("#Pumping'.$i.'").click();';
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
                                                        <p style="display:flex"><span><input type="checkbox" id="Pumping<?php echo $i ?>" onclick="percentageCal()" class="percentage" data-per="<?php echo $per; ?>" name="pumpingMachinerySchedule[]" value="<?php echo $i ?>"></span>&nbsp; <label for="Pumping<?php echo $i ?>"><?php echo $result['schedule']." (".$per."%)" ?></label></p>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentPumping[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
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
                                                            // echo '$("#delayPumping'.$r1['delay'].$i.'").click();';
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
                                                    function delayPumpingFun(val){
                                                        if(val == "Yes"){
                                                            $("#reasonPumpingDiv").show();
                                                            $("#checkboxPumpingDiv").hide();
                                                            var arr = $('.percentage').map(function () {
                                                                console.log(this.getAttribute('name'));
                                                                if(this.getAttribute('name') == 'pumpingMachinerySchedule[]'){
                                                                    if(this.checked){
                                                                        this.click();
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            $("#checkboxPumpingDiv").show();
                                                            $("#reasonPumpingDiv").hide();
                                                        }
                                                    }
                                                    function otherReasonPumpingFun(val){
                                                        if(val == "Other"){
                                                            $("#otherReasonPumpingDiv").show();
                                                            $("#otherReasonPumping").val('');
                                                        } else {
                                                            $("#otherReasonPumpingDiv").hide();
                                                            $("#otherReasonPumping").val(val);
                                                        }
                                                    }
                                                </script>
                                                
                                                <?php 
                                                }
                                                
                                                $q4 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Rising main'");
                                                if(mysqli_num_rows($q4) >0){
                                                
                                                if($exit == true){
                                                    $q2 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Rising main'");
                                                    if(mysqli_num_rows($q2)>0){
                                                        $r2 = mysqli_fetch_assoc($q2);
                                                        $radio = '$("#delayRising'.$r2['delay'].'").click();';
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
                                                        <h4 class="card-title">Rising main</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Delay : &nbsp;<span> &nbsp;<input type="radio" name="delayRising" value="Yes" id="delayRisingYes" onclick="delayRisingFun(this.value)"> &nbsp;<label for="delayRisingYes">Yes</label></span><span> &nbsp;<input type="radio" name="delayRising" id="delayRisingNo" value="No" onclick="delayRisingFun(this.value)"> &nbsp;<label for="delayRisingNo">No</label></span></p>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="row" id="reasonRisingDiv" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="diameter">Reason</label>
                                                            <select class="js-example-basic-single" id="reasonRising" name="reasonRising" onchange="otherReasonRisingFun(this.value)" style="width: 100%;">
                                                                <option selected="" disabled=""value=""></option>
                                                                <?php
                                                                $q = 0;
                                                                $q = mysqli_query($con, "SELECT * FROM delayReasons");
                                                                while($r = mysqli_fetch_assoc($q)){
                                                                    if($r['reasons'] == $r2['reason']){
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                        $delay++;
                                                                    }
                                                                ?>
                                                                <option <?php echo $selected." ".$selected2 ?>><?php echo $r['reasons'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="otherReasonRisingDiv" <?php echo $display ?>>
                                                        <div class="form-group">
                                                            <label for="">Other Reason</label>     
                                                            <input type="text" class="form-control" id="otherReasonRising" value="<?php echo $r2['otherReason'] ?>" name="otherReasonRising" style="height:20px;"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentRising" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
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
                                                
                                                
                                                <div class="row" id="checkboxRisingDiv" style="display:none">
                                                    <?php
                                                    
                                                    $query = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE subWork = 'Rising main'");
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        $i = $result['id'];
                                                        if($exit == true){
                                                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$i' AND yojanaId = '$yojanaId'");
                                                            $r1 = mysqli_fetch_assoc($q1);
                                                            if(mysqli_num_rows($q1)>0){
                                                                $check = '$("#Rising'.$i.'").click();';
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
                                                        <p style="display:flex"><span><input type="checkbox" id="Rising<?php echo $i ?>" onclick="percentageCal()" class="percentage" data-per="<?php echo $per; ?>" name="risingMainSchedule[]" value="<?php echo $i ?>"></span>&nbsp; <label for="Rising<?php echo $i ?>"><?php echo $result['schedule']." (".$per."%)" ?></label></p>
                                                    </div> 
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentRising[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
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
                                                            echo '$("#delayRising'.$r2['delay'].$i.'").click();';
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
                                                    function delayRisingFun(val){
                                                        if(val == "Yes"){
                                                            $("#reasonRisingDiv").show();
                                                            $("#checkboxRisingDiv").hide();
                                                            var arr = $('.percentage').map(function () {
                                                                console.log(this.getAttribute('name'));
                                                                if(this.getAttribute('name') == 'risingMainSchedule[]'){
                                                                    if(this.checked){
                                                                        this.click();
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            $("#checkboxRisingDiv").show();
                                                            $("#reasonRisingDiv").hide();
                                                        }
                                                    }
                                                    function otherReasonRisingFun(val){
                                                        if(val == "Other"){
                                                            $("#otherReasonRisingDiv").show();
                                                            $("#otherReasonRising").val('');
                                                        } else {
                                                            $("#otherReasonRisingDiv").hide();
                                                            $("#otherReasonRising").val(val);
                                                        }
                                                    }
                                                </script>
                                            <?php 
                                                }
                                            ?>
                                            </div>
                                        </div>
                                        <!-- -->
                                        
                                        <!-- percentage of work-->
                                        <div class="form-group">
                                            <label for="completionPercentage">Work completion in percentage</label>
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
                                            <label for="remark">Remark </label>
                                            <input type="text" class="form-control" id="remark" value="<?php echo $remark ?>" name="remark" placeholder="Remark" />
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

    <script type="text/javascript">
        <?php 
        echo $readonly;
        ?>
        function isInputNumber(evt) {
            var ch = String.fromCharCode(evt.which);
            if (!(/[0-9]/.test(ch))) {
                evt.preventDefault();
                if (!$('#mobile').val().match('[0-9]{10}')) {
                    alert("Enter Valid Mobile Number...");
                    return;
                }
            }
        }
        
        <?php 
        if($_SESSION['designation'] != "sectionEng"){
            if(isset($_GET['back'])){
                $page = "acceptExtension"; 
                $back = '+"&back=acceptExtension"';
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
        
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location+"?yojanaId="+yojanaId<?php echo $back ?>;   
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


    </script>


    <script>
        var count = 3;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var type = $('#element').val();
                // $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>Document Name </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='img[]' class='file-upload-default' /><div class='input-group col-xs-12'><input type='text' class='form-control file-upload-info' disabled placeholder='Upload Image' /><span class='input-group-append'> <button class='file-upload-browse btn btn-primary' type='button'> Upload </button></span></div></div></div>");
                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label for='docName"+count+"'>Document Name </label><input type='text' onkeyup='referred()' class='form-control' required name='docName[]' id='docName"+count+"' data-id='"+count+"'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='photo"+count+"' accept='.jpeg,.jpg,.png' class='form-control document' /> <input type='hidden' id='longitude"+count+"' name='longitude[]'> <input type='hidden' id='latitude"+count+"' name='latitude[]'> </div></div></div>");
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
            if (count > 3) {
                $("#textboxDiv").children().last().remove();
                count = count - 1;
                count2 = count - 1;
                // document.getElementById("total_member").value = count2;
                $("#add").show();
                if (count == 3) {
                    $("#remove").hide();
                }
            } else {
                $("#remove").hide();
            }
        });
        
        $(".document").on("change", function(){
            var id = $(this).data("id");
            var x = document.getElementById("latitude"+id);
            var y = document.getElementById("longitude"+id);
            console.log(x.innerHTML+" "+y.innerHTML);
            // getLocation();
        })
        
        $("#taluka").on("change", function () {
            var taluka = $(this).val();
            var village = $("#village");
            console.log(village.html());
            village.html("कृपया वाट पहा");
            $.ajax({
                type: 'POST',
                url: 'villagesAjax',
                data: { taluka: taluka },
                success: function (data) {
                    village.html(data);
                }
            })
        })

        /*$(function () {
            $('#datepicker').datepicker();
        });*/
        
        
        

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            x.value = position.coords.latitude;
            y.value = position.coords.longitude;
        }

        // we need to turn degree, min, sec format into decimal
        function DMS2DD(degrees, minutes, seconds, direction) {
            var dd = degrees + (minutes / 60) + (seconds / 3600);
            if (direction == "S" || direction == "W") {
                dd = dd * -1;
            }
            return dd;
        }
    </script>


</body>

</html>