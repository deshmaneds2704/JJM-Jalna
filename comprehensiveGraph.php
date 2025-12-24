<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Column chart</title>
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
                        
                                    <form action="comprehensiveGraph" method="GET" enctype="multipart/form-data">
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
                                                    <label>Name of Scheme</label>
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
                                            
                                            <!--<div class="col-md-3">
                                                <div class="form-group" id="yojanaHtml">
                                                    <label>Graph Type</label>
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
                                            </div>-->
                                            
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
                                            // $grahpType = $_GET['grahpType'];
                                    ?>
                                    <div id="container" style="width: 100%;height: 30rem;"></div>
                                    
                                    <script>
                                        anychart.onDocumentReady(function () {
                                            // create line chart
                                            var chart = anychart.line();
                                    
                                            // set chart padding
                                            chart.padding([10, 20, 5, 20]);
                                    
                                            // turn on chart animation
                                            chart.animation(true);
                                    
                                            // turn on the crosshair
                                            chart.crosshair(true);
                                    
                                            // set chart title text settings
                                            chart.title('Physical Work Progress');
                                    
                                            // set y axis title
                                            chart.yAxis().title('Percentage');
                                    
                                            // create logarithmic scale
                                            var logScale = anychart.scales.log();
                                            logScale.minimum(1).maximum(45000);
                                    
                                            // set scale for the chart, this scale will be used in all scale dependent entries such axes, grids, etc
                                            chart.yScale(logScale);
                                    
                                            // create data set on our data,also we can pud data directly to series
                                            var dataSet = anychart.data.set([
                                                <?php
                                                $i = 1;
                                                $query = mysqli_query($con, "SELECT DISTINCT(subWork) FROM scheduleMaster");
                                                while($result = mysqli_fetch_assoc($query)){
                                                    $subWork = $result['subWork'];
                                                    if($i>1){
                                                        echo ",";
                                                    }
                                                    echo "['".$subWork."']";
                                                    $i++;
                                                }
                                                ?>
                                            ]);
                                    
                                            // map data for the first series,take value from first column of data set
                                            var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });
                                    
                                            // map data for the second series,take value from second column of data set
                                            var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });
                                    
                                            // map data for the third series, take x from the zero column and value from the third column of data set
                                            var thirdSeriesData = dataSet.mapAs({ x: 0, value: 3 });
                                    
                                            // temp variable to store series instance
                                            var series;
                                    
                                            // setup first series
                                            series = chart.line(firstSeriesData);
                                            series.name('Review about the product');
                                            // enable series data labels
                                            series.labels().enabled(true).anchor('left-bottom').padding(5);
                                            // enable series markers
                                            series.markers(true);
                                    
                                            // setup second series
                                            series = chart.line(secondSeriesData);
                                            series.name('Comment blog posts');
                                            // enable series data labels
                                            series.labels().enabled(true).anchor('left-bottom').padding(5);
                                            // enable series markers
                                            series.markers(true);
                                    
                                            // setup third series
                                            series = chart.line(thirdSeriesData);
                                            series.name('Email delivery support');
                                            // enable series data labels
                                            series.labels().enabled(true).anchor('left-bottom').padding(5);
                                            // enable series markers
                                            series.markers(true);
                                    
                                            // turn the legend on
                                            chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);
                                    
                                            // set container for the chart and define padding
                                            chart.container('container');
                                            // initiate chart drawing
                                            chart.draw();
                                        });
                                    </script>
                                    <?php
                                            
                                        }
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