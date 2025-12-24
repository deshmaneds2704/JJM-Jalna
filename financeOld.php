<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');

if(isset($_POST['yojanaId'])){
    $yojanaId = $_POST['yojanaId'];
    $query = mysqli_query($con, "SELECT * FROM finance WHERE yojanaId = '$yojanaId'");
    /*if(mysqli_num_rows($query)<=0){
        echo "noData";
    }*/
    
?>

<div class="col-md-11">
    
    <div id="textboxDiv">
        <?php 
        while($result = mysqli_fetch_assoc($query)){
            $amount = 0;
        ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="docName">Sub Work </label>
                    <select class="form-control" name="subWork[]">
                        <?php 
                        $q = mysqli_query($con, "SELECT * FROM subWorkMaster");
                        while($r = mysqli_fetch_assoc($q)){
                            if($r['id'] == $result['subWorkId']){
                                $selected = "selected";
                                $q2 = mysqli_query($con, "SELECT * FROM subWork WHERE name = '{$r['id']}' AND yojanaId = '$yojanaId'");
                                $r2 = mysqli_fetch_assoc($q2);
                                $amount = $r2['amount'];
                            } else {
                                $selected = "";
                            }
                        ?>
                        <option value="<?php echo $r['id'] ?>" <?php echo $selected ?>><?php echo $r['subWork'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="docName">Remark </label>
                    <input type="text" class="form-control" value="<?php echo $result['remark'] ?>" id="remark" name="remark[]">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount[]" step='0.01' max="<?php echo $amount ?>" value="<?php echo $result['amount'] ?>"  class="form-control" />
                </div>
            </div>
        </div>
        <?php 
        }
        ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="docName">Sub Work </label>
                    <select class="form-control" id="subWork" name="subWork[]">
                        <?php 
                        $q = mysqli_query($con, "SELECT * FROM subWorkMaster");
                        while($r = mysqli_fetch_assoc($q)){
                            $q2 = mysqli_query($con, "SELECT * FROM subWork WHERE name = '{$r['id']}' AND yojanaId = '$yojanaId'");
                            $r2 = mysqli_fetch_assoc($q2);
                            $amount = $r2['amount'];
                        ?>
                        <option value="<?php echo $r['id'] ?>" data-amount="<?php echo $amount ?>" ><?php echo $r['subWork'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="docName">Remark </label>
                    <input type="text" class="form-control" value="<?php echo $result['remark'] ?>" id="remark" name="remark[]">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" name="amount[]" step='0.01' max="<?php echo $amount ?>" value="<?php echo $result['amount'] ?>"  class="form-control" />
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" value="">

<div class="col-md-1">
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
<script src="js/custom.js?v=1.0.2"></script>
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
</head>
<style>
    select.form-control {
        padding: 1.1375rem .75rem !important;
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
                                        <h3 class="ribbon">Finacial Entry </h3>
                                        </center>
                                    <!--<h4 class="card-title">Finacial Entry </h4>-->
                                    <form action="finance_db" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <!-- taluka-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>तालुका</label>
                                                    <select class="js-example-basic-single" id="taluka" name="taluka" style="width: 100%;">
                                                        <option value="" selected="" disabled=""></option>
                                                        <?php 
                                                        $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $taluka = $result['taluka'];
                                                        ?>
                                                        <option value="<?php echo $taluka ?>"><?php echo $taluka ?></option>
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
                                            <div class="col-md-6">
                                                <div class="form-group" id="yojanaHtml">
                                                    <label>योजनेचे नाव</label>
                                                    <select class="js-example-basic-single" id="yojanaId" name="yojanaId" style="width: 100%;">
                                                        <option disabled="" selected=""></option>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                        ?>
                                                        <option value="<?php echo $result['yojanaId'] ?>"><?php echo $result['yojanaName'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- -->
                                        </div>
    
                                        <!-- upload photo and mention steps-->
                                        <div class="row" style="align-items:end" id="html">
                                            <div class="col-md-11">
                                                <div id="textboxDiv">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="docName">Sub Work </label>
                                                                <select class="form-control" id="subWork" data-amount"123" name="subWork[]">
                                                                    <?php 
                                                                    $query = mysqli_query($con, "SELECT * FROM subWorkMaster");
                                                                    while($result = mysqli_fetch_assoc($query)){
                                                                        $q2 = mysqli_query($con, "SELECT * FROM subWork WHERE name = '{$result['id']}' AND yojanaId = '$yojanaId'");
                                                                        $r2 = mysqli_fetch_assoc($q2);
                                                                        $amount = $r2['amount'];
                                                                    ?>
                                                                    <option value="<?php echo $result['id'] ?>" data-amount="<?php echo $amount ?>" ><?php echo $result['subWork'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
    
                                                        <!-- -->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="docName">Remark </label>
                                                                <input type="text" class="form-control" id="remark" name="remark[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Amount</label>
                                                                <input type="number" name="amount[]" step='0.01'   class="form-control" placeholder="0.00" min="0" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <input type="hidden" value="">
    
                                            <div class="col-md-1">
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
                                        <!-- -->
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary me-2"> Submit </button>
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