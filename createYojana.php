<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once("include/con.php");

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

if(isset($_POST['yojanaName'])){
    $yojanaName = $_POST['yojanaName'];
    $taluka = $_POST['taluka2'];
    $village = $_POST['village'];
    $habitation = $_POST['habitation'];
    $gramPanchayat = $_POST['gramPanchayat'];
    
    $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaName = '$yojanaName' AND taluka = '$taluka' AND gramPanchayat = '$gramPanchayat' AND habitation = '$habitation'");
    $row = mysqli_num_rows($query);
    if($row >0){
        echo 1;
    } else {
        echo 0;
    }
    die();
}

if(isset($_POST['taluka'])){
    $taluka = $_POST['taluka'];
    $query = mysqli_query($con, "SELECT MAX(number) as 'count' FROM yojanaMaster WHERE taluka = '$taluka'");
    $result = mysqli_fetch_assoc($query);
    $count = intval($result['count']) + 1;
    
    if($count >0 && $count < 10) {
        $count = "00".$count;
    } else if($count >= 10 && $count <100){
        $count = "0".$count;
    } else if($count >=100){
        $count = $count;
    }
    
    /*if($count > 10 && $count <= 100){
        $count2 = "0".$count;
    } else if($count > 100 && $count <=1000) {
        $count2 = $count;
    } else if($count < 10 && $count >0){
        $count2 = "00".$count;
    } else if($count == 0){
        $count2 = "001";
    }*/
    echo substr($taluka, 0, 4).$count .":".$count;
    die();
    
}

