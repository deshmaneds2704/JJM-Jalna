<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobileDevice()){
    $hideGraph = false;
}
else {
    $hideGraph = true;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Scheme Specific Graph</title>
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
    <!-- bar graph -->
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  <!-- -->
</head>
<style type="text/css">
 .star{
        font-size:18px;
        color:red;
    }

    .anychart-credits{
        display:none;
    }
    
</style>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
        $query = mysqli_query($con, "SELECT * FROM yojanaMaster ORDER BY createdDate DESC  LIMIT 1");
        $result = mysqli_fetch_assoc($query);
        $newYojanaId = $result['yojanaId'];
        $newTaluka = "";//$result['taluka'];
        ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">


                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <!--<center style="padding-bottom:30px;">
                                        <h3 class="ribbon">Expenditures Report</h3>
                                    </center>-->
                                    
                                    <?php
                                    if($hideGraph == true){
                                    ?>
                                    <form action="schemeSpecific" method="GET" enctype="multipart/form-data">
                                        <div class="row">
                                            <!-- taluka-->
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Taluka</label>
                                                    <select class="js-example-basic-single" id="taluka" name="taluka" style="width: 100%;">
                                                        <option value="" selected="" disabled=""></option>
                                                        <?php 
                                                        $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $taluka = $result['taluka'];
                                                            if($taluka == $_GET['taluka']){
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
                                            <!-- -->
                                            <!-- village-->
                                            <!--<div class="col-md-3">
                                                <div class="form-group">
                                                    <label>गाव</label>
                                                    <div id="village">
                                                        <select class="js-example-basic-multiple" name="village[]" multiple="multiple" style="width: 100%;">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>-->
                                            <!-- -->
                                            
                                            <!--yojana-->
                                            <div class="col-md-4">
                                                <div class="form-group" id="yojanaHtml">
                                                    <label>Name of Scheme <span class="star">*</span></label>
                                                    <select class="js-example-basic-single" id="yojanaIdFinance" name="yojanaId" style="width: 100%;">
                                                        <option disabled="" selected=""></option>
                                                        <?php
                                                        if(isset($_GET['taluka'])){
                                                            $taluka = "WHERE taluka = '".$_GET['taluka']."'";
                                                        } else {
                                                            $taluka = "";
                                                        }
                                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster $taluka ORDER BY id DESC");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            if($_GET['yojanaId'] == $result['yojanaId']){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option value="<?php echo $result['yojanaId'] ?>" <?php echo $selected ?>><?php echo  $result['yojanaId']." - ".$result['yojanaName'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group" id="yojanaHtml">
                                                    <label>Graph Type <span class="star">*</span></label>
                                                    <select class="js-example-basic-single" id="grahpType" name="grahpType" style="width: 100%;">
                                                        <option disabled="" selected=""></option>
                                                        <?php 
                                                        $grahpTypeArray = array(
                                                            'physicalCompletionGraph' => 'Physical Completion Graph',
                                                            'ganttChart' => 'Gantt Chart',
                                                            'subWorkWiseExpenditure' => 'Sub Work Wise Expenditures',
                                                            'workProgressAgainstExpenditure' => 'Work Progress Against Expenditures',
                                                            'plannedVsActualSubWork' => 'Planned Vs Actual Sub Work Progress'
                                                            );
                                                        foreach ($grahpTypeArray as $key => $grahpType){
                                                            if($key == $_REQUEST['grahpType']){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $grahpType ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2" style="display: flex;align-items: center;">
                                                <button type="submit" class="btn btn-primary me-2" name="show">Show</button>
                                            </div>
                                            <!-- -->
                                        </div>
                                    </form>
                                 
                                    <?php 
                                    if(isset($_REQUEST['show'])){
                                        if(isset($_GET['yojanaId'])){
                                            $yojanaId = $_GET['yojanaId'];
                                            $grahpType = $_GET['grahpType'];
                                            if($grahpType == "physicalCompletionGraph"){
                                    ?>
                                    
                                    <div id="physicalCompletionChart" style="height: 30rem;width:100%"></div>
                                    
                                    <script>
                                        anychart.onDocumentReady(function () {
                                            // create data set on our data
                                            var chartData = {
                                                title: '% Physical Completion Graph',
                                                header: ['',
                                                    <?php
                                                    $countPumping = 1;
                                                    $countRising = 1;
                                                    $countEsr = 1;
                                                    $i = 0;
                                                    $yojanaId = $_GET['yojanaId'];
                                                    $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        if($result['subWork'] == "Percolation Well"){
                                                            $subWork = "Percolation Well  (Depth - ".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[0] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[0] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Approach Bund"){
                                                            $subWork = $result['subWork']." (Length - ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Approach Bund' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[1] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[1] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Switch Room"){
                                                            $subWork = $countPumping++.". ".$result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Switch Room' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[2] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[2] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Pumping Machinery"){
                                                            $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[2] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[2] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Rising Main"){
                                                            $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm² = ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[3] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[3] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "RCC ESR"){
                                                            $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Elevated Service Reservoir' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[4] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[4] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Distribution System"){
                                                            $subWork = $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[5] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[5] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "MSEDC Work"){
                                                            $subWork = $result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'MSEDC Work' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[6] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[6] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Trial & Run"){
                                                            $subWork = $result['subWork']. " (Months - ".$result['month'].")";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Trial & Run' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone[7] = $r['workDone'];
                                                            if(empty($r['workDone'])){
                                                                $workDone[7] = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                                                            continue;
                                                        }
                                                        
                                                        if($i == 0){
                                                            echo "'".$subWork."'";
                                                        } else {
                                                            echo ", '".$subWork."'";
                                                        }
                                                        $i++;
                                                    }
                                                    ?>
                                                    ],
                                                rows: [
                                                    [ '',
                                                    <?php
                                                    $i=0;
                                                    foreach ($workDone as $competed){
                                                        if($i==0){
                                                            echo $competed;
                                                        } else {
                                                            echo ", ".$competed;
                                                        }
                                                        $i++;
                                                    }
                                                    ?>    
                                                    ]
                                                ]
                                            };
                                    
                                            // create column chart
                                            var chart = anychart.column();
                                    
                                            // set chart data
                                            chart.data(chartData);
                                    
                                            // turn on chart animation
                                            chart.animation(true);
                                    
                                            chart.yAxis().labels().format('{%Value}{groupsSeparator: } %');
                                    
                                            // set titles for Y-axis
                                            chart.yAxis().title(' Completion percentage');
                                            
                                            chart.xAxis().title('Subwork');
                                    
                                            chart
                                                .labels()
                                                .enabled(true)
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .format('{%Value}{groupsSeparator: } %');
                                            chart.hovered().labels(false);
                                    
                                            // turn on legend and tune it
                                            chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);
                                    
                                            // interactivity settings and tooltip position
                                            chart.interactivity().hoverMode('single');
                                    
                                            chart
                                                .tooltip()
                                                .positionMode('point')
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .offsetX(0)
                                                .offsetY(5)
                                                .titleFormat('{%X}')
                                                .format('{%SeriesName} : {%Value}{groupsSeparator: } %');
                                    
                                            // set container id for the chart
                                            chart.container('physicalCompletionChart');
                                    
                                            // initiate chart drawing
                                            chart.draw();
                                        });
                                    </script>

                                    <?php
                                            } else if($grahpType == "ganttChart"){
                                                $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId' AND plannedDate != '' AND plannedEndDate != '' AND actualDate !='' AND actualEndDate != ''") or die($con->error);
                                                if(mysqli_num_rows($query) <=0 ){
                                                    echo "<div class='card-body' style='text-align:center' ><img src='img/no-records.png' id='norecord' class='img-fluid'></div>";
                                                } else {
                                    ?>
                                    <div>
                                        <iframe src="ganttChart?yojanaId=<?php echo $yojanaId ?>" style="height:35rem" width="100%"></iframe>
                                    </div>
                                    <?php
                                                }
                                            } else if($grahpType == "subWorkWiseExpenditure"){
                                    ?>
                                    <div id="subWorkWiseExpenditure" style="height: 40rem;width:100%"></div>
                                    
                                    <script>
                                        anychart.onDocumentReady(function () {
                                            // create data set on our data
                                            var chartData = {
                                              
                                                title: 'Sub Work Wise Expenditures',
                                                header: ['#', 'Total Sanctioned Cost', 'Spent Amount', 'Remaining Amount'],
                                                rows: [
                                                    <?php
                                                    $countPumping = 1;
                                                    $countRising = 1;
                                                    $countEsr = 1;
                                                    $i = 1;
                                                    $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        
                                                        $subWorkId = $result['id'];
                                                        if($result['subWork'] == "Percolation Well"){
                                                            $subWork = "Percolation Well (Depth - ".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Approach Bund"){
                                                            $subWork = $result['subWork']." (Length - ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Approach Bund' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Switch Room"){
                                                            $subWork = $countPumping++.". ".$result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Switch Room' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Pumping Machinery"){
                                                            $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Rising Main"){
                                                            $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm² = ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "RCC ESR"){
                                                            $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Elevated Service Reservoir' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Distribution System"){
                                                            $subWork = $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "MSEDC Work"){
                                                            $subWork = $result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'MSEDC Work' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Trial & Run"){
                                                            $subWork = $result['subWork']. " (Months - ".$result['month'].")";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Trial & Run' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                                                            continue;
                                                        }
                                                        
                                                        $q = mysqli_query($con, "SELECT SUM(amount) as 'totalExpenditure' FROM `finance` WHERE subWorkId = '$subWorkId' AND yojanaId = '$yojanaId'");
                                                        $r = mysqli_fetch_assoc($q);
                                                        $totalExpenditure = $r['totalExpenditure'];
                                                        
                                                        $actualCost = $result['actualPrice'];
                                                        
                                                        $remainingAmount = intval($actualCost) - intval($totalExpenditure) ;
                                                        
                                                        
                                                        if($i > 1){
                                                            echo ",";
                                                        }
                                                        
                                                        echo "['".$subWork."', ".$actualCost.", ".$totalExpenditure.", ".$remainingAmount."]";
                                                        $i++;
                                                    }
                                                    
                                                    ?>
                                                ]
                                            };
                                        
                                            // create column chart
                                            var chart = anychart.column();
                                        
                                            // set chart data
                                            chart.data(chartData);
                                        
                                            // turn on chart animation
                                            chart.animation(true);
                                            chart.xAxis().labels().rotation(-45);
                                            chart.yAxis().labels().format('₹{%Value}{groupsSeparator: }');
                                        
                                            // set titles for Y-axis
                                            chart.yAxis().title('Amount');
                                        
                                            chart
                                                .labels()
                                                .enabled(true)
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .format('₹{%Value}{groupsSeparator: }');
                                            chart.hovered().labels(false);
                                        
                                            // turn on legend and tune it
                                            chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);
                                        
                                            // interactivity settings and tooltip position
                                            chart.interactivity().hoverMode('single');
                                        
                                            chart
                                                .tooltip()
                                                .positionMode('point')
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .offsetX(0)
                                                .offsetY(5)
                                                .titleFormat('{%X}')
                                                .format('{%SeriesName} : ₹{%Value}{groupsSeparator: }');
                                        
                                            // set container id for the chart
                                            chart.container('subWorkWiseExpenditure');
                                        
                                            // initiate chart drawing
                                            chart.draw();
                                        });
                                      
                                    </script>
                                    <?php
                                            } else if($grahpType == "workProgressAgainstExpenditure"){
                                    ?>
                                    <div id="workProgressAgainstExpenditure" style="height: 40rem;width:100%"></div>
                                    
                                    <script>
                                        anychart.onDocumentReady(function () {
                                            // create data set on our data
                                            var chartData = {
                                              
                                                title: 'Work Progress Against Expenditure',
                                                header: ['#', 'Work Done', 'Expenditure'],
                                                rows: [
                                                    <?php
                                                    $countPumping = 1;
                                                    $countRising = 1;
                                                    $countEsr = 1;
                                                    $i = 1;
                                                    $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        
                                                        $subWorkId = $result['id'];
                                                        if($result['subWork'] == "Percolation Well"){
                                                            $subWork = "Percolation Well (Depth - ".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Approach Bund"){
                                                            $subWork = $result['subWork']." (Length - ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Approach Bund' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Switch Room"){
                                                            $subWork = $countPumping++.". ".$result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Switch Room' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Pumping Machinery"){
                                                            $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Rising Main"){
                                                            $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm² = ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "RCC ESR"){
                                                            $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Elevated Service Reservoir' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Distribution System"){
                                                            $subWork = $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "MSEDC Work"){
                                                            $subWork = $result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'MSEDC Work' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Trial & Run"){
                                                            $subWork = $result['subWork']. " (Months - ".$result['month'].")";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Trial & Run' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                                                            continue;
                                                        }
                                                        
                                                        $q = mysqli_query($con, "SELECT SUM(amount) as 'totalExpenditure' FROM `finance` WHERE subWorkId = '$subWorkId' AND yojanaId = '$yojanaId'");
                                                        $r = mysqli_fetch_assoc($q);
                                                        $totalExpenditure = $r['totalExpenditure'];
                                                        
                                                        $actualCost = $result['actualPrice'];
                                                        
                                                        $remainingAmount = intval($actualCost) - intval($totalExpenditure) ;
                                                        
                                                        
                                                        if($totalExpenditure == "" || $result['actualPrice'] == ""){
                                                            $per = 0;
                                                        } else {
                                                            if($totalExpenditure == $actualCost){
                                                                $per = 100;
                                                            } else {
                                                                $per = ($remainingAmount / $actualCost)*100;
                                                                if($per != "INF"){
                                                                    $per = 100 - round($per);
                                                                } else {
                                                                    $per = 0;
                                                                } 
                                                            }
                                                        }
                                                        
                                                        if($i > 1){
                                                            echo ",";
                                                        }
                                                        
                                                        echo "['".$subWork."', ".$workDone.", ".$per."]";
                                                        $i++;
                                                    }
                                                    
                                                    ?>
                                                ]
                                            };
                                        
                                        
                                            // var seriesData_1 = chartData.mapAs({x: 0, value: 1});
                                            // var seriesData_2 = chartData.mapAs({x: 0, value: 2});
                                            
                                            // create column chart
                                            var chart = anychart.column();
                                        
                                            // set chart data
                                            chart.data(chartData);
                                        
                                            // turn on chart animation
                                            chart.animation(true);
                                            chart.xAxis().labels().rotation(-65);
                                            chart.yAxis().labels().format('{%Value}{groupsSeparator: } %');
                                            
                                            // var series1 = chart.column(seriesData_1);
                                            // series1.normal().fill("#3ba158");
                                            // series1.normal().stroke("#3ba158");
                                            
                                            // var series2 = chart.column(seriesData_2);
                                            // series1.normal().fill("#00cc99");
                                            // series1.normal().stroke("#00cc99");
                                        
                                            // set titles for Y-axis
                                            chart.yAxis().title('Amount');
                                        
                                            chart
                                                .labels()
                                                .enabled(true)
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .format('{%Value}{groupsSeparator: } %');
                                            chart.hovered().labels(false);
                                        
                                            // turn on legend and tune it
                                            chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);
                                        
                                            // interactivity settings and tooltip position
                                            chart.interactivity().hoverMode('single');
                                        
                                            chart
                                                .tooltip()
                                                .positionMode('point')
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .offsetX(0)
                                                .offsetY(5)
                                                .titleFormat('{%X}')
                                                .format('{%SeriesName} : {%Value}{groupsSeparator: } %');
                                        
                                            // set container id for the chart
                                            chart.container('workProgressAgainstExpenditure');
                                        
                                            // initiate chart drawing
                                            chart.draw();
                                        });
                                      
                                    </script>
                                    <?php
                                            } else if($grahpType == "plannedVsActualSubWork"){
                                                $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId' AND plannedDate != '' AND plannedEndDate != '' AND actualDate !='' AND actualEndDate != ''") or die($con->error);
                                                if(mysqli_num_rows($query) <=0 ){
                                                    echo "<div class='card-body' style='text-align:center' ><img src='img/no-records.png' id='norecord' class='img-fluid'></div>";
                                                } else {
                                                
                                    ?>
                                    <div id="plannedVsActualSubWork" style="height: 40rem;width:100%"></div>
                                    
                                    <script>
                                        anychart.onDocumentReady(function () {
                                            // create data set on our data
                                            var chartData = {
                                              
                                                title: 'Planned Vs Actual Sub Work',
                                                header: ['#', 'Planned month', 'Actual month'],
                                                rows: [
                                                    <?php
                                                    $countPumping = 1;
                                                    $countRising = 1;
                                                    $countEsr = 1;
                                                    $i = 1;
                                                    $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        
                                                        $subWorkId = $result['id'];
                                                        if($result['subWork'] == "Percolation Well"){
                                                            $subWork = "Percolation Well (Depth - ".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Approach Bund"){
                                                            $subWork = $result['subWork']." (Length - ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Approach Bund' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Switch Room"){
                                                            $subWork = $countPumping++.". ".$result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Switch Room' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Pumping Machinery"){
                                                            $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Rising Main"){
                                                            $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm² = ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "RCC ESR"){
                                                            $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Elevated Service Reservoir' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Distribution System"){
                                                            $subWork = $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "MSEDC Work"){
                                                            $subWork = $result['subWork'];
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'MSEDC Work' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Trial & Run"){
                                                            $subWork = $result['subWork']. " (Months - ".$result['month'].")";
                                                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Trial & Run' AND yojanaId = '$yojanaId'");
                                                            $r = mysqli_fetch_assoc($q);
                                                            $workDone = $r['workDone'];
                                                            if(empty($workDone)){
                                                                $workDone = 0;
                                                            }
                                                            
                                                        } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                                                            continue;
                                                        }
                                                        
                                                        $plannedStartDate = strtotime($result['plannedDate']);
                                                        $plannedEndDate = strtotime($result['plannedEndDate']);
                                                        
                                                        $diff = abs($plannedEndDate - $plannedStartDate);
                                                        
                                                        $years  = floor($diff / (365 * 60 * 60 * 24));
                                                        $plannedMonths = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                        
                                                        $actualStartDate = strtotime($result['actualDate']);
                                                        $actualEndDate = strtotime($result['actualEndDate']);
                                                        
                                                        $diff = abs($actualEndDate - $actualStartDate);
                                                        
                                                        $years  = floor($diff / (365 * 60 * 60 * 24));
                                                        $actualMonths = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                                        
                                                        if($i > 1){
                                                            echo ",";
                                                        }
                                                        
                                                        echo "['".$subWork."', ".$plannedMonths.", ".$actualMonths."]";
                                                        $i++;
                                                    }
                                                    
                                                    ?>
                                                ]
                                            };
                                        
                                        
                                            // var seriesData_1 = chartData.mapAs({x: 0, value: 1});
                                            // var seriesData_2 = chartData.mapAs({x: 0, value: 2});
                                            
                                            // create column chart
                                            var chart = anychart.column();
                                        
                                            // set chart data
                                            chart.data(chartData);
                                        
                                            // turn on chart animation
                                            chart.animation(true);
                                            chart.xAxis().labels().rotation(-65);
                                            chart.yAxis().labels().format('{%Value}{groupsSeparator: } ');
                                            
                                            // var series1 = chart.column(seriesData_1);
                                            // series1.normal().fill("#3ba158");
                                            // series1.normal().stroke("#3ba158");
                                            
                                            // var series2 = chart.column(seriesData_2);
                                            // series1.normal().fill("#00cc99");
                                            // series1.normal().stroke("#00cc99");
                                        
                                            // set titles for Y-axis
                                            chart.yAxis().title('Amount');
                                        
                                            chart
                                                .labels()
                                                .enabled(true)
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .format('{%Value}{groupsSeparator: } ');
                                            chart.hovered().labels(false);
                                        
                                            // turn on legend and tune it
                                            chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);
                                        
                                            // interactivity settings and tooltip position
                                            chart.interactivity().hoverMode('single');
                                        
                                            chart
                                                .tooltip()
                                                .positionMode('point')
                                                .position('center-top')
                                                .anchor('center-bottom')
                                                .offsetX(0)
                                                .offsetY(5)
                                                .titleFormat('{%X}')
                                                .format('{%SeriesName} : {%Value}{groupsSeparator: } ');
                                        
                                            // set container id for the chart
                                            chart.container('plannedVsActualSubWork');
                                        
                                            // initiate chart drawing
                                            chart.draw();
                                        });
                                      
                                    </script>
                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    } else{
                                    ?>
                                    <h4 style="line-height: 2rem;color: red;">Graphical reports are best viewed on desktop. Please switch to web view.</h4>
                                    <center>
                                        <a href="index"><button class="btn btn-primary">Back to home</button></a>
                                    </center>
                                    <?php
                                    }
                                    ?>    
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
    
    <!--<script src="js/custom.js?v=1.0.1"></script>-->
    
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
    
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location+"?yojanaId="+yojanaId;   
            }
        }
        
        $("#taluka").on("change", function(){
            var taluka = $(this).val();
            var yojanaHtml = $("#yojanaHtml");
            var submit = $("#submit");
            submit.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            submit.prop('disabled', true);
            yojanaHtml.html("Please Wait");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {talukaYojana:taluka},
                success:function(data){
                    yojanaHtml.html(data);
                    submit.html('Submit');
                    submit.prop('disabled', false);
                }
            });
        });
    </script>
</body>

</html>