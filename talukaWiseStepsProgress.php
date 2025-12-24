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
    <title>Tulaka Wise Stage Progress</title>
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
    <style>
        #container{
            width: 100%;
            height: 30rem;
        }
        @media print{
            .btn, .bottom-navbar>.contain, .mdi-menu, .footer, .no-print, .horizontal-menu {
                display: none;
            }
            @page {
                size: landscape
            }
            #container{
                width: 60rem;
            }
        }
        
    </style>
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
                                    <!-- GRAPH -->
                                    <!--<div style="text-align:right">-->
                                    <!--    <a onclick="talukaWiseStepsProgressFun()" style="cursor:pointer;font-size: 20px;"><i class="mdi mdi-printer"></i></a>-->
                                    <!--</div>-->
                                    <div id="container"></div>
                                    <!-- -->
                                    
                                    
                                    
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

        anychart.onDocumentReady(function () {
            // create data set on our data
            var chartData = {
    
                title: 'Taluka Wise Stages Progress',
                header: ['#', 'Stage 1', 'Stage 2', 'Stage 3a', 'Stage 3b', 'Stage 4'],
                rows: [
                    <?php
                    $countPumping = 1;
                    $countRising = 1;
                    $countEsr = 1;
                    $i = 1;
                    $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                    while($result = mysqli_fetch_assoc($query)){
                        $taluka = $result['taluka'];
                        $stepOneCount = 0;
                        $stepTwoCount = 0;
                        $stepThreeCount = 0;
                        $stepFourCount = 0;
                        $stepFiveCount = 0;
                        $q = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE taluka = '$taluka'");
                        while($r = mysqli_fetch_assoc($q)){
                            $yojanaId = $r['yojanaId'];
                            
                            $stepOneQuery = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'");
                            $stepOneResult = mysqli_fetch_assoc($stepOneQuery);
                            $stepOne = $stepOneResult['completionPercentage'];
                            if(!empty($stepOne) && $stepOne == 100){
                                $stepOneCount = $stepOneCount + 1;
                            }
                            
                            $stepTwoQuery = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'");
                            $stepTwoResult = mysqli_fetch_assoc($stepTwoQuery);
                            $stepTwo = $stepTwoResult['completionPercentage'];
                            if(!empty($stepTwo) && $stepTwo == 100){
                                $stepTwoCount = $stepTwoCount + 1;
                            }
                            
                            $stepThreeQuery = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'");
                            $stepThreeResult = mysqli_fetch_assoc($stepThreeQuery);
                            $stepThree = $stepThreeResult['completionPercentage'];
                            if(!empty($stepThree) && $stepThree == 100){
                                $stepThreeCount = $stepThreeCount + 1;
                            }
                            
                            $stepFourQuery = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'");
                            $stepFourResult = mysqli_fetch_assoc($stepFourQuery);
                            $stepFour = $stepFourResult['completionPercentage'];
                            if(!empty($stepFour) && $stepFour == 100){
                                $stepFourCount = $stepFourCount + 1;
                            }
                            
                            $stepFiveQuery = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'");
                            $stepFiveResult = mysqli_fetch_assoc($stepFiveQuery);
                            $stepFive = $stepFiveResult['completionPercentage'];
                            if(!empty($stepFive) && $stepFive == 100){
                                $stepFiveCount = $stepFiveCount + 1;
                            }
                        
                        }
                        
                        if ($i > 1) {
                            echo ",";
                        }
                        echo "['".$taluka."', ".$stepOneCount.", ".$stepTwoCount.", ".$stepThreeCount.", ".$stepFourCount.", ".$stepFiveCount."]";
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
            // chart.xAxis().labels().rotation(-45);
            chart.yAxis().labels().format('{%Value}{groupsSeparator: }');
    
            // set titles for Y-axis
            chart.yAxis().title('Completed Count');
    
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
                .format('{%SeriesName} : {%Value}{groupsSeparator: } completed');
    
            // set container id for the chart
            chart.container('container');
    
            // initiate chart drawing
            chart.draw();
        });
        
        
       
    
    </script>
    
    <script>
    
        function talukaWiseStepsProgressFun(){
            window.print();
        }
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