<?php
session_start(); 
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobileDevice()){
    $mobile = "col-12 p-1";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
else {
    $mobile = "col-4 p-0";
    $step = "Stage (Tappa)";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Show Agreement</title>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
    .card .card-body {
    padding: 0px 28px;
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
        }

        .steps>.step:after {
            content: "";
            position: absolute;
            display: block;
            background: #e6e6e6;
            width: 100%;
            height: 0.125rem;
            top: 1rem;
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



        .can-toggle {
            position: relative;
        }

        .can-toggle *,
        .can-toggle *:before,
        .can-toggle *:after {
            box-sizing: border-box;
        }

        .can-toggle input[type=checkbox] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
        }

        .can-toggle input[type=checkbox][disabled]~label {
            pointer-events: none;
        }

        .can-toggle input[type=checkbox][disabled]~label .can-toggle__switch {
            opacity: 0.4;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:before {
            content: attr(data-unchecked);
            left: 0;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            content: attr(data-checked);
        }

        .can-toggle label {
            user-select: none;
            position: relative;
            display: flex;
            align-items: center;
        }

        .can-toggle label .can-toggle__label-text {
            flex: 1;
            padding-left: 32px;
        }

        .can-toggle label .can-toggle__switch {
            position: relative;
        }

        .can-toggle label .can-toggle__switch:before {
            content: attr(data-checked);
            position: absolute;
            top: 0;
            text-transform: uppercase;
            text-align: center;
        }

        .can-toggle label .can-toggle__switch:after {
            content: attr(data-unchecked);
            position: absolute;
            z-index: 5;
            text-transform: uppercase;
            text-align: center;
            background: white;
            transform: translate3d(0, 0, 0);
        }

        .can-toggle input[type=checkbox][disabled]~label {
            color: rgba(234, 0, 48, 0.5);
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch {
            background-color: #ea0030;
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
            color: #b70026;
        }

        .can-toggle input[type=checkbox]:hover~label {
            color: #d1002b;
        }

        .can-toggle input[type=checkbox]:checked~label:hover {
            color: #55bc49;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch {
            background-color: #70c767;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            color: #4fb743;
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch {
            background-color: #5fc054;
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            color: #47a43d;
        }

        .can-toggle label .can-toggle__label-text {
            flex: 1;
        }

        .can-toggle label .can-toggle__switch {
            transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
            background: #ff0538;
        }

        .can-toggle label .can-toggle__switch:before {
            color: rgba(255, 255, 255, 0.5);
        }

        .can-toggle label .can-toggle__switch:after {
            -webkit-transition: -webkit-transform 0.3s cubic-bezier(0, 1, 0.5, 1);
            transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
            color: #ea0030;
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            transform: translate3d(65px, 0, 0);
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle label {
            font-size: 14px;
        }

        .can-toggle label .can-toggle__switch {
            height: 36px;
            flex: 0 0 134px;
            border-radius: 4px;
        }

        .can-toggle label .can-toggle__switch:before {
            left: 67px;
            font-size: 12px;
            line-height: 36px;
            width: 67px;
            padding: 0 12px;
        }

        .can-toggle label .can-toggle__switch:after {
            top: 2px;
            left: 2px;
            border-radius: 2px;
            width: 65px;
            line-height: 32px;
            font-size: 12px;
        }

        .can-toggle label .can-toggle__switch:hover:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle.can-toggle--size-small input[type=checkbox]:hover~label .can-toggle__switch:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:checked~label .can-toggle__switch:after {
            transform: translate3d(44px, 0, 0);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle.can-toggle--size-small input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small label {
            font-size: 13px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch {
            height: 28px;
            flex: 0 0 90px;
            border-radius: 2px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:before {
            left: 45px;
            font-size: 10px;
            line-height: 28px;
            width: 45px;
            padding: 0 12px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:after {
            top: 1px;
            left: 1px;
            border-radius: 1px;
            width: 44px;
            line-height: 26px;
            font-size: 10px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:hover:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }
        
        /*.pointer{
            cursor: pointer;
        }*/
        .center{
            text-align: center;
        }

    </style>



</head>

<body>
    <div class="container-scroller">
        <?php
       
      
        include("include/con.php");
         include('header.php');
    ?>
    
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" style="padding:17px">
                                <div class="col-md-4">
                                    <center style="padding-top: 10px;padding-bottom: 20px;float: left;">
                                        <h3>Show Agreement</h3>
                                    </center>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="Search..."
                                        id="search_field">
                                </div>
                            </div>
                            <?php
                            $result=mysqli_query($con,"SELECT * FROM agreement") ;
                            
                            if(mysqli_num_rows($result)>0){
                            ?>

                            <div class="table-responsive">
                                <table class="table table-striped" >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="font-weight: bold;">Contractor's Name</th>
                                            <th style="font-weight: bold;">Scheme Id</th>
                                            <th style="font-weight: bold;">Name of Scheme</th>
                                            <th style="font-weight: bold;">Agreement Number</th>
                                            <th style="font-weight: bold;">Time Limit (Months)</th>
                                            <th style="font-weight: bold;">Date of Work Order</th>
                                            <th style="font-weight: bold;">Tender Cost</th>
                                            <th style="font-weight: bold;">Accepted Cost</th>
                                            <th style="font-weight: bold;">Percentage</th>
                                            <th style="font-weight: bold;">Expected end date</th>
                                            <th style="font-weight: bold;">Date of completion</th>
                                            <th style="font-weight: bold;">Delay</th>
                                            <th style="font-weight: bold;">Extension count</th>
                                            <?php 
                                            if($_SESSION['designation'] == "clerk"){
                                            ?>
                                            <th style="font-weight: bold;" class="center">Action</th>
                                            <?php 
                                            }
                                            ?>
                                        </tr>
                                    </thead>

                                    <tbody id="yojanatable">
                                        <?php
                                		$sql="SELECT * FROM agreement ORDER BY id DESC";
                                        $query = mysqli_query($con,$sql);
                                        $i= 1;
                                        while($result = mysqli_fetch_assoc($query)){
                                            
                                            $id = $result['id'];
                                            $q = mysqli_query($con, "SELECT * FROM users WHERE userId = '{$result['contractor']}'");
                                            $r = mysqli_fetch_assoc($q);
                                            $fullName = $r['fullName'];
                                            
                                            $q = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '{$result['yojanaId']}'");
                                            
                                            $r = mysqli_fetch_assoc($q);
                                            $yojanaName = $r['yojanaName'];
                                            $yojanaId = $r['yojanaId'];
                                            $expected = $r['expectedDate'];
                                            
                                            $agreementNo = $result['agreementNo'];
                                            $timeLimit = $result['timeLimit'];
                                            $dateOfWorkOrder = $result['dateOfWorkOrder'];
                                            $tenderCost = $result['tenderCost'];
                                            $acceptedCost = $result['acceptedCost'];
                                            $percentage = $result['percentage'];
                                            $above_below = $result['above_below'];
                                         
                                            $query1 = mysqli_query($con,"SELECT * FROM stepFive WHERE yojanaId = '{$result['yojanaId']}'");
                                            $fetch = mysqli_fetch_assoc($query1);
                                            $completionDate = $fetch['dateOfCompletion'];
                                           
$ts1 = strtotime($completionDate);
$ts2 = strtotime($expected);

/*$year1 = date('Y', $ts1);
$year2 = date('Y', $ts2);

$month1 = date('m', $ts1);
$month2 = date('m', $ts2);

$day1 = date('d' , $ts1);
$day2 = date('d', $ts2);

$diff = (($year1 - $year2) * 12) + ($month1 - $month2);*/

$dateDifference = abs($ts1 - $ts2);

$years  = floor($dateDifference / (365 * 60 * 60 * 24));
$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
$days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));


                                            
                                        ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $fullName ?></td>
                                            <td><?php echo $yojanaId ?></td>
                                            <td><?php echo $yojanaName ?></td>
                                            <td><?php echo $agreementNo; ?></td>
                                            <td><?php echo $timeLimit ?></td>
                                            <td><?php echo $dateOfWorkOrder ?></td>
                                            <td><?php echo $tenderCost ?></td>
                                            <td><?php echo $acceptedCost ?></td>
                                            <td>
                                                <?php echo $percentage ?>
                                                <?php
                                                if($above_below == "Above"){
                                                ?>
                                                <span style="font-size:18px;color:green">&uarr;</span>
                                                <?php
                                                } else if($above_below == "Below") {
                                                ?>
                                                <span style="font-size:18px;color:red">&darr;</span>
                                            <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $expected ?></td>
                                            <td>
                                                <?php if($completionDate=='0000-00-00' || $completionDate==""){?>
                                                -
                                                <?php } else{?>
                                                <?php echo $completionDate ?></td>
                                                <?php } ?>
                                            <td>
                                                <?php if($completionDate!=''){?>
                                                
                                                <?php if($ts1>$ts2){?>
                                                <?php echo $years." y,  ".$months." m & ".$days." d" ?> 
                                                <?php }else{?>
                                                -
                                                <?php } ?>
                                                <?php }else{?>
                                                -
                                                <?php } ?>
                                                </td>
                                            <td> </td>
                                            
                                            <?php 
                                            if($_SESSION['designation'] == "clerk"){
                                            ?>
                                            <td>
                                                <a href="agreement?id=<?php echo $id ?>"><i class="mdi mdi-pencil" style="font-size:20px;color:green;padding:5px;"></i></a>
                                                <a onclick="deletefun('agreement_db','<?php echo $id ?>')"><i class="mdi mdi-delete" style="font-size:20px;color:red;padding:5px;"></i></a>
                                            </td>
                                            <?php
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        $i++;
                                        }
                                        ?>
                                    </tbody>

                                </table>
                            </div>
                            <?php
                            } else{
                                echo "<img src='img/no-records.png' class='img-fluid'>";
                            }
                            ?>

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
        $('#search_field').on('keyup', function () {
            var value = $(this).val();
            var patt = new RegExp(value, "i");

            $('#yojanatable').find('tr').each(function () {
                var $table = $(this);

                if (!($table.find('td').text().search(patt) >= 0)) {
                    $table.not('#t_head').hide();
                }
                if (($table.find('td').text().search(patt) >= 0)) {
                    $(this).show();
                }

            });

        });
    </script>
</body>

</html>