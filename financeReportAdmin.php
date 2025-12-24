<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');

if(isset($_POST['yojanaId'])){
    $yojanaId = $_POST['yojanaId'];
?>
<thead class="tableHead" >
    <tr>
        <th>#</th>
        <th>समाविष्ट उपांगे </th>
        <th>मंजूर किंमत </th>
        <th>Used Amount</th>
        <th>Remarks</th>
    </tr>
</thead>
<tbody id="TbodyHtml">
    <?php
    $i=1;
    echo "SELECT * FROM finance WHERE yojanaId = '$yojanaId'";
    $query = mysqli_query($con, "SELECT * FROM finance WHERE yojanaId = '$yojanaId'");
    /*if(mysqli_num_rows($query) <=0){
        echo "noRecord";
    }*/
    while($result = mysqli_fetch_assoc($query)){
        $subWorkId = $result['subWorkId'];
        $q = mysqli_query($con, "SELECT * FROM subWorkMaster WHERE id = '$subWorkId'");
        $r = mysqli_fetch_assoc($q);
        $subWork = $r['subWork'];
        $q = mysqli_query($con, "SELECT * FROM subWork WHERE name = '$subWorkId'");
        $r = mysqli_fetch_assoc($q);
        $actualPrice = $r['actualPrice'];
        $usedPrice = $result['amount'];
        $remark = $result['remark'];
    ?>
    <tr>
        <td class="center"><?php echo $i++; ?></td>
        <td><?php echo $subWork; ?></td>
        <td class="center"><?php echo $actualPrice; ?></td>
        <td class="center"><?php echo $usedPrice ?></td>
        <td><?php echo $remark; ?></td>
    </tr>
    <?php 
    }
    ?>
<!--<script src="js/custom.js?v=1.0.1"></script>-->
</tbody>
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
    <title>Expenditures Report</title>
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
.star{
        font-size:18px;
        color:red;
    }
    select.form-control {
        padding: 1.1375rem .75rem !important;
    }
    .tableHead {
        background: #0033c4;
        /*text-align: center;*/
        color: white;
        font-weight: bold;
    }
    .center{
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
        .pumpRisingMain{
            font-size: 10px;
        }
         @media screen and (max-width: 600px) {
             .pumpRisingMain{
                 font-size: 8px;
             }
                .font
             {
                 font-size: 10px;
             }
             .steps>.step:before
             {
                 top:62%;
             }
             .steps>.step:after
             {
                 top: 3.5rem;
             }
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
                                        <h3 class="ribbon">Expenditures Report</h3>
                                    </center>
                                    <!--<h4 class="card-title">Financial Entry </h4>-->
                                    <form action="financeReportAdmin" method="GET" enctype="multipart/form-data">
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
                                    <form>
                                        <?php 
                                        if(isset($_GET['yojanaId'])){
                                            $yojanaId = $_GET['yojanaId'];
                                            $row=mysqli_query($conn,"SELECT * FROM yojanaMaster WHERE yojanaId='$yojanaId'");
                                            $row1=mysqli_fetch_assoc($row);
                                        ?>
                                        <!-- table for Financial report-->
                                        <div class="row" style="align-items:end">
                                            <div class="col-md-12" id="noRecord">
                                                <ol class="steps">
                                                    <?php
                                                  if($row1['stepOne']=='Yes'){
                                                    $stepOneCompleted = "is-complete";
                                                    $query = mysqli_query($con,"SELECT * FROM stepOne WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                                    $result = mysqli_fetch_assoc($query);
                                                    if($result['completionPercentage'] == 0 ){
                                                       $percentage = 0; 
                                                    } else {
                                                        $percentage = $result['completionPercentage'];
                                                    }
                            					    if(mysqli_num_rows($query)>0){
                                                        if($percentage < 100){
                                                            $stepOneCompleted = "is-incomplete pointer";
                                                        }
                            					    }else{
                            					        $stepOneCompleted = "";
                            					    }                                        
                                                    ?>                                       
                                                    <li class="step <?php echo $stepOneCompleted; ?> " onclick="redirect('stepOne', '<?php echo $yojanaId ?>')" data-step="1">
                                                        <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                                        <br>
                                                        <span class="font">Stage 1</span>
                                                        <br>
                                                        <span style="font-size:10px">(Source)</span>
                                                    </li>
                                                    <?php
                                                  }
                                                  if($row1['stepTwo']=='Yes'){
                                                    $stepTwoCompleted = "is-complete";
                                                    $query = mysqli_query($con,"SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                                    $result = mysqli_fetch_assoc($query);
                                                    if($result['completionPercentage'] == 0 ){
                                                       $percentage = 0; 
                                                    } else {
                                                        $percentage = $result['completionPercentage'];
                                                    }
                            					    if(mysqli_num_rows($query)>0){
                                                        if($percentage < 100 ){
                                                            $stepTwoCompleted = "is-incomplete ";
                                                        }
                            					    }else{
                            					       $stepTwoCompleted = ""; 
                            					    }                                        
                                                    ?>
                                                    <li class="step <?php echo $stepTwoCompleted; ?> " onclick="redirect('stepTwo', '<?php echo $yojanaId ?>')" data-step="2">
                                                        <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                                        <br>
                                                       <span class="font"> Stage 2</span>
                                                        <br>
                                                        <span class="pumpRisingMain">(Pump/Rising Main)</span>
                                                    </li>
                                                    <?php
                                                  }
                                                  if($row1['stepThree']=='Yes')
                                                  {
                                                    $stepThreeCompleted = "is-complete";
                                                    $query = mysqli_query($con,"SELECT * FROM stepThree WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                                    $result = mysqli_fetch_assoc($query);
                                                    if($result['completionPercentage'] == 0 ){
                                                       $percentage = 0; 
                                                    } else {
                                                        $percentage = $result['completionPercentage'];
                                                    }
                            					    if(mysqli_num_rows($query)>0){
                                                        if($percentage < 100 ){
                                                            $stepThreeCompleted = "is-incomplete ";
                                                        }
                            					    }else{
                            					        $stepThreeCompleted = "";
                            					    }                                        
                                                    ?>
                                                    <li class="step <?php echo $stepThreeCompleted; ?> " onclick="redirect('stepThree', '<?php echo $yojanaId ?>')" data-step="3">
                                                        <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                                        <br>
                                                       <span class="font"> Stage 3a</span>
                                                        <br>
                                                        <span style="font-size:10px">(ESR)</span>
                                                    </li>
                                                    <?php 
                                                  }
                                                  if($row1['stepFour']=='Yes'){
                                                    $stepFourCompleted = "is-complete";
                                                    $query = mysqli_query($con,"SELECT * FROM stepFour WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                                    $result = mysqli_fetch_assoc($query);
                                                    if($result['completionPercentage'] == 0 ){
                                                       $percentage = 0; 
                                                    } else {
                                                        $percentage = $result['completionPercentage'];
                                                    }
                            					    if(mysqli_num_rows($query)>0){
                                                        if($percentage < 100 ){
                                                            $stepFourCompleted = "is-incomplete ";
                                                        }  
                            					    }else{
                            					        $stepFourCompleted = "";
                            					    }                                         
                                                    ?>
                                                    <li class="step <?php echo $stepFourCompleted; ?> " onclick="redirect('stepFour', '<?php echo $yojanaId ?>')" data-step="4">
                                                          <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                                          <br>
                                                      <span class="font">  Stage 3b</span>
                                                        <br>
                                                        <span style="font-size:10px">(Distribution)</span>
                                                    </li>
                                                    <?php }
                                                    if($row1['stepFive']=='Yes'){
                                                    $stepFiveCompleted = "is-complete";
                                                    $query = mysqli_query($con,"SELECT * FROM stepFive WHERE yojanaId = '$yojanaId'") or die("ERROR123"); 
                                                    $result = mysqli_fetch_assoc($query); 
                                                    if($result['completionPercentage'] == 0 ){
                                                       $percentage = 0; 
                                                    } else {
                                                        $percentage = $result['completionPercentage'];
                                                    }
                            					    if(mysqli_num_rows($query)>0){
                                                        if($percentage < 100 ){
                                                            $stepFiveCompleted = "is-incomplete ";
                                                        }
                            					    }else{
                            					        $stepFiveCompleted = "";
                            					    }                                        
                                                    ?>
                                                    <li class="step <?php echo $stepFiveCompleted; ?> " onclick="redirect('stepFive', '<?php echo $yojanaId ?>')" data-step="5">
                                                          <span style="font-weight:bold;"><?php echo $percentage ?>%</span>
                                                          <br>
                                                        <span class="font">Stage 4</span>
                                                    <br>
                                                        <span style="font-size:11px">(Trial Run)</span>
                                                    </li>
                                                    <?php } ?>
                                                </ol>
                                                <br>
                                                <div class="table-responsive">
                                                    <table class="table table-striped" id="tableHtml">
                                                        <thead class="tableHead" >
                                                            <tr>
                                                                <th>#</th>
                                                                <th class="center">Sub Work </th>
                                                                <th class="center">Sanctioned Cost </th>
                                                                <th class="center">Spent Amount</th>
                                                                <!--<th>Remaining Amount</th>-->
                                                                <th class="center">% Cost utilized</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i=1;
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
                                                            /*if(mysqli_num_rows($query) <=0){
                                                                echo "noRecord";
                                                            }*/
                                                            $totalSanctionedCost = 0;
                                                            $totalSpentAmount = 0;
                                                            $totalUtilizedCost = 0;
                                                            $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId'");
                                                            while($result = mysqli_fetch_assoc($query)){
                                                                $subWorkId = $result['id'];
                                                                if($result['subWork'] == "Trial Bore"){
                                                                    $subWork = $countTrialBore++.". Trial Bore  (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                                    
                                                                } else if($result['subWork'] == "Percolation Well"){
                                                                    $subWork = $countPercolation++.". Percolation Well  (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";
                                                                    
                                                                } else if($result['subWork'] == "Approach Bund"){
                                                                    $subWork = $countApproach++.". ".$result['subWork']." (Length -".$result['length']." m)";
                                                                    
                                                                } else if($result['subWork'] == "Pumping Machinery"){
                                                                    $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                                                                    
                                                                } else if($result['subWork'] == "Switch Room"){
                                                                    $subWork = $countSwitch++.". ".$result['subWork'];
                                                                    
                                                                } else if($result['subWork'] == "Rising Main"){
                                                                    $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm<sup>2</sup> = ".$result['length']." m)";
                                                                    
                                                                } else if($result['subWork'] == "RCC ESR"){
                                                                    $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                                                                    
                                                                } else if($result['subWork'] == "Distribution System"){
                                                                    $subWork = $countDistribution++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                                                                    
                                                                } else if($result['subWork'] == "MSEDC Work"){
                                                                    $subWork = $countMsedc++.". ".$result['subWork'];
                                                                    
                                                                } else if($result['subWork'] == "Trial & Run"){
                                                                    $subWork = $countTrial++.". ".$result['subWork']. " (Months - ".$result['month'].")";
                                                                    
                                                                } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                                                                    continue;
                                                                }
                                                                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$subWorkId' AND yojanaId = '$yojanaId'");
                                                                $r = mysqli_fetch_assoc($q);
                                                                $actualPrice = $r['actualPrice'];
                                                                $totalSanctionedCost = $totalSanctionedCost + $actualPrice;
                                                                // echo "SELECT * FROM finance WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'<br>";
                                                                // $q = mysqli_query($con, "SELECT SUM(amount) as amount, remark FROM finance WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'");
                                                                $usedPrice = 0;
                                                                $remark = "-";
                                                                $remainingPrice = 0;
                                                                $q2 = mysqli_query($con, "SELECT * FROM finance WHERE yojanaId = '$yojanaId' AND subWorkId = '$subWorkId'");
                                                                while($r2 = mysqli_fetch_assoc($q2)){
                                                                    $usedPrice = $usedPrice + $r2['amount'];
                                                                    $remark = $r2['remark'];
                                                                    $remainingPrice = $remainingPrice + $r2['remainingAmount'];
                                                                    $gst = $r2['gst'];
                                                                }
                                                                $remainingPrice = $actualPrice - $usedPrice;
                                                                $totalSpentAmount = $totalSpentAmount + $usedPrice;
                                                            ?>
                                                            <tr>
                                                                <td class="center"><?php echo $i++; ?></td>
                                                                <td><?php echo $subWork; ?></td>
                                                                <td class="center"><?php echo $actualPrice; ?></td>
                                                                <td class="center"><?php echo $usedPrice ?></td>
                                                                <!--<td class="center"><?php echo $actualPrice-$usedPrice ?></td>-->
                                                                <td class="center">
                                                                    <?php 
                                                                    if($usedPrice == "" || $r['actualPrice'] == ""){
                                                                        echo "-";
                                                                    } else {
                                                                        if($usedPrice == $actualPrice){
                                                                            echo "100";
                                                                        } else {
                                                                            $per = ($remainingPrice / $actualPrice)*100;
                                                                            if($per != "INF"){
                                                                                $per = 100 - round($per);
                                                                                $totalUtilizedCost = $totalUtilizedCost + $per;
                                                                                if($per > 100){
                                                                                    echo "<span style='color:red'>".$per."</span>";
                                                                                } else {
                                                                                    echo $per;
                                                                                }
                                                                            } else {
                                                                                echo "-";
                                                                            } 
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><div style="text-align: center;"><?php echo $remark; ?></div></td>
                                                            </tr>
                                                            <?php 
                                                            }
                                                            ?>
                                                            <tr>
                                                                <th colspan="2">
                                                                    Total
                                                                </th>
                                                                <td class="center">
                                                                    <?php
                                                                    $q2 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
                                                                    $r2 = mysqli_fetch_assoc($q2);
                                                                    $gst = $r2['gst'];
                                                                    
                                                                    $finialCost = ($totalSanctionedCost * $gst)/100;
                                                                    $finialCost = $finialCost + $totalSanctionedCost;
                                                                    echo $totalSanctionedCost." + ".$gst."% = <b>".$finialCost."</b>";
                                                                    // echo $totalSanctionedCost
                                                                    ?>
                                                                </td>
                                                                <td class="center">
                                                                    <?php
                                                                    $finialCost = ($totalSpentAmount * $gst)/100;
                                                                    $finialCost = $finialCost + $totalSpentAmount;
                                                                    echo $totalSpentAmount." + ".$gst."% = <b>".$finialCost."</b>";
                                                                    
                                                                    ?>
                                                                </td>
                                                                <th class="center">
                                                                    <?php
                                                                    
                                                                    if($totalSanctionedCost == "" || $totalSpentAmount == ""){
                                                                        echo "-";
                                                                    } else {
                                                                        if($totalSanctionedCost == $totalSpentAmount){
                                                                            echo "100";
                                                                        } else {
                                                                            $per = ($totalSpentAmount / $totalSanctionedCost)*100;
                                                                            if($per != "INF"){
                                                                                // $per = 100 - round($per);
                                                                                $per = round($per);
                                                                                // $totalUtilizedCost = $totalUtilizedCost + $per;
                                                                                if($per > 100){
                                                                                    echo "<span style='color:red'>".$per."</span>";
                                                                                } else {
                                                                                    echo $per;
                                                                                }
                                                                            } else {
                                                                                echo "-";
                                                                            } 
                                                                        }
                                                                    }
                                                                    
                                                                    ///echo $totalUtilizedCost ?>
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <?php
                                            $query = mysqli_query($con, "SELECT * FROM finance WHERE yojanaId = '$yojanaId'");
                                            if(mysqli_num_rows($query) >0){
                                            ?>
                                            <div class="col-md-12">
                                                <div id="container" style="height: 40rem;width:100%"></div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <!-- -->
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
    
    <script>

        anychart.onDocumentReady(function () {
            // create data set on our data
            var chartData = {
              
                title: 'Subwork cost status',
                header: ['#', 'Total Sanctioned Cost', 'Expenditure', 'Remaining Amount'],
                rows: [
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
                    $i = 1;
                    $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
                    while($result = mysqli_fetch_assoc($query)){
                        
                        $subWorkId = $result['id'];
                        if($result['subWork'] == "Trial Bore"){
                            $subWork = $countTrialBore++.". Trial Bore (Depth - ".$result['depth']." m & Dia - ".$result['diameter']." m)";
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "Percolation Well"){
                            $subWork = $countPercolation++.". Percolation Well (Depth - ".$result['depth']." m & Dia - ".$result['diameter']." m)";
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "Approach Bund"){
                            $subWork = $countApproach++.". ".$result['subWork']." (Length - ".$result['length']." m)";
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Approach Bund' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "Switch Room"){
                            $subWork = $countSwitch++.". ".$result['subWork'];
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Switch Room' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "Rising Main"){
                            $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm² = ".$result['length']." m)";
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "RCC ESR"){
                            $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Elevated Service Reservoir' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "Distribution System"){
                            $subWork = $countDistribution++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "MSEDC Work"){
                            $subWork = $countMsedc++.". ".$result['subWork'];
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'MSEDC Work' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "Trial & Run"){
                            $subWork = $countTrial++.". ".$result['subWork']. " (Months - ".$result['month'].")";
                            $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Trial & Run' AND yojanaId = '$yojanaId'");
                            $r = mysqli_fetch_assoc($q);
                            $workDone = $r['workDone'];
                            if(empty($workDone)){
                                $workDone = 0;
                            }
                            
                        } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                            continue;
                        }
                        
                        $q = mysqli_query($con, "SELECT SUM(amount) as 'totalExpenditure' FROM `finance` WHERE subWorkId = '$subWorkId' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $totalExpenditure = $r['totalExpenditure'];
                        
                        $actualCost = $result['actualPrice'];
                        
                        $remainingAmount = intval($actualCost) - intval($totalExpenditure) ;
                        
                        
                        if($i > 1){
                            echo ",";
                        }
                        
                        echo "['".$subWork."', ".$actualCost.", ".$totalExpenditure.", ".$remainingAmount."]";
                        $i++;
                    }
                    
                    ?>
                ]
            };
        
            // create column chart
            var chart = anychart.column();
        
            // set chart data
            chart.data(chartData);
        
            // turn on chart animation
            chart.animation(true);
            // chart.xAxis().labels().rotation(-45);
            chart.yAxis().labels().format('₹{%Value}{groupsSeparator: }');
        
            // set titles for Y-axis
            chart.yAxis().title('Amount');
            var xLabels = chart.xAxis().labels();
            xLabels.wordBreak("break-word");
            xLabels.hAlign("center");
            xLabels.width(80);
        
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