<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once("include/con.php"); 
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(isMobileDevice()){
    $mobile = "col-12 p-1";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
}
else {
    $mobile = "col-4 p-0";
    $step = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stage (Tappa)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

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

       /* for progress bar tooltip*/
        
        
.speech-bubble {
  background: #eebf3fc2;
  color: #fff;
  font-weight: bold;
  display: inline-block;
	font-size: 14px;
  line-height: 1.5em;
  margin-bottom: 1em;
	padding: 0 1em;
	position: relative;
	text-align: center;
	vertical-align: top;
		min-width: auto;
		border-radius: 3px;
}
.speech-bubble:after {
    font-size: smaller;
	border: 1em solid transparent;
	border-top-color: #eebf3fc2;
	content: '';
	margin-left: -1em;
	position: absolute;
		top: 100%;
		left: 50%;
	width: 0;
	height: 0;
}

        
        /*****/
        .step-span {
            font-size: 10px;
        }

        .center {
            text-align: center;
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
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="table-responsive">
        <?php 
        if(!(isset($_REQUEST['taluka']))){
        ?>
        <table class="table table-striped" id="yojanatable">
            <thead>
                <tr id="t_head">
                    <th>#</th>
                    <th>Taluka</th>
                    <th class="center">#Total Schemes</th>
                    <th class="center">#Completed Schemes</th>
                    <th class="center">#In Progress Schemes</th>
                </tr>

            </thead>
            <tbody>
                <?php 
                $i=1;
                
                $query = mysqli_query($con, "SELECT DISTINCT(taluka) FROM villages");
                while($result = mysqli_fetch_assoc($query)){
                    $taluka = $result['taluka'];
                    $query1=mysqli_query($con,"SELECT COUNT(yojanaId) AS 'totalSchemes' FROM yojanaMaster WHERE taluka = '$taluka'");
                    $result1 = mysqli_fetch_assoc($query1);
                    $totalSchemes=$result1['totalSchemes'];
                    
                    $sql = "SELECT DISTINCT(yojanaMaster.yojanaId) as 'yojanaId',  yojanaMaster.stepOne as 'stepOne', yojanaMaster.stepTwo as 'stepTwo', yojanaMaster.stepThree  as 'stepThree', yojanaMaster.stepFour as 'stepFour', yojanaMaster.stepFive as 'stepFive', stepOne.completionPercentage as 'stepOnePer', stepTwo.completionPercentage as 'stepTwoPer', stepThree.completionPercentage as 'stepThreePer', stepFour.completionPercentage as 'stepFourPer', stepFive.completionPercentage as 'stepFivePer', (stepOne.completionPercentage + stepTwo.completionPercentage+ stepThree.completionPercentage+ stepFour.completionPercentage+ stepFive.completionPercentage) as 'percentage' from yojanaMaster 
                            LEFT JOIN stepOne on yojanaMaster.yojanaId = stepOne.yojanaId 
                            LEFT JOIN stepTwo on yojanaMaster.yojanaId = stepTwo.yojanaId
                            LEFT JOIN stepThree on yojanaMaster.yojanaId = stepThree.yojanaId
                            LEFT JOIN stepFour on yojanaMaster.yojanaId = stepFour.yojanaId
                            LEFT JOIN stepFive on yojanaMaster.yojanaId = stepFive.yojanaId
                            WHERE yojanaMaster.taluka = '$taluka';
                            ";
                        
                    $query4 = mysqli_query($con, $sql);
                    $completedSchemes = 0;
                    $progressSchemes = 0;
                    while($result4 = mysqli_fetch_assoc($query4)){
                        $yojanaId = $result4['yojanaId'];
                        $totalDiv = 0;
                        if($result4['stepOne'] == "Yes"){
                            $stepOne = $r1['stepOnePer'];
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        
                        if($result4['stepTwo'] == "Yes"){
                            $stepTwo = $result4['stepTwoPer'];
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        
                        if($result4['stepThree'] == "Yes"){
                            $stepThree = $result4['stepThreePer'];
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        
                        if($result4['stepFour'] == "Yes"){
                            $stepFour = $result4['stepFourPer'];
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        
                        if($result4['stepFive'] == "Yes"){
                            $stepFive = $result4['stepFivePer'];
                            $totalDiv = $totalDiv + 100;
                        }
                    
                        $percentage = (($stepOne + $stepTwo + $stepThree + $stepFour + $stepFive) / $totalDiv) * 100;
                        if($percentage<100){
                            $progressSchemes = $progressSchemes + 1;  
                            $progressSchemesId .= $yojanaId.",";
                        } else {
                            $completedSchemes = $completedSchemes + 1;
                            $completedSchemesId .= $yojanaId.",";
                        }
                    }
                ?>
                <tr>
                    <td>
                        <?php echo $i++; ?>
                    </td>
                    <td><a href="yojanaStatusReportNew?taluka=<?php echo $taluka ?>">
                            <?php echo $taluka ?>
                        </a></td>
                    <td class="center">
                        <?php echo $totalSchemes ?>
                    </td>
                    <td class="center">
                        <?php echo $completedSchemes ?>
                    </td>
                    <td class="center">
                        <?php echo $progressSchemes ?>
                    </td>
                </tr>
                <?php
                }
              
              ?>
            </tbody>
        </table>
        <?php 
        }
        
        if(isset($_REQUEST['taluka'])){
            $taluka = $_REQUEST['taluka'];
            $query1 = mysqli_query($con, "select * from yojanaMaster WHERE taluka = '$taluka' ORDER BY id DESC");
            if(mysqli_num_rows($query1) <= 0){
                echo "<div class='card-body' style='text-align:center' ><a href='yojanaStatusReportNew' style='float: left;'><i class='fa fa-mail-reply' style='font-size: 18px;'></i></a><img src='img/no-records.png' id='norecord' class='img-fluid'></div>";
            } else {
        ?>
        <span class="step-span"> ( <b>1</b> - Source, </span>
        <span class="step-span"><b>2</b> - Pump & Rising Main, </span>
        <span class="step-span"><b>3a</b> - ESR, </span>
        <span class="step-span"><b>3b</b> - Distribution System, </span>
        <span class="step-span"><b>4</b> - Trial Run )</span>
        <div class="table-responsive">
            <table class="table table-striped" id="yojanaTableDT">
                <thead>
                    <tr>
                        <th colspan="7">
                            <a href="yojanaStatusReportNew" style="float: left;"><i class="fa fa-mail-reply"
                                    style="font-size: 18px;"></i></a>
                            <center>
                                <?php echo $taluka ?>
                            </center>
                        </th>
                    </tr>
                    <tr id="t_head">
                        <th>#</th>
                        <th>Scheme Id</th>
                        <th>Name of scheme</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Progress&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </th>
                        <th style="width:500px" id="step">
                            <?php echo $step ?>
                        </th>
                        <th class="text-center">Village</th>
                        <th>Engineer</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    $i=1;
                    $sql = "SELECT DISTINCT(yojanaMaster.yojanaId) as 'yojanaId', yojanaMaster.yojanaName as 'yojanaName',  yojanaMaster.stepOne as 'stepOne', yojanaMaster.stepTwo as 'stepTwo', yojanaMaster.stepThree  as 'stepThree', yojanaMaster.stepFour as 'stepFour', yojanaMaster.stepFive as 'stepFive', stepOne.completionPercentage as 'stepOnePer', stepTwo.completionPercentage as 'stepTwoPer', stepThree.completionPercentage as 'stepThreePer', stepFour.completionPercentage as 'stepFourPer', stepFive.completionPercentage as 'stepFivePer', (stepOne.completionPercentage + stepTwo.completionPercentage+ stepThree.completionPercentage+ stepFour.completionPercentage+ stepFive.completionPercentage) as 'percentage' from yojanaMaster 
                            LEFT JOIN stepOne on yojanaMaster.yojanaId = stepOne.yojanaId 
                            LEFT JOIN stepTwo on yojanaMaster.yojanaId = stepTwo.yojanaId
                            LEFT JOIN stepThree on yojanaMaster.yojanaId = stepThree.yojanaId
                            LEFT JOIN stepFour on yojanaMaster.yojanaId = stepFour.yojanaId
                            LEFT JOIN stepFive on yojanaMaster.yojanaId = stepFive.yojanaId
                            WHERE yojanaMaster.taluka = '$taluka' ORDER BY yojanaMaster.id DESC";
                    $query1 = mysqli_query($con, $sql);
                    while($result1 = mysqli_fetch_assoc($query1)){
                        $yojanaId = $result1['yojanaId'];
                        $totalDiv = 0;
                        $stepOne = 0;
                        $stepTwo = 0;
                        $stepThree = 0;
                        $stepFour = 0;
                        $stepFive = 0;
                        
                        if($result1['stepOne'] == "Yes" && $result1['stepOnePer'] != ''){
                            $stepOne = $result1['stepOnePer'];
                            
                            if($stepOne < 100){
                                $stepOneCompleted = "is-incomplete pointer";
                            } else {
                                $stepOneCompleted = "is-complete pointer";
                            }
                            
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        if($result1['stepTwo'] == "Yes" && $result1['stepTwoPer'] != ''){
                            $stepTwo = $result1['stepTwoPer'];
                            
                            if($stepTwo < 100){
                                $stepTwoCompleted = "is-incomplete pointer";
                            } else {
                                $stepTwoCompleted = "is-complete pointer";
                            }
                            
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        if($result1['stepThree'] == "Yes" && $result1['stepThreePer'] != ''){
                            $stepThree = $result1['stepThreePer'];
                            
                            if($stepThree < 100){
                                $stepThreeCompleted = "is-incomplete pointer";
                            } else {
                                $stepThreeCompleted = "is-complete pointer";
                            }
                            
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        if($result1['stepFour'] == "Yes" && $result1['stepFourPer'] != ''){
                            $stepFour = $result1['stepFourPer'];
                            
                            if($stepFour < 100){
                                $stepFourCompleted = "is-incomplete pointer";
                            } else {
                                $stepFourCompleted = "is-complete pointer";
                            }
                            
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        if($result1['stepFive'] == "Yes" && $result1['stepFivePer'] != ''){
                            $stepFive = $result1['stepFivePer'];
                            
                            if($stepFive < 100){
                                $stepFiveCompleted = "is-incomplete pointer";
                            } else {
                                $stepFiveCompleted = "is-complete pointer";
                            }
                            
                            $totalDiv = $totalDiv + 100;
                        }
                        
                        
                        if($totalDiv != 0){
                            $percentage = (($stepOne + $stepTwo + $stepThree + $stepFour + $stepFive) / $totalDiv) * 100;   
                        } else {
                            $percentage = 0;
                        }
                            
                    ?>
                    <tr>
                        <td>
                            <?php echo $i++ ?>
                        </td>
                        <td>
                            <?php echo $result1['yojanaId'] ?>
                        </td>
                        <td>
                            <?php echo $result1['yojanaName']; ?>
                        </td>
                        <td class="center">
                            <div style="display:none">
                            <?php 
                            $cal = $percentage / 10;
                            if($percentage == 100){
                                $cal = 9.9999;
                                echo $cal;
                            }else{
                                echo $cal;
                            }
                            ?></div>
                            <!-- Tooltip -->
                            <div class="speech-bubble">
                                <?php echo round($percentage) ?>%
                            </div>
                            <!-- End Tooltip -->                   
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo $percentage ?>%;" aria-valuenow="<?php echo $percentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td id="step" style="width:250px">
                            <ol class="steps">
                                <li class="step is-complete pointer"
                                    onclick="redirect('createYojana', '<?php echo $yojanaId ?>')" data-step="1">
                                    0
                                </li>

                                <?php
                                if($result1['stepOne'] == "Yes"){
                                ?>
                                <li class="step <?php echo $stepOneCompleted ?> pointer"
                                    onclick="redirect('<?php echo $stepOneLink ?>', '<?php echo $yojanaId ?>')"
                                    data-step="1">
                                    1
                                    <br><br><br>
                                    <?php echo $stepOne; ?>%
                                </li>
                                <?php 
                                }
                                
                                if($result1['stepTwo'] == "Yes"){
                                ?>
                                <li class="step <?php echo $stepTwoCompleted ?> pointer"
                                    onclick="redirect('<?php echo $stepTwoLink ?>', '<?php echo $yojanaId ?>')"
                                    data-step="2">
                                    2
                                    <br><br><br>
                                    <?php echo $stepTwo; ?>%
                                </li>
                                <?php 
                                }
                                
                                if($result1['stepThree'] == "Yes"){
                                ?>

                                <li class="step <?php echo $stepThreeCompleted ?> pointer"
                                    onclick="redirect('<?php echo $stepThreeLink ?>', '<?php echo $yojanaId ?>')"
                                    data-step="3a">
                                    3a
                                    <br><br><br>
                                    <?php echo $stepThree; ?>%
                                </li>
                                <?php 
                                }
                                
                                if($result1['stepFour'] == "Yes"){
                                ?>

                                <li class="step <?php echo $stepFourCompleted ?> pointer"
                                    onclick="redirect('<?php echo $stepFourLink ?>', '<?php echo $yojanaId ?>')"
                                    data-step="3b">
                                    3b
                                    <br><br><br>
                                    <?php echo $stepFour; ?>%
                                </li>
                                <?php
                                }
                                if($result1['stepFive'] == "Yes"){
                                ?>
                                <li class="step <?php echo $stepFiveCompleted ?> pointer"
                                    onclick="redirect('<?php echo $stepFiveLink ?>', '<?php echo $yojanaId ?>')"
                                    data-step="4">
                                    4
                                    <br><br><br>
                                    <?php echo $stepFive; ?>%
                                </li>
                                <?php 
                                }
                                ?>
                            </ol>
                        </td>
                        <td class="text-center">
                            <!--<span id="taluka">
                                    <?php echo $result1['taluka']; ?>
                                </span>
                                <br>-->
                            <span>
                                <?php echo $result1['village']; ?>
                            </span>
                        </td>

                        <?php
                            
                        $queryeng1=mysqli_query($con,"select userId from allocatedYojana where yojanaId='$yojanaId'and designation='sectionEng'");
                        $eng1=mysqli_fetch_assoc($queryeng1);
                        
                        $queryeng=mysqli_query($con,"select userId from allocatedYojana where yojanaId='$yojanaId'and designation='executiveEng'");
                        $eng=mysqli_fetch_assoc($queryeng);
            
                        ?>
                        <td>

                            <span>
                                <?php 
                                $query2 = mysqli_query($con, "SELECT fullName FROM users WHERE userId = '{$eng1['userId']}'");
                                $result2 = mysqli_fetch_assoc($query2);
                                
                                echo $result2['fullName'] ; 
                                ?>
                            </span>
                            <br>
                            <span class="designation">

                                (<?php if(!empty($result2['mobileNo'])){ echo $result2['mobileNo']; } else { echo " -"; } ?> Section Eng.)
                            </span>

                            <br><br>

                            <span>
                                <?php 
                                $query2 = mysqli_query($con, "SELECT fullName FROM users WHERE userId = '{$eng['userId']}'");
                                $result2 = mysqli_fetch_assoc($query2);
                                
                                echo $result2['fullName'] ; 
                                ?>
                            </span>
                            <br>
                            <span class="designation">
                                (<?php if(!empty($result2['mobileNo'])){ echo $result2['mobileNo']; } else { echo " -"; } ?> Sub Divisional Eng.)
                            </span>

                        </td>
                    </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
            }
        }
        ?>
    </div>
    <!-- page-body-wrapper ends -->


    <!-- container-scroller -->
    <!-- plugins:js -->
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

    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Datatable JS -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script>
        $('#yojanaTableDT').dataTable({
            "targets": [3, 4, 5],
            "orderable": false
        });


        function scrollWin() {
            window.scrollTo(Math.random() * 5, Math.random() * 5);
        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip({ trigger: 'manual' }).tooltip('show');
        });

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