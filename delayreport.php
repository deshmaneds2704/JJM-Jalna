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
    <title> Delay Report</title>
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

    <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
    <!-- End layout styles -->
</head>
<style>
    select.form-control {
        padding: 1.1375rem .75rem !important;
    }

    .tableHead {
        background: #0033c4;
        /*text-align: center;*/
        color: white;
        font-weight: bold;
    }

    .center {
        text-align: center;
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
        top: 37%;
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
        line-height: 50px;

    }

    .steps>.step.is-active:before {
        color: #FFF;
        border: 2px solid #0033c4;
        background: #0033c4;
        margin-bottom: -4.9rem;
    }

    .steps {
        margin-top: 3em;
        cursor: pointer;
    }

    .hide {
        display: none;
    }

    .center {
        text-align: center;
    }

    .pointer {
        cursor: pointer;
    }

    ul li,
    ol li,
    dl li {
        line-height: 1.3;
    }

    .pumpRisingMain {
        font-size: 10px;
    }

    @media screen and (max-width: 600px) {
        .pumpRisingMain {
            font-size: 8px;
        }

        .font {
            font-size: 10px;
        }

        .steps>.step:before {
            top: 62%;
        }

        .steps>.step:after {
            top: 3.5rem;
        }
    }
</style>
        <style>
    @media print{
        .btn, .bottom-navbar>.contain, .mdi-menu, .footer, .no-print, .horizontal-menu {
                display: none;
            }
        @page {size: landscape}
        
        #subWorkDiv, #stepDiv{
                    width: 100%;
                }
        body {
        zoom: 70%;
            }
        }
    
    @media print {
       .main-panel
        {
            margin-top:10px;
        }
        .content-text h2
        {
            margin-top: 0px !important;
        }
        }
        
        .col-md-4 {
            font-size: 14px;
        }

        .color {
            color: #212529;
            font-weight: bold;
            font-size: 18px;
        }

        .tablehead {
            background: #0033c4;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        .table thead th {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }
        
        @media screen and (max-width: 600px) {
                #printBtn
                {
                    display:none;
                }
                .color{
                    font-size:12px;
                }
                .fon
                {
                    font-size:11px;
                }
            }
        
        @media print{
            .btn, .bottom-navbar>.contain, .mdi-menu, .footer, .no-print {
                display: none;
            }
            .break {
                margin-top: 2rem;
            }
        }
        hr{
            margin : 0.5rem 0;
            width: 100%;
        }
        .table-bordered>:not(caption)>*>*, .table-bordered>:not(caption)>*{
            border-color: #000;
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
                                    <center style="padding-bottom:30px;">
                                        <h3 class="ribbon">Delay Report</h3>
                                    </center>
                                    <!--<h4 class="card-title">Financial Entry </h4>-->
                                    <form action="delayreport" method="GET" enctype="multipart/form-data">
                                        <div class="row">
                                            <!-- taluka-->

                                            <div class="col-md-5 ">
                                                <div class="form-group">
                                                    <label>Taluka</label>
                                                    <select class="js-example-basic-single float-end" id="taluka"
                                                        name="taluka" style="width: 100%;">
                                                        <option value="" selected="" >All Taluka</option>
                                                        <?php 
                                                        $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM yojanaMaster   ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $taluka = $result['taluka'];
                                                            if($taluka == $_GET['taluka']){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option value="<?php echo $taluka ?>" <?php echo $selected; ?>>
                                                            <?php echo $taluka ?>
                                                        </option>
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


                                            <div class="col-md-2" style="display: flex;align-items: center;">
                                                <button type="submit" class="btn btn-primary me-2"
                                                    name="show">Show</button>
                                            <button type="button" id="printBtn" class="btn btn-primary me-2" onclick="printFun()">Print</button>
                                            </div>

                                        </div>
                                    </form>
                                    <form>

                                        <!-- table for Financial report-->
                                        <div class="row" style="align-items:center;justify-content:center">


                                            <?php
                                            
                                            
                                            
                                            $i = 1;
                                            $query = mysqli_query($con, "SELECT * FROM delayReasons");
                                            while($result = mysqli_fetch_assoc($query)){
                                                
                                                $reasons = $result['reasons'];
                                                $yojanaIds = "";
                                                $count = 0;
                                                $q = mysqli_query($con, "SELECT DISTINCT(yojanaId) FROM delayYojanas WHERE reason = '$reasons'");
                                                while($r = mysqli_fetch_assoc($q)){
                                                    
                                                    if(isset($_GET['taluka'])){
                                                        
                                                        if($_GET['taluka'] == ""){
                                                            $taluka = "";
                                                        } else {
                                                            $taluka = "AND taluka = '{$_GET['taluka']}'";
                                                        }
                                                        
                                                        
                                                        $q1 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '{$r['yojanaId']}' $taluka");
                                                        if(mysqli_num_rows($q1) <=0){
                                                            continue;
                                                        }
                                                    }
                                                    
                                                    $yojanaIds .= $r['yojanaId'].",";
                                                    $count++;
                                                }
                                                // $count = mysqli_num_rows($q);
                                            ?>
                                            <div class="col-md-4 mb-2">
                                                <div class="card text-center">
                                                    <div class="card-header">
                                                        <img src="<?php echo $result['icon'] ?>" style="width:10%;">
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <h5 class="card-title m-0">
                                                            <?php echo $result['reasons'] ?>
                                                        </h5>
                                                        <p class="card-text">
                                                            <?php
                                                            if($count > 0){
                                                            ?>
                                                            <a href="notstarted?back=delayreport&yojanaid=<?php echo $yojanaIds ?>" value=""> <?php echo $count  ?> </a> 
                                                            <?php
                                                            } else {
                                                                echo 0;
                                                            }
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            
                                            
                                            
                                            
                                            /*$qurey1 = mysqli_query($con,"SELECT * FROM yojanaMaster") or die($con->error);
                                            $fetch = mysqli_fetch_assoc($qurey1);
                                            $mytaluka = $fetch['taluka'];
                                            
                                             $query = mysqli_query($con, "SELECT distinct(reason) FROM schedule where delay = 'Yes' and reason !=''  ")  or die($con->error) ;
                                             while($result = mysqli_fetch_assoc($query)){
                                                 $yojanaIds="";
                                             
                                            $queries = mysqli_query($con,"SELECT DISTINCT(yojanaId) FROM schedule WHERE reason = '{$result['reason']}' ") or die($con->error);
                                            $count1 = 0;
                                            while($myfetch = mysqli_fetch_assoc($queries)){
                                                    if(!isset($_REQUEST['taluka'])){
                                                    $talusks = "taluka != ''";
                                                     $yojanaIds.=$myfetch['yojanaId'].',';
                                                      $countall = mysqli_query($con,"SELECT * from yojanaMaster WHERE yojanaId = '{$myfetch['yojanaId']}'"); 
                                                    
                                                    if(mysqli_num_rows($countall)>0){
                                                        $count1 = $count1+1;
                                                    }
                                                    
                                                }else{
                                                    $talusks = "taluka = '".$_REQUEST['taluka']."'";
                                                    
                                                      
                                                    $countall = mysqli_query($con,"SELECT * from yojanaMaster WHERE yojanaId = '{$myfetch['yojanaId']}' and $talusks "); 
                                                    
                                                    if(mysqli_num_rows($countall)>0){
                                                         $yojanaIds.=$myfetch['yojanaId'].',';
                                                        $count1 = $count1+1;
                                                    }
                                            
                                                }
                                            
                                            }
                                            
                                            
                                            ?>

                                            <?php 
                                                            
                                            $myquery = mysqli_query($con, "SELECT * from delayReasons  WHERE reasons = '{$result['reason']}' ");
                                            $fetch2 = mysqli_fetch_assoc($myquery);
                                            $reasons= $fetch2['reasons'];
                                            
                                            ?>
                                            <div class="col-md-4 mb-2">
                                                <div class="card text-center">
                                                    <div class="card-header">
                                                        <img src="
                                                        <?php 
                                                        if($result['reason'] != $reasons)
                                                        {
                                                        echo " img/icon8/pencil.png"; } else { echo $fetch2['icon'] ; } 
                                                        ?>" style="width:10%;">
                                                    </div>
                                                    <div class="card-body p-3">
                                                        <h5 class="card-title m-0">
                                                            <?php echo $result['reason'] ?>
                                                        </h5>
                                                        <p class="card-text"><a
                                                                href="notstarted?back=delayreport&yojanaid=<?php echo $yojanaIds ?>&"
                                                                value="">
                                                                <?php echo $count1  ?>
                                                            </a> </p>

                                                    </div>
                                                </div>
                                            </div>
                                            <?php    
                                            }*/
                                            ?>
                                        </div>
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
    <script>
        
        function printFun(){
            window.print();
            // $('#subWorkDiv').removeClass()
        }
    </script>
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

    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>

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

</body>

</html>