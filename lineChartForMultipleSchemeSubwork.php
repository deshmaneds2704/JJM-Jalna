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
    <title>Line chart</title>
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
                                    
                                    <form action="lineChartForMultipleSchemeSubwork" method="GET" enctype="multipart/form-data">
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
                                            <div class="col-md-5">
                                                <div class="form-group" id="yojanaHtml">
                                                    <label>Name of Scheme<span class="star">*</span></label>
                                                    

                                                    <select class="js-example-basic-multiple yojanaId" id="yojanaIdFinance" name="yojanaId[]" style="width: 100%;" multiple="multiple">
                                                        <option disabled="" selected=""></option>
                                                        <?php
                                                        if(isset($_GET['taluka'])){
                                                            $taluka = "WHERE taluka = '".$_GET['taluka']."'";
                                                            if($_GET['yojanaId'][0] == "all_schemes"){
                                                        ?>
                                                        <option value="all_schemes" selected>All Scheme</option>
                                                        <?php
                                                            }
                                                        } else {
                                                            $taluka = "";
                                                        }
                                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster $taluka ORDER BY id DESC");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $i = 1;
                                                            // foreach ($_GET['yojanaId'] as $yojanaIds){
                                                                if($yojanaIds == $result['yojanaId']){
                                                                    $selected = "selected='selected'";
                                                                } else {
                                                                    $selected = "";
                                                                }
                                                        ?>
                                                        <option value="<?php echo $result['yojanaId'] ?>" <?php echo $selected ?>><?php echo  $result['yojanaId']." - ".$result['yojanaName'] ?></option>
                                                        <?php
                                                                /*$i++;
                                                                
                                                                if($yojanaIds == $result['yojanaId']){
                                                                    break;
                                                                }*/
                                                            // }
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
                                            
                                            $yojanaId = $_GET['yojanaId'];
                                            
                                            $taluka = $_GET['taluka'];
                                            
                                            if($yojanaId[0] == "all_schemes"){
                                                $yojanaId = array();
                                                $i=0;
                                                $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE taluka = '$taluka'");
                                                while($result = mysqli_fetch_assoc($query)){
                                                    $yojanaId[$i] = $result['yojanaId'];
                                                    $i++;
                                                }
                                            }
                                            
                                        ?>
  
  <div id="container" style="height:400px;width:100%"></div>
  

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
      chart.title('Subwork wise completion percentage');

      // set y axis title
      chart.yAxis().title('Percentage');
      chart.yAxis().labels().format('{%Value}%');
     
     chart.xAxis().title('Subwork');
     
      // create logarithmic scale
      var logScale = anychart.scales.log();
      logScale.minimum(1).maximum(100);

      // set scale for the chart, this scale will be used in all scale dependent entries such axes, grids, etc
      chart.yScale(logScale);

      // create data set on our data,also we can pud data directly to series
      var dataSet = anychart.data.set([
         
                 [ 'Trial Bore', 
                 <?php
                 foreach($yojanaId as $a){
                 $per1=0;
                                        $q1 = mysqli_query($con,"select * from schedule where yojanaId='$a' and subWork='Trial Bore'");
                                        $res1 = mysqli_fetch_assoc($q1);
                                        $per1 = $res1['percentage'];
                                        $count1 = mysqli_num_rows($q1);
                                        if($count1==0){
                                            $per1 = 0;
                                        }
                                        
                 ?>
                
                 '<?php echo $per1 ?>',
                 <?php } ?>
                
                 ],
                 ['Percolation Well',
                 
                  <?php
                 foreach($yojanaId as $b){
                 $per2=0;
                                        $q2 = mysqli_query($con,"select * from schedule where yojanaId='$b' and subWork='Percolation Well'");
                                        while($res2 = mysqli_fetch_assoc($q2)){
                                        $per2 += $res2['percentage'];
                                        }
                                        $count2 = mysqli_num_rows($q2);
                                        if($count2==0){
                                            $per2 = 0;
                                        
                                        }
                                        
                 ?>
                 
                 '<?php echo $per2 ?>',
                 <?php } ?>
                 ],
                 ['Approach Bund',
                 
                 <?php
                 foreach($yojanaId as $c){
                 $per3=0;
                                         $q3 = mysqli_query($con,"select * from schedule where yojanaId='$c' and subWork='Approach Bund'");
                                        while($res3 = mysqli_fetch_assoc($q3)){
                                        $per3 += $res3['percentage'];
                                        }
                                        $count3 = mysqli_num_rows($q3);
                                        if($count3==0){
                                            $per3 = 0;
                                        }
                                        
                 ?>
                 
                 '<?php echo $per3 ?>',
                 <?php } ?>
                 ],
                 ['Switch Room', 
                 
                 <?php
                 foreach($yojanaId as $d){
                 $per4=0;
                                        $q4 = mysqli_query($con,"select * from schedule where yojanaId='$d' and subWork='Switch Room'");
                                        while($res4 = mysqli_fetch_assoc($q4)){
                                        $per4 += $res4['percentage'];
                                        }
                                        $count4 = mysqli_num_rows($q4);
                                        if($count4==0){
                                            $per4 = 0;
                                        }
                                        
                 ?>
                 
                 '<?php echo $per4 ?>',
                 <?php } ?> 
                 ],
                 ['Pumping Machinery', 
                 
                 <?php
                 foreach($yojanaId as $e){
                 $per5=0;
                                        $q5 = mysqli_query($con,"select * from schedule where yojanaId='$e' and subWork='Pumping Machinery'");
                                        while($res5 = mysqli_fetch_assoc($q5)){
                                        $per5 += $res5['percentage'];
                                        }
                                        $count5 = mysqli_num_rows($q5);
                                        if($count5==0){
                                            $per5 = 0;
                                        }
                                        
                 ?>
                 
                 '<?php echo $per5 ?>',
                 <?php } ?>
                 ],
                 ['Rising Main', 
                 
                 <?php
                 foreach($yojanaId as $f){
                 $per6=0;
                                        $q6 = mysqli_query($con,"select * from schedule where yojanaId='$f' and subWork='Rising Main'");
                                        while($res6 = mysqli_fetch_assoc($q6)){
                                        $per6 += $res6['percentage'];
                                        }
                                        $count6 = mysqli_num_rows($q6);
                                        if($count6==0){
                                            $per6 = 0;
                                        }
                                        
                 ?>
                 
                 '<?php echo $per6 ?>',
                 <?php } ?>
                 ],
                 ['Elevated Service Reservoir',
                 
                 <?php
                 foreach($yojanaId as $g){
                 $per7=0;
                                        $q7 = mysqli_query($con,"select * from schedule where yojanaId='$g' and subWork='Elevated Service Reservoir'");
                                        while($res7 = mysqli_fetch_assoc($q7)){
                                        $per7 += $res7['percentage'];
                                        }
                                        $count7 = mysqli_num_rows($q7);
                                        if($count7==0){
                                            $per7 = 0;
                                        }
                                        
                 ?>
                 
                 '<?php echo $per7 ?>',
                 <?php } ?>
                 ],
                 ['Distribution System', 
                 
                 <?php
                 foreach($yojanaId as $h){
                  $per8=0;
                                        $q8 = mysqli_query($con,"select * from schedule where yojanaId='$h' and subWork='Distribution System'");
                                        while($res8 = mysqli_fetch_assoc($q8)){
                                        $per8 += $res8['percentage'];
                                        }
                                        $count8 = mysqli_num_rows($q8);
                                        if($count8==0){
                                            $per8 = 0;
                                        }
                                        
                 ?>
                 
                 '<?php echo $per8 ?>',
                 <?php } ?>
                 ],
                 ['MSEDC Work',
                 
                 <?php
                 foreach($yojanaId as $i){
                 $per9=0;
                                        $q9 = mysqli_query($con,"select * from schedule where yojanaId='$i' and subWork='MSEDC Work'");
                                        while($res9 = mysqli_fetch_assoc($q9)){
                                        $per9 += $res9['percentage'];
                                        }
                                        $count9 = mysqli_num_rows($q9);
                                        if($count9==0){
                                            $per9 = 0;
                                        }
                                        
                 ?>
                 
                 '<?php echo $per9 ?>',
                 <?php } ?>
                 ]
                
      ]);
     
      <?php
      $i=1;
      foreach($yojanaId as $a){
              $query1 = mysqli_query($con,"select * from yojanaMaster where yojanaId='$a'");
     
              $village = mysqli_fetch_assoc($query1);
              $v = $village['village'];
              $id = $village['yojanaId'];
      
      ?>

      // map data for the first series,take value from first column of data set
      var <?php echo $id ?> = dataSet.mapAs({ x: 0, value: <?php echo $i++; ?> });
      <?php } ?>

      // temp variable to store series instance
      
      <?php 
      foreach($yojanaId as $a){
           $query2 = mysqli_query($con,"select * from yojanaMaster where yojanaId='$a'");
     
              $vill = mysqli_fetch_assoc($query2);
              $vi = $vill['village'];
             $id = $vill['yojanaId'];
             
      ?>
      var series;

      // setup first series
      series = chart.line(<?php echo $id ?>);
      series.name('<?php echo $vi. " (".$id.")" ?>');
      // enable series data labels
      series.labels().enabled(true).anchor('left-bottom').padding(5);
      series.labels().format('{%Value}%');
      series.tooltip().format('{%SeriesName} : {%Value}%');
      
      // enable series markers
      series.markers(true);
      <?php } ?>

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
       /* $(".yojanaId option").each(function() {
            if($(this).siblings('[selected="selected"]')){
                $(this).siblings('[value="'+ this.value +'"]').remove();
            } else {
            }
        });*/
        
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
                url  : 'villagesAjaxMultiple',
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