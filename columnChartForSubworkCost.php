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
                        
                                    <form action="columnChartForSubworkCost" method="GET" enctype="multipart/form-data">
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
                                    
                                        ?>
                                        
     <!-- GRAPH -->
  <div id="container" style="height:400px;width:100%"></div>
  

  <script>

    anychart.onDocumentReady(function () {
      // create data set on our data
      var chartData = {
          
        <?php 
        
        //TRIAL BORE
        
         $query1 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='Trial & Run'");
          $fetch1 = mysqli_fetch_assoc($query1);
          $cost1 = $fetch1['actualPrice'];
          
          $subworkid1 = $fetch1['id'];
         
          
          $query2 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid1' ");
          $fetch2 = mysqli_fetch_assoc($query2);
          $amount2 = $fetch2['amount'];
          $count1 = mysqli_num_rows($query2);
          if($count1==0){
              $amount2=0;
          }
          $remainingamount2 = $cost1 - $amount2;
          
         
          //PERCOLATION WELL
          
          $query3 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='Percolation Well'");
          $fetch3 = mysqli_fetch_assoc($query3);
          $cost3 = $fetch3['actualPrice'];
          $subworkid3 = $fetch3['id'];
         
          
          $query4 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid3' ");
          $fetch4 = mysqli_fetch_assoc($query4);
          $amount4 = $fetch4['amount'];
          $count2 = mysqli_num_rows($query4);
          if($count2==0){
              $amount4=0;
          }
          $remainingamount4 = $cost3 - $amount4;
          
          
          //RISING MAIN
          
          $query5 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='Rising Main'");
          $fetch5 = mysqli_fetch_assoc($query5);
         $cost5 = $fetch5['actualPrice'];
          $subworkid5 = $fetch5['id'];
          
          
          $query6 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid5' ");
          $fetch6 = mysqli_fetch_assoc($query6);
          $amount6 = $fetch6['amount'];
          $count3 = mysqli_num_rows($query6);
          if($count3==0){
              $amount6=0;
          }
          $remainingamount6 = $cost5 - $amount6;
          
          
          
          //APPROACH BUND
          
          $query7 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='Approach Bund'");
          $fetch7 = mysqli_fetch_assoc($query7);
          $cost7 = $fetch1['actualPrice'];
          $subworkid7 = $fetch1['id'];
          
          $query8 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid7' ");
          $fetch8 = mysqli_fetch_assoc($query8);
          $amount8 = $fetch8['amount'];
          $count4 = mysqli_num_rows($query8);
          if($count4==0){
              $amount8=0;
          }
          $remainingamount8 = $cost7 - $amount8;
         
          
          //DISTRIBUTION SYSTEM
          
          $query9 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='Distribution System'");
          $fetch9 = mysqli_fetch_assoc($query9);
          $cost9 = $fetch9['actualPrice'];
          $subworkid9 = $fetch9['id'];
         
          
          $query10 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid9' ");
          $fetch10 = mysqli_fetch_assoc($query10);
          $amount10 = $fetch10['amount'];
          $count5 = mysqli_num_rows($query10);
          if($count5==0){
              $amount10=0;
          }
          $remainingamount10 = $cost9 - $amount10;
         
          
          //PUMPING MACHINERY
          
          $query11 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='Pumping Machinery'");
          $fetch11 = mysqli_fetch_assoc($query11);
          $cost11 = $fetch11['actualPrice'];
          $subworkid11 = $fetch11['id'];
          
          
          $query12 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid11' ");
          $fetch12 = mysqli_fetch_assoc($query12);
          $amount12 = $fetch12['amount'];
          $count6 = mysqli_num_rows($query12);
          if($count6==0){
              $amount12=0;
          }
           $remainingamount12 = $cost11 - $amount12;
         
          
          //RCC ESR
          
          $query13 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='RCC ESR'");
          $fetch13 = mysqli_fetch_assoc($query13);
          $cost13 = $fetch13['actualPrice'];
          $subworkid13 = $fetch13['id'];
          
          
          $query14 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid13' ");
          $fetch14 = mysqli_fetch_assoc($query14);
          $amount14 = $fetch14['amount'];
          $count7 = mysqli_num_rows($query14);
          if($count7==0){
              $amount14=0;
          }
           $remainingamount14 = $cost13 - $amount14;
         
          //MSEDC WORK
          
          $query15 = mysqli_query($con,"select * from subWork where yojanaId='$yojanaId' and subWork='MSEDC Work'");
          $fetch15 = mysqli_fetch_assoc($query15);
          $cost15 = $fetch15['actualPrice'];
          $subworkid15 = $fetch15['id'];
         
          
          $query16 = mysqli_query($con,"select * from finance where yojanaId='$yojanaId' and subWorkId='$subworkid15' ");
          $fetch16 = mysqli_fetch_assoc($query16);
          $amount16 = $fetch16['amount'];
          $count8 = mysqli_num_rows($query16);
          if($count8==0){
              $amount16=0;
          }
          $remainingamount16 = $cost15 - $amount16;
         
          ?>
          
          
          
          
        title: 'Subwork cost status',
        header: ['#', 'Total Sanctioned Cost', 'Expenditure', 'Remaining Amount'],
        rows: [
          ['Trial Bore', <?php echo $cost1 ?>, <?php echo $amount2 ?>, <?php echo $remainingamount2 ?>],
         
          ['Percolation Well', <?php echo $cost3 ;?>, <?php echo $amount4 ; ?>, <?php echo $remainingamount4 ; ?>],
         
          ['Rising Main',<?php echo $cost5 ?>,<?php echo $amount6 ?>,<?php echo $remainingamount6 ?>],
         
          ['Approach Bund', <?php echo $cost7 ?>, <?php echo $amount8 ?>, <?php echo $remainingamount8 ?>],
          
          ['Distribution System',<?php echo $cost9 ?>,<?php echo $amount10 ?>,<?php echo $remainingamount10 ?>],
         
          ['Pumping Machinery',<?php echo $cost11 ?>,<?php echo $amount12 ?>,<?php echo $remainingamount12 ?>],
         
          ['Elevated Service Reservoir',<?php echo $cost13 ?>,<?php echo $amount14 ?>,<?php echo $remainingamount14 ?>],
          
          ['MSEDC Work',<?php echo $cost15 ?>,<?php echo $amount16 ?>,<?php echo $remainingamount16 ?>]
        ]
      };

      // create column chart
      var chart = anychart.column();

      // set chart data
      chart.data(chartData);

      // turn on chart animation
      chart.animation(true);

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
      chart.container('container');

      // initiate chart drawing
      chart.draw();
    });
  
