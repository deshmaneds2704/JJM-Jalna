<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');

function getDatesFromRange($start, $end, $format = 'Y-m-d') {
      
    $array = array();
    
    $interval = new DateInterval('P1D');
  
    $realEnd = new DateTime($end);
    $realEnd->add($interval);
  
    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);
  
    foreach($period as $date) {                 
        $array[] = $date->format($format); 
    }
    
    return $array;
}

if(isset($_POST['yojanaId'])){
    $yojanaId = $_POST['yojanaId'];
    $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
    $result = mysqli_fetch_assoc($query);
    $createdDate = $result['createdDate'];
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main-timeline">
                <div class="timeline">
                    <div class="timeline-icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="timeline-content">
                        <h2 class="title textRight"><?php //echo date('d M Y', strtotime($createdDate)); ?></h2>
                        <p class="description textRight">
                            <?php echo $result['yojanaName'] ?> is created.
                        </p>

                    </div>
                </div>
                
                <?php 
                
                
                $from = $createdDate;
                $to = date('Y-m-d');
                
                $Date = getDatesFromRange($from, $to);
                
                $i = 1;
                foreach ($Date as $date){
                    $querys[0] = mysqli_query($con, "SELECT * FROM stepOne WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
                    $result[0] = mysqli_fetch_assoc($querys[0]);
                    $percentage[0] = $result[0]['completionPercentage'];
                    $counts[0] = mysqli_num_rows($querys[0]);
                    
                    $querys[1] = mysqli_query($con, "SELECT * FROM stepTwo WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
                    $result[1] = mysqli_fetch_assoc($querys[1]);
                    $percentage[1] = $result[1]['completionPercentage'];
                    $counts[1] = mysqli_num_rows($querys[1]);
                    
                    $querys[2] = mysqli_query($con, "SELECT * FROM stepThree WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
                    $result[2] = mysqli_fetch_assoc($querys[2]);
                    $percentage[2] = $result[2]['completionPercentage'];
                    $counts[2] = mysqli_num_rows($querys[2]);
                    
                    $querys[3] = mysqli_query($con, "SELECT * FROM stepFour WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
                    $result[3] = mysqli_fetch_assoc($querys[3]);
                    $percentage[3] = $result[3]['completionPercentage'];
                    $counts[3] = mysqli_num_rows($querys[3]);
                    
                    $querys[4] = mysqli_query($con, "SELECT * FROM stepFive WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
                    $result[4] = mysqli_fetch_assoc($querys[4]);
                    $percentage[4] = $result[4]['completionPercentage'];
                    $counts[4] = mysqli_num_rows($querys[4]);
                    
                    $querys[5] = mysqli_query($con, "SELECT * FROM finance WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
                    $counts[5] = mysqli_num_rows($querys[5]);
                    
                    if ($counts[0] == 0 && $counts[1] == 0 && $counts[2] == 0 && $counts[3] == 0 && $counts[4] == 0 && $counts[5] == 0){
                        continue;
                    }
                    
                    if($i%2 != 0){
                        $right = "right";
                        $textRight = "";
                    } else {
                        $textRight = "textRight";
                        $right = "";
                    }
                    $i++;
                
                ?>
                <div class="timeline">
                    <div class="timeline-icon">
                        <i class="fa fa-star"></i>
                    </div>
                    <div class="timeline-content <?php echo $right ?>">
                        <h2 class="title <?php echo $textRight ?>"><?php //echo date('d M Y', strtotime($date)) ?></h2>
                        <p class="description <?php echo $textRight ?>">
                            <?php
                            if($counts[0] != 0){
                                echo "Stage One (Source) is <b>".$percentage[0]."</b> completed <br>";
                            }
                            
                            if($counts[1] != 0){
                                echo "Stage Two (Pump / Rising Main) is <b>".$percentage[1]."</b> completed <br>";
                            }
                            
                            if($counts[2] != 0){
                                echo "Stage Three (ESR) is <b>".$percentage[2]."</b> completed <br>";
                            }
                            
                            if($counts[3] != 0){
                                echo "Stage Four (Distribution) is <b>".$percentage[3]."</b> completed <br>";
                            }
                            
                            if($counts[4] != 0){
                                echo "Stage Five (Trial Run) is <b>".$percentage[4]."</b> completed <br>";
                            }
                            
                            if($counts[0] != 0){
                                $countPumping = 1;
                                $countRising = 1;
                                $countEsr = 1;
                                while($result = mysqli_fetch_assoc($querys[5])){
                                    $subWorkId = $result['subWorkId'];
                                    $amount = $result['amount'];
                                    $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$subWorkId'");
                                    $r = mysqli_fetch_assoc($q);
                                    $subWork = $r['subWork'];
                                    if($r['subWork'] == "Percolation Well"){
                                        $subWork = "Percolation Well  (Depth -".$r['depth']." m & Dia - ".$r['diameter']." m)";
                                    
                                    } else if($r['subWork'] == "Approach Bund"){
                                        $subWork = $r['subWork']." (Length -".$r['length']." m)";
                                        
                                    } else if($r['subWork'] == "Pumping Machinery"){
                                        $subWork = $countPumping++.". ".$r['subWork']." (".$r['bhp']." bhp)";
                                        
                                    } else if($r['subWork'] == "Rising Main"){
                                        $subWork = $countRising++.". ".$r['subWork']." (".$r['diameter']." mm ".$r['typePipe']." ".$r['kg_cm']." kg/cm<sup>2</sup> = ".$r['length']." m)";
                                        
                                    } else if($r['subWork'] == "RCC ESR"){
                                        $subWork = $countEsr++.". ".$r['subWork']." (".$r['capacity']." ltr.)";
                                        
                                    } else if($r['subWork'] == "Distribution System"){
                                        $subWork = $r['subWork']." (".$r['diameter']." mm ".$r['typePipe']." ".$r['length']." m)";
                                        
                                    } else if($r['subWork'] == "MSEDC Work"){
                                        $subWork = $r['subWork'];
                                        
                                    } else if($r['subWork'] == "Trial & Run"){
                                        $subWork = $r['subWork']. " (Months - ".$r['month'].")";
                                        
                                    } else if($r['subWork'] == "Year - Demand" || $r['subWork'] == "Year - Population"){
                                        continue;
                                    }
                                    echo $subWork." <b>(".$amount.")</b> <br>";
                                }
                            }
                            ?>
                        </p>

                    </div>
                </div>
                <?php 
                }
                ?>
            </div>
        </div>
    </div>
</div>
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
    <title>Scheme Tracking</title>
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
</head>
<style>
.star{
        font-size:18px;
        color:red;
    }
    select.form-control {
        padding: 1.1375rem .75rem !important;
    }

    .main-timeline {
        position: relative;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -ms-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 20px;
}

    .main-timeline:before {
        content: "";
        width: 3px;
        height: 100%;
        background: #1abc9c;
        position: absolute;
        top: 0;
        left: 50%;
    }

    .main-timeline .timeline {

        position: relative;
    }

    .main-timeline .timeline:before,
    .main-timeline .timeline:after {
        content: "";
        display: block;
        width: 100%;
        clear: both;
    }

    .main-timeline .timeline-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #1abc9c;
        overflow: hidden;
        margin-left: -23px;
        position: absolute;
        top: 0;
        left: 50%;
        text-align: center;
    }

    .main-timeline .timeline-icon i {
        font-size: 30px;
        line-height: 50px;
        color: #fff;
    }

    .main-timeline .timeline-content {
        width: 45%;
        padding: 20px;
        border-radius: 5px;
        background: #fff;
        -webkit-box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
        -moz-box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
        -ms-box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
        box-shadow: 0 3px 0 rgba(0, 0, 0, 0.1);
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -ms-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
    }

    .main-timeline .timeline-content:before {
        content: "";
        border-left: 7px solid #1abc9c;
        border-top: 7px solid transparent;
        border-bottom: 7px solid transparent;
        position: absolute;
        left: 45%;
        top: 20px;
    }

    .main-timeline .title {
        font-size: 15px;
        font-weight: 900;
        color: #fff;
        padding: 10px;
        background: #1abc9c;
        border-radius: 3px 3px 0 0;
        margin: -20px -20px 10px;
    }

    .main-timeline .description {
        font-size: 14px;
        color: #726f77;
    }

    .main-timeline .read-more {
        display: inline-block;
        font-size: 12px;
        color: #64d8c1;
        text-transform: uppercase;
        padding: 5px 15px;
        border: 2px solid #64d8c1;
        position: relative;
        border-radius: 5px;
        -webkit-box-shadow: 2px 2px 0 #64d8c1;
        -moz-box-shadow: 2px 2px 0 #64d8c1;
        -ms-box-shadow: 2px 2px 0 #64d8c1;
        box-shadow: 2px 2px 0 #64d8c1;
    }

    .main-timeline .read-more:hover {
        top: 2px;
        left: 2px;
        box-shadow: none;
    }

    .main-timeline .timeline-content.right {
        float: right;
    }

    .main-timeline .timeline-content.right:before {
        content: "";
        right: 45%;
        left: inherit;
        border-left: 0;
        border-right: 7px solid #1abc9c;
    }
    
    .textRight{
        text-align: right;
    }

    @media only screen and (max-width: 990px) {
        .main-timeline .title {
            font-size: 25px;
        }
        
        .textRight{
            text-align: left;
        }
        .main-timeline .timeline-content::before {
            top: 16px;
        }
    }

    @media only screen and (max-width: 767px) {
        .main-timeline {
            margin-left: 20px;
        }

        .main-timeline:before {
            left: 0;
        }

        .main-timeline .timeline-content {
            width: 90%;
            float: right;
        }

        .main-timeline .timeline-content:before,
        .main-timeline .timeline-content.right:before {
            left: 10%;
            right: inherit;
            margin-left: -6px;
            border-left: 0;
            border-right: 7px solid #1abc9c;
        }

        .main-timeline .timeline-icon {
            left: 0;
        }
    }

    @media only screen and (max-width: 479px) {
        .main-timeline .timeline-content {
            width: 85%;
        }

        .main-timeline .timeline-content:before,
        .main-timeline .timeline-content.right:before {
            left: 15%;
        }

        .main-timeline .title {
            font-size: 20px;
        }

        .main-timeline .timeline-content:before {
            top: 13px;
        }
    }
</style>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
        
        $query = mysqli_query($con, "SELECT * FROM yojanaMaster ORDER BY id DESC LIMIT 1");
        $result = mysqli_fetch_assoc($query);
        $yojanaId = $result['yojanaId'];
        $talukaNew = $result['taluka'];
    ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <center style="padding-bottom:30px;">
                                        <h3 class="ribbon">Scheme Tracker</h3>
                                    </center>

                                    <div class="row">
                                        <!-- taluka-->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Taluka</label>
                                                <select class="js-example-basic-single" id="taluka" name="taluka"
                                                    style="width: 100%;">
                                                    <option value="" selected="" disabled=""></option>
                                                    <?php 
                                                        $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $taluka = $result['taluka'];
                                                            if($taluka == $talukaNew){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                    <option value="<?php echo $taluka ?>" <?php echo $selected ?>>
                                                        <?php echo $taluka ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- village
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>गाव</label>
                                                    <div id="village">
                                                        <select class="js-example-basic-multiple" name="village[]" multiple="multiple" style="width: 100%;">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                             -->
                                        <!--yojana-->
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Name of Scheme <span class="star">*</span></label>
                                                <select class="js-example-basic-single" id="yojanaTracker" name="yojanaId"
                                                    style="width: 100%;">
                                                    <option selected disabled></option>
                                                    <?php
                                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster ORDER BY id DESC");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            if($result['yojanaId'] == $yojanaId){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                    <option value="<?php echo $result['yojanaId'] ?>" <?php echo $selected ?>>
                                                        <?php echo $result['yojanaName'] ?>
                                                    </option>
                                                    <?php
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    
                                    <div id="tracker">
                                        <?php
                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
                                        $result = mysqli_fetch_assoc($query);
                                        $createdDate = $result['createdDate'];
                                        ?>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="main-timeline">
                                                        <div class="timeline">
                                                            <div class="timeline-icon">
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                            <div class="timeline-content">
                                                                <h2 class="title textRight"><?php ///echo date('d M Y', strtotime($createdDate)); ?></h2>
                                                                <p class="description textRight">
                                                                    <?php echo $result['yojanaName'] ?> is created.
                                                                </p>
    
                                                            </div>
                                                        </div>
                                                        
                                                        <?php
                                                        $from = $createdDate;
                                                        $to = date('Y-m-d');
                                                        
                                                        $Date = getDatesFromRange($from, $to);
                                                        
                                                       
$i = 1;

foreach ($Date as $date) {

    $querys[0] = mysqli_query($con, "SELECT * FROM stepOne WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
    $result[0] = mysqli_fetch_assoc($querys[0]);
    $percentage[0] = $result[0]['completionPercentage'] ?? 0;
    $counts[0] = mysqli_num_rows($querys[0]);

    $querys[1] = mysqli_query($con, "SELECT * FROM stepTwo WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
    $result[1] = mysqli_fetch_assoc($querys[1]);
    $percentage[1] = $result[1]['completionPercentage'] ?? 0;
    $counts[1] = mysqli_num_rows($querys[1]);

    $querys[2] = mysqli_query($con, "SELECT * FROM stepThree WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
    $result[2] = mysqli_fetch_assoc($querys[2]);
    $percentage[2] = $result[2]['completionPercentage'] ?? 0;
    $counts[2] = mysqli_num_rows($querys[2]);

    $querys[3] = mysqli_query($con, "SELECT * FROM stepFour WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
    $result[3] = mysqli_fetch_assoc($querys[3]);
    $percentage[3] = $result[3]['completionPercentage'] ?? 0;
    $counts[3] = mysqli_num_rows($querys[3]);

    $querys[4] = mysqli_query($con, "SELECT * FROM stepFive WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
    $result[4] = mysqli_fetch_assoc($querys[4]);
    $percentage[4] = $result[4]['completionPercentage'] ?? 0;
    $counts[4] = mysqli_num_rows($querys[4]);

    $querys[5] = mysqli_query($con, "SELECT * FROM finance WHERE dateTime LIKE '$date%' AND yojanaId = '$yojanaId'");
    $counts[5] = mysqli_num_rows($querys[5]);

    // Continue with your existing code below

                                                            
                                                            if ($counts[0] == 0 && $counts[1] == 0 && $counts[2] == 0 && $counts[3] == 0 && $counts[4] == 0 && $counts[5] == 0){
                                                                continue;
                                                            }
                                                            
                                                            if($i%2 != 0){
                                                                $right = "right";
                                                                $textRight = "";
                                                            } else {
                                                                $textRight = "textRight";
                                                                $right = "";
                                                            }
                                                            $i++;
                                                        
                                                        ?>
                                                        <div class="timeline">
                                                            <div class="timeline-icon">
                                                                <i class="fa fa-star"></i>
                                                            </div>
                                                            <div class="timeline-content <?php echo $right ?>">
                                                                <h2 class="title <?php echo $textRight ?>"><?php //echo date('d M Y', strtotime($date)) ?></h2>
                                                                <p class="description <?php echo $textRight ?>">
                                                                    <?php
                                                                    if($counts[0] != 0){
                                                                        echo "Stage One (Source) is <b>".$percentage[0]."</b> completed <br>";
                                                                    }
                                                                    
                                                                    if($counts[1] != 0){
                                                                        echo "Stage Two (Pump / Rising Main) is <b>".$percentage[1]."</b> completed <br>";
                                                                    }
                                                                    
                                                                    if($counts[2] != 0){
                                                                        echo "Stage Three (ESR) is <b>".$percentage[2]."</b> completed <br>";
                                                                    }
                                                                    
                                                                    if($counts[3] != 0){
                                                                        echo "Stage Four (Distribution) is <b>".$percentage[3]."</b> completed <br>";
                                                                    }
                                                                    
                                                                    if($counts[4] != 0){
                                                                        echo "Stage Five (Trial Run) is <b>".$percentage[4]."</b> completed <br>";
                                                                    }
                                                                    
                                                                    if($counts[0] != 0){
                                                                        $countPumping = 1;
                                                                        $countRising = 1;
                                                                        $countEsr = 1;
                                                                        while($result = mysqli_fetch_assoc($querys[5])){
                                                                            $subWorkId = $result['subWorkId'];
                                                                            $amount = $result['amount'];
                                                                            $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$subWorkId'");
                                                                            $r = mysqli_fetch_assoc($q);
                                                                            $subWork = $r['subWork'];
                                                                            if($r['subWork'] == "Percolation Well"){
                                                                                $subWork = "Percolation Well  (Depth -".$r['depth']." m & Dia - ".$r['diameter']." m)";
                                                                            
                                                                            } else if($r['subWork'] == "Approach Bund"){
                                                                                $subWork = $r['subWork']." (Length -".$r['length']." m)";
                                                                                
                                                                            } else if($r['subWork'] == "Pumping Machinery"){
                                                                                $subWork = $countPumping++.". ".$r['subWork']." (".$r['bhp']." bhp)";
                                                                                
                                                                            } else if($r['subWork'] == "Rising Main"){
                                                                                $subWork = $countRising++.". ".$r['subWork']." (".$r['diameter']." mm ".$r['typePipe']." ".$r['kg_cm']." kg/cm<sup>2</sup> = ".$r['length']." m)";
                                                                                
                                                                            } else if($r['subWork'] == "RCC ESR"){
                                                                                $subWork = $countEsr++.". ".$r['subWork']." (".$r['capacity']." ltr.)";
                                                                                
                                                                            } else if($r['subWork'] == "Distribution System"){
                                                                                $subWork = $r['subWork']." (".$r['diameter']." mm ".$r['typePipe']." ".$r['length']." m)";
                                                                                
                                                                            } else if($r['subWork'] == "MSEDC Work"){
                                                                                $subWork = $r['subWork'];
                                                                                
                                                                            } else if($r['subWork'] == "Trial & Run"){
                                                                                $subWork = $r['subWork']. " (Months - ".$r['month'].")";
                                                                                
                                                                            } else if($r['subWork'] == "Year - Demand" || $r['subWork'] == "Year - Population"){
                                                                                continue;
                                                                            }
                                                                            echo $subWork." <b>(".$amount.") </b> <br>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </p>
    
                                                            </div>
                                                        </div>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- 
                                        <button type="submit" name="submit" class="btn btn-primary me-2"> Submit </button>
                                        <button class="btn btn-light" type="button">Cancel</button>
                                        -->
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
    
    <script scr="js/custom.js?v=1.0.2"></script>

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
        var radio = 1;
        var count = 2;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(20);
        $("#add").on("click", function on() {

            if (count <= 20) {

                var type = $('#element').val();

                $("#textboxDiv").append("<div class='row'><div class='col-md-4'><div class='form-group'><label for='docName'>Sub Work </label><select class='form-control' name='subWork[]'> <?php $query = mysqli_query($con, 'SELECT * FROM subWorkMaster'); while($result = mysqli_fetch_assoc($query)){ ?><option value='<?php echo $result['id'] ?>'><?php echo $result['subWork'] ?></option><?php } ?></select></div></div><div class='col-md-6'><div class='form-group'><label>Remark </label><input type='text' onkeyup='referred()' class='form-control' required name='remark" + count + "' id='remark'></div></div><div class='col-md-2'><div class='form-group'><label>Amount</label><input type='number' name='amount[]' class='form-control' step='0.01' /></div></div>");
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
        
        $("#yojanaTracker").on('change', function(){
            var yojanaId = $(this).val();
            console.log(yojanaId);
            $.ajax({
                type : 'POST',
                url  : 'yojanaTracker',
                data : 'yojanaId='+yojanaId,
                // data : {yojanaId:yojanaId},
                success:function(html){
                    console.log(html);
                    $("#tracker").html(html);
                },
                error:function(html){
                    console.log(html);
                }
            })
        })

        /*$("#taluka").on("change", function () {
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
        })*/
    </script>
</body>

</html>