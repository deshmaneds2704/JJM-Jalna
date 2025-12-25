<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/_con.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <title>Quality Certificate</title>
    
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
    <style>
     .star{
        font-size:18px;
        color:red;
    }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 20px;
}
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
        /*if(isset($_GET['yojanaId'])){
            $yojanaId = $_GET['yojanaId'];
            $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
            $result = mysqli_fetch_assoc($query);
            $talukaNew = $result['taluka'];
        }*/
        ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                    </div>
                    <div class="row">
                        <form action="qualityCertificate_db" method="POST" enctype="multipart/form-data">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <center style="padding-bottom:30px;">
                                        <h3 class="ribbon">Quality certificate </h3>
                                        </center>
                                        <div class="row">
                                            <!-- taluka-->
                                            <div class="form-group col-md-6">
                                                <label for="taluka">Taluka</label>
                                                <select class="js-example-basic-single" id="taluka" name="taluka" style="width: 100%;">
                                                    <option value="" selected="" disabled=""></option>
                                                    <?php 
                                                    $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                                                    while($result = mysqli_fetch_assoc($query)){
                                                        $taluka = $result['taluka'];
                                                        if($talukaNew == $taluka){
                                                            $selected = "selected";
                                                        } else {
                                                            $selected = "";
                                                        }
                                                    ?>
                                                    <option value="<?php echo $taluka ?>" <?php echo $selected ?>><?php echo $taluka ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- -->
                                            
                                            <!--village-->
                                            <!--<div class="form-group col-md-3">
                                                <label for="village">गाव</label>
                                                <div id="village">
                                                    <select class="js-example-basic-multiple" name="village[]" multiple="multiple" style="width: 100%;">
                                                        <option></option>
                                                    </select> 
                                                </div>
                                            </div>-->
                                            <!-- -->
                                            
                                            <!--yojana-->
                                            <div class="col-md-6">
                                                <div class="form-group" id="yojanaHtml">
                                                    <label>Name of Scheme <span class="star">*</span></label>
                                                    <select class="js-example-basic-single" required id="yojanaId" name="yojanaId" style="width: 100%;">
                                                        <option disabled="" value="" selected=""></option>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster ORDER BY id DESC");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            if($result['yojanaId'] == $yojanaId){
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
                                            <!-- -->
                                        </div>
    
                                        <!-- upload photo and mention steps-->
                                        <div class="row" style="align-items:end">
                                            <div class="col-md-11">
                                                <div id="textboxDiv">
                                                    <div class="row">
                                                        <!-- steps-->
                                                        <!--<div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Step</label>
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input type="radio" class="form-check-input"name="step0" id="optionsRadios1" value="1" /> 1 
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input type="radio" class="form-check-input" name="step0" id="optionsRadios2" value="2" /> 2 
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input type="radio" class="form-check-input" name="step0" id="optionsRadios3" value="3" /> 3 
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input type="radio" class="form-check-input" name="step0" id="optionsRadios4" value="4" /> 4 
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input type="radio" class="form-check-input" name="step0" id="optionsRadios4" value="5" /> 5 
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>-->
    
                                                        <!-- -->
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="docName">Sub Work <span class="star">*</span></label>
                                                                <select class="form-control" required id="subWork" name="subWork[]" style="width: 100%;">
                                                                    <option disabled="" value="" selected=""></option>
                                                                    <?php
                                                                    $query = mysqli_query($con, "SELECT * FROM subWorkMaster WHERE type = ''");
                                                                    while($result = mysqli_fetch_assoc($query)){
                                                                    ?>
                                                                    <option><?php echo $result['subWork'] ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <!--<input type="text" class="form-control" id="docName" name="docName[]">-->
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="docName">Document Name <span class="star">*</span></label>
                                                                <select class="form-control" required id="docName" name="docName[]" style="width: 100%;">
                                                                    <option disabled="" value="" selected=""></option>
                                                                    <option>Third party inspection certificate</option>
                                                                    <option>Thrid part report</option>
                                                                    <option>Warranty certificate</option>
                                                                    <option>Warranty card</option>
                                                                    <option>Cement</option>
                                                                    <option>Sand</option>
                                                                    <option>Aggregates</option>
                                                                    <option>Steel</option>
                                                                    <option>Bricks</option>
                                                                    <option>Concrete Cube</option>
                                                                </select>
                                                                <!--<input type="text" class="form-control" id="docName" name="docName[]">-->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Upload File<span class="star">*</span></label>
                                                                <input type="file" required name="document[]" accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx" class="form-control" />
                                                                <!--<input type="file" name="document[]" accept=".jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx" class="file-upload-default" />
                                                                            <div class="input-group col-xs-12">
                                                                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image" />
                                                                                <span class="input-group-append">
                                                                                    <button class="file-upload-browse btn btn-primary" type="button"> Upload </button>
                                                                                </span>
                                                                            </div>-->
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
                                                            <button type="button" class="btn " id="add" style="padding:0px;">
                                                                <i class="mdi mdi-plus-circle" style="font-size: 2.5rem;color: green;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group ">
                                                            <button type="button" class="btn " id="remove" style="padding:0px;">
                                                                <i class="mdi mdi-minus-circle" style="font-size: 2.5rem;color: red;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- -->
                                        <button type="submit" name="submit" class="btn btn-primary me-2"> Submit </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    <script src="js/custom.js?v=1.0.4"></script>
    <!-- End custom js for this page -->
    
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
                // $("#textboxDiv").append("<div class='row'><div class='col-md-3'><div class='form-group'><label>Step</label><div class='row'><div class='col-2'><div class='form-check'><label class='form-check-label'><input type='radio' class='form-check-input' name='step"+count+"' id='optionsRadios1' value='1' />1<i class='input-helper'></i></label></div></div><div class='col-2'><div class='form-check'><label class='form-check-label'><input type='radio' class='form-check-input' name='step"+count+"' id='optionsRadios1' value='2' />2<i class='input-helper'></i></label></div></div><div class='col-2'><div class='form-check'><label class='form-check-label'><input type='radio' class='form-check-input' name='step"+count+"' id='optionsRadios1' value='3' />3<i class='input-helper'></i></label></div></div><div class='col-2'><div class='form-check'><label class='form-check-label'><input type='radio' class='form-check-input' name='step"+count+"' id='optionsRadios1' value='4' />4<i class='input-helper'></i></label></div></div><div class='col-2'><div class='form-check'><label class='form-check-label'><input type='radio' class='form-check-input' name='step"+count+"' id='optionsRadios1' value='5' />5<i class='input-helper'></i></label></div></div></div></div></div><div class='col-md-4'><div class='form-group'><label>Document Name </label><input type='text' onkeyup='referred()' class='form-control' required name='docName[]' id='doc'></div></div><div class='col-md-5'><div class='form-group'><label>Upload File</label><input type='file' name='document[]' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div></div>");
                $("#textboxDiv").append("<div class='row'><div class='col-md-3'><div class='form-group'><label for='docName'>Sub Work <span class='star'>*</span></label><select class='form-control' required id='subWork' name='subWork[]' style='width: 100%;'><option disabled='' value='' selected=''></option><?php $query = mysqli_query($con, "SELECT * FROM subWorkMaster WHERE type = ''"); while($result = mysqli_fetch_assoc($query)){ ?> <option><?php echo $result['subWork'] ?></option><?php } ?></select></div></div><div class='col-md-3'><div class='form-group'><label>Document Name <span class='star'>*</span></label><select class='form-control' id='docName' name='docName[]' style='width: 100%;' required><option disabled='' value='' selected=''></option><option>Third party inspection certificate</option><option>Thrid part report</option><option>Warranty certificate</option><option>Warranty card</option><option>Cement</option><option>Sand</option><option>Aggregates</option><option>Steel</option><option>Bricks</option><option>Concrete Cube</option></select></div></div><div class='col-md-6'><div class='form-group'><label>Upload File<span class='star'>*</span></label><input type='file' name='document[]' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div></div>");
                radio = radio + 1;
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
        
        
        $("#taluka").on("change", function(){
            var taluka = $(this).val();
            var village = $("#village");
            console.log(village.html());
            village.html("Please Wait");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {taluka:taluka},
                success:function(data){
                    village.html(data);
                }
            })
        })
    </script>
</body>

</html>