</script>
  
 <!-- <script>
      // create data
var data = [
    
    <?php
    
    //TOTAL SANCTIONED COST
    
    $query1 = mysqli_query($con,"select * from yojanaMaster where yojanaid='$yojanaId'");
    $fetch1 = mysqli_fetch_assoc($query1);
    $cost = $fetch1['totalSanctionedCost'];
    $count1=mysqli_num_rows($query1);
    if($count1==0){
        $cost=0;
    }
    
    //AMOUNT
    
    $amount=0;
    $query2 = mysqli_query($con,"select * from finance where yojanaid='$yojanaId'");
    while($fetch2 = mysqli_fetch_assoc($query2)){
    $amount += $fetch2['amount'];
    }

    $count2=mysqli_num_rows($query2);
    if($count2==0){
        $amount=0;
    }
    
   //REMAINING AMOUNT
   
    $remainingamount = $cost - $amount;

    ?>
    
  {x : "Total Sanctioned Cost", value : <?php echo $cost ?>,
      normal:   {
               fill: "#ADD8E6",
               stroke: null,
               label: {enabled: true}
             }
  },
  {x : "Expenditure", value : <?php echo $amount ?>,
  normal:   {
               fill: "#76BA1B",
               stroke: null,
               label: {enabled: true}
             }
      
  },
  {x : "Remaining amount", value : <?php echo $remainingamount ?>,
  normal:   {
               fill: "#FFA500",
               stroke: null,
               label: {enabled: true}
             }
      
  }
  
];

// create a chart
chart = anychart.column();

// create a bar series and set the data
var series = chart.column(data);
series.name("₹ ");

// set the container id
chart.container("container");

// initiate drawing the chart
chart.draw();

// set the chart title
    chart.title("Expenses ");

    // set the titles of the axes
    chart.xAxis().title("Cost Status");
    chart.yAxis().title("Amount, ₹");

  </script>-->
  
<!-- -->

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