if($_SESSION['designation'] != "clerk"){
    $title = "Scheme Details";
} else {
    $title = "Create Scheme";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title><?php echo $title; ?></title>
    
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
    <style>
    .star{
        font-size:18px;
        color:red;
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
        .select2-container--default .select2-selection--single{
            height:50px;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__rendered{
            height: 44px;
        }
        .hide{
            display: none;
        }
        .bachBtn{
            margin-bottom: 1rem;
        }
        @media screen and (max-width: 600px) {
            .card-title{
                text-align: center;
            }
            .pd-0{
                padding: 0px;
            }
         
        }
        
    </style>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
    
    <style class="INLINE_PEN_STYLESHEET_ID">
    .marg_1
            {
                margin-top:21px;
            }
            
            @media screen and (max-width: 600px) {
                
                    .marg_1
            {
                margin-top:0px;
            }
                    
                }
    @charset "UTF-8";
/* Reset */
.accessory:before,
        .accessory:after {
            content: "";
        }

hr {
  border: 0;
  margin: 1.35em auto;
  max-width: 100%;
  background-position: 50%;
  box-sizing: border-box;
  opacity:inherit;
}

.accessory {
  height: 6px;
  background-image: radial-gradient(closest-side, gray, rgba(128, 128, 128, 0) 100%);
  position: relative;
}

.accessory:after {
    position: absolute;
    top: 50%;
    left: 50%;
    display: block;
    background-color: #bfbfbf;
    height: 18px;
    width: 18px;
    transform: rotate(45deg);
    margin-top: -9px;
    margin-left: -10px;
    border-radius: 4px 0;
    border: 4px solid rgba(255, 255, 255, 0.35);
    background-clip: padding-box;
    box-shadow: -10px 10px 0 rgb(255 255 255 / 15%), 10px -10px 0 rgb(255 255 255 / 15%);
}
    
    
        body {
            counter-reset: serial-tiral serial-pumping serial-rising serial-esr serial-approach serial-msedc serial-tiral serial-switch serial-distribution;
        }
    
        h6 {
            margin-top: 1rem !important;
        }
        
        .serialTrial::before {
            counter-increment: serial-tiral;
            /* Increment the serial number counter */
            content: counter(serial-tiral) ". ";
            /* Display the counter */
        }
    
        .serialPumping::before {
            counter-increment: serial-pumping;
            /* Increment the serial number counter */
            content: counter(serial-pumping) ". ";
            /* Display the counter */
        }
    
        .serialRising::before {
            counter-increment: serial-rising;
            /* Increment the serial number counter */
            content: counter(serial-rising) ". ";
            /* Display the counter */
        }
    
        .serialEsr::before {
            counter-increment: serial-esr;
            /* Increment the serial number counter */
            content: counter(serial-esr) ". ";
            /* Display the counter */
        }
    
        .serialApproach::before {
            counter-increment: serial-approach;
            /* Increment the serial number counter */
            content: counter(serial-approach) ". ";
            /* Display the counter */
        }
    
        .serialMsedc::before {
            counter-increment: serial-msedc;
            /* Increment the serial number counter */
            content: counter(serial-msedc) ". ";
            /* Display the counter */
        }
    
        .serialTrial::before {
            counter-increment: serial-tiral;
            /* Increment the serial number counter */
            content: counter(serial-tiral) ". ";
            /* Display the counter */
        }
    
        .serialSwitch::before {
            counter-increment: serial-switch;
            /* Increment the serial number counter */
            content: counter(serial-switch) ". ";
            /* Display the counter */
        }
        
        .serialDistribution::before {
            counter-increment: serial-distribution;
            /* Increment the serial number counter */
            content: counter(serial-distribution) ". ";
            /* Display the counter */
        }
    
        .trialBoreToggle, .percolationWellToggle, .approachBundToggle, .pumpingMachineryToggle, .switchRoomToggle, .risingMainToggle, .rccEsrToggle, .distributionSystemToggle, .msedcWorkToggle, .trialRunToggle {
            display: none;
        }
    </style>

</head>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
        
        if(isset($_GET['yojanaId'])){
            $yojanaId = $_GET['yojanaId'];
            $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
            $result = mysqli_fetch_assoc($query);
            $yojanaName = $result['yojanaName'];
            $expectedDate = $result['expectedDate'];
            $number = $result['number'];
            $talukaYojana = $result['taluka'];
            $gramPanchayat = $result['gramPanchayat'];
            $village = $result['village'];
            $habitation = $result['habitation'];
            $subDivision1 = $result['subDivision'];
            $exectedStartDate = $result['exectedStartDate'];
            $gst = $result['gst'];
            $q = mysqli_query($con, "SELECT * FROM allocatedYojana WHERE yojanaId = '$yojanaId' AND designation = 'executiveEng'");
            $r = mysqli_fetch_assoc($q);
            $executiveEng = $r['userId'];
            
            $q = mysqli_query($con, "SELECT * FROM allocatedYojana WHERE yojanaId = '$yojanaId' AND designation = 'sectionEng'");
            $r = mysqli_fetch_assoc($q);
            $sectionEng = $r['userId'];
            $subWorkId = "WHERE yojanaId = '$yojanaId'";
            
            if($_SESSION['designation'] != "clerk"){
                $readonly = "disabled";
                $showFile = true;
                $showDate = true;
            ?>
            <style>
            
                .addBtn{
                    display: none;
                }
                
                .removeBtn{
                    display: none;
                }
            </style>
            <?php
            } else {
                $showFile = true;
                $show = true;
                $showDate = false;
            }
            
            $yojana = "?yojanaId=".$yojanaId;
        } else {
            $yojanaName = "Water Supply Scheme";
        }
        
        ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <center style="padding-bottom:30px;">
                                        <?php 
                                        if(isset($_GET['yojanaId'])){
                                            if($_SESSION['designation'] == "clerk"){
                                        ?>
                                        <a href="yojanaList" style="float: left;"><button type="button" class="btn btn-primary me-2 bachBtn">Back</button></a>
                                        <?php
                                            } else {
                                        ?>
                                        <a href="home" style="float: left;"><button type="button" class="btn btn-primary me-2 bachBtn" >Back</button></a>
                                        <?php
                                            }
                                        }
                                        ?>
                                        <h3 class="ribbon"><?php echo $title; ?></h3>
                                        </center>
                                    <!--<h4 class="card-title">योजना तयार करा      </h4>-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form class="forms-sample" action="createYojana_db<?php echo $yojana ?>" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        
                                                    </div>
                                                    <div class="form-group col-md-3" id="yojanaNameHTML">
                                                        <label for="yojanaName">Scheme Id</label>
                                                        <input type="text" class="form-control" readonly required="" value="<?php echo $yojanaId ?>" id="schemeId" name="yojanaId" <?php echo $readonly ?> placeholder="">
                                                        <input type="hidden" name="number" id="number" value="<?php echo $number ?>" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-3" id="yojanaNameHTML">
                                                        <label for="yojanaName">Name of Scheme<span class="star">*</span></label>
                                                        <input type="text" class="form-control" readonly required="" id="yojanaName" name="yojanaName" <?php echo $readonly ?> value="<?php echo $yojanaName ?>" placeholder="">
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3" id="yojanaNameHTML">
                                                        <label for="yojanaName">Sub division<span class="star">*</span></label>
                                                        <?php 
                                                        $subDivisionArray = array('Jalna', 'Ambad', 'Ghansawangi', 'Jafrabad');
                                                        
                                                        ?>
                                                        <select class="js-example-basic-single" required=""  id="subDivision" name="subDivision" <?php echo $readonly ?> style="width: 100%;">
                                                            <option value="" selected="" disabled=""></option>
                                                            <?php 
                                                            foreach ($subDivisionArray as $subDivision){
                                                                if($subDivision == $subDivision1){
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            ?>
                                                            <option <?php echo $selected ?>><?php echo $subDivision ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3" >
                                                        <label for="taluka">Taluka<span class="star">*</span></label>
                                                        <select class="js-example-basic-single" required=""  id="taluka" name="taluka" <?php echo $readonly." ".$talukaUpdate ?> style="width: 100%;">
                                                            <option value="" selected="" disabled=""></option>
                                                            <?php 
                                                            $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                                                            while($result = mysqli_fetch_assoc($query)){
                                                                $taluka = $result['taluka'];
                                                                if($talukaYojana == $taluka){
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            ?>
                                                            <option <?php echo $selected ?> value="<?php echo $taluka ?>"><?php echo $taluka ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="gramPanchayat">Gram Panchayat<span class="star">*</span></label>
                                                        <div id="gramPanchayatHtml">
                                                            <!--<select class="js-example-basic-multiple" name="village"  multiple="multiple" style="width: 100%;">-->
                                                            <select class="js-example-basic-single" <?php echo $readonly ?> required="" id="gramPanchayat" name="gramPanchayat" style="width: 100%;">
                                                                <option value="" disabled="" selected=""></option>
                                                                <?php
                                                                $query = mysqli_query($con, "SELECT DISTINCT(gramPanchayat) FROM villages WHERE taluka = '$talukaYojana'");
                                                                while($result = mysqli_fetch_assoc($query)){
                                                                    if($gramPanchayat == $result['gramPanchayat']){
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                                <option <?php echo $selected ?> value="<?php echo $result['gramPanchayat'] ?>"><?php echo $result['gramPanchayat'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="form-group col-md-3">
                                                        <label for="village">Village<span class="star">*</span></label>
                                                        <div id="villageHtml">
                                                            <!--<select class="js-example-basic-multiple" name="village"  multiple="multiple" style="width: 100%;">-->
                                                            <select class="js-example-basic-single" <?php echo $readonly ?> required="" id="village" name="village" style="width: 100%;">
                                                                <option value="" disabled="" selected=""></option>
                                                                <?php
                                                                $query = mysqli_query($con, "SELECT DISTINCT(village) FROM villages WHERE taluka = '$talukaYojana' AND gramPanchayat = '$gramPanchayat'");
                                                                while($result = mysqli_fetch_assoc($query)){
                                                                    if($village == $result['village']){
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                                <option <?php echo $selected ?> value="<?php echo $result['village'] ?>"><?php echo $result['village'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select> 
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="habitation">Habitation<span class="star">*</span></label>
                                                        <div id="habitationHtml">
                                                            <!--<select class="js-example-basic-multiple" name="village"  multiple="multiple" style="width: 100%;">-->
                                                            <select class="js-example-basic-single" <?php echo $readonly ?> required="" id="habitation"  onchange="yojanaNameByVillage()" name="habitation" style="width: 100%;">
                                                                <option value="" disabled="" selected=""></option>
                                                                <?php
                                                                $query = mysqli_query($con, "SELECT DISTINCT(habitation) FROM villages WHERE taluka = '$talukaYojana' AND gramPanchayat
                                                                 = '$gramPanchayat' AND village = '$village'");
                                                                while($result = mysqli_fetch_assoc($query)){
                                                                    if($habitation == $result['habitation']){
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                                <option <?php echo $selected ?> value="<?php echo $result['habitation'] ?>"><?php echo $result['habitation'] ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select> 
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-3">
                                                        <label for="exampleInputEmail1">Sub Divisional Engineer<span class="star">*</span></label>
                                                        <select class="js-example-basic-single" <?php echo $readonly ?> required="" id="executiveEng" name="executiveEng" style="width: 100%;">
                                                            <option value="" selected="" disabled=""></option>
                                                            <?php
                                                            $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'executiveEng'");
                                                            while($result = mysqli_fetch_assoc($query)){
                                                                if($executiveEng == $result['userId']){
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            ?>
                                                            <option <?php echo $selected ?> value="<?php echo $result['userId'] ?>"><?php echo $result['fullName'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label for="exampleInputPassword1">Section Engineer<span class="star">*</span></label>
                                                        <select class="js-example-basic-single" required="" <?php echo $readonly ?> id="sectionEng" name="sectionEng" style="width: 100%;">
                                                            <option value="" selected="" disabled=""></option>
                                                            <?php
                                                            $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'sectionEng'");
                                                            while($result = mysqli_fetch_assoc($query)){
                                                                if($sectionEng == $result['userId']){
                                                                    $selected = "selected";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                            ?>
                                                            <option <?php echo $selected ?> value="<?php echo $result['userId'] ?>"><?php echo $result['fullName'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="exectedStartDate">Expected Start Date<span class="star">*</span></label>
                                                        <input type="date" name="exectedStartDate" id="exectedStartDate" <?php echo $readonly ?> required="" class="form-control" value="<?php echo $exectedStartDate ?>">
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="expectedDate">Expected End Date<span class="star">*</span></label>
                                                        <input type="date" name="expectedDate" id="expectedDate" required="" <?php echo $readonly ?> class="form-control" value="<?php echo $expectedDate ?>">
                                                    </div>
                                                </div>

                                                <div class="row" style="align-items: end">
                                                    <h4 class="card-title"> Scheme related document</h4>
                                                    <div class="col-md-12">
                                                        <div id="textboxDiv">
                                                            <div class="row">  
                                                                <div class="row col-md-4">
                                                                    <div class="col-md-6 hide">
                                                                        <div class="form-group">
                                                                            <label for="docName">Document Name </label>
                                                                            <input type="text"  <?php echo $readonly ?> class="form-control" value="Work Order" id="docName" name="docName[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 ">
                                                                        <div class="form-group">
                                                                            <label>Work Order</label>
                                                                            <input type="file" <?php echo $readonly ?> name="photo[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf,.pdf" class="form-control" />
                                                                            <?php
                                                                            if($showFile == true){
                                                                                $q = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND docName = 'Work Order'");
                                                                                $r = mysqli_fetch_assoc($q);
                                                                                
                                                                                if($r['document'] != ""){
                                                                                ?>
                                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r['document'] ?>"> <?php echo $r['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                                                <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row col-md-4">
                                                                    <div class="col-md-6 hide">
                                                                        <div class="form-group">
                                                                            <label for="docName">Document Name </label>
                                                                            <input type="text" <?php echo $readonly ?> class="form-control" value="Abstract of Estimate" id="docName" name="docName[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Abstract of Estimate</label>
                                                                            <input type="file" <?php echo $readonly ?> name="photo[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control" />
                                                                            <?php
                                                                            if($showFile == true){
                                                                                $q = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND docName = 'Abstract of Estimate'");
                                                                                $r = mysqli_fetch_assoc($q);
                                                                                
                                                                                if($r['document'] != ""){
                                                                                ?>
                                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r['document'] ?>"> <?php echo $r['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                                                <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row col-md-3">
                                                                    <div class="col-md-6 hide">
                                                                        <div class="form-group">
                                                                            <label for="docName">Document Name </label>
                                                                            <input type="text" <?php echo $readonly ?> class="form-control" value="Flow Diagram" id="docName" name="docName[]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label>Flow Diagram</label>
                                                                            <input type="file" <?php echo $readonly ?> name="photo[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control" />
                                                                            <?php
                                                                            if($showFile == true){
                                                                                $q = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND docName = 'Flow Diagram'");
                                                                                $r = mysqli_fetch_assoc($q);
                                                                                
                                                                                if($r['document'] != ""){
                                                                                ?>
                                                                                Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r['document'] ?>"> <?php echo $r['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                                                <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                           
                                                              
    
                                                                <div class="col-md-1 marg_1" >
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group " style="margin-bottom:0px">
                                                                                <button type="button" class="btn " id="add" style="padding:0px;">
                                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group ">
                                                                                <button type="button" class="btn " id="remove" style="padding:0px;">
                                                                                    <i class="mdi mdi-minus-circle removeBtn" style="font-size: 2.5rem;color: red;"></i>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="">
                                                        </div>
                                                    </div>
                                                </div> 
                                                <hr class="accessory">
                                                <div class="col-md-12">
                                                    
                                                    
                                                    <?php
                                                    //
                                                    //Trial Bore
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore' ");
                                                        
                                                        if(mysqli_num_rows($query) <=0 ){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="trialBore" value="stepTwo" id="trialBore"> </span><label for="trialBore">Trial Bore</label></h4>
                                                        <h6 class="trialBoreToggle"><span class="serialTrial"> Trial Bore</span></h6>
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="depthTrial">Depth (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthTrial ?>" name="depthTrial[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="diameterTrial">Diameter (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterTrial" value="<?php echo $diameterTrial ?>" name="diameterTrial[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="amountTrialBore">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountTrialBore" value="<?php echo $amountTrial ?>" name="amountTrialBore[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 marg_1 trialBoreToggle">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addTrial" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="percolationDiv" class="trialBoreToggle">
                                                        
                                                    </div>
                                                    <?php    
                                                        } else {
                                                            $trialBore = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $depthTrial = $result['depth'];
                                                            $diameterTrial = $result['diameter'];
                                                            $amountTrial = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id'];
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='trialBoreId[]' value='".$id."'>";
                                                            if($i == 1){
                                                    ?>
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="trialBore" value="stepTwo" id="trialBore"> </span><label for="trialBore">Trial Bore</label></h4>
                                                        <h6 class="trialBoreToggle"><span class="serialTrial"> Trial Bore</span></h6>
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="depthTrial">Depth (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthTrial ?>" name="depthTrial[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="diameterTrial">Diameter (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterTrial" value="<?php echo $diameterTrial ?>" name="diameterTrial[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="amountTrialBore">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountTrialBore" value="<?php echo $amountTrial ?>" name="amountTrialBore[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 marg_1 trialBoreToggle">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addTrial" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php 
                                                            } else {
                                                    ?>
                                                    <div id="percolationDiv" class="trialBoreToggle">
                                                        <div class="row">
                                                            <h6><span class="serialTrial"> Trial Bore</span></h6>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="depthTrial">Depth (in m) </label>
                                                                    <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthTrial ?>" name="depthTrial[]" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="diameterTrial">Diameter (in m) </label>
                                                                    <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterTrial" value="<?php echo $diameterTrial ?>" name="diameterTrial[]" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="amountTrialBore">Sanctioned Cost</label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountTrialBore" value="<?php echo $amountTrial ?>" name="amountTrialBore[]" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3 marg_1">
                                                                <div class="form-group" style="margin-bottom:0px">
                                                                    <button type='button' class='btn removeTrial' <?php echo $readonly ?> id='removeTrial' style='padding:0px;'>
                                                                        <i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                                }
                                                            if($showDate == true){
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                                }
                                                                $i++;
                                                        }
                                                        if($i == 2){
                                                        ?>
                                                        <div id="percolationDiv" class="trialBoreToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                    } else {
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="trialBore" value="stepTwo" id="trialBore"> </span><label for="trialBore">Trial Bore</label></h4>
                                                        <h6 class="trialBoreToggle"><span class="serialTrial"> Trial Bore</span></h6>
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="depthTrial">Depth (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthTrial ?>" name="depthTrial[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="diameterTrial">Diameter (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterTrial" value="<?php echo $diameterTrial ?>" name="diameterTrial[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 trialBoreToggle">
                                                            <div class="form-group">
                                                                <label for="amountTrialBore">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountTrialBore" value="<?php echo $amountTrial ?>" name="amountTrialBore[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 marg_1 trialBoreToggle">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addTrial" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="percolationDiv" class="trialBoreToggle">
                                                        
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <hr class="accessory">
                                                    
                                                    
                                                    <?php
                                                    //
                                                    //Percolation Well
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well' ");
                                                        
                                                        if(mysqli_num_rows($query) <=0 ){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="percolationWell" value="stepTwo" id="percolationWell"> </span><label for="percolationWell">Percolation Well</label></h4>
                                                        <h6 class="percolationWellToggle"><span class="serialPumping"> Percolation Well</span></h6>
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="depthPercolation">Depth (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthPercolation ?>" name="depthPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="diameterPercolation">Diameter (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterPercolation" value="<?php echo $diameterPercolation ?>" name="diameterPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="amountPercolation">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountPercolation" value="<?php echo $amountPercolation ?>" name="amountPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 marg_1 percolationWellToggle">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addPercolation" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="percolationDiv" class="percolationWellToggle">
                                                        
                                                    </div>
                                                    <?php    
                                                        } else {
                                                            $percolationWell = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $depthPercolation = $result['depth'];
                                                            $diameterPercolation = $result['diameter'];
                                                            $amountPercolation = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id'];
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='percolationWellId[]' value='".$id."'>";
                                                            if($i == 1){
                                                    ?>
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="percolationWell" value="stepTwo" id="percolationWell"> </span><label for="percolationWell">Percolation Well</label></h4>
                                                        <h6 class="percolationWellToggle"><span class="serialPumping"> Percolation Well</span></h6>
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="depthPercolation">Depth (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthPercolation ?>" name="depthPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="diameterPercolation">Diameter (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterPercolation" value="<?php echo $diameterPercolation ?>" name="diameterPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="amountPercolation">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountPercolation" value="<?php echo $amountPercolation ?>" name="amountPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 marg_1 percolationWellToggle">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addPercolation" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php 
                                                            } else {
                                                    ?>
                                                    <div id="percolationDiv" class="percolationWellToggle">
                                                        <div class="row">
                                                            <h6><span class="serialPumping"> Percolation Well</span></h6>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="depthPercolation">Depth (in m) </label>
                                                                    <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthPercolation ?>" name="depthPercolation[]" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="diameterPercolation">Diameter (in m) </label>
                                                                    <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterPercolation" value="<?php echo $diameterPercolation ?>" name="diameterPercolation[]" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="amountPercolation">Sanctioned Cost</label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountPercolation" value="<?php echo $amountPercolation ?>" name="amountPercolation[]" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3 marg_1">
                                                                <div class="form-group" style="margin-bottom:0px">
                                                                    <button type='button' class='btn removePercolation' <?php echo $readonly ?> id='removePercolation' style='padding:0px;'>
                                                                        <i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                                }
                                                            if($showDate == true){
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                                }
                                                                $i++;
                                                        }
                                                        if($i == 2){
                                                        ?>
                                                        <div id="percolationDiv" class="percolationWellToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                    } else {
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="percolationWell" value="stepTwo" id="percolationWell"> </span><label for="percolationWell">Percolation Well</label></h4>
                                                        <h6 class="percolationWellToggle"><span class="serialPumping"> Percolation Well</span></h6>
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="depthPercolation">Depth (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" value="<?php echo $depthPercolation ?>" name="depthPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="diameterPercolation">Diameter (in m) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> step="0.01" id="diameterPercolation" value="<?php echo $diameterPercolation ?>" name="diameterPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 percolationWellToggle">
                                                            <div class="form-group">
                                                                <label for="amountPercolation">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" id="amountPercolation" value="<?php echo $amountPercolation ?>" name="amountPercolation[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 marg_1 percolationWellToggle">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addPercolation" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="percolationDiv" class="percolationWellToggle">
                                                        
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <hr class="accessory">
                                                    <?php
                                                    
                                                    //
                                                    //Approach Bund
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i=1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund' ");
                                                        if(mysqli_num_rows($query) <=0 ){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="approachBund" id="approachBund" value="stepTwo"> </span><label for="approachBund">Approach Bund</label></h4>
                                                        <h6 class="approachBundToggle"><span class="serialApproach"> Approach Bund</span></h6>
                                                        <div class="col-md-4 approachBundToggle">
                                                            <div class="form-group">
                                                                <label for="lengthApproach">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthApproach ?>" id="lengthApproach" name="lengthApproach[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 approachBundToggle">
                                                            <div class="form-group">
                                                                <label for="amountApproach">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountApproach" value="<?php echo $amountApproach ?>" name="amountApproach[]"> 
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 approachBundToggle marg_1">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addApproach" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="approachDiv" class="approachBundToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $approachBund = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $lengthApproach = $result['length'];
                                                            $amountApproach = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='approachBundId[]' value='".$id."'>";
                                                            
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="approachBund" id="approachBund" value="stepTwo"> </span><label for="approachBund">Approach Bund</label></h4>
                                                        <h6 class="approachBundToggle"><span class="serialApproach"> Approach Bund</span></h6>
                                                        <div class="col-md-4 approachBundToggle">
                                                            <div class="form-group">
                                                                <label for="lengthApproach<?php echo $i ?>">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthApproach ?>" id="lengthApproach<?php echo $i ?>" name="lengthApproach[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 approachBundToggle">
                                                            <div class="form-group">
                                                                <label for="amountApproach">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountApproach<?php echo $i ?>" value="<?php echo $amountApproach ?>" name="amountApproach[]"> 
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 marg_1 approachBundToggle">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addApproach" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            } else {
                                                    ?>
                                                    <div id="approachDiv" class="approachBundToggle">
                                                        <div class="row">
                                                            <h6><span class="serialApproach"> Approach Bund</span></h6>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="lengthApproach<?php echo $i ?>">Length (in m) </label>
                                                                    <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthApproach ?>" id="lengthApproach<?php echo $i ?>" name="lengthApproach[]" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="amountApproach">Sanctioned Cost</label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountApproach<?php echo $i ?>" value="<?php echo $amountApproach ?>" name="amountApproach[]"> 
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4 marg_1">
                                                                <div class="form-group" style="margin-bottom:0px">
                                                                    <button type='button' class='btn removeApproach' <?php echo $readonly ?> id='removeApproach' style='padding:0px;'>
                                                                        <i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                        
                                                            if($showDate == true){
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            $i++;
                                                        }
                                                        if($i == 2){
                                                        ?>
                                                        <div id="approachDiv" class="approachBundToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                        
                                                    } else {
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="approachBund" id="approachBund" value="stepTwo"> </span><label for="approachBund">Approach Bund</label></h4>
                                                        <h6 class="approachBundToggle"><span class="serialApproach"> Approach Bund</span></h6>
                                                        <div class="col-md-4 approachBundToggle">
                                                            <div class="form-group">
                                                                <label for="lengthApproach">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthApproach ?>" id="lengthApproach" name="lengthApproach[]" >
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 approachBundToggle">
                                                            <div class="form-group">
                                                                <label for="amountApproach">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountApproach" value="<?php echo $amountApproach ?>" name="amountApproach[]"> 
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 approachBundToggle marg_1">
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addApproach" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="approachDiv" class="approachBundToggle">
                                                        
                                                    </div>
                                                    <?php 
                                                    }
                                                    ?>
                                                    <hr class="accessory">
                                                    <?php
                                                    
                                                    //
                                                    //Pumping Machinery
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery' ");
                                                        if(mysqli_num_rows($query) <= 0){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="pumpingMachinery" id="pumpingMachinery" value="stepTwo"> </span><label for="pumpingMachinery">Pumping Machinery</label></h4>
                                                        <h6 class="pumpingMachineryToggle"><span class="serialPumping"> Pumping Machinery</span></h6>
                                                        <div class="col-md-5 pumpingMachineryToggle">
                                                            <div class="form-group">
                                                                <label for="bhpPumping1">Power (bhp) </label>
                                                                <input type="number" class="form-control" step="0.01" value="<?php echo $bhpPumping ?>" id="bhpPumping1" name="bhpPumping[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5 pumpingMachineryToggle">
                                                            <div class="form-group">
                                                                <label for="amountPumping1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" id="amountPumping1" value="<?php echo $amountPumping ?>" name="amountPumping[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 pumpingMachineryToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addPumping" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="pumpingDiv" class="pumpingMachineryToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $pumpingMachinery = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $bhpPumping = $result['bhp'];
                                                            $amountPumping = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='pumpingMachineryId[]' value='".$id."'>";
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="pumpingMachinery" id="pumpingMachinery" value="stepTwo"> </span><label for="pumpingMachinery">Pumping Machinery</label></h4>
                                                        <h6 class="pumpingMachineryToggle"><span class="serialPumping"> Pumping Machinery</span></h6>
                                                        <div class="col-md-5 pumpingMachineryToggle">
                                                            <div class="form-group">
                                                                <label for="bhpPumping1">Power (bhp) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $bhpPumping ?>" id="bhpPumping1" name="bhpPumping[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5 pumpingMachineryToggle">
                                                            <div class="form-group">
                                                                <label for="amountPumping1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountPumping1" value="<?php echo $amountPumping ?>" name="amountPumping[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 pumpingMachineryToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addPumping" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            } else {
                                                    ?>
                                                    <div id="pumpingDiv" class="pumpingMachineryToggle">
                                                        <div class="row">
                                                            <h6><span class="serialPumping"> Pumping Machinery</span></h6>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="bhpPumping1">Power (bhp) </label>
                                                                    <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $bhpPumping ?>" id="bhpPumping1" name="bhpPumping[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="amountPumping1">Sanctioned Cost </label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountPumping1" value="<?php echo $amountPumping ?>" name="amountPumping[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2 marg_1" >
                                                                <div class="form-group">
                                                                    <button type='button' class='btn removePumping' id='removePumping' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                    
                                                            if($showDate == true){
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Planned Start Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Planned End Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Actual Start Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Actual End Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            }
                                                            $i++;
                                                        }
                                                        
                                                        if($i == 2){
                                                        ?>
                                                        <div id="pumpingDiv" class="pumpingMachineryToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                    } else {
                                                    ?>
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="pumpingMachinery" id="pumpingMachinery" value="stepTwo"> </span><label for="pumpingMachinery">Pumping Machinery</label></h4>
                                                        <h6 class="pumpingMachineryToggle"><span class="serialPumping"> Pumping Machinery</span></h6>
                                                        <div class="col-md-5 pumpingMachineryToggle">
                                                            <div class="form-group">
                                                                <label for="bhpPumping1">Power (bhp) </label>
                                                                <input type="number" class="form-control" step="0.01" value="<?php echo $bhpPumping ?>" id="bhpPumping1" name="bhpPumping[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5 pumpingMachineryToggle">
                                                            <div class="form-group">
                                                                <label for="amountPumping1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" id="amountPumping1" value="<?php echo $amountPumping ?>" name="amountPumping[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 pumpingMachineryToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addPumping" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="pumpingDiv" class="pumpingMachineryToggle">
                                                        
                                                    </div>
                                                    <?php
                                                    } 
                                                    ?>
                                                    <hr class="accessory">
                                                    
                                                    <?php
                                                    
                                                    //
                                                    //Switch Room
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room' ");
                                                        if(mysqli_num_rows($query) <=0 ){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="switchRoom" id="switchRoom" value="stepTwo"> </span><label for="switchRoom">Switch Room</label></h4>
                                                        <h6 class="switchRoomToggle"><span class="serialSwitch"> Switch Room</span></h6>
                                                        
                                                        <div class="col-md-5 switchRoomToggle">
                                                            <div class="form-group">
                                                                <label for="amountSwitch1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" id="amountSwitch1" value="<?php echo $amountSwitch ?>" name="amountSwitch[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 switchRoomToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addSwitch" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="switchDiv" class="switchRoomToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $switchRoom = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $amountSwitch = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='switchRoomId[]' value='".$id."'>";
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="switchRoom" id="switchRoom" value="stepTwo"> </span><label for="switchRoom">Switch Room</label></h4>
                                                        <h6 class="switchRoomToggle"><span class="serialSwitch"> Switch Room</span></h6>
                                                        
                                                        <div class="col-md-5 switchRoomToggle">
                                                            <div class="form-group">
                                                                <label for="amountSwitch1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountSwitch1" value="<?php echo $amountSwitch ?>" name="amountSwitch[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 marg_1 switchRoomToggle" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addSwitch" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            } else {
                                                    ?>
                                                    <div id="switchDiv" class="switchRoomToggle">
                                                        <div class="row">
                                                            <h6><span class="serialSwitch"> Switch Room</span></h6>
                                                            
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="amountSwitch1">Sanctioned Cost </label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountSwitch1" value="<?php echo $amountSwitch ?>" name="amountSwitch[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2 marg_1" >
                                                                <div class="form-group">
                                                                    <button type='button' class='btn removeSwitch' id='removeSwitch' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                    
                                                        if($showDate == true){
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Planned Start Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Planned End Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Actual Start Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Actual End Date</label>
                                                                    <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        }
                                                            $i++;
                                                        }
                                                        
                                                        
                                                        if($i == 2){
                                                        ?>
                                                        <div id="switchDiv" class="switchRoomToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                    } else {
                                                    ?>
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="switchRoom" id="switchRoom" value="stepTwo"> </span><label for="switchRoom">Switch Room</label></h4>
                                                        <h6 class="switchRoomToggle"><span class="serialSwitch"> Switch Room</span></h6>
                                                        
                                                        <div class="col-md-5 switchRoomToggle">
                                                            <div class="form-group">
                                                                <label for="amountSwitch1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" id="amountSwitch1" value="<?php echo $amountSwitch ?>" name="amountSwitch[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 switchRoomToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addSwitch" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="switchDiv" class="switchRoomToggle">
                                                        
                                                    </div>
                                                    <?php
                                                    } 
                                                    ?>
                                                    <hr class="accessory">
                                                    <?php
                                                    
                                                    //
                                                    //Rising Main
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main' ");
                                                        if(mysqli_num_rows($query) <= 0){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="risingMain" id="risingMain" value="stepTwo"> </span><label for="risingMain">Rising Main</label></h4>
                                                        <h6 class="risingMainToggle"><span class="serialRising"> Rising Main</span></h6>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="diameterRising1">Diameter (in mm) </label>
                                                                <input type="number" class="form-control" step="0.01" id="diameterRising1" name="diameterRising[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="diameterRising1">Pipe Type</label>
                                                                <?php
                                                                $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                ?>
                                                                <select class="form-control" name="typePipeRising[]">
                                                                    <option selected="" disabled=""></option>
                                                                    <?php 
                                                                    foreach ($typePipeArray as $typePipe){
                                                                    ?>
                                                                    <option><?php echo $typePipe ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="kg_cmRising1"> (in kg/cm<sup>2</sup>) </label>
                                                                <input type="number" class="form-control" step="0.01" id="kg_cmRising1"name="kg_cmRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="lengthRising1">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" id="lengthRising1" name="lengthRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="amountRising1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" id="amountRising1" name="amountRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 marg_1 risingMainToggle" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addRising" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="risingDiv" class="risingMainToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $risingMain = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $diameterRising = $result['diameter'];
                                                            $typePipeRising = $result['typePipe'];
                                                            $kg_cmRising = $result['kg_cm'];
                                                            $lengthRising = $result['length'];
                                                            $amountRising = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='risingMainId[]' value='".$id."'>";
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="risingMain" id="risingMain" value="stepTwo"> </span><label for="risingMain">Rising Main</label></h4>
                                                        <h6 class="risingMainToggle"><span class="serialRising"> Rising Main</span></h6>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="diameterRising1">Diameter (in mm) </label>
                                                                <input type="number" class="form-control" step="0.01" id="diameterRising1" <?php echo $readonly ?> value="<?php echo $diameterRising ?>" name="diameterRising[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="diameterRising1">Pipe Type</label>
                                                                <?php
                                                                $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                ?>
                                                                <select class="form-control" <?php echo $readonly ?>  name="typePipeRising[]">
                                                                    <option selected="" disabled=""></option>
                                                                    <?php 
                                                                    foreach ($typePipeArray as $typePipe){
                                                                        if($typePipe == $typePipeRising){
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        }
                                                                    ?>
                                                                    <option <?php echo $selected ?>><?php echo $typePipe ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="kg_cmRising1"> (in kg/cm<sup>2</sup>) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $kg_cmRising ?>" id="kg_cmRising1"name="kg_cmRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="lengthRising1">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthRising ?>" id="lengthRising1" name="lengthRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="amountRising1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> value="<?php echo $amountRising ?>" id="amountRising1" name="amountRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 risingMainToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addRising" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            } else {
                                                    ?>
                                                    <div id="risingDiv" class="risingMainToggle">
                                                        <div class="row">
                                                            <h6><span class="serialRising"> Rising Main</span></h6>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="diameterRising1">Diameter (in mm) </label>
                                                                    <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> id="diameterRising1" value="<?php echo $diameterRising ?>" name="diameterRising[]">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="diameterRising1">Pipe Type</label>
                                                                    <?php
                                                                    $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                    ?>
                                                                    <select class="form-control" <?php echo $readonly ?> name="typePipeRising[]">
                                                                        <option selected="" disabled=""></option>
                                                                        <?php 
                                                                        foreach ($typePipeArray as $typePipe){
                                                                            if($typePipe == $typePipeRising){
                                                                                $selected = "selected";
                                                                            } else {
                                                                                $selected = "";
                                                                            }
                                                                        ?>
                                                                        <option <?php echo $selected ?>><?php echo $typePipe ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="kg_cmRising1"> (in kg/cm<sup>2</sup>) </label>
                                                                    <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $kg_cmRising ?>" id="kg_cmRising1"name="kg_cmRising[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="lengthRising1">Length (in m) </label>
                                                                    <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthRising ?>" id="lengthRising1" name="lengthRising[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="amountRising1">Sanctioned Cost </label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> value="<?php echo $amountRising ?>" id="amountRising1" name="amountRising[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2 marg_1" >
                                                                <div class="form-group">
                                                                    <button type='button' class='btn removeRising' <?php echo $readonly ?> id='removeRising' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            $i++;
                                                            
                                                            if($showDate == true){
                                                    ?>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Planned Start Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Planned End Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Actual Start Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Actual End Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                            }
                                                        }
                                                        if($i == 2){
                                                        ?>
                                                        <div id="risingDiv" class="risingMainToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                    
                                                    } else {
                                                    ?>
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="risingMain" id="risingMain" value="stepTwo"> </span><label for="risingMain">Rising Main</label></h4>
                                                        <h6 class="risingMainToggle"><span class="serialRising"> Rising Main</span></h6>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="diameterRising1">Diameter (in mm) </label>
                                                                <input type="number" class="form-control" step="0.01" id="diameterRising1" name="diameterRising[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="diameterRising1">Pipe Type</label>
                                                                <?php
                                                                $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                ?>
                                                                <select class="form-control" name="typePipeRising[]">
                                                                    <option selected="" disabled=""></option>
                                                                    <?php 
                                                                    foreach ($typePipeArray as $typePipe){
                                                                    ?>
                                                                    <option><?php echo $typePipe ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="kg_cmRising1"> (in kg/cm<sup>2</sup>) </label>
                                                                <input type="number" class="form-control" step="0.01" id="kg_cmRising1"name="kg_cmRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="lengthRising1">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" id="lengthRising1" name="lengthRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 risingMainToggle">
                                                            <div class="form-group">
                                                                <label for="amountRising1">Sanctioned Cost </label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" id="amountRising1" name="amountRising[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 marg_1 risingMainToggle" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addRising" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="risingDiv" class="risingMainToggle">
                                                        
                                                    </div>
                                                    
                                                    <?php 
                                                    }
                                                    
                                                    ?>
                                                    <hr class="accessory">
                                                    <?php
                                                    //
                                                    //RCC ESR
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'RCC ESR' ");
                                                        if(mysqli_num_rows($query) <= 0){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="rccEsr" id="rccEsr" value="stepThree"> </span><label for="rccEsr">RCC ESR</label></h4>
                                                        <h6 class="rccEsrToggle"><span class="serialEsr"> RCC  ESR</span></h6>
                                                        <div class="col-md-5 rccEsrToggle">
                                                            <div class="form-group">
                                                                <label for="capacityEsr1">Capacity (in ltr) </label>
                                                                <input type="number" class="form-control" id="capacityEsr1" step="0.01" name="capacityEsr[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5 rccEsrToggle">
                                                            <div class="form-group">
                                                                <label for="amountEsr1">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' id="amountEsr1" step="0.01" name="amountEsr[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 rccEsrToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addEsr" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="esrDiv" class="rccEsrToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $rccEsr = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $capacityEsr = $result['capacity'];
                                                            $amountEsr = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='rccEsrId[]' value='".$id."'>";
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="rccEsr" id="rccEsr" value="stepThree"> </span><label for="rccEsr">RCC ESR</label></h4>
                                                        <h6 class="rccEsrToggle"><span class="serialEsr"> RCC  ESR</span></h6>
                                                        <div class="col-md-5 rccEsrToggle">
                                                            <div class="form-group">
                                                                <label for="capacityEsr1">Capacity (in ltr) </label>
                                                                <input type="number" class="form-control" <?php echo $readonly ?> value="<?php echo $capacityEsr ?>" id="capacityEsr1" step="0.01" name="capacityEsr[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5 rccEsrToggle">
                                                            <div class="form-group">
                                                                <label for="amountEsr1">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> value="<?php echo $amountEsr ?>" id="amountEsr1" step="0.01" name="amountEsr[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 marg_1 rccEsrToggle" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addEsr" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="esrDiv" class="rccEsrToggle">
                                                        
                                                    </div>
                                                    <?php
                                                            } else {
                                                    ?>
                                                    <div id="esrDiv" class="rccEsrToggle">
                                                        <div class="row">
                                                            <h6><span class="serialEsr"> RCC  ESR</span></h6>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="capacityEsr1">Capacity (in ltr) </label>
                                                                    <input type="number" class="form-control" <?php echo $readonly ?> id="capacityEsr1" value="<?php echo $capacityEsr ?>" step="0.01" name="capacityEsr[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label for="amountEsr1">Sanctioned Cost</label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' onkeyup='sanctionedCostFun()' <?php echo $readonly ?> id="amountEsr1" value="<?php echo $amountEsr ?>" step="0.01" name="amountEsr[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2 marg_1" >
                                                                <div class="form-group">
                                                                    <button type='button' class='btn removeEsr' id='removeEsr' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                    <?php
                                                            }
                                                            $i++;
                                                            if($showDate == true){
                                                    ?>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Planned Start Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Planned End Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Actual Start Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label>Actual End Date</label>
                                                                        <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php
                                                            }
                                                        }
                                                        if($i == 2){
                                                        ?>
                                                        <div id="esrDiv" class="rccEsrToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                    
                                                    } else {
                                                    ?>
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="rccEsr" id="rccEsr" value="stepThree"> </span><label for="rccEsr">RCC ESR</label></h4>
                                                        <h6 class="rccEsrToggle"><span class="serialEsr"> RCC  ESR</span></h6>
                                                        <div class="col-md-5 rccEsrToggle">
                                                            <div class="form-group">
                                                                <label for="capacityEsr1">Capacity (in ltr) </label>
                                                                <input type="number" class="form-control" id="capacityEsr1" step="0.01" name="capacityEsr[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5 rccEsrToggle">
                                                            <div class="form-group">
                                                                <label for="amountEsr1">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' id="amountEsr1" step="0.01" name="amountEsr[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 rccEsrToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addEsr" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="esrDiv" class="rccEsrToggle">
                                                        
                                                    </div>
                                                    
                                                    <?php
                                                    } 
                                                    
                                                    ?>
                                                    <hr class="accessory">
                                                    <?php
                                                    
                                                    //
                                                    //Distribution System
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System' ");
                                                        if(mysqli_num_rows($query) <=0 ){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="distributionSystem" id="distributionSystem" value="stepFour"> </span><label for="distributionSystem">Distribution System</label></h4>
                                                        <h6 class="distributionSystemToggle"><span class="serialDistribution"> Distribution System</span></h6>
                                                        <div class="col-md-2 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="diameterDistribution">Diameter (in mm) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $diameterDistribution ?>" id="diameterDistribution" name="diameterDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="typePipeDistribution">Pipe Type</label>
                                                                <?php
                                                                $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                ?>
                                                                <select class="form-control" <?php echo $readonly ?> id="typePipeDistribution" name="typePipeDistribution[]">
                                                                    <option selected="" disabled=""></option>
                                                                    <?php 
                                                                    foreach ($typePipeArray as $typePipe){
                                                                        if($typePipe == $typePipeDistribution){
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        }
                                                                    ?>
                                                                    <option <?php echo $selected ?>><?php echo $typePipe ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="lengthDistribution">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthDistribution ?>" id="lengthDistribution"  name="lengthDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="amountDistribution">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountDistribution" value="<?php echo $amountDistribution ?>"  name="amountDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-1 distributionSystemToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addDistribution" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div id="distributionDiv" class="distributionSystemToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $distributionSystem = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $diameterDistribution = $result['diameter'];
                                                            $typePipeDistribution = $result['typePipe'];
                                                            $lengthDistribution = $result['length'];
                                                            $amountDistribution = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='distributionSystemId[]' value='".$id."'>";
                                                            
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="distributionSystem" id="distributionSystem" value="stepFour"> </span><label for="distributionSystem">Distribution System</label></h4>
                                                        <h6 class="distributionSystemToggle"><span class="serialDistribution"> Distribution System</span></h6>
                                                        <div class="col-md-2 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="diameterDistribution<?php echo $i ?>">Diameter (in mm) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $diameterDistribution ?>" id="diameterDistribution<?php echo $i ?>" name="diameterDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="typePipeDistribution<?php echo $i ?>">Pipe Type</label>
                                                                <?php
                                                                $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                ?>
                                                                <select class="form-control" <?php echo $readonly ?> id="typePipeDistribution<?php echo $i ?>" name="typePipeDistribution[]">
                                                                    <option selected="" disabled=""></option>
                                                                    <?php 
                                                                    foreach ($typePipeArray as $typePipe){
                                                                        if($typePipe == $typePipeDistribution){
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        }
                                                                    ?>
                                                                    <option <?php echo $selected ?>><?php echo $typePipe ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="lengthDistribution<?php echo $i ?>">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthDistribution ?>" id="lengthDistribution<?php echo $i ?>"  name="lengthDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="amountDistribution<?php echo $i ?>">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountDistribution<?php echo $i ?>" value="<?php echo $amountDistribution ?>"  name="amountDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-1 distributionSystemToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addDistribution" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <?php
                                                            } else {
                                                    ?>
                                                    <div id="distributionDiv" class="distributionSystemToggle">
                                                        <div class="row">
                                                            <h6><span class="serialDistribution"> Distribution System</span></h6>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="diameterDistribution<?php echo $i ?>">Diameter (in mm) </label>
                                                                    <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $diameterDistribution ?>" id="diameterDistribution<?php echo $i ?>" name="diameterDistribution[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="typePipeDistribution<?php echo $i ?>">Pipe Type</label>
                                                                    <?php
                                                                    $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                    ?>
                                                                    <select class="form-control" <?php echo $readonly ?> id="typePipeDistribution[]" name="typePipeDistribution[]">
                                                                        <option selected="" disabled=""></option>
                                                                        <?php 
                                                                        foreach ($typePipeArray as $typePipe){
                                                                            if($typePipe == $typePipeDistribution){
                                                                                $selected = "selected";
                                                                            } else {
                                                                                $selected = "";
                                                                            }
                                                                        ?>
                                                                        <option <?php echo $selected ?>><?php echo $typePipe ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="lengthDistribution<?php echo $i ?>">Length (in m) </label>
                                                                    <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthDistribution ?>" id="lengthDistribution<?php echo $i ?>"  name="lengthDistribution[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="amountDistribution<?php echo $i ?>">Sanctioned Cost</label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountDistribution<?php echo $i ?>" value="<?php echo $amountDistribution ?>"  name="amountDistribution[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-1 marg_1" >
                                                                <div class="form-group" style="margin-bottom:0px">
                                                                    <button type='button' class='btn removeEsr' id='removeEsr' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            if($showDate == true){
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            $i++;    
                                                        }
                                                        if($i == 2){
                                                        ?>
                                                        <div id="distributionDiv" class="distributionSystemToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                    } else { 
                                                    
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="distributionSystem" id="distributionSystem" value="stepFour"> </span><label for="distributionSystem">Distribution System</label></h4>
                                                        <h6 class="distributionSystemToggle"><span class="serialDistribution"> Distribution System</span></h6>
                                                        <div class="col-md-2 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="diameterDistribution">Diameter (in mm) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $diameterDistribution ?>" id="diameterDistribution" name="diameterDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-2 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="typePipeDistribution">Pipe Type</label>
                                                                <?php
                                                                $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI');
                                                                ?>
                                                                <select class="form-control" <?php echo $readonly ?> id="typePipeDistribution" name="typePipeDistribution[]">
                                                                    <option selected="" disabled=""></option>
                                                                    <?php 
                                                                    foreach ($typePipeArray as $typePipe){
                                                                        if($typePipe == $typePipeDistribution){
                                                                            $selected = "selected";
                                                                        } else {
                                                                            $selected = "";
                                                                        }
                                                                    ?>
                                                                    <option <?php echo $selected ?>><?php echo $typePipe ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="lengthDistribution">Length (in m) </label>
                                                                <input type="number" class="form-control" step="0.01" <?php echo $readonly ?> value="<?php echo $lengthDistribution ?>" id="lengthDistribution"  name="lengthDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3 distributionSystemToggle">
                                                            <div class="form-group">
                                                                <label for="amountDistribution">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' step="0.01" <?php echo $readonly ?> id="amountDistribution" value="<?php echo $amountDistribution ?>"  name="amountDistribution[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-1 distributionSystemToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addDistribution" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div id="distributionDiv" class="distributionSystemToggle">
                                                        
                                                    </div>
                                                    
                                                    <?php
                                                    }
                                                    
                                                    ?>
                                                    <hr class="accessory">
                                                    <?php
                                                    //
                                                    //MSEDC Work
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work' ");
                                                        
                                                        if(mysqli_num_rows($query) <=0 ){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="msedcWork" id="msedcWork" value="stepFive"> </span><label for="msedcWork">MSEDC Work</label></h4>
                                                        <h6 class="msedcWorkToggle"><span class="serialMsedc"> MSEDC Work</span></h6>
                                                        <div class="col-md-4 msedcWorkToggle">
                                                            <div class="form-group">
                                                                <label for="amountMsedc">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" v value="<?php echo $amountMsedc ?>" id="amountMsedc" name="amountMsedc[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 msedcWorkToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addMsedc" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="msedcDiv" class="msedcWorkToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $msedcWork = true;
                                                        }
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $amountMsedc = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='msedcWorkId[]' value='".$id."'>";
                                                            
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="msedcWork" id="msedcWork" value="stepFive"> </span><label for="msedcWork">MSEDC Work</label></h4>
                                                        <h6 class="msedcWorkToggle"><span class="serialMsedc"> MSEDC Work</span></h6>
                                                        <div class="col-md-4 msedcWorkToggle">
                                                            <div class="form-group">
                                                                <label for="amountMsedc">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" v value="<?php echo $amountMsedc ?>" id="amountMsedc" name="amountMsedc[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 msedcWorkToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addMsedc" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            } else {
                                                    ?>
                                                    <div id="msedcDiv" class="msedcWorkToggle">
                                                        <div class="row">
                                                            <h6><span class="serialMsedc"> MSEDC Work</span></h6>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="amountMsedc">Sanctioned Cost</label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" v value="<?php echo $amountMsedc ?>" id="amountMsedc" name="amountMsedc[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4 marg_1" >
                                                                <div class="form-group" style="margin-bottom:0px">
                                                                    <button type='button' class='btn removeMsedc' id='removeMsedc' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            
                                                            if($showDate == true){
                                                            ?>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                            <?php
                                                            }
                                                            $i++;
                                                        }
                                                        if($i == 2){
                                                        ?>
                                                        <div id="msedcDiv" class="msedcWorkToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                    } else {
                                                    ?>
                                                    
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="msedcWork" id="msedcWork" value="stepFive"> </span><label for="msedcWork">MSEDC Work</label></h4>
                                                        <h6 class="msedcWorkToggle"><span class="serialMsedc"> MSEDC Work</span></h6>
                                                        <div class="col-md-4 msedcWorkToggle">
                                                            <div class="form-group">
                                                                <label for="amountMsedc">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' <?php echo $readonly ?> step="0.01" v value="<?php echo $amountMsedc ?>" id="amountMsedc" name="amountMsedc[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 msedcWorkToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addMsedc" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="msedcDiv" class="msedcWorkToggle">
                                                        
                                                    </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <hr class="accessory">
                                                    <?php
                                                    
                                                    //
                                                    //Trial & Run
                                                    //
                                                    if(isset($_GET['yojanaId'])){
                                                        $i = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Trial & Run' ");
                                                        
                                                        if(mysqli_num_rows($query) <=0 ){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="trialRun" id="trialRun" value="stepFive"> </span><label for="trialRun">Trial & Run</label></h4>
                                                        <h6 class="trialRunToggle"><span class="serialTrial"> Trial & Run</span></h6>
                                                        <div class="col-md-4 trialRunToggle">
                                                            <div class="form-group">
                                                                <label for="monthTrial">Months</label>
                                                                <input type="number" step="0.1" id="monthTrial" <?php echo $readonly ?> value="<?php echo $monthTrial ?>" class="form-control" name="monthTrial[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 trialRunToggle">
                                                            <div class="form-group">
                                                                <label for="amountTrial">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' id="amountTrial" <?php echo $readonly ?> value="<?php echo $amountTrial ?>" step="0.01" name="amountTrial[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 trialRunToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addTrial" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="trialDiv" class="trialRunToggle">
                                                        
                                                    </div>
                                                    <?php
                                                        } else {
                                                            $trialRun = true;
                                                        }
                                                        
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $monthTrial = $result['month'];
                                                            $amountTrial = $result['actualPrice'];
                                                            $plannedDate = $result['plannedDate'];
                                                            $actualDate = $result['actualDate'];
                                                            $plannedEndDate = $result['plannedEndDate'];
                                                            $actualEndDate = $result['actualEndDate'];
                                                            $id = $result['id']; 
                                                            echo "<input type='hidden' name='subWorkId[]' value='".$id."'>";
                                                            echo "<input type='hidden' name='trialRunId[]' value='".$id."'>";
                                                            
                                                            if($i == 1){
                                                    ?>
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="trialRun" id="trialRun" value="stepFive"> </span><label for="trialRun">Trial & Run</label></h4>
                                                        <h6 class="trialRunToggle"><span class="serialTrial"> Trial & Run</span></h6>
                                                        <div class="col-md-4 trialRunToggle">
                                                            <div class="form-group">
                                                                <label for="monthTrial">Months</label>
                                                                <input type="number" step="0.1" id="monthTrial" <?php echo $readonly ?> value="<?php echo $monthTrial ?>" class="form-control" name="monthTrial[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 trialRunToggle">
                                                            <div class="form-group">
                                                                <label for="amountTrial">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' id="amountTrial" <?php echo $readonly ?> value="<?php echo $amountTrial ?>" step="0.01" name="amountTrial[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 trialRunToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addTrial" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php            
                                                            } else {
                                                    ?>
                                                    <div id="trialDiv" class="trialRunToggle">
                                                        <div class="row">
                                                            <h6><span class="serialTrial"> Trial & Run</span></h6>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="monthTrial">Months</label>
                                                                    <input type="number" step="0.1" id="monthTrial" <?php echo $readonly ?> value="<?php echo $monthTrial ?>" class="form-control" name="monthTrial[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="amountTrial">Sanctioned Cost</label>
                                                                    <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' id="amountTrial" <?php echo $readonly ?> value="<?php echo $amountTrial ?>" step="0.01" name="amountTrial[]">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4 marg_1" >
                                                                <div class="form-group" style="margin-bottom:0px">
                                                                    <button type='button' class='btn removeTrial' id='removeTrial' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            if($showDate == true){
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedDate ?>" name="plannedDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Planned End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $plannedEndDate ?>" name="plannedEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual Start Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualDate ?>" name="actualDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Actual End Date</label>
                                                                <input type="date" class="form-control secDate" value="<?php echo $actualEndDate ?>" name="actualEndDate<?php echo $id ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                            }
                                                            $i++;
                                                        }
                                                        
                                                        if($i == 2){
                                                        ?>
                                                        <div id="trialDiv" class="trialRunToggle">
                                                        </div>
                                                        <?php
                                                        }
                                                        
                                                    } else {
                                                    ?>
                                                    
                                                    
                                                    <div class="row">
                                                        <h4 class="card-title"><span><input type="checkbox" name="trialRun" id="trialRun" value="stepFive"> </span><label for="trialRun">Trial & Run</label></h4>
                                                        <h6 class="trialRunToggle"><span class="serialTrial"> Trial & Run</span></h6>
                                                        <div class="col-md-4 trialRunToggle">
                                                            <div class="form-group">
                                                                <label for="monthTrial">Months</label>
                                                                <input type="number" step="0.1" id="monthTrial" <?php echo $readonly ?> value="<?php echo $monthTrial ?>" class="form-control" name="monthTrial[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 trialRunToggle">
                                                            <div class="form-group">
                                                                <label for="amountTrial">Sanctioned Cost</label>
                                                                <input type="number" class="form-control sanctionedCost" onkeyup='sanctionedCostFun()' id="amountTrial" <?php echo $readonly ?> value="<?php echo $amountTrial ?>" step="0.01" name="amountTrial[]">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 trialRunToggle marg_1" >
                                                            <div class="form-group" style="margin-bottom:0px">
                                                                <button type="button" class="btn " id="addTrial" style="padding:0px;">
                                                                    <i class="mdi mdi-plus-circle addBtn" style="font-size: 2.5rem;color: green;"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="trialDiv" class="trialRunToggle">
                                                        
                                                    </div>
                                                    
                                                    <?php 
                                                    }
                                                    ?>
                                                    <hr class="accessory">
                                                    
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Total Cost</label>
                                                                <input type="text" readonly="" class="form-control" name="totalSanctionedCost" id="totalCost">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>GST</label>
                                                                <select name="gst" id="gst" class="form-control" onchange="finialCost()" required>
                                                                    <option disabled="" selected="">Select GST</option>
                                                                    <option value="12" <?php if($gst == "12"){ echo "selected"; } ?>>12 %</option>
                                                                    <option value="18" <?php if($gst == "18"){ echo "selected"; } ?>>18 %</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="card-title">Finial Cost</label>
                                                                <input type="text" readonly="" class="form-control" id="finialCurrentCost">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr class="tablehead table-striped">
                                                                    <th></th>
                                                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year - Population&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                    <?php
                                                                    if($mobile != true){
                                                                    ?>
                                                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year - Population &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year - Population &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                                    <!--<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year - Population &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>-->
                                                                    <?php 
                                                                    }
                                                                    ?>
                                                                </tr>
                                                                <?php
                                                                $query = mysqli_query($con, "SELECT * FROM subWorkMaster WHERE type = 'date'");
                                                                while($result = mysqli_fetch_assoc($query)){
                                                                    $id = $result['id'];
                                                                    $subWork = $result['subWork'];
                                                                    
                                                                    if($mobile == true){
                                                                        $explode = explode( "-", $subWork);
                                                                        $subWork = $explode[0]."<br><br>-".$explode[1];
                                                                    }
                                                                    
                                                                    
                                                                    if($id == 14){
                                                                        $value = "Year - Population";
                                                                    } else {
                                                                        $value = "Year - Demand";
                                                                    }
                                                                    
                                                                    if(isset($_GET['yojanaId'])){
                                                                        $yojanaId = $_GET['yojanaId'];
                                                                        $q = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = '$value'") or die($con->error);
                                                                        $r = mysqli_fetch_assoc($q);
                                                                        $yearPopulation1 = $r['yearPopulation1'];
                                                                        $yearPopulation2 = $r['yearPopulation2'];
                                                                        $yearPopulation3 = $r['yearPopulation3'];
                                                                        $yearPopulation4 = $r['yearPopulation4'];
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $subWork; ?>
                                                                            <input type="hidden" value="<?php echo $id ?>" name="subWorkId[]"> 
                                                                        </td>
                                                                        <td >
                                                                            <input type="text" <?php echo $readonly ?>  name="yearPopulation1<?php echo $id ?>" value="<?php echo $yearPopulation1 ?>" class="form-control" placeholder="<?php echo $value ?> ">
                                                                            <?php
                                                                            if($mobile == true){
                                                                            ?>
                                                                            <br>
                                                                            <input type="text" <?php echo $readonly ?> name="yearPopulation2<?php echo $id ?>" value="<?php echo $yearPopulation2 ?>"  class="form-control" placeholder="<?php echo $value ?> ">
                                                                            <br>
                                                                            <input type="text" <?php echo $readonly ?> name="yearPopulation3<?php echo $id ?>" value="<?php echo $yearPopulation3 ?>"  class="form-control" placeholder="<?php echo $value ?> ">
                                                                            <br>
                                                                            <!--<input type="text" <?php echo $readonly ?> name="yearPopulation4<?php echo $id ?>" value="<?php echo $yearPopulation4 ?>"  class="form-control" placeholder="<?php echo $value ?> ">-->
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <?php
                                                                        if($mobile != true){
                                                                        ?>
                                                                        <td >
                                                                            <input type="text" <?php echo $readonly ?> name="yearPopulation2<?php echo $id ?>" value="<?php echo $yearPopulation2 ?>"  class="form-control" placeholder="<?php echo $value ?> ">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" <?php echo $readonly ?> name="yearPopulation3<?php echo $id ?>" value="<?php echo $yearPopulation3 ?>"  class="form-control" placeholder="<?php echo $value ?> ">
                                                                        </td>
                                                                        <!--<td>
                                                                            <input type="text" <?php echo $readonly ?> name="yearPopulation4<?php echo $id ?>" value="<?php echo $yearPopulation4 ?>"  class="form-control" placeholder="<?php echo $value ?> ">
                                                                        </td>-->
                                                                        <?php 
                                                                        }
                                                                        ?>
                                                                        </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <h4 class="card-title mt-2"> Other documents</h4>
                                                    <div class="container">
                                                        <div class="row">  
                                                            <div class="col-md-4 pd-0">
                                                                <div class="col-md-6 hide">
                                                                    <div class="form-group">
                                                                        <label for="docName">Document Name </label>
                                                                        <input type="text"  <?php echo $readonly ?> class="form-control" value="Source Certificate" id="docName" name="docName[]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 ">
                                                                    <div class="form-group">
                                                                        <label>Source Certificate-</label>
                                                                        <input type="file" <?php echo $readonly ?> name="photo[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf,.pdf" class="form-control" />
                                                                        <?php
                                                                        if($showFile == true){
                                                                            $q = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND docName = 'Source Certificate'");
                                                                            $r = mysqli_fetch_assoc($q);
                                                                            
                                                                            if($r['document'] != ""){
                                                                            ?>
                                                                            Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r['document'] ?>"> <?php echo $r['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4 pd-0">
                                                                <div class="col-md-6 hide">
                                                                    <div class="form-group">
                                                                        <label for="docName">Document Name </label>
                                                                        <input type="text" <?php echo $readonly ?> class="form-control" value="Google Map" id="docName" name="docName[]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Google Map</label>
                                                                        <input type="file" <?php echo $readonly ?> name="photo[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control" />
                                                                        <?php
                                                                        if($showFile == true){
                                                                            $q = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND docName = 'Google Map'");
                                                                            $r = mysqli_fetch_assoc($q);
                                                                            
                                                                            if($r['document'] != ""){
                                                                            ?>
                                                                            Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r['document'] ?>"> <?php echo $r['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--<div class="row col-md-4">
                                                                <div class="col-md-6 hide">
                                                                    <div class="form-group">
                                                                        <label for="docName">Document Name </label>
                                                                        <input type="text" <?php echo $readonly ?> class="form-control" value="ग्रा. पं. ठराव" id="docName" name="docName[]">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>ग्रा. पं. ठराव</label>
                                                                        <input type="file" <?php echo $readonly ?> name="photo[]" accept=".jpeg,.jpg,.png,.pptx,.xls,.xlsx,.docx,.pdf" class="form-control" />
                                                                        <?php
                                                                        if($show == true){
                                                                            $q = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND docName = 'ग्रा. पं. ठराव'");
                                                                            $r = mysqli_fetch_assoc($q);
                                                                            
                                                                            if($r['document'] != ""){
                                                                            ?>
                                                                            Your Selected File is <a <?php echo $file ?> href="uploadedDoc/<?php echo $r['document'] ?>"> <?php echo $r['document'] ?> <i class="bi bi-arrow-right"></i></a>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>-->
                                                       </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="amountMsedcId">
                                                <br>
                                                <button type="submit" name="submit" class="btn btn-primary me-2"> Submit </button>
                                                <!--<button class="btn btn-light" type="button">Cancel</button>-->
                                            </form>
                                        </div>
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
    
    <!--<script src="js/custom.js?v=1.0.05"></script>-->
    
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
    
        $("#exectedStartDate").on('change', function(){
            $("#expectedDate").attr('min', $(this).val());
        })
    
        function secDateFun(){
            var arr = $('.secDate').map(function () {
                
                if($(this).val() == ""){
                    $(this).css('border-color', 'red');
                } else {
                    $(this).css('border-color', 'green');
                }
            }).get();
        }
        
        <?php 
        if($showDate == true){
        ?>
        
        secDateFun();
        
        $('.secDate').on('change', function(){
            secDateFun();
        })
        <?php
        }
        ?>
        
        var amountMsedc = 0;
        function sanctionedCostFun(){
            var total = 0;
            var amountMsedc = 0;
            var arr = $('.sanctionedCost').map(function () {
                
                // console.log($(this).data('per'));
                // console.log($(this).attr("name"));
                if($(this).attr("name") == "amountMsedc[]"){
                    amountMsedc = amountMsedc + Number($(this).val())
                }
                total = total + Number($(this).val());
                
            }).get();
            
            $("#totalCost").val(total);
            $("#amountMsedcId").val(amountMsedc);
            finialCost(amountMsedc);
            
        }
        sanctionedCostFun();
        
        
        function finialCost(amountMsedc){
            // console.log("finial Cost"+amountMsedc);
            var amountMsedc = $("#amountMsedcId").val();
            gst = $("#gst").val();
            var totalCurrentCost = parseInt($("#totalCost").val()) - amountMsedc;
            var finialCurrentCost = (totalCurrentCost * gst)/100;
            finialCurrentCost = finialCurrentCost + totalCurrentCost;
            $("#finialCurrentCost").val(finialCurrentCost);
        }
        
        /*function sanctionedCostFun(){
            var total = 0;
            var arr = $('.sanctionedCost').map(function () {
                total = total + Number($(this).val());
                // console.log($(this).data('per'));
                
            }).get();
            console.log(total);
            $("#totalCost").val(total);
            finialCost();
            
        }
        sanctionedCostFun();
        
        
        function finialCost(){
            gst = $("#gst").val();
            var totalCurrentCost = parseInt($("#totalCost").val());
            var finialCurrentCost = (totalCurrentCost * gst)/100;
            finialCurrentCost = finialCurrentCost + totalCurrentCost;
            $("#finialCurrentCost").val(finialCurrentCost);
        }*/
        
        
        
        //
        var count = 4;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var type = $('#element').val();
                // $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>दस्तऐवजाचा प्रकार </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='img[]' class='file-upload-default' /><div class='input-group col-xs-12'><input type='text' class='form-control file-upload-info' disabled placeholder='Upload Image' /><span class='input-group-append'> <button class='file-upload-browse btn btn-primary' type='button'> Upload </button></span></div></div></div>");
                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>Document Name </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='document[]' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx,.pdf' class='form-control' /></div></div></div>");
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
            if (count > 4) {
                $("#textboxDiv").children().last().remove();
                count = count - 1;
                count2 = count - 1;
                // document.getElementById("total_member").value = count2;
                $("#add").show();
                if (count == 4) {
                    $("#remove").hide();
                }
            } else {
                $("#remove").hide();
            }
        });
        
        
        //
        //Trial Bore
        //
        
        var countTrial = 1;
        // $("#remove").hide();
        $("#addTrial").on("click", function on() {
            if (countTrial <= 4) {
                var type = $('#element').val();
                $("#trialDiv").append("<div class='row' id='newTrial"+countPercolation+"'><h6><span class='serialTrial'> Trial Bore</span></h6><div class='col-md-3'><div class='form-group'><label for='depthTrial'>Depth (in m) </label><input type='number' class='form-control'  step='0.01' name='depthPercolation[]' ></div></div><div class='col-md-3'><div class='form-group'><label for='diameterTrial'>Diameter (in m) </label><input type='number' class='form-control'  step='0.01' id='diameterTrial' name='diameterPercolation[]' ></div></div><div class='col-md-3'><div class='form-group'><label for='amountTrialBore'>Sanctioned Cost</label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()'  step='0.01' id='amountTrialBore' name='amountTrialBore[]' ></div></div><div class='col-md-3 marg_1'><div class='form-group' style='margin-bottom:0px'><button type='button' class='btn removeTrial' data-id='"+countPercolation+"'  id='removeTrial' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countTrial = countTrial + 1;
                
                if (countTrial - 1 == 4) {
                    $("#addTrial").hide();
                } else {
                    $("#addTrial").show();
                }
            }
        });

        $("#trialDiv").on('click', '#removeTrial', function () {
            $("#addTrial").show();
            $(this).closest('.row').remove();
            countTrial = countTrial - 1;
        });
        
        
        $("#trialBore").on('click', function(){
            $(".trialBoreToggle").toggle();
        });
        
        <?php 
        if($trialBore == true){
            echo '$("#trialBore").click();';
        }
        ?>
        
        //
        //Percolation Well
        //
        
        var countPercolation = 1;
        // $("#remove").hide();
        $("#addPercolation").on("click", function on() {
            if (countPercolation <= 4) {
                var type = $('#element').val();
                $("#percolationDiv").append("<div class='row' id='newPercolation"+countPercolation+"'><h6><span class='serialPercolation'> Percolation Well</span></h6><div class='col-md-3'><div class='form-group'><label for='depthPercolation'>Depth (in m) </label><input type='number' class='form-control'  step='0.01' name='depthPercolation[]' ></div></div><div class='col-md-3'><div class='form-group'><label for='diameterPercolation'>Diameter (in m) </label><input type='number' class='form-control'  step='0.01' id='diameterPercolation' name='diameterPercolation[]' ></div></div><div class='col-md-3'><div class='form-group'><label for='amountPercolation'>Sanctioned Cost</label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()'  step='0.01' id='amountPercolation' name='amountPercolation[]' ></div></div><div class='col-md-3 marg_1'><div class='form-group' style='margin-bottom:0px'><button type='button' class='btn removePercolation' data-id='"+countPercolation+"'  id='removePercolation' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countPercolation = countPercolation + 1;
                
                if (countPercolation - 1 == 4) {
                    $("#addPercolation").hide();
                } else {
                    $("#addPercolation").show();
                }
            }
        });

        $("#percolationDiv").on('click', '#removePercolation', function () {
            $("#addPercolation").show();
            $(this).closest('.row').remove();
            countPercolation = countPercolation - 1;
        });
        
        
        $("#percolationWell").on('click', function(){
            $(".percolationWellToggle").toggle();
        });
        
        <?php 
        if($percolationWell == true){
            echo '$("#percolationWell").click();';
        }
        ?>
        
        
        //
        //Approach Bund
        //
        var countApproach = 1;
        // $("#remove").hide();
        $("#addApproach").on("click", function on() {
            if (countApproach <= 4) {
                var type = $('#element').val();
                $("#approachDiv").append("<div class='row' id='newApproach"+countApproach+"'><h6><span class='serialApproach'> Approach Bund</span></h6><div class='col-md-4'><div class='form-group'><label for='lengthApproach"+countApproach+"'>Length (in m) </label><input type='number' class='form-control' step='0.01' id='lengthApproach"+countApproach+"' name='lengthApproach[]' ></div></div><div class='col-md-4'><div class='form-group'><label for='amountApproach"+countApproach+"'>Sanctioned Cost</label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()' step='0.01' id='amountApproach"+countApproach+"' name='amountApproach[]'> </div></div><div class='col-md-4 marg_1'><div class='form-group' style='margin-bottom:0px'><button type='button' class='btn removeApproach' data-id='"+countApproach+"'  id='removeApproach' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countApproach = countApproach + 1;
                
                if (countApproach - 1 == 4) {
                    $("#addApproach").hide();
                } else {
                    $("#addApproach").show();
                }
            }
        });

        $("#approachDiv").on('click', '#removeApproach', function () {
            $("#addApproach").show();
            $(this).closest('.row').remove();
            countApproach = countApproach - 1;
        });
        
        $("#approachBund").on('click', function(){
            $(".approachBundToggle").toggle();
        });
        
        <?php 
        if($approachBund == true){
            echo '$("#approachBund").click();';
        }
        ?>
        
        
        //
        //Pumping Machinery
        //
        var countPumping = 1;
        // $("#remove").hide();
        $("#addPumping").on("click", function on() {
            if (countPumping <= 4) {
                var type = $('#element').val();
                $("#pumpingDiv").append("<div class='row' id='newPumping"+countPumping+"'><h6><span class='serialPumping'> Pumping Machinery</span></h6><div class='col-md-5'><div class='form-group'><label for='bhpPumping1'>Power (bhp) </label><input type='number' class='form-control' step='0.01' id='bhpPumping1' name='bhpPumping[]'></div></div><div class='col-md-5'><div class='form-group'><label for='amountPumping1'>Sanctioned Cost </label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()' step='0.01' id='amountPumping1' name='amountPumping[]'></div></div><div class='col-md-2 marg_1' ><div class='form-group'><button type='button' class='btn removePumping' data-id='"+countPumping+"' id='removePumping' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countPumping = countPumping + 1;
                
                if (countPumping - 1 == 4) {
                    $("#addPumping").hide();
                } else {
                    $("#addPumping").show();
                }
            }
        });

        $("#pumpingDiv").on('click', '#removePumping', function () {
            $("#addPumping").show();
            $(this).closest('.row').remove();
            countPumping = countPumping - 1;
        });
        
        $("#pumpingMachinery").on('click', function(){
            $(".pumpingMachineryToggle").toggle();
        });
        
        <?php 
        if($pumpingMachinery == true){
            echo '$("#pumpingMachinery").click();';
        }
        ?>
        
        //
        //Switch Room
        //
        var countSwitch = 1;
        // $("#remove").hide();
        $("#addSwitch").on("click", function on() {
            if (countSwitch <= 4) {
                var type = $('#element').val();
                $("#switchDiv").append("<div class='row' id='newSwitch"+countSwitch+"'><h6><span class='serialSwitch'> Switch Room</span></h6><div class='col-md-5'><div class='form-group'><label for='amountSwitch1'>Sanctioned Cost </label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()' step='0.01' id='amountSwitch1' name='amountSwitch[]'></div></div><div class='col-md-2 marg_1' ><div class='form-group'><button type='button' class='btn removeSwitch' data-id='"+countSwitch+"' id='removeSwitch' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countSwitch = countSwitch + 1;
                
                if (countSwitch - 1 == 4) {
                    $("#addSwitch").hide();
                } else {
                    $("#addSwitch").show();
                }
            }
        });

        $("#switchDiv").on('click', '#removeSwitch', function () {
            $("#addSwitch").show();
            $(this).closest('.row').remove();
            countSwitch = countSwitch - 1;
        });
        
        $("#switchRoom").on('click', function(){
            $(".switchRoomToggle").toggle();
        });
        
        <?php 
        if($switchRoom == true){
            echo '$("#switchRoom").click();';
        }
        ?>
        
        
        //
        //RCC ESR
        //
        var countEsr = 1;
        // $("#remove").hide();
        $("#addEsr").on("click", function on() {
            if (countEsr <= 4) {
                var type = $('#element').val();
                $("#esrDiv").append("<div class='row' id='newRising"+countEsr+"'><h6><span class='serialEsr'> RCC  ESR</span></h6><div class='col-md-5'><div class='form-group'><label for='capacityEsr1'>Capacity (in ltr) </label><input type='number' class='form-control' id='capacityEsr1' step='0.01' name='capacityEsr[]'></div></div><div class='col-md-5'><div class='form-group'><label for='amountEsr1'>Sanctioned Cost</label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()' id='amountEsr1' step='0.01' name='amountEsr[]'></div></div><div class='col-md-2 marg_1' ><div class='form-group'><button type='button' class='btn removeEsr' data-id='"+countEsr+"' id='removeEsr' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countEsr = countEsr + 1;
                
                if (countEsr - 1 == 4) {
                    $("#addRising").hide();
                } else {
                    $("#addRising").show();
                }
            }
        });

        $("#esrDiv").on('click', '#removeEsr', function () {
            $("#addRising").show();
            $(this).closest('.row').remove();
            countEsr = countEsr - 1;
        });
        
        $("#rccEsr").on('click', function(){
            $(".rccEsrToggle").toggle();
        });
        
        <?php 
        if($rccEsr == true){
            echo '$("#rccEsr").click();';
        }
        ?>
        
        
        //
        //Rising Main
        //
        var countRising = 1;
        // $("#remove").hide();
        $("#addRising").on("click", function on() {
            if (countRising <= 4) {
                var type = $('#element').val();
                $("#risingDiv").append("<div class='row' id='newRising"+countRising+"'><h6><span class='serialRising'> Rising Main</span></h6><div class='col-md-2'><div class='form-group'><label for='diameterRising1'>Diameter (in mm) </label><input type='number' class='form-control' step='0.01' id='diameterRising1' name='diameterRising[]'></div></div><div class='col-md-2'><div class='form-group'><label for='diameterRising1'>Pipe Type</label><?php $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI'); ?><select class='form-control' name='typePipeRising[]'><option selected='' disabled=''></option><?php foreach ($typePipeArray as $typePipe){ ?><option><?php echo $typePipe ?></option><?php } ?></select></div></div><div class='col-md-2'><div class='form-group'><label for='kg_cmRising1'> (in kg/cm<sup>2</sup>) </label><input type='number' class='form-control' step='0.01' id='kg_cmRising1' name='kg_cmRising[]'></div></div><div class='col-md-2'><div class='form-group'><label for='lengthRising1'>Length (in m) </label><input type='number' class='form-control' step='0.01' id='lengthRising1' name='lengthRising[]'></div></div><div class='col-md-2'><div class='form-group'><label for='amountRising1'>Sanctioned Cost </label><input type='number' class='form-control sanctionedCost' step='0.01' onkeyup='sanctionedCostFun()' id='amountRising1' name='amountRising[]'></div></div><div class='col-md-2 marg_1' ><div class='form-group'><button type='button' class='btn removeRising' data-id='"+countRising+"' id='removeRising' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countRising = countRising + 1;
                
                if (countRising - 1 == 4) {
                    $("#addRising").hide();
                } else {
                    $("#addRising").show();
                }
            }
        });

        $("#risingDiv").on('click', '#removeRising', function () {
            $("#addRising").show();
            $(this).closest('.row').remove();
            countRising = countRising - 1;
        });
        
        $("#risingMain").on('click', function(){
            $(".risingMainToggle").toggle();
        });
        
        <?php 
        if($risingMain == true){
            echo '$("#risingMain").click();';
        }
        ?>
        
        
        //
        //Distribution System
        //
        
        var countDistribution = 1;
        // $("#remove").hide();
        $("#addDistribution").on("click", function on() {
            if (countDistribution <= 4) {
                var type = $('#element').val();
                $("#distributionDiv").append("<div class='row' id='newDistribution"+countDistribution+"'><h6><span class='serialDistribution'> Distribution System</span></h6><div class='col-md-2'><div class='form-group'><label for='diameterDistribution"+countDistribution+"'>Diameter (in mm) </label><input type='number' class='form-control' step='0.01' id='diameterDistribution"+countDistribution+"' name='diameterDistribution[]'></div></div><div class='col-md-2'><div class='form-group'><label for='typePipeDistribution"+countDistribution+"'>Pipe Type</label><?php $typePipeArray = array('PVC', 'HDPE', 'GI', 'DI'); ?><select class='form-control' id='typePipeDistribution[]' name='typePipeDistribution[]'><option selected='' disabled=''></option><?php foreach ($typePipeArray as $typePipe){ ?><option <?php echo $selected ?>><?php echo $typePipe ?></option><?php } ?></select></div></div><div class='col-md-3'><div class='form-group'><label for='lengthDistribution"+countDistribution+"'>Length (in m) </label><input type='number' class='form-control' step='0.01' id='lengthDistribution"+countDistribution+"'  name='lengthDistribution[]'></div></div><div class='col-md-3'><div class='form-group'><label for='amountDistribution"+countDistribution+"'>Sanctioned Cost</label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()' step='0.01' id='amountDistribution"+countDistribution+"' name='amountDistribution[]'></div></div><div class='col-md-1 marg_1' ><div class='form-group' style='margin-bottom:0px'><button type='button' class='btn removeDistribution' id='removeDistribution' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countDistribution = countDistribution + 1;
                
                if (countDistribution - 1 == 4) {
                    $("#addDistribution").hide();
                } else {
                    $("#addDistribution").show();
                }
            }
        });

        $("#distributionDiv").on('click', '#removeDistribution', function () {
            $("#addDistribution").show();
            $(this).closest('.row').remove();
            countDistribution = countDistribution - 1;
        });
        
        $("#distributionSystem").on('click', function(){
            $(".distributionSystemToggle").toggle();
        });
        
        <?php 
        if($distributionSystem == true){
            echo '$("#distributionSystem").click();';
        }
        ?>
        
        
        //
        //MSEDC Work
        //
        var countMsedc = 1;
        // $("#remove").hide();
        $("#addMsedc").on("click", function on() {
            if (countMsedc <= 4) {
                var type = $('#element').val();
                $("#msedcDiv").append("<div class='row' id='newMsedc"+countMsedc+"'><h6><span class='serialMsedc'> MSEDC Work</span></h6><div class='col-md-4'><div class='form-group'><label for='amountMsedc"+countMsedc+"'>Sanctioned Cost</label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()' step='0.01' id='amountMsedc"+countMsedc+"' name='amountMsedc[]'></div></div><div class='col-md-4 marg_1' ><div class='form-group' style='margin-bottom:0px'><button type='button' class='btn removeMsedc' id='removeMsedc' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countMsedc = countMsedc + 1;
                
                if (countMsedc - 1 == 4) {
                    $("#addMsedc").hide();
                } else {
                    $("#addMsedc").show();
                }
            }
        });

        $("#msedcDiv").on('click', '#removeMsedc', function () {
            $("#addMsedc").show();
            $(this).closest('.row').remove();
            countMsedc = countMsedc - 1;
        });
        
        $("#msedcWork").on('click', function(){
            $(".msedcWorkToggle").toggle();
        });
        
        <?php 
        if($msedcWork == true){
            echo '$("#msedcWork").click();';
        }
        ?>
        
        
        //
        //Trial Work
        //
        var countTrial = 1;
        // $("#remove").hide();
        $("#addTrial").on("click", function on() {
            if (countTrial <= 4) {
                var type = $('#element').val();
                $("#trialDiv").append("<div class='row' id='newTrial"+countTrial+"'><h6><span class='serialTrial'> Trial & Run</span></h6><div class='col-md-4'><div class='form-group'><label for='monthTrial'>Months</label><input type='number' step='0.1' id='monthTrial' class='form-control' name='monthTrial[]'></div></div><div class='col-md-4'><div class='form-group'><label for='amountTrial'>Sanctioned Cost</label><input type='number' class='form-control sanctionedCost' onkeyup='sanctionedCostFun()' id='amountTrial' step='0.01' name='amountTrial[]'></div></div><div class='col-md-4 marg_1' ><div class='form-group' style='margin-bottom:0px'><button type='button' class='btn removeTrial' id='removeTrial' style='padding:0px;'><i class='mdi mdi-minus-circle removeBtn' style='font-size: 2.5rem;color: red;'></i></button></div></div></div>");
                countTrial = countTrial + 1;
                
                if (countTrial - 1 == 4) {
                    $("#addTrial").hide();
                } else {
                    $("#addTrial").show();
                }
            }
        });

        $("#trialDiv").on('click', '#removeTrial', function () {
            $("#addTrial").show();
            $(this).closest('.row').remove();
            countTrial = countTrial - 1;
        });
        
        $("#trialRun").on('click', function(){
            $(".trialRunToggle").toggle();
        });
        
        <?php 
        if($trialRun == true){
            echo '$("#trialRun").click();';
        }
        ?>
        
        function yojanaNameByVillage(){
            var village = document.getElementById('village').value;
            var yojanaName = " Water Supply Scheme";//document.getElementById('yojanaName').value;
            console.log(yojanaName+" "+village);
            document.getElementById('yojanaName').value = "";
            document.getElementById('yojanaName').value = village+yojanaName;
        }
        
        $("#taluka").on("change", function(){
            var taluka = $(this).val();
            var gramPanchayatHtml = $("#gramPanchayatHtml");
            // console.log(village.html());
            gramPanchayatHtml.html("Please Wait");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {taluka:taluka},
                success:function(data){
                    gramPanchayatHtml.html(data);
                }
            })
        
            $.ajax({
                type : 'POST',
                url  : 'createYojana',
                data : {taluka:taluka},
                success:function(data){
                    var explode = data.split(":");
                    $("#schemeId").val(explode[0]);
                    console.log(explode[1]);
                    $("#number").val(explode[1]);
                }
            })
        })
        
        /*$("#taluka").on('change', function(){
            var taluka = $("#taluka").val();
            var gramPanchayatHtml = $("#gramPanchayatHtml");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {taluka:taluka},
                success:function(data){
                    gramPanchayatHtml.html(data);
                }
            })
        })*/
        
        
        $("#gramPanchayat").on('change', function(){
            var taluka = $("#taluka").val();
            var gramPanchayat = $(this).val();
            var villageHtml = $("#villageHtml");
            villageHtml.html("Please Wait");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {taluka2:taluka, gramPanchayat:gramPanchayat},
                success:function(data){
                    villageHtml.html(data);
                }
            })
        })
        
        $("#village").on('change', function(){
            var taluka = $("#taluka").val();
            var gramPanchayat = $("#gramPanchayat").val();
            var habitationHtml = $("#habitationHtml");
            habitationHtml.html("Please Wait");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {taluka3:taluka, gramPanchayat2:gramPanchayat,habitation:habitation},
                success:function(data){
                    habitationHtml.html(data);
                }
            })
        })
        
        
        
        /*$(function () {
            $('#datepicker').datepicker();
        });*/
    </script>

    <!-- End custom js for this page -->
</body>

</html>