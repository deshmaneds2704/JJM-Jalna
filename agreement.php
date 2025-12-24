<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    exit;
    die();
}
require_once('include/con.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!--  meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <title>Argeement</title>
    
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
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
    <style>
     .star{
        font-size:18px;
        color:red;
    }
        .range-slider {
            margin: 2px 0 0 0;
        }

        .range-slider input[type="range"] {
            width: calc(100% - (68px));
            height: 10px;
            border-radius: 5px;
            background: #d7dcdf;
            outline: none;
            float: left;
            -webkit-appearance: none;
        }

        .range-slider input[type="range"]::-webkit-slider-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #2c3e50;
            cursor: pointer;
            transition: background .15s ease-in-out;
            -webkit-appearance: none;
            appearance: none;
        }

        .range-slider input[type="range"]::-webkit-slider-thumb:hover,
        .range-slider input[type="range"]:active::-webkit-slider-thumb {
            background: #4cb2ef;
        }

        .range-slider input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border: 0;
            border-radius: 50%;
            background: #2c3e50;
            cursor: pointer;
            transition: background .15s ease-in-out;
        }

        .range-slider input[type="range"]::-moz-range-thumb:hover,
        .range-slider input[type="range"]:active::-moz-range-thumb {
            background: #4cb2ef;
        }
        
        horizontal-menu.fixed-on-scroll + .page-body-wrapper {
    padding-top: 0px;
}

        .range-slider .range-value {
            display: inline-block;
            width: 60px;
            background: #2c3e50;
            border-radius: 3px;
            padding: 5px 10px;
            margin-left: 8px;
            line-height: 20px;
            color: #fff;
            text-align: center;
            position: relative;
            top: -10px;
        }

        .range-slider .range-value:after {
            content: "";
            border-right: 7px solid #2c3e50;
            border-top: 7px solid transparent;
            border-bottom: 7px solid transparent;
            position: absolute;
            top: 8px;
            left: -7px;
        }

        ::-moz-range-track {
            background: #d7dcdf;
            border: 0;
        }


        .steps {
            list-style: none;
            margin: 0;
            padding: 0;
            display: table;
            table-layout: fixed;
            width: 100%;
            color: #929292;
            height: 4rem;
        }

        .steps>.step {
            position: relative;
            display: table-cell;
            text-align: center;
            font-size: 0.875rem;
            color: #6D6875;
        }

        .steps>.step:before {
            content: attr(data-step);
            display: block;
            margin: 0 auto;
            background: #ffffff;
            border: 2px solid #e6e6e6;
            color: #e6e6e6;
            width: 2rem;
            height: 2rem;
            text-align: center;
            margin-bottom: -4.2rem;
            line-height: 1.9rem;
            border-radius: 100%;
            position: relative;
            z-index: 1;
            font-weight: 700;
            font-size: 1rem;
            top:37%;
        }

        .steps>.step:after {
            content: "";
            position: absolute;
            display: block;
            background: #e6e6e6;
            width: 100%;
            height: 0.125rem;
            top: 2.5rem;
            left: 50%;
        }

        .steps>.step:last-child:after {
            display: none;
        }

        .steps>.step.is-complete {
            color: #6D6875;
        }

        .steps>.step.is-complete:before {
            content: "✓";
            color: #3CB371;
            background: #e2fefb;
            border: 2px solid #3CB371;
        }

        .steps>.step.is-incomplete:before {
                content: "!";
                color: red;
                background: yellow;
                border: 2px solid red;
        }  

        .steps>.step.is-complete:after {
            background: #3CB371;
        }

        .steps>.step.is-active {
            font-weight: bold;
            

        }

        .steps>.step.is-active:before {
            color: #FFF;
            border: 2px solid #0033c4;
            background: #0033c4;
            margin-bottom: -4.9rem;
        }

        .steps {
            margin-top: 3em;
        }
        
        .hide{
            display: none;
        }
        .center {
            text-align: center;
        }
        .pointer{
            cursor: pointer;
        }
        ul li, ol li, dl li {
            line-height: 1.3;
        }
        .text{
            font-size: 10px;
        }
         @media screen and (max-width: 600px) {
             .text{
                 font-size: 8px;
             }
              .font
             {
                 font-size: 10px;
             }
             #above_1
             {
                margin-top:20px; 
             }
             #margin_1
             {
                 margin-top: -20px;
             }
             .bottom
             {
                 margin-bottom:10px;
             }
             
        }
        
        .ribbon {
            padding: 15px;
            height: 50px;
            background: #6a8ab8;
            -webkit-clip-path: polygon(100% 0, 95% 50%, 100% 100%, 0% 100%, 5% 50%, 0% 0%);
                  clip-path: polygon(100% 0, 95% 50%, 100% 100%, 0% 100%, 5% 50%, 0% 0%);
            font-family: "font_condensed";
            text-transform: uppercase;
            color: #fff;
            letter-spacing: 0.18em;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 450px;
        }
       @media screen and (max-width: 600px) {
            .ribbon{
                font-size: 100%;
            }
    </style>

</head>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
        
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $query = mysqli_query($con, "SELECT * FROM agreement WHERE id = '$id'");
            $result = mysqli_fetch_assoc($query);
            
            $contractor = $result['contractor'];
            $yojanaId = $result['yojanaId'];
            $agreementNo = $result['agreementNo'];
            $timeLimit = $result['timeLimit'];
            $dateOfWorkOrder = $result['dateOfWorkOrder'];
            $tenderCost = $result['tenderCost'];
            $acceptedCost = $result['acceptedCost'];
            $percentage = $result['percentage'];
            $above_below1 = $result['above_below'];
            
            $back = '<a href="agreementReport" style="text-align: left;"><button type="button" class="btn btn-primary me-2 bottom">Back</button></a>';
        } else {
            $back = '';
        }
        ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                
                                <div class="card-body">
                                    <?php echo $back; ?>
                                    <center style="padding-bottom:30px;"><h3 class="ribbon">Add Agreement</h3></center>
                                    
                                    <form class="forms-sample" action="agreement_db" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Contractor's Name <span class="star">*</span></label>
                                                    <select class="js-example-basic-single" required="" id="contractor" name="contractor" style="width: 100%;">
                                                        <option value="" selected="" disabled=""></option>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'contractor'");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            if($result['userId'] == $contractor){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option <?php echo $selected ?> value="<?php echo $result['userId'] ?>" ><?php echo $result['fullName'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Scheme <span class="star">*</span></label>
                                                    <select class="js-example-basic-single" required="" id="yojanaId" name="yojanaId" style="width: 100%;">
                                                        <option value="" selected="" disabled=""></option>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM yojanaMaster ORDER BY id DESC ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            if($result['yojanaId'] == $yojanaId){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";                                                                
                                                            }
                                                        ?>
                                                        <option <?php echo $selected ?> value="<?php echo $result['yojanaId'] ?>" ><?php echo $result['yojanaId']." - ".$result['yojanaName'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="argeementNo">Agreement Number<span class="star">*</span></label>
                                                    <input type="number" value="<?php echo $agreementNo ?>" step="0.01" required="" class="form-control" name="argeementNo" id="argeementNo">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for=timeLimit"">Time Limit (Months)<span class="star">*</span></label>
                                                    <input type="text" value="<?php echo $timeLimit ?>" required="" class="form-control" name="timeLimit" id="timeLimit">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="dateWorkOrder">Date of Work Order<span class="star">*</span></label>
                                                    <input type="date" class="form-control" value="<?php echo $dateOfWorkOrder ?>" required="" name="dateWorkOrder" id="dateWorkOrder">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="tenderCost">Tender Cost<span class="star">*</span></label>
                                                    <input type="number" step="0.01" class="form-control" onkeyup="acceptedCostFun()" value="<?php echo $tenderCost ?>" required="" name="tenderCost" id="tenderCost">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="acceptedCost">Accepted Cost <span class="star">*</span></label>
                                                    <input type="number" step="0.01" class="form-control" name="acceptedCost" readonly=""  required="" value="<?php echo $acceptedCost ?>" id="acceptedCost">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3" id="margin_1">
                                                <div class="form-group">
                                                    <label for="tenderCost"></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <select class="js-example-basic-single" required="" onchange="acceptedCostFun()" id="above_below" name="above_below" style="width: 100%;">
                                                                <option value="" selected="" disabled="">Above/Below</option>
                                                                <?php 
                                                                $above_belowArray = array(
                                                                    'Above' => 'above',
                                                                    'Below' => 'below'
                                                                    );
                                                                foreach ($above_belowArray as $above_below => $key ){
                                                                    if($above_below == $above_below1){
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                ?>
                                                                <option <?php echo $selected ?>><?php echo $above_below ?></option>
                                                                <?php 
                                                                }
                                                                ?>
                                                            </select>  
                                                        </div>
                                                        <div class="col-md-6" id="above_1">
                                                            <span style="display: flex;align-items: center;font-size: 18px;"><input type="number" step="0.01" class="form-control" value="<?php echo $percentage ?>" placeholder="Percentage" required="" onkeyup="acceptedCostFun()" name="percentage" id="percentage">&nbsp;&nbsp;%</span>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>
                                        
                                        
                                        <?php
                                        if(isset($_GET['id'])){
                                        ?>
                                        <button type="submit"  name="update" value="<?php echo $_GET['id'] ?>" class="btn btn-primary me-2"> Update </button>
                                        <?php
                                        } else {
                                        ?>
                                        <button type="submit"  name="submit" class="btn btn-primary me-2"> Submit </button>
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
    
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
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

    <script type="text/javascript">
    
        function acceptedCostFun(){
            var tenderCost = parseFloat($("#tenderCost").val());
            var above_below = $("#above_below").val();
            var percentage = parseFloat($("#percentage").val());
            var acceptedCost = 0;
            if(above_below == "Above"){
                acceptedCost = (tenderCost * percentage)/100;
                acceptedCost = acceptedCost + tenderCost;
            } else if(above_below == "Below"){
                acceptedCost = (tenderCost * percentage)/100;
                acceptedCost = tenderCost - acceptedCost;
            }
            $("#acceptedCost").val(acceptedCost);
        }
    
        function percentageFun(val){
            $("#percentage").val('');
            $("#percentage").val(val+"%");
        }
        
        function isInputNumber(evt) {
            var ch = String.fromCharCode(evt.which);
            if (!(/[0-9]/.test(ch))) {
                evt.preventDefault();
                if (!$('#mobile').val().match('[0-9]{10}')) {
                    alert("Enter Valid Mobile Number...");
                    return;
                }
            }
        }
        
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location+"?yojanaId="+yojanaId;   
            }
        }
        $(document).ready(function () {
            var rangeSlider = function () {
                var slider = $('.range-slider'),
                    range = $('.range-slider input[type="range"]'),
                    value = $('.range-value');

                slider.each(function () {
                    value.each(function () {
                        var value = $(this).prev().attr('value');
                        var v = value + "%";
                        $(this).html(v);
                    });
                    range.on('input', function () {


                        var val = this.value + "%";
                        $(this).next(value).html(val);

                    });
                });
            };
            rangeSlider();
        });


    </script>


    <script>
        var count = 4;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var type = $('#element').val();
                // $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>दस्तऐवजाचा प्रकार </label><input type='text' onkeyup='referred()' class='form-control'  name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='img[]' class='file-upload-default' /><div class='input-group col-xs-12'><input type='text' class='form-control file-upload-info' disabled placeholder='Upload Image' /><span class='input-group-append'> <button class='file-upload-browse btn btn-primary' type='button'> Upload </button></span></div></div></div>");
                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>दस्तऐवजाचा प्रकार </label><input type='text' onkeyup='referred()' class='form-control'  name='docName" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='photo" + count + "' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div></div>");
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
            if (count > 4) {
                $("#textboxDiv").children().last().remove();
                count = count - 1;
                count2 = count - 1;
                // document.getElementById("total_member").value = count2;
                $("#add").show();
                if (count == 4) {
                    $("#remove").hide();
                }
            } else {
                $("#remove").hide();
            }
        });

        $("#taluka").on("change", function () {
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
        })

        flatpickr(".datepicker", {
            dateFormat: "Y"
        });
    </script>

</body>

</html>