<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('location:login');
    die();
}
require_once("include/con.php");
function isMobileDevice()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if (isMobileDevice()) {
    $mobile = "col-12 p-1";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
    $mobile = "col-4 p-0";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>जल जीवन मिशन </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="template/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="template/assets/vendors/jquery-bar-rating/css-stars.css" />
    <link rel="stylesheet" href="template/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="template/assets/css/demo_2/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="template/assets/images/favicon.png" />

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

    <style>
        .main-panel .content-wrapper .color-card-wrapper .card-body .color-card-outer .color-card {
            width: 50%;
            height: 128px;
            color: #ffffff;
            padding: 27px 0 0 12px;
            border-radius: 7px;
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

        .designation {
            line-height: 3;
            font-size: 12px;
            color: blue;
        }

        #taluka {
            color: blue;
        }

        #village {
            font-size: 12px;
        }

        .progress {
            border-radius: 0;
            overflow: visible;
        }

        .progress-bar {
            background: rgb(23, 44, 60);
            -webkit-transition: width 1.5s ease-in-out;
            transition: width 1.5s ease-in-out;
        }

        .tooltip {
            position: relative;
            float: right;
            z-index: 1000 !important;
        }

        .popOver+.tooltip>.tooltip-arrow {
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #eebf3f;
        }

        .tooltip>.tooltip-inner {
            background-color: #eebf3f;
            padding: 5px 15px;
            color: white;
            font-weight: bold;
            font-size: 13px;
        }

        .step-span {
            font-size: 10px;
        }

        @media only screen and (max-width: 600px) {
            #step {
                width: 200px;
            }
        }

        @media only screen and (max-width: 600px) {
            #heatmap {
                height: 500px;
            }
        }

        @media only screen and (max-width: 600px) {
            #scheme {
                font-size: 12px;
            }
        }

        @media only screen and (max-width: 600px) {
            #count {
                font-size: 10px;
            }
        }

        @media only screen and (max-width: 600px) {
            .main-panel .content-wrapper .color-card-wrapper .card-body .color-card-outer .color-card {
                width: 95%;
            }
        }

        @media only screen and (min-width: 769px) {
            #scheme {
                font-size: 16px;
            }
        }

        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
        ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper pb-0">

                    <div class="row">


                        <!-- data-->
                        <?php
                        require_once('include/con.php');
                        $query1 = mysqli_query($con, "select count(yojanaId) as 'total_schemes' from yojanaMaster");
                        $result1 = mysqli_fetch_assoc($query1);
                        $rowcount1 = $result1['total_schemes'];

                        // $query2=mysqli_query($con,"select count(yojanaId) as  from stepFive where yojanaComplete=''");
                        // $rowcount2=mysqli_num_rows($query2);

                        // $query3=mysqli_query($con,"select * from stepFive where yojanaComplete='Yes'");
                        // $rowcount3=mysqli_num_rows($query3);

                        $sql = "SELECT DISTINCT(yojanaMaster.yojanaId) as 'yojanaId',  yojanaMaster.stepOne as 'stepOne', yojanaMaster.stepTwo as 'stepTwo', yojanaMaster.stepThree  as 'stepThree', yojanaMaster.stepFour as 'stepFour', yojanaMaster.stepFive as 'stepFive', stepOne.completionPercentage as 'stepOnePer', stepTwo.completionPercentage as 'stepTwoPer', stepThree.completionPercentage as 'stepThreePer', stepFour.completionPercentage as 'stepFourPer', stepFive.completionPercentage as 'stepFivePer', (stepOne.completionPercentage + stepTwo.completionPercentage+ stepThree.completionPercentage+ stepFour.completionPercentage+ stepFive.completionPercentage) as 'percentage' from yojanaMaster 
                            LEFT JOIN stepOne on yojanaMaster.yojanaId = stepOne.yojanaId 
                            LEFT JOIN stepTwo on yojanaMaster.yojanaId = stepTwo.yojanaId
                            LEFT JOIN stepThree on yojanaMaster.yojanaId = stepThree.yojanaId
                            LEFT JOIN stepFour on yojanaMaster.yojanaId = stepFour.yojanaId
                            LEFT JOIN stepFive on yojanaMaster.yojanaId = stepFive.yojanaId";

                        $query4 = mysqli_query($con, $sql);
                        $completedSchemes = 0;
                        $progressSchemes = 0;
                        while ($result4 = mysqli_fetch_assoc($query4)) {
                            $yojanaId = $result4['yojanaId'];
                            $totalDiv = 0;
                            $stepOne = 0;
                            $stepTwo = 0;
                            $stepThree = 0;
                            $stepFour = 0;
                            $stepFive = 0;
                            if ($result4['stepOne'] == "Yes") {
                                $stepOne = $result4['stepOnePer'];
                                $totalDiv = $totalDiv + 100;
                            }


                            if ($result4['stepTwo'] == "Yes") {
                                $stepTwo = $result4['stepTwoPer'];
                                $totalDiv = $totalDiv + 100;
                            }


                            if ($result4['stepThree'] == "Yes") {
                                $stepThree = $result4['stepThreePer'];
                                $totalDiv = $totalDiv + 100;
                            }


                            if ($result4['stepFour'] == "Yes") {
                                $stepFour = $result4['stepFourPer'];
                                $totalDiv = $totalDiv + 100;
                            }


                            if ($result4['stepFive'] == "Yes") {
                                $stepFive = $result4['stepFivePer'];
                                $totalDiv = $totalDiv + 100;
                            }


                            $percentage = (($stepOne + $stepTwo + $stepThree + $stepFour + $stepFive) / $totalDiv) * 100;
                            if ($percentage < 100) {
                                $progressSchemes = $progressSchemes + 1;
                                $progressSchemesId .= $yojanaId . ",";
                            } else {
                                $completedSchemes = $completedSchemes + 1;
                                $completedSchemesId .= $yojanaId . ",";
                            }
                        }

                        ?>
                        <!-- -->

                        <!--https://media-exp1.licdn.com/dms/image/C4D1BAQEW4iwzCUqvNg/company-background_10000/0/1544465304926?e=2147483647&v=beta&t=fHn0Eatuk0pcnAz-ioIucMHhwreVt-DZiJDwWwOlAPs -->
                        <!--template/assets/images/dashboard/img_5.jpg-->
                        <!-- -->

                        <div class="col-sm-6 col-md-12 stretch-card grid-margin">
                            <div class="card color-card-wrapper">
                                <div class="card-body">

                                    <img class="img-fluid card-top-img w-100" src="img/waterbackground.png" alt="" />
                                    <div class="d-flex flex-wrap justify-content-around color-card-outer">
                                        <div class="<?php echo $mobile ?>">
                                            <div class="color-card primary m-auto">
                                                <i class="mdi mdi-clock-outline"></i>
                                                <p class="font-weight-semibold mb-0" id="scheme">Total Schemes</p>
                                                <span class="small">
                                                    # <?php echo $rowcount1; ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="<?php echo $mobile ?> p-0">
                                            <div class="color-card bg-success m-auto">
                                                <i class="mdi mdi-checkbox-marked-circle"></i>
                                                <p class="font-weight-semibold mb-0" id="scheme">Completed Schemes
                                                </p>
                                                <span class="small">
                                                    <a style="color: white;" href="notstarted?back=index&yojanaid=<?php echo $completedSchemesId ?>"># <?php echo $completedSchemes; ?></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="<?php echo $mobile ?> p-0 ">
                                            <div class="color-card bg-danger m-auto">
                                                <i class="mdi mdi-timer-sand"></i>
                                                <p class="font-weight-semibold mb-0" id="scheme">In Progress</p>
                                                <span class="small">
                                                    <a style="color: white;" href="notstarted?back=index&yojanaid=<?php echo $progressSchemesId ?>"># <?php echo $progressSchemes; ?></a>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- -->

                        <div class="col-md-4 stretch-card grid-margin">

                            <iframe src="heatMap" title="Jalna district's heat map" style="width: 100%;height: 33rem;" id="heatmap"></iframe>

                        </div>
                        <!-- table-->

                        <div class="col-md-8 grid-margin">
                            <div class="card">

                                <div class="row" style="padding:17px">
                                    <div class="col-md-6">
                                        <center style="float:left;">
                                            <h3>Dashboard</h3>
                                        </center>
                                        <br>
                                        <br>

                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4">
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <iframe src="yojanaStatusReportNew" onclick="scrollWin()" width="100%" height="100%" id="tableIframe"></iframe>

                                </div>
                            </div>
                        </div>
                        <!-- -->


                    </div>

                </div>
                <!-- content-wrapper ends -->


            </div>

            <!-- main-panel ends -->
        </div>
        <?php
        include('footer.php');
        ?>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="template/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="template/assets/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
    <script src="template/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="template/assets/vendors/flot/jquery.flot.js"></script>
    <script src="template/assets/vendors/flot/jquery.flot.resize.js"></script>
    <script src="template/assets/vendors/flot/jquery.flot.categories.js"></script>
    <script src="template/assets/vendors/flot/jquery.flot.fillbetween.js"></script>
    <script src="template/assets/vendors/flot/jquery.flot.stack.js"></script>
    <script src="template/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="template/assets/js/off-canvas.js"></script>
    <script src="template/assets/js/hoverable-collapse.js"></script>
    <script src="template/assets/js/misc.js"></script>
    <script src="template/assets/js/settings.js"></script>
    <script src="template/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="template/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
    <!-- master search-->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!-- -->
    <script>
        // Selecting the iframe element
        var frame = document.getElementById("tableIframe");

        // Adjusting the iframe height onload event
        frame.onload = function()
        // function execute while load the iframe
        {
            // set the height of the iframe as 
            // the height of the iframe content
            frame.style.height =
                frame.contentWindow.document.body.scrollHeight + 'px';


            // set the width of the iframe as the 
            // width of the iframe content
            frame.style.width =
                frame.contentWindow.document.body.scrollWidth + 'px';

        }

        function scrollWin() {
            frame.scrollTo(Math.random() * 5, Math.random() * 5);
        }

        $(function() {
            $('[data-toggle="tooltip"]').tooltip({
                trigger: 'manual'
            }).tooltip('show');
        });
        $('#search_field').on('keyup', function() {
            var value = $(this).val();
            var patt = new RegExp(value, "i");

            $('#yojanatable').find('tr').each(function() {
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