<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    exit;
}
require_once('include/con.php');
$delayReason = 9;
function isMobileDevice(): bool {
    $userAgent = $_SERVER["HTTP_USER_AGENT"] ?? '';
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $userAgent);
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

$yojanaId = $_GET['yojanaId'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--  meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <title>Step One - Source</title>
    
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
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
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
            border-bottom: 7px transparent;
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
        .pointer{
            cursor: pointer;
        }
        ul li, ol li, dl li {
            line-height: 1.3;
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
        
    </style>
    
    <?php 
    $totalSub = 0;
    $q1 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
    if(mysqli_num_rows($q1)>0){
        $totalSub = $totalSub + 100; 
    }
    $q1 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
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
            }).get();
            totalPer = (per/<?php echo $totalSub; ?>) * 100;
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
        $q = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
        $r = mysqli_fetch_assoc($q) ?? [];
        $yojanaName = $r['yojanaName'] ?? '';
        $stepOne = $r['stepOne'] ?? '';
        $stepTwo = $r['stepTwo'] ?? '';
        $stepThree = $r['stepThree'] ?? '';
        $stepFour = $r['stepFour'] ?? '';
        $stepFive = $r['stepFive'] ?? '';
        $query = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'");
        
        // Initialize all variables with default values
        $diameter = '';
        $typeOfSource = '';
        $depth = '';
        $yearOfConstruction = '';
        $photo1 = '';
        $photo2 = '';
        $photo3 = '';
        $typeOfStructure = '';
        $completionPercentage = 0;
        $video_link = '';
        $remark = '';
        $exit = false;
        
        if(mysqli_num_rows($query) > 0){
            $result = mysqli_fetch_assoc($query) ?? [];
            $diameter = $result['diameter'] ?? '';
            $typeOfSource = $result['typeOfSource'] ?? '';
            $depth = $result['depth'] ?? '';
            $yearOfConstruction = $result['yearOfConstruction'] ?? '';
            $photo1 = $result['photo1'] ?? '';
            $photo2 = $result['photo2'] ?? '';
            $photo3 = $result['photo3'] ?? '';
            $typeOfStructure = $result['typeOfStructure'] ?? '';
            $completionPercentage = $result['completionPercentage'] ?? 0;
            $video_link = $result['video_link'] ?? '';
            $remark = $result['remark'] ?? '';
            $exit = true;
        } else {
            $exit = false;
            $completionPercentage = 0;
            $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId' ");
            $r3 = mysqli_fetch_assoc($q3) ?? [];
            $diameter = $r3['diameter'] ?? '';
            $depth = $r3['depth'] ?? '';
            $q3 = mysqli_query($con, "SELECT * FROM uploadDoc WHERE docName = 'Source Certificate' AND yojanaId = '$yojanaId' AND document !='' ");
            $r3 = mysqli_fetch_assoc($q3) ?? [];
            $photo2 = $r3['document'] ?? '';
        }
        
        if(!empty($diameter)){
            $readonlyDia = "readonly";
        } else {
            $readonlyDia = "";
        }
        if(!empty($depth)){
            $readonlyDepth = "readonly";
        } else {
            $readonlyDepth = "";
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
                                    if(($_SESSION['designation'] ?? '') != "sectionEng"){
                                        if(isset($_GET['back'])){
                                            $page = "acceptExtension";    
                                        } else {
                                            $page = "financeReportAdmin?yojanaId=" . $yojanaId;
                                        }
                                        $readonly = "$('.forms-sample input').attr('disabled', 'disabled');
                                                    $('.forms-sample select').attr('disabled', 'disabled');
                                                    $('.forms-sample button').attr('disabled', 'disabled');";
                                    } else {
                                        $page = "home";
                                        $readonly = "";
                                    }
                                    ?>
                                    <a href="<?php echo $page; ?>" style="float: left;margin-bottom:3rem"><button type="button" class="btn btn-primary me-2">Back</button></a>
                                    <h4 class="card-title center"><?php echo htmlspecialchars($yojanaName) . " (" . htmlspecialchars($yojanaId) . ")" ?></h4>
                                    <ol class="steps">
                                        <?php 
                                        if($stepOne == "Yes"){
                                            $query = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query) ?? []; 
                                            $percentage = ($result['completionPercentage'] ?? 0) == 0 ? 0 : ($result['completionPercentage'] ?? 0);
                                        ?>
                                        <li class="step is-active" data-step="1">
                                             <p style="font-weight:bold;margin-bottom:5px;margin-top: 11px;"><?php echo $percentage; ?>%</p>
                                            <span class="font">Stage 1</span>
                                        </li>
                                        <?php
                                        
                                        }
                                        
                                        if($stepTwo == "Yes"){
                                            $stepTwoCompleted = "is-complete";
                                            $query = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query) ?? []; 
                                            $percentage = ($result['completionPercentage'] ?? 0) == 0 ? 0 : ($result['completionPercentage'] ?? 0);
                    					    if(mysqli_num_rows($query)>0){
                                                $check_two = 0;
                                                if($percentage < 100 ){
                                                    $stepTwoCompleted = "is-incomplete pointer";
                                                }
                    					    }else{
                    					       $stepTwoCompleted = ""; 
                    					    }                                        
                                        ?>
                                        <li class="step <?php echo $stepTwoCompleted; ?> pointer" onclick="redirect('stepTwo', '<?php echo $yojanaId; ?>')" data-step="2">
                                            <span style="font-weight:bold;"><?php echo $percentage; ?>%</span>
                                            <br>
                                           <span class="font"> Stage 2</span>
                                            <br>
                                            <span class="text">(Pump/Rising Main)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        if($stepThree == "Yes"){
                                            $stepThreeCompleted = "is-complete";
                                            $query = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query) ?? []; 
                                            $percentage = ($result['completionPercentage'] ?? 0) == 0 ? 0 : ($result['completionPercentage'] ?? 0);
                    					    if(mysqli_num_rows($query)>0){
                                                $check_three = 0;
                                                if($percentage < 100 ){
                                                    $stepThreeCompleted = "is-incomplete pointer";
                                                }
                    					    }else{
                    					        $stepThreeCompleted = "";
                    					    }                                        
                                        ?>
                                        <li class="step <?php echo $stepThreeCompleted; ?> pointer" onclick="redirect('stepThree', '<?php echo $yojanaId; ?>')" data-step="3a">
                                            <span style="font-weight:bold;"><?php echo $percentage; ?>%</span>
                                            <br>
                                           <span class="font"> Stage 3a</span>
                                            <br>
                                            <span class="text">(ESR)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        if($stepFour == "Yes"){
                                            $stepFourCompleted = "is-complete";
                                            $query = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query) ?? [];
                                            $percentage = ($result['completionPercentage'] ?? 0) == 0 ? 0 : ($result['completionPercentage'] ?? 0);
                                            if(mysqli_num_rows($query)>0){
                                                $check_four = 0;
                                                if($percentage < 100 ){
                                                    $stepFourCompleted = "is-incomplete pointer";
                                                }  
                    					    }else{
                    					        $stepFourCompleted = "";
                    					    }                                         
                                        ?>
                                        <li class="step <?php echo $stepFourCompleted; ?> pointer" onclick="redirect('stepFour', '<?php echo $yojanaId; ?>')" data-step="3b">
                                            <span style="font-weight:bold;"><?php echo $percentage; ?>%</span>
                                            
                                            <br>
                                           <span class="font"> Stage 3b</span>
                                            <br>
                                            <span class="text">(Distribution)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        if($stepFive == "Yes"){
                                            $stepFiveCompleted = "is-complete";
                                            $query = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query) ?? [];  
                                            $percentage = ($result['completionPercentage'] ?? 0) == 0 ? 0 : ($result['completionPercentage'] ?? 0);
                    					    if(mysqli_num_rows($query)>0){
                                                if($percentage < 100 ){
                                                    $stepFiveCompleted = "is-incomplete pointer";
                                                }
                    					    }else{
                    					        $stepFiveCompleted = "";
                    					    }                                        
                                        ?>
                                        <li class="step <?php echo $stepFiveCompleted; ?> pointer" onclick="redirect('stepFive', '<?php echo $yojanaId; ?>')" data-step="4">
                                            <span style="font-weight:bold;"><?php echo $percentage; ?>%</span>
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
                                    
                                      <div></div>
                                    <h4 class="card-title">Source</h4>


                                    <p class="card-description"></p>
                                    <form class="forms-sample" action="stepOne_db.php" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" value="<?php echo $yojanaId; ?>" name="yojanaId">
                                        
                                        <!-- diameter depth year-->
                                        <?php
                                        $i2 = 1;
                                        $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId' ");
                                        $hasSubWork = false;
                                        while($r3 = mysqli_fetch_assoc($q3) ?? []){
                                            $hasSubWork = true;
                                            $depth = $r3['depth'] ?? '';
                                            $diameter = $r3['diameter'] ?? '';
                                            
                                            $subWorkId = $r3['id'] ?? '';
                                            $q4 = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'");
                                            $r4 = mysqli_fetch_assoc($q4) ?? [];
                                            $typeOfSource = $r4['typeOfSource'] ?? '';
                                        
                                            $typeOfSourceArray = array('Existing Supply Well', 'New Supply well', 'New Bore well');
                                        ?>
                                        <input type="hidden" value="<?php echo $subWorkId; ?>" name="subWorkId[]">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="diameter<?php echo $i2; ?>">Type of Source</label>
                                                    <select class="js-example-basic-single" id="typeOfSource<?php echo $i2; ?>"  name="typeOfSource<?php echo $subWorkId; ?>" style="width: 100%;">
                                                        <option value="" selected disabled>Select Type</option>
                                                        <?php
                                                        foreach ($typeOfSourceArray as $typeOfSources){
                                                            $selected = $typeOfSources == $typeOfSource ? "selected" : "";
                                                        ?>
                                                        <option <?php echo $selected; ?> value="<?php echo htmlspecialchars($typeOfSources); ?>"><?php echo htmlspecialchars($typeOfSources); ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="depth<?php echo $i2; ?>">Depth (In M)</label>
                                                    <input type="number" step="0.01" value="<?php echo htmlspecialchars($depth); ?>" <?php echo $readonlyDepth; ?> class="form-control" id="depth<?php echo $i2; ?>" name="depth<?php echo $subWorkId; ?>" placeholder="Depth" />
                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="diameter<?php echo $i2; ?>">Diameter (In M)</label>
                                                    <input type="number" step="0.01" value="<?php echo htmlspecialchars($diameter); ?>" <?php echo $readonlyDia; ?> class="form-control" id="diameter<?php echo $i2; ?>" name="diameter<?php echo $subWorkId; ?>" placeholder="Diameter" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 hide">
                                                <div class="form-group">
                                                    <label for="typeOfStructure<?php echo $i2; ?>">Type of structure</label><br>
                                                    <select class="js-example-basic-single" id="typeOfStructure<?php echo $i2; ?>" name="typeOfStructure<?php echo $subWorkId; ?>" style="width: 100%;">
                                                        <option selected value="RCC">RCC</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                            $i2++;
                                        }
                                        
                                        // If no subwork found, add default fields
                                        if(!$hasSubWork) {
                                        ?>
                                        <input type="hidden" value="0" name="subWorkId[]">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="typeOfSource">Type of Source</label>
                                                    <select class="js-example-basic-single" id="typeOfSource" name="typeOfSource" style="width: 100%;">
                                                        <option value="" selected disabled>Select Type</option>
                                                        <option value="Existing Supply Well">Existing Supply Well</option>
                                                        <option value="New Supply well">New Supply well</option>
                                                        <option value="New Bore well">New Bore well</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="depth">Depth (In M)</label>
                                                    <input type="number" step="0.01" class="form-control" id="depth" name="depth" placeholder="Depth" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="diameter">Diameter (In M)</label>
                                                    <input type="number" step="0.01" class="form-control" id="diameter" name="diameter" placeholder="Diameter" />
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        
                                        <!-- Year of Construction field (hidden but required for stepOne_db.php) -->
                                        <input type="hidden" name="yearOfConstruction" value="<?php echo date('Y'); ?>">
                                        <input type="hidden" name="typeOfStructure" value="RCC">
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div id="textboxDiv">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Land Record</label>
                                                                <input type="file" name="photo1" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control document" />
                                                                <?php
                                                                if(!empty($photo1)){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file; ?> href="uploadedDoc/<?php echo htmlspecialchars($photo1); ?>"><?php echo htmlspecialchars($photo1); ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <!-- Hidden fields for coordinates -->
                                                                <input type="hidden" id="longitude1" name="longitude1" value="0">
                                                                <input type="hidden" id="latitude1" name="latitude1" value="0">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Source certificate</label>
                                                                <input type="file" name="photo2" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control document" />
                                                                <?php
                                                                if(!empty($photo2)){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file; ?> href="uploadedDoc/<?php echo htmlspecialchars($photo2); ?>"> <?php echo htmlspecialchars($photo2); ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude2" name="longitude2" value="0">
                                                                <input type="hidden" id="latitude2" name="latitude2" value="0">
                                                            </div>
                                                        </div>
                                                
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Yield Certificate</label>
                                                                <input type="file" name="photo3" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control document" />
                                                                <?php
                                                                if(!empty($photo3)){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file; ?> href="uploadedDoc/<?php echo htmlspecialchars($photo3); ?>"> <?php echo htmlspecialchars($photo3); ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude3" name="longitude3" value="0">
                                                                <input type="hidden" id="latitude3" name="latitude3" value="0">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2" style="margin-top: 1rem;">
                                                            <div class="row" style="height:75px;">
                                                                <div class="col-6">
                                                                    <div class="form-group ">
                                                                        <button type="button" class="btn " id="add" style="padding:0px;">
                                                                            <i class="mdi mdi-plus-circle" style="font-size: 2.5rem;color: green;"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group ">
                                                                        <button type="button" class="btn " id="remove" style="padding:0px;">
                                                                            <i class="mdi mdi-minus-circle" style="font-size: 2.5rem;color: red;"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?php
                                                
                                                $q4 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                                                if(mysqli_num_rows($q4) >0){
                                                
                                                // Initialize $r2 as empty array
                                                $r2 = ['delay' => '', 'reason' => '', 'otherReason' => ''];
                                                $radio = "";
                                                $display = 'style="display:none"';
                                                
                                                if($exit){
                                                    $q2 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well'");
                                                    if(mysqli_num_rows($q2)>0){
                                                        $r2 = mysqli_fetch_assoc($q2) ?? $r2;
                                                        $radio = '$("#delayPercolation'.$r2['delay'].'").click();';
                                                        if(($r2['reason'] ?? '') == "Other"){
                                                            $display = '';
                                                        }
                                                    }
                                                }
                                                ?>
                                                
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4 class="card-title">Percolation Well</h4>    
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Delay : &nbsp;<span> &nbsp;<input type="radio" name="delayPercolation" value="Yes" id="delayPercolationYes" onclick="delayPercolationFun(this.value)"> &nbsp;<label for="delayPercolationYes">Yes</label></span>
                                                        <span> &nbsp;<input type="radio" name="delayPercolation" id="delayPercolationNo" value="No" onclick="delayPercolationFun(this.value)"> &nbsp;<label for="delayPercolationNo">No</label></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="reasonPercolationDiv" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="diameter">Reason</label>
                                                            <select class="js-example-basic-single" id="reasonPercolation" name="reasonPercolation" onchange="otherReasonFunPercolation(this.value)" style="width: 100%;">
                                                                <option selected="" disabled=""value=""></option>
                                                                <?php
                                                                $q = mysqli_query($con, "SELECT * FROM delayReasons");
                                                                while($r = mysqli_fetch_assoc($q) ?? []){
                                                                    $selected = (($r['reasons'] ?? '') == ($r2['reason'] ?? '')) ? "selected" : "";
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo htmlspecialchars($r['reasons'] ?? ''); ?>"><?php echo htmlspecialchars($r['reasons'] ?? ''); ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="otherReasonPercolationDiv" <?php echo $display; ?>>
                                                        <div class="form-group">
                                                            <label for="">Other Reason</label>     
                                                            <input type="text" class="form-control" id="otherReasonPercolation" value="<?php echo htmlspecialchars($r2['otherReason'] ?? ''); ?>" name="otherReasonPercolation" style="height:20px;"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="delayDocumentPercolation" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control document" />  
                                                            <?php 
                                                            if(!empty($r1['document'] ?? '')){
                                                            ?>
                                                            Your Selected File is <a <?php echo $file; ?> href="uploadedDoc/<?php echo htmlspecialchars($r1['document']); ?>"> <?php echo htmlspecialchars($r1['document']); ?> <i class="bi bi-arrow-right"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="checkboxPercolationDiv" style="display:none">
                                                    <?php
                                                    $query = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE subWork = 'Percolation Well'");
                                                    while($result = mysqli_fetch_assoc($query) ?? []){
                                                        $i = $result['id'] ?? '';
                                                        $check = "";
                                                        $r1 = [];
                                                        
                                                        if($exit){
                                                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$i' AND yojanaId = '$yojanaId'");
                                                            if(mysqli_num_rows($q1)>0){
                                                                $r1 = mysqli_fetch_assoc($q1) ?? [];
                                                                $check = '$("#percolation'.$i.'").click();';
                                                            }
                                                        }
                                                        $per = $result['percentage'] ?? 0;
                                                    ?>
                                                    
                                                    <div class="col-md-12">
                                                        <p style="display:flex"><span><input type="checkbox" onclick="percentageCal()" class="percentage" data-per="<?php echo $per; ?>" id="percolation<?php echo $i; ?>" name="percolationWellSchedule[]" value="<?php echo $i; ?>"></span>&nbsp; <label for="percolation<?php echo $i; ?>"><?php echo htmlspecialchars($result['schedule'] ?? '') . " (" . $per . "%)"; ?></label></p>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentPercolation[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control document" />  
                                                            <?php 
                                                            if(!empty($r1['document'] ?? '') && ($r1['document'] ?? '') != 'Array'){
                                                            ?>
                                                            Your Selected File is <a <?php echo $file; ?> href="uploadedDoc/<?php echo htmlspecialchars($r1['document']); ?>"> <?php echo htmlspecialchars($r1['document']); ?> <i class="bi bi-arrow-right"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                
                                                <script>
                                                    <?php
                                                    if($exit && !empty($check)){
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
                                                    if(!empty($radio)) {
                                                        echo $radio;
                                                    }
                                                    ?>
                                                    function delayPercolationFun(val){
                                                        if(val == "Yes"){
                                                            $("#reasonPercolationDiv").show();
                                                            $("#checkboxPercolationDiv").hide();
                                                            var arr = $('.percentage').map(function () {
                                                                if(this.getAttribute('name') == 'percolationWellSchedule[]'){
                                                                    if(this.checked){
                                                                        this.click();
                                                                    }
                                                                }
                                                            });
                                                        } else {
                                                            $("#checkboxPercolationDiv").show();
                                                            $("#reasonPercolationDiv").hide();
                                                        }
                                                    }
                                                    function otherReasonFunPercolation(val){
                                                        if(val == "Other"){
                                                            $("#otherReasonPercolationDiv").show();
                                                            $("#otherReasonPercolation").val('');
                                                        } else {
                                                            $("#otherReasonPercolationDiv").hide();
                                                            $("#otherReasonPercolation").val(val);
                                                        }
                                                    }
                                                    
                                                    // Initialize based on current state
                                                    $(document).ready(function(){
                                                        <?php 
                                                        if($exit && isset($r2['delay']) && $r2['delay'] == "Yes") { 
                                                            echo "$('#reasonPercolationDiv').show();";
                                                            echo "$('#checkboxPercolationDiv').hide();";
                                                        } else {
                                                            echo "$('#reasonPercolationDiv').hide();";
                                                            echo "$('#checkboxPercolationDiv').show();";
                                                        }
                                                        ?>
                                                    });
                                                </script>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            
                                            <?php
                                            
                                            $q4 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                                            if(mysqli_num_rows($q4) >0){
                                            
                                            // Initialize $r2 as empty array
                                            $r2 = ['delay' => '', 'reason' => '', 'otherReason' => ''];
                                            $radio = "";
                                            $display = 'style="display:none"';
                                            
                                            if($exit){
                                                $q2 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund'");
                                                if(mysqli_num_rows($q2)>0){
                                                    $r2 = mysqli_fetch_assoc($q2) ?? $r2;
                                                    $radio = '$("#delayApproach'.$r2['delay'].'")';
                                                    
                                                    if(($r2['reason'] ?? '') == "Other"){
                                                        $display = '';
                                                    }
                                                }
                                            }
                                            ?>
                                                
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4 class="card-title">Approach Bund</h4>  
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Delay : &nbsp;<span> &nbsp;<input type="radio" name="delayApproach" value="Yes" id="delayApproachYes" onclick="delayApproachFun(this.value)"> &nbsp;<label for="delayApproachYes">Yes</label></span>
                                                        <span> &nbsp;<input type="radio" name="delayApproach" id="delayApproachNo" value="No" onclick="delayApproachFun(this.value)"> &nbsp;<label for="delayApproachNo">No</label></span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row" id="reasonApproachDiv" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="diameter">Reason</label>
                                                            <select class="js-example-basic-single" id="reasonApproach" name="reasonApproach" onchange="otherReasonFunApproach(this.value)" style="width: 100%;">
                                                                <option selected="" disabled=""value=""></option>
                                                                <?php
                                                                $q = mysqli_query($con, "SELECT * FROM delayReasons");
                                                                while($r = mysqli_fetch_assoc($q) ?? []){
                                                                    $selected = (($r['reasons'] ?? '') == ($r2['reason'] ?? '')) ? "selected" : "";
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo htmlspecialchars($r['reasons'] ?? ''); ?>"><?php echo htmlspecialchars($r['reasons'] ?? ''); ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="otherReasonApproachDiv" <?php echo $display; ?>>
                                                        <div class="form-group">
                                                            <label for="">Other Reason</label>     
                                                            <input type="text" class="form-control" id="otherReasonApproach" value="<?php echo htmlspecialchars($r2['otherReason'] ?? ''); ?>" name="otherReasonApproach" style="height:20px;"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="delayDocumentApproach" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control document" />  
                                                            <?php 
                                                            if(!empty($r1['document'] ?? '') && ($r1['document'] ?? '') != 'Array'){
                                                            ?>
                                                            Your Selected File is <a <?php echo $file; ?> href="uploadedDoc/<?php echo htmlspecialchars($r1['document']); ?>"> <?php echo htmlspecialchars($r1['document']); ?> <i class="bi bi-arrow-right"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="checkboxApproachDiv" style="display:none">
                                                    <?php
                                                    $query = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE subWork = 'Approach Bund'");
                                                    while($result = mysqli_fetch_assoc($query) ?? []){
                                                        $i = $result['id'] ?? '';
                                                        $check = "";
                                                        $show = "style='display:none'";
                                                        $r1 = [];
                                                        
                                                        if($exit){
                                                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$i' AND yojanaId = '$yojanaId'");
                                                            if(mysqli_num_rows($q1)>0){
                                                                $r1 = mysqli_fetch_assoc($q1) ?? [];
                                                                $check = '$("#approach'.$i.'").click();';
                                                                if(($r1['reason'] ?? '') == "Other"){
                                                                    $show = "style='display:block'";
                                                                }
                                                            }
                                                        }
                                                        $per = $result['percentage'] ?? 0;
                                                    ?>
                                                
                                                    <div class="col-md-8">
                                                        <p style="display:flex"><span><input type="checkbox" onclick="percentageCal()" id="approach<?php echo $i; ?>" class="percentage" data-per='<?php echo $per; ?>' name="approachBundSchedule[]" value="<?php echo $i; ?>"></span>&nbsp; <label for="approach<?php echo $i; ?>"><?php echo htmlspecialchars($result['schedule'] ?? '') . " (" . $per . "%)"; ?></label></p>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentApproach[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control document" />  
                                                            <?php 
                                                            if(!empty($r1['document'] ?? '') && ($r1['document'] ?? '') != 'Array'){
                                                            ?>
                                                            Your Selected File is <a <?php echo $file; ?> href="uploadedDoc/<?php echo htmlspecialchars($r1['document']); ?>"> <?php echo htmlspecialchars($r1['document']); ?> <i class="bi bi-arrow-right"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                
                                                    <script>
                                                        <?php
                                                        if($exit && !empty($check)){
                                                            echo $check;
                                                        }
                                                        ?>
                                                    </script>
                                                    <hr>
                                                <?php
                                                }
                                                ?>
                                                <script>
                                                    function delayApproachFun(val){
                                                        if(val == "Yes"){
                                                            $("#reasonApproachDiv").show();
                                                            $("#checkboxApproachDiv").hide();
                                                        } else {
                                                            $("#checkboxApproachDiv").show();
                                                            $("#reasonApproachDiv").hide();
                                                        }
                                                    }
                                                    function otherReasonFunApproach(val){
                                                        if(val == "Other"){
                                                            $("#otherReasonApproachDiv").show();
                                                            $("#otherReasonApproach").val('');
                                                        } else {
                                                            $("#otherReasonApproachDiv").hide();
                                                            $("#otherReasonApproach").val(val);
                                                        }
                                                    }
                                                    
                                                    // Initialize based on current state
                                                    $(document).ready(function(){
                                                        <?php 
                                                        if($exit && isset($r2['delay']) && $r2['delay'] == "Yes") { 
                                                            echo "$('#reasonApproachDiv').show();";
                                                            echo "$('#checkboxApproachDiv').hide();";
                                                        } else {
                                                            echo "$('#reasonApproachDiv').hide();";
                                                            echo "$('#checkboxApproachDiv').show();";
                                                        }
                                                        ?>
                                                    });
                                                    
                                                    <?php 
                                                    if($exit && !empty($r2['delay'] ?? '')){
                                                        echo '$("#delayApproach'.$r2['delay'].'").click();';
                                                    }
                                                    ?>
                                                </script>
                                                </div>
                                             </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <!-- percentage of work-->
                                        <div class="form-group">
                                            <label for="completionPercentage">Work completion in percentage</label>
                                            <div class="range-slider">
                                                <input type="range" disabled="" value="<?php echo $completionPercentage; ?>" min="0" max="100" id="completionPercentage">
                                                <input type="hidden" value="<?php echo $completionPercentage; ?>" min="0" max="100" id="completionPercentageText" name="completionPercentage">
                                                <span class="range-value" id="completionPercentage2"><?php echo $completionPercentage . " %"; ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="video_link">Upload Video Link</label>
                                            <input type="url" class="form-control" id="video_link" name="video_link" value="<?php echo htmlspecialchars($video_link); ?>" placeholder="Video Link" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="remark">Remark </label>
                                            <input type="text" class="form-control" id="remark" name="remark" value="<?php echo htmlspecialchars($remark); ?>" placeholder="Remark" />
                                        </div>
                                        
                                        <button type="submit"  name="submit" class="btn btn-primary me-2"> Submit </button>
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
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <?php 
    require_once('include/sweetAlert.php');
    if(isset($_SESSION['status'])){
        $status = $_SESSION['status'] ?? false;
        $msg = $_SESSION['msg'] ?? '';
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
        echo $readonly ?? '';
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
        
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location + "?yojanaId=" + yojanaId;   
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
            
            // Initialize delay status
            <?php
            if($exit){
                if(isset($r2['delay']) && $r2['delay'] == "Yes"){
                    echo "delayPercolationFun('Yes');";
                    echo "delayApproachFun('Yes');";
                } else {
                    echo "delayPercolationFun('No');";
                    echo "delayApproachFun('No');";
                }
            }
            ?>
        });
    </script>

    <script>
        var count = 4;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var nextCount = count + 1;
                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>Document Name </label><input type='text' class='form-control' name='docName" + count + "'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='photo" + count + "' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div></div>");
                count = nextCount;
                $("#remove").show();
                if (count > suspected) {
                    $("#add").hide();
                }
            }
        });

        $("#remove").on("click", function () {
            if (count > 4) {
                $("#textboxDiv").children().last().remove();
                count = count - 1;
                $("#add").show();
                if (count == 4) {
                    $("#remove").hide();
                }
            } else {
                $("#remove").hide();
            }
        });

        $("#taluka").on("change", function () {
            var taluka = $(this).val();
            var village = $("#village");
            village.html("कृपया वाट पहा");
            $.ajax({
                type: 'POST',
                url: 'villagesAjax',
                data: { taluka: taluka },
                success: function (data) {
                    village.html(data);
                }
            })
        });

        flatpickr(".datepicker", {
            dateFormat: "Y"
        });
    </script>
</body>
</html>