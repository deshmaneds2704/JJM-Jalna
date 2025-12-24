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
    <title>Bar chart</title>
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
                                    
                                    <?php 
                                    
                                    if($hideGraph == true){
                                    ?>
                                    <form action="barChartForTaluka" method="GET" enctype="multipart/form-data">
                                        <div class="row">
                                            <!-- taluka-->
                                            <div class="col-md-5">
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
                                           <!-- <div class="col-md-5">
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
                                            </div>-->
                                            <div class="col-md-2" style="display: flex;align-items: center;">
                                                <button type="submit" class="btn btn-primary me-2" name="show">Show</button>
                                            </div>
                                            <!-- -->
                                        </div>
                                    </form>
                                 
                                        <?php 
                                        if(isset($_REQUEST['show'])){
                                            if(isset($_GET['taluka'])){
                                            $taluka = $_GET['taluka'];
                                    
                                        ?>
                                        
                                    <!-- GRAPH -->
                                    <div id="container" style="height:500px;width:100%"></div>
                                    
                                    
                                    <script>
                                    
                                        anychart.onDocumentReady(function () {
                                            // create data set on our data
                                            var dataSet = anychart.data.set([
                                          
                                          <?php 
                                          
                                         
                                          
                                            $query1 = mysqli_query($con,"select * from yojanaMaster where taluka='$taluka' ORDER BY id DESC");
                                            while($res1 = mysqli_fetch_assoc($query1)){
                                                $rows = $res1['yojanaId'];
                                                $village = $res1['village'];
                                                $schemeName = $res1['yojanaName'];
                                                $schemeid = $res1['yojanaId'];
                                                $c = mysqli_num_rows($query1);
                                                $totalPer = 100;
                                                
                                                if($res1['stepOne'] == "Yes"){
                                                    $totalPer = $totalPer + 100;
                                                }
                                                
                                                if($res1['stepTwo'] == "Yes"){
                                                    $totalPer = $totalPer + 100;
                                                }
                                                
                                                if($res1['stepThree'] == "Yes"){
                                                    $totalPer = $totalPer + 100;
                                                }
                                                
                                                if($res1['stepFour'] == "Yes"){
                                                    $totalPer = $totalPer + 100;
                                                }
                                              
                                              
                                                //STEP ONE 
                                              
                                                $per1 = 0;
                                                $step1 = mysqli_query($con,"select * from stepOne where yojanaId='$rows'");
                                                $percent1 = mysqli_fetch_assoc($step1);
                                                $per1 = $percent1['completionPercentage'];
                                                $count1 = mysqli_num_rows($step1);
                                                
                                              
                                                //STEP TWO
                                              
                                                $per2 = 0;
                                                $step2 = mysqli_query($con,"select * from stepTwo where yojanaId='$rows'");
                                                $percent2 = mysqli_fetch_assoc($step2);
                                                $per2 = $percent2['completionPercentage'];
                                                $count2 = mysqli_num_rows($step2);
                                                
                                              
                                                //STEP THREE
                                                
                                                $per3 = 0;
                                                $step3 = mysqli_query($con,"select * from stepThree where yojanaId='$rows'");
                                                $percent3 = mysqli_fetch_assoc($step3);
                                                $per3 = $percent3['completionPercentage'];
                                                $count3 = mysqli_num_rows($step3);
                                                
                                              
                                                //STEP FOUR
                                                
                                                $per4 = 0;
                                                $step4 = mysqli_query($con,"select * from stepFour where yojanaId='$rows'");
                                                $percent4 = mysqli_fetch_assoc($step4);
                                                $per4 = $percent4['completionPercentage'];
                                                $count4 = mysqli_num_rows($step4);
                                                
                                              
                                                //STEP FIVE
                                              
                                                $per5 = 0;
                                                $step5 = mysqli_query($con,"select * from stepFive where yojanaId='$rows'");
                                                $percent5 = mysqli_fetch_assoc($step5);
                                                $per5 = $percent5['completionPercentage'];
                                                $count5 = mysqli_num_rows($step5);
                                                if($count5==0){
                                                    $per5 = 0;
                                                }
                                              
                                                $add = $per1 + $per2 + $per3 + $per4 + $per5;
                                              
                                                $percentage = ($add/$totalPer)*100;
                                              
                                                //TOTAL SANCTIONED COST
                                              
                                                $cost = 0;
                                                $query2 = mysqli_query($con,"select * from yojanaMaster where yojanaId='$rows'");
                                                $res2 = mysqli_fetch_assoc($query2);
                                                $cost = $res2['totalSanctionedCost'];
                                              
                                                //AMOUNT
                                              
                                                $amount = 0;
                                                $query3 = mysqli_query($con,"select * from finance where yojanaId='$rows'");
                                                while($res3 = mysqli_fetch_assoc($query3)){
                                                    $amount += $res3['amount'];
                                                }
                                                if($amount > 0 && $cost > 0 ){
                                                    $value = $amount/$cost;
                                                    $utilised = $value*100;
                                                } else {
                                                    $utilised = 0;
                                                }
                                                if(is_nan($utilised)){
                                                    $utilised = 0;
                                                } 

                                            ?>
                                          
                                        ['<?php echo $schemeName  ?> (<?php echo $schemeid ?>)', <?php echo round($percentage,2) ; ?>, <?php echo round($utilised,2); ?>],
                                        
                                        <?php } ?>
                                        
                                      ]);
                                    
                                      // map data for the first series, take x from the zero column and value from the first column of data set
                                      var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });
                                    
                                      // map data for the second series, take x from the zero column and value from the second column of data set
                                      var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });
                                    
                                      
                                    
                                      // create bar chart
                                      var chart = anychart.bar();
                                    
                                      // turn on chart animation
                                      chart.animation(true);
                                    
                                      chart.padding([10, 40, 5, 20]);
                                    
                                      // set chart title text settings
                                      chart.title(' ');
                                    
                                      // set scale minimum
                                      chart.yScale().minimum(0);
                                    
                                      chart.xAxis().labels().rotation(+360).padding([0, 0, 20, 0]);
                                      chart.xAxis().labels().fontSize(11);
                                    
                                      chart.yAxis().labels().format('{%Value}%');
                                      
                                    
                                      // set titles for Y-axis
                                      chart.yAxis().title('Percentage');
                                      chart.xAxis().title('Villages');
                                    
                                      // helper function to setup settings for series
                                      var setupSeries = function (series, name) {
                                        series.name(name);
                                        series.hovered().labels(false);
                                    
                                        series
                                          .labels()
                                          .enabled(true)
                                          .position('right-center')
                                          .anchor('left-center')
                                          .format('{%Value}%');
                                    
                                        series
                                          .tooltip()
                                          .position('right')
                                          .anchor('left-center')
                                          .offsetX(5)
                                          .offsetY(0)
                                          .titleFormat('{%X}')
                                          .format('{%SeriesName} : {%Value}%');
                                      };
                                    
                                      // temp variable to store series instance
                                      var series;
                                    
                                      // create first series with mapped data
                                      series = chart.bar(firstSeriesData);
                                      setupSeries(series, 'Scheme completion %');
                                    
                                      // create second series with mapped data
                                      series = chart.bar(secondSeriesData);
                                      setupSeries(series, 'Fund utilised %');
                                      
                                      // turn on legend
                                      chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);
                                    
                                      chart.interactivity().hoverMode('single');
                                      chart.tooltip().positionMode('point');
                                    
                                      // set container id for the chart
                                      chart.container('container');
                                      // initiate chart drawing
                                      
                                      chart.xScroller(true);
                                    
                                    
                                    // turn on Y Scroller
                                    chart.xZoom().setTo(0, 0.1);
                                    
                                      chart.draw();
                                    });
                                    
                                    </script>
                                    <?php
                                            }
                                        }
                                    } else {
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
        /*$("#yojanaIdFinance").on('change', function(){
            var yojanaId = $(this).val();
            var tableHtml = $("#tableHtml");
            $.ajax({
                type : 'POST',
                url  : 'financeReport',
                data : {yojanaId:yojanaId},
                success:function(data){
                    console.log(data);
                    // if(data == 'noRecord'){
                    //     $("#noRecord").html("<div class='card-body' style='text-align:center'><img src='img/no-records.png'></div>");
                    // } else {
                        tableHtml.html(data);
                    // }
                }
            })
        })*/
        /*var count = 2;
        $("#remove").hide();
        var suspected = Number(20);
        $("#add").on("click", function on() {

            if (count <= 20) {

                var type = $('#element').val();

                $("#textboxDiv").append("<div class='row'><div class='col-md-4'><div class='form-group'><label for='docName'>Sub Work </label><select class='form-control' name='subWork[]'> <?php $query = mysqli_query($con, 'SELECT * FROM subWorkMaster'); while($result = mysqli_fetch_assoc($query)){ ?><option value='<?php echo $result['id'] ?>'><?php echo $result['subWork'] ?></option><?php } ?></select></div></div><div class='col-md-6'><div class='form-group'><label>Remark </label><input type='text' onkeyup='referred()' class='form-control' required name='remark" + count + "' id='remark'></div></div><div class='col-md-2'><div class='form-group'><label>Amount</label><input type='number' name='amount[]' class='form-control' step='0.01' /></div></div>");
                count = count + 1;
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
                $("#add").show();
                if (count == 2) {
                    $("#remove").hide();
                }
            } else {
                $("#remove").hide();
            }

        });*/
        
        
        /*$("#taluka").on("change", function(){
            var taluka = $(this).val();
            var yojanaHtml = $("#yojanaHtml");
            var submit = $("#submit");
            submit.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            submit.prop('disabled', true);
            yojanaHtml.html("कृपया वाट पहा");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {talukaYojana:taluka},
                success:function(data){
                    yojanaHtml.html(data);
                    submit.html('Submit');
                    submit.prop('disabled', false);
                }
            })
        })
        
        */
    </script>
</body>

</html>