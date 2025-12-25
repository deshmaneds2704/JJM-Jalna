<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/_con.php');

if(isset($_POST['subWork'])){
    $subWork = $_POST['subWork'];
    $yojanaId = $_REQUEST['yojanaId'];
    $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND id = '$subWork'");
    /*if(mysqli_num_rows($query)<=0){
        echo "noData";
    }*/
    $result = mysqli_fetch_assoc($query);
    $actualPrice = $result['actualPrice'];
    if($actualPrice == ""){
        $actualPrice = 0;
    }
    
    $q = mysqli_query($con, "SELECT SUM(amount) as amount FROM finance WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWork' ");
    $r = mysqli_fetch_assoc($q);
    $amount = $r['amount'];
    $remainingAmount = $r['remainingAmount'];
    if(empty($r['amount'])){
        $amount = 0;
    }
    
    // echo $subWork.":".$yojanaId;
    
    echo $actualPrice.":".$amount;
    
    /*$output = array(
        "actualPriceAjax" => $actualPrice,
        "remainingAmountAjax" => $remainingAmount
        );
        
    echo json_encode($output);*/
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Expenditures Entry</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<style>
.star{
        font-size:18px;
        color:red;
    }
    select.form-control {
        padding: 1.1375rem .75rem !important;
    }
    .tablehead {
        background: #0033c4;
        text-align: center;
        color: white;
        font-weight: bold;
    }
</style>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
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
                                     <center style="padding-bottom:30px;">
                                        <h3 class="ribbon">Expenditures Entry </h3>
                                        </center>
                                    <!--<h4 class="card-title">Financial Entry </h4>-->
                                    <?php 
                                    if(isset($_REQUEST['yojanaId'])){
                                        $page = "finance_db";
                                    } else {
                                        $page = "finance";
                                    }
                                    ?>
                                    <form action="<?php echo $page ?>" method="POST" enctype="multipart/form-data">
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
                                                            if($_REQUEST['taluka'] == $taluka){
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
                                                    <select class="js-example-basic-single" required id="yojanaId" name="yojanaId" style="width: 100%;">
                                                        <option disabled="" selected="" value=""></option>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster ORDER BY id DESC");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            
                                                            if($_SESSION['designation'] == "sectionEng"){
                                                                $q = mysqli_query($con, "SELECT * FROM allocatedYojana WHERE yojanaId = '{$result['yojanaId']}' AND userId = '{$_SESSION['userId']}'");
                                                                if(mysqli_num_rows($q) <=0 ){
                                                                    continue;
                                                                }
                                                            }
                                                            
                                                            if($_REQUEST['yojanaId'] == $result['yojanaId']){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option <?php echo $selected; ?> value="<?php echo $result['yojanaId'] ?>"><?php echo  $result['yojanaId']." - ".$result['yojanaName'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- -->
                                            <?php 
                                            if(isset($_REQUEST['yojanaId'])){
                                                $val = 'type="button" id="show"';
                                            } else {
                                                $val = 'type="submit"';
                                            }
                                            ?>
                                            <div class="col-md-2" style="display: flex;align-items: center;margin-bottom:1rem">
                                                <button class="btn btn-primary me-2" <?php echo $val ?> name="show">Show</button>
                                            </div>
                                        </div>
                                        <script>
                                            $("#show").on('click', function(){
                                                var taluka = $("#taluka").val();
                                                var yojanaId = $("#yojanaId").val();
                                                window.location = "finance?taluka="+taluka+"&yojanaId="+yojanaId;
                                            });
                                        </script>
                                        <?php
                                        if(isset($_REQUEST['yojanaId'])){
                                            $yojanaId = $_REQUEST['yojanaId'];
                                            $q1 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
                                            $r1 = mysqli_fetch_assoc($q1);
                                            $gst = $r1['gst'];
                                        ?>
                                        <!-- upload photo and mention steps-->
                                        <div class="row" style="align-items:end" id="html">
                                            
                                            
                                            
                                            <input type="hidden" value="">
                                            
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr class="tablehead">
                                                                <th>Sub Work</th>
                                                                <th>Sanctioned Cost</th>
                                                                <th>Spent Amount</th>
                                                                <th>Current Expense</th>
                                                                <th>Remark</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $countTrialBore = 1;
                                                            $countPercolation = 1;
                                                            $countApproach = 1;
                                                            $countPumping = 1;
                                                            $countRising = 1;
                                                            $countEsr = 1;
                                                            $countDistribution = 1;
                                                            $countMsedc = 1;
                                                            $countTrial = 1;
                                                            $countSwitch = 1;
                                                            $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' ");
                                                            while($result = mysqli_fetch_assoc($query)){
                                                                $id = $result['id'];
                                                                $actualPrice = $result['actualPrice'];
                                                                
                                                                $q = mysqli_query($con, "SELECT SUM(amount) as amount FROM finance WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWork' ");
                                                                $r = mysqli_fetch_assoc($q);
                                                                $amount = $r['amount'];
                                                                $remainingAmount = $r['remainingAmount'];
                                                                if(empty($r['amount'])){
                                                                    $amount = 0;
                                                                }
                                                                if($result['subWork'] == "Trial Bore"){
                                                                    $subWork = $countTrialBore++.". Trial Bore  (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                                    
                                                                } else if($result['subWork'] == "Percolation Well"){
                                                                    $subWork = $countPercolation++.". Percolation Well  (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                                    
                                                                } else if($result['subWork'] == "Approach Bund"){
                                                                    $subWork = $countApproach++.". ".$result['subWork']." (Length -".$result['length']." m)";
                                                                    
                                                                } else if($result['subWork'] == "Switch Room"){
                                                                    $subWork = $countSwitch++.". ".$result['subWork'];
                                                                    
                                                                } else if($result['subWork'] == "Pumping Machinery"){
                                                                    $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                                                                    
                                                                } else if($result['subWork'] == "Rising Main"){
                                                                    $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm<sup>2</sup> = ".$result['length']." m)";
                                                                    
                                                                } else if($result['subWork'] == "RCC ESR"){
                                                                    $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                                                                    
                                                                } else if($result['subWork'] == "Distribution System"){
                                                                    $subWork = $countApproach++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                                                                    
                                                                } else if($result['subWork'] == "MSEDC Work"){
                                                                    $subWork = $countMsedc++.". ".$result['subWork'];
                                                                    
                                                                } else if($result['subWork'] == "Trial & Run"){
                                                                    $subWork = $countTrial++.". ".$result['subWork']. " (Months - ".$result['month'].")";
                                                                    
                                                                } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                                                                    continue;
                                                                }
                                                                $usedPrice = 0;
                                                                $q = mysqli_query($con, "SELECT * FROM finance WHERE yojanaId = '$yojanaId' AND subWorkId = '$id'");
                                                                while($r = mysqli_fetch_assoc($q)){
                                                                    $usedPrice = $usedPrice + intval($r['amount']);
                                                                    $remark = $r['remark'];
                                                                }
                                                                
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <?php echo $subWork ?>
                                                                    <input type="hidden" value="<?php echo $id ?>" name="subWorkId[]">    
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control sanctionedCost" readonly="" name="actualPrice<?php echo $id ?>" value="<?php echo $actualPrice ?>" id="actualPrice<?php echo $id ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control spentCost" readonly="" value="<?php echo $usedPrice ?>" id="remainingAmount<?php echo $id ?>" name="remainingAmount<?php echo $id ?>">
                                                                    <input type="hidden" class="form-control" readonly="" value="<?php echo $usedPrice ?>" id="remainingAmountStatic<?php echo $id ?>">
                                                                </td>
                                                                <td>
                                                                    <input type="number" id="amount" name="amount<?php echo $id ?>" step='0.01' onkeyup="remainingAmountFun(this.value, 'actualPrice<?php echo $id ?>', 'remainingAmount<?php echo $id ?>', 'remainingAmountStatic<?php echo $id ?>')"  class="form-control currentCost" placeholder="0.00" min="0" />
                                                                </td>
                                                                <td><input type="text" class="form-control" id="remark" name="remark<?php echo $id ?>"></td>
                                                            </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                            <tr>
                                                                <th>
                                                                    Total 
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" readonly="" name="totalSanctionedCost" id="totalSanctionedCost">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" readonly="" name="totalSpentCost" id="totalSpentCost">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control" readonly="" name="totalCurrentCost" id="totalCurrentCost">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="text-align:right">
                                                                    GST 
                                                                </th>
                                                                <td>
                                                                    <select name="gst" id="gst" class="form-control" onchange="finialCost()" required>
                                                                        <option disabled="" selected="">Select GST</option>
                                                                        <option value="12" <?php if($gst == "12"){ ?> selected <?php } ?>>12 %</option>
                                                                        <option value="18" <?php if($gst == "18"){ ?> selected <?php } ?>>18 %</option>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="3" style="text-align:right">
                                                                    Total 
                                                                </th>
                                                                <td>
                                                                    <input type="text" class="form-control" readonly="" name="finialCurrentCost" id="finialCurrentCost">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!--<div class="col-md-1">
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
                                            </div>-->
                                        </div>
                                        <!-- -->
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary me-2" style="margin-top:1rem"> Submit </button>
                                        <?php
                                        }
                                        ?>
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
    
    <!--<script src="js/custom.js?v=1.0.4"></script>-->
    
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
        $("#subWork").on("change", function(){
            var amount = $(this).data('amount');
            console.log(amount);
        })
        
        $(".sanctionedCost").on('click', function(){
            sanctionedCostFun();
        })
        
        function sanctionedCostFun(){
            var totalSanctionedCost = 0;
            var finialCurrentCost = 0;
            var arr = $('.sanctionedCost').map(function () {
                totalSanctionedCost = totalSanctionedCost + Number($(this).val());
                // console.log($(this).data('per'));
            }).get();
            
            var finialCurrentCost = (totalSanctionedCost * <?php echo $gst ?>)/100;
            finialCurrentCost = finialCurrentCost + totalSanctionedCost;
            $("#totalSanctionedCost").val(totalSanctionedCost + " + <?php echo $gst ?>% = " + finialCurrentCost);
        }
        
        sanctionedCostFun();
        
        $(".spentCost").on('change', function(){
            spentCostFun();
        })
        
        function spentCostFun(){
            var totalSpentCost = 0;
            var arr = $('.spentCost').map(function () {
                totalSpentCost = totalSpentCost + Number($(this).val());
                // console.log($(this).data('per'));
            }).get();
            $("#totalSpentCost").val(totalSpentCost);
        }
        
        spentCostFun();
        
        
        $(".currentCost").on('keyup', function(){
            currentCostFun();
            spentCostFun();
            finialCost();
        })
        
        function currentCostFun(){
            var totalCurrentCost = 0;
            var arr = $('.currentCost').map(function () {
                totalCurrentCost = totalCurrentCost + Number($(this).val());
                // console.log($(this).data('per'));
            }).get();
            $("#totalCurrentCost").val(totalCurrentCost);
        }
        
        currentCostFun();
        
        
        function finialCost(){
            gst = $("#gst").val();
            var totalCurrentCost = parseInt($("#totalCurrentCost").val());
            var finialCurrentCost = (totalCurrentCost * gst)/100;
            finialCurrentCost = finialCurrentCost + totalCurrentCost;
            $("#finialCurrentCost").val(finialCurrentCost);
        }
        
        var count = 2;
        $("#remove").hide();
        var suspected = Number(20);
        $("#add").on("click", function on() {

            if (count <= 20) {

                var type = $('#element').val();

                $("#textboxDiv").append("<div class='row'><div class='col-md-4'><div class='form-group'><label for='docName'>Sub Work </label><select class='form-control' name='subWork[]'> <?php $query = mysqli_query($con, 'SELECT * FROM subWorkMaster'); while($result = mysqli_fetch_assoc($query)){ ?><option value='<?php echo $result['id'] ?>'><?php echo $result['subWork'] ?></option><?php } ?></select></div></div><div class='col-md-6'><div class='form-group'><label>Remark </label><input type='text' onkeyup='referred()' class='form-control' required name='remark" + count + "' id='remark'></div></div><div class='col-md-2'><div class='form-group'><label>Amount</label><input placeholder='0.00' type='number' name='amount[]' class='form-control' step='0.01' /></div></div>");
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

        });
        
        
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
            })
        })
        
        $("#subWork").on("change", function(){
            var subWork = $(this).val();
            var yojanaId = $("#yojanaId").val();
            var actualPrice = $("#actualPrice");
            var remainingAmount = $("#remainingAmount");
            var remainingAmountStatic = $("#remainingAmountStatic");
            var amount = $("#amount");
            var submit = $("#submit");
            console.log(yojanaId);
            submit.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            submit.prop('disabled', true);
            $.ajax({
                type : 'POST',
                url  : 'finance',
                data : {subWork:subWork, yojanaId:yojanaId},
                success:function(data){
                    console.log(data);
                    var explode = data.split(":");
                    actualPrice.val(explode[0]);
                    remainingAmount.attr('value', explode[1]);
                    remainingAmountStatic.attr('value', explode[1]);
                    // amount.attr('max', explode[1]);
                    submit.html('Submit');
                    submit.prop('disabled', false);
                }
            })
        })
        
        function remainingAmountFun(amount, actualPriceId, remainingAmountId, remainingAmountStaticId){
            var actualPrice = $("#"+actualPriceId).val();
            var remainingAmountTxt = $("#"+remainingAmountId);
            var remainingAmountStatic = Number($("#"+remainingAmountStaticId).val());
            remainingAmountTxt.attr('value', remainingAmountStatic + Number(amount));
        }
        
        /*$("#yojanaId").on('change', function(){
            var yojanaId = $(this).val();
            var html = $("#html");
            $.ajax({
                type : 'POST',
                url  : 'finance',
                data : {yojanaId:yojanaId},
                success:function(data){
                    html.html(data);
                }
            })
        })*/
    </script>
</body>

</html>