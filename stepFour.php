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
} else {
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

// Initialize variables to prevent undefined variable errors
$r2 = [];
$r1 = [];
$delayDocumentDistribution = '';
$reasonDistribution = '';
$otherReasonDistribution = '';
$delayDistributionValue = '';
$documentDistribution = '';
$stepOnePrecentage = 0;
$photo1 = $photo2 = $photo3 = $photo4 = '';
$docName2 = $docName3 = $docName4 = '';
$video_link = $remark = '';
$length = $material = '';
$exit = false;
$completionPercentage = 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <title>Step Four - Distribution</title>
    
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
    <script>
        function percentageCal(){
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
        $yojanaName = $r['yojanaName'] ?? '';
        $stepOne = $r['stepOne'] ?? '';
        $stepTwo = $r['stepTwo'] ?? '';
        $stepThree = $r['stepThree'] ?? '';
        $stepFour = $r['stepFour'] ?? '';
        $stepFive = $r['stepFive'] ?? '';
        
        $query = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'");
        $document = 2;
        if(mysqli_num_rows($query) > 0){
            $result = mysqli_fetch_assoc($query);
            $length = $result['length'] ?? '';
            $material = $result['material'] ?? '';
            $photo1 = $result['photo1'] ?? '';
            $docName2 = $result['docName2'] ?? '';
            $photo2 = $result['photo2'] ?? '';
            $docName3 = $result['docName3'] ?? '';
            $photo3 = $result['photo3'] ?? '';
            $docName4 = $result['docName4'] ?? '';
            $photo4 = $result['photo4'] ?? '';
            $completionPercentage = $result['completionPercentage'] ?? 0;
            $video_link  = $result['video_link'] ?? '';
            $remark = $result['remark'] ?? '';
            $exit = true;
        } else {
            $exit = false;
            $completionPercentage = 0;
            $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId' ORDER BY id DESC ");
            if(mysqli_num_rows($q3) > 0) {
                $r3 = mysqli_fetch_assoc($q3);
                $length = $r3['length'] ?? '';
                $material = $r3['typePipe'] ?? '';
            }
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
                                        if(isset($stepOne) && $stepOne == "Yes"){
                                            $stepOneCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);
                                            $percentage = $result['completionPercentage'] ?? 0;
                    					    if(mysqli_num_rows($query)>0){
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
                                           <span class="font"> Stage 1 </span>
                                            <br>
                                            <span class="text">(Source)</span>
                                        </li>
                                        <?php
                                        }
                                        
                                        if(isset($stepTwo) && $stepTwo == "Yes"){
                                            $stepTwoCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query); 
                                            $percentage = $result['completionPercentage'] ?? 0;
                    					    if(mysqli_num_rows($query)>0){
                                                if( $percentage < 100 ){
                                                    $stepTwoCompleted = "is-incomplete pointer";
                                                }
                    					    }else{
                    					       $stepTwoCompleted = ""; 
                    					    }                                        
                                        ?>
                                        <li class="step <?php echo $stepTwoCompleted; ?> pointer" onclick="redirect('stepTwo', '<?php echo $yojanaId ?>')" data-step="2">
                                            <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                            <br>
                                           <span class="font"> Stage 2 </span>
                                            <br>
                                            <span class="text">(Pump/Rising Main)</span>
                                        </li>
                                        <?php
                                        }
                                        if(isset($stepThree) && $stepThree == "Yes"){
                                            $stepThreeCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);   
                                            $percentage = $result['completionPercentage'] ?? 0;
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
                                        $query = mysqli_query($con,"SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                        if(mysqli_num_rows($query) > 0) {
                                            $result = mysqli_fetch_assoc($query); 
                                            $percentage = $result['completionPercentage'] ?? 0;
                                        } else {
                                            $percentage = 0;
                                        }
                                        ?>
                                        <li class="step is-active pointer" onclick="redirect('stepFour', '<?php echo $yojanaId ?>')" data-step="3b">
                                            <p style="font-weight:bold;margin-bottom:5px;margin-top: 11px;"><?php echo $percentage ?>%</p>
                                           <span class="font"> Stage 3b</span>
                                           
                                        </li>
                                        <?php
                                        if(isset($stepFive) && $stepFive == "Yes"){
                                            $stepFiveCompleted = "is-complete";
                                            $query = mysqli_query($con,"SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                            $result = mysqli_fetch_assoc($query);     
                                            $percentage = $result['completionPercentage'] ?? 0;
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
                                    <h4 class="card-title">Distribution System</h4>



                                    <p class="card-description"></p>
                                                                
                                    <form class="forms-sample" action="stepFour_db" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" value="<?php echo $yojanaId ?>" name="yojanaId">
                                        
                                        
                                        <?php
                                        $q3 = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId' ");
                                        while($r3 = mysqli_fetch_assoc($q3)){
                                            $subWorkId = $r3['id'];
                                            $length = $r3['length'] ?? '';
                                            $material = $r3['typePipe'] ?? '';
                                            
                                            $q4 = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'");
                                            if(mysqli_num_rows($q4) > 0){
                                                $r4 = mysqli_fetch_assoc($q4);
                                                $length = $r4['length'] ?? $length;
                                                $material = $r4['material'] ?? $material;
                                            }
                                            
                                            
                                        ?>
                                        <input type="hidden" value="<?php echo $subWorkId ?>" name="subWorkId[]">
                                        <!-- diameter depth year-->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="diameter">Length</label>
                                                    <!--<input type="text" class="form-control" onkeypress="isInputNumber(event)" value="<?php echo $length ?>" id="diameter" name="length" />-->
                                                    <input type="number" step="0.01" class="form-control" value="<?php echo $length ?>" <?php if($length != "") { echo "readonly"; } ?> id="diameter<?php echo $subWorkId ?>" name="length<?php echo $subWorkId ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="material">Material</label>
                                                    
                                                    <?php 
                                                    if($material != "") {
                                                    ?>
                                                    <input type="hidden" id="material<?php echo $subWorkId ?>" name="material<?php echo $subWorkId ?>" value="<?php echo $material ?>">
                                                    <?php
                                                    } 
                                                    
                                                    ?>
                                                    
                                                    <select class="js-example-basic-single" id="material<?php echo $subWorkId ?>" <?php if($material != "") { echo "disabled"; } ?> name="material<?php echo $subWorkId ?>" style="width: 100%;">
                                                        <option></option>
                                                        <?php 
                                                        $materialArray = array('PVC','HDPE', 'GI', 'DI');
                                                        foreach ($materialArray as $materials){
                                                            if($materials == $material){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option <?php echo $selected ?>><?php echo $materials ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <!--<input type="text" class="form-control" value="<?php echo $material ?>" id="material" name="material" />-->
                                                </div>
                                            </div>

                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <!-- -->

                                        <!-- upload photo-->
                                        <div class="row" style="align-items: end">
                                            <div class="col-md-10">
                                                <div id="textboxDiv">
                                                    <div class="row hide">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName1">Document Name </label>
                                                                <input type="text" class="form-control" id="docName1" value="SGS Report" name="docName1">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File</label>
                                                                <input type="file" name="photo1" accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx" class="form-control" />
                                                                <?php
                                                                if(!empty($photo1)){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo1 ?>"> <?php echo $photo1 ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>SGS Report</label>
                                                                <input type="file" name="photo1" accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx" class="form-control" />
                                                                <?php
                                                                if(!empty($photo1)){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo1 ?>"> <?php echo $photo1 ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <?php
                                                        if(!empty($photo2)){
                                                            $document = 3;
                                                        ?>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name </label>
                                                                <input type="text" class="form-control" id="docName" value="<?php echo $docName2  ?>" name="docName2">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Upload File </label>
                                                                <input type="file" name="photo2" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />
                                                                <?php
                                                                if(!empty($photo2)){
                                                                ?>
                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $photo2 ?>"> <?php echo $photo2 ?> <i class="bi bi-arrow-right"></i></a>
                                                                <?php
                                                                }
                                                                ?>
                                                                <input type="hidden" id="longitude1" name="longitude[]">
                                                                <input type="hidden" id="latitude1" name="latitude[]">
                                                            </div>
                                                        </div>
                                                        <?php 
                                                        }
                                                        
                                                        if(!empty($photo3)){
                                                            $document = 4;
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
                                                                if(!empty($photo3)){
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
                                                            $document = 5;
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
                                                                if(!empty($photo4)){
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
                                                
                                                $q4 = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
                                                if(mysqli_num_rows($q4) >0){
                                                
                                                // Initialize variables
                                                $r2 = [];
                                                $r1 = [];
                                                $display = 'style="display:none"';
                                                $radio = "";
                                                
                                                if($exit == true){
                                                    $q2 = mysqli_query($con, "SELECT * FROM delayYojanas WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System'");
                                                    if(mysqli_num_rows($q2)>0){
                                                        $r2 = mysqli_fetch_assoc($q2);
                                                        $radio = "$('#delayDistribution".($r2['delay'] ?? 'No')."').click();";
                                                        if(($r2['reason'] ?? '') == "Other"){
                                                            $display = '';
                                                        } else {
                                                            $display = 'style="display:none"';
                                                        }
                                                    }
                                                }
                                                ?>
                                                
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h4 class="card-title">Distribution System</h4>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p>Delay : &nbsp;<span> &nbsp;<input type="radio" name="delayDistribution" value="Yes" id="delayDistributionYes" onclick="delayDistributionFun(this.value)"> &nbsp;<label for="delayDistributionYes">Yes</label></span><span> &nbsp;<input type="radio" name="delayDistribution" id="delayDistributionNo" value="No" onclick="delayDistributionFun(this.value)"> &nbsp;<label for="delayDistributionNo">No</label></span></p>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="reasonDistributionDiv" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="diameter">Reason</label>
                                                            <select class="js-example-basic-single" id="reasonDistribution" name="reasonDistribution" onchange="otherReasonDistributionFun(this.value)" style="width: 100%;">
                                                                <option selected="" disabled=""value=""></option>
                                                                <?php
                                                                $delay = 0;
                                                                $q = mysqli_query($con, "SELECT * FROM delayReasons");
                                                                while($r = mysqli_fetch_assoc($q)){
                                                                    $selected = (($r2['reason'] ?? '') == $r['reasons']) ? "selected" : "";
                                                                    $delay++;
                                                                ?>
                                                                <option <?php echo $selected ?>><?php echo $r['reasons'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="otherReasonDistributionDiv" <?php echo $display; ?>>
                                                        <div class="form-group">
                                                            <label for="">Other Reason</label>     
                                                            <input type="text" class="form-control" id="otherReasonDistribution" value="<?php echo $r2['otherReason'] ?? '' ?>" name="otherReasonDistribution" style="height:20px;"/>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="delayDocumentDistribution" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
                                                            <?php 
                                                            if(!empty($r2['document'] ?? '')){
                                                            ?>
                                                            Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r2['document'] ?>"> <?php echo $r2['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row" id="checkboxDistributionDiv" style="display:none">
                                                    <?php
                                                    
                                                    $query = mysqli_query($con, "SELECT * FROM scheduleMaster WHERE subWork = 'Distribution System'");
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        $i = $result['id'];
                                                        $r1 = [];
                                                        $show = "style='display:none'";
                                                        $check = "";
                                                        
                                                        if($exit == true){
                                                            $q1 = mysqli_query($con, "SELECT * FROM schedule WHERE scheduleId = '$i' AND yojanaId = '$yojanaId'");
                                                            if(mysqli_num_rows($q1)>0){
                                                                $r1 = mysqli_fetch_assoc($q1);
                                                                $check = "$('#Distribution".$i."').click();";
                                                                if(($r1['reason'] ?? '') == "Other"){
                                                                    $show = "style='display:block'";
                                                                }
                                                            }
                                                        }
                                                        $per = $result['percentage'];
                                                    ?>
                                                
                                                    <div class="col-md-12">
                                                        <p style="display:flex"><span><input type="checkbox" onclick="percentageCal()" class="percentage" data-per="<?php echo $per; ?>" id="Distribution<?php echo $i ?>" name="distributionSchedule[]" value="<?php echo $i ?>"></span>&nbsp; <label for="Distribution<?php echo $i ?>"><?php echo $result['schedule']." (".$per."%)" ?></label></p>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>File</label>
                                                            <input type="file" name="documentDistribution[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" data-id="1" class="form-control document" />  
                                                            <?php 
                                                            if(!empty($r1['document'] ?? '')){
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
                                                    function delayDistributionFun(val){
                                                        if(val == "Yes"){
                                                            $("#reasonDistributionDiv").show();
                                                            $("#checkboxDistributionDiv").hide();
                                                        } else {
                                                            $("#checkboxDistributionDiv").show();
                                                            $("#reasonDistributionDiv").hide();
                                                        }
                                                    }
                                                    function otherReasonDistributionFun(val){
                                                        if(val == "Other"){
                                                            $("#otherReasonDistributionDiv").show();
                                                            $("#otherReasonDistribution").val('');
                                                        } else {
                                                            $("#otherReasonDistributionDiv").hide();
                                                            $("#otherReasonDistribution").val(val);
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
                                            <label for="range">Work completion in percentage</label>
                                            <div class="range-slider">
                                                <input type="range" disabled="" value="<?php echo $completionPercentage ?>" min="<?php echo $stepOnePrecentage; ?>" max="100" id="completionPercentage">
                                                <input type="hidden" value="<?php echo $completionPercentage ?>" min="<?php echo $stepOnePrecentage; ?>" max="100" id="completionPercentageText" name="completionPercentage">
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
                                            <input type="text" class="form-control" id="remark" placeholder="Remark" value="<?php echo $remark ?>" name="remark" />
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
        
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location+"?yojanaId="+yojanaId;   
            }
        }
            
        var count = <?php echo $document ?>;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var type = $('#element').val();
                // $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>Document Name </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='img[]' class='file-upload-default' /><div class='input-group col-xs-12'><input type='text' class='form-control file-upload-info' disabled placeholder='Upload Image' /><span class='input-group-append'> <button class='file-upload-browse btn btn-primary' type='button'> Upload </button></span></div></div></div>");
                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label  for='docName" + count + "'>Document Name </label><input type='text' onkeyup='referred()' class='form-control' required name='docName" + count + "' id='docName" + count + "'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='photo" + count + "' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div></div>");
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
    </script>

</body>

</html>