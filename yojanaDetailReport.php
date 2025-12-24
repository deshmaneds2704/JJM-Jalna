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
    $mobile = true;
    $file = "download";
}
else {
    $mobile = false;
    $file = "target='_blank'";
}
require_once("include/con.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Scheme Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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
    @media print{
        .btn, .bottom-navbar>.contain, .mdi-menu, .footer, .no-print, .horizontal-menu {
                display: none;
            }
        @page {size: landscape}
        
        #subWorkDiv, #stepDiv{
                    width: 100%;
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

</head>

<body>
    <div class="container-scroller">
        <?php
        include('header.php');
    ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <?php
                                $yojanaId = $_GET['id'];
                                
                                $query1 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId ='$yojanaId' ") or die ($con->error); 
                                $row1= mysqli_fetch_assoc($query1);
                                ?>

                                <div class="card-body">
                                    <a href="yojanaReport" style="text-align: left;"><button type="button"class="btn btn-primary me-2" name="back">Back</button></a>
                                    <button type="button" id="printBtn" class="btn btn-primary me-2" onclick="printFun()">Print</button>
                                    <center>
                                        <h4 class="card-title" style="color: #ff0854c9;">
                                            <?php echo $row1['yojanaName'] ." (".$row1['yojanaId'].")" ; ?>
                                        </h4>
                                    </center>
                                    <div class="row">
                                        <div class="col-md-12" style="padding-bottom:20px;">
                                            <div class="row">
                                                <div class="col-md-2 no-print"></div>
                                                <div class="col-md-3 ">
                                                    <span class="color">
                                                        Sub Division :
                                                    </span>
                                                    <span class="fon"> <?php echo $row1['subDivision']; ?></span>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <span class="color">
                                                        Taluka :
                                                    </span>
                                                    <span class="fon"> <?php echo $row1['taluka']; ?></span>
                                                </div>
                                                
                                                <div class="col-md-3 ">
                                                    <span class="color">
                                                        Gram Panchayat :
                                                    </span>
                                                    <span class="fon"> <?php echo $row1['gramPanchayat']; ?></span>
                                                </div>
                                                
                                                <div class="col-md-1 no-print"></div>
                                                <div class="col-md-2 no-print"></div>
                                                
                                                <div class="col-md-3 ">
                                                    <span class="color">
                                                        Village :
                                                    </span>
                                                    <span class="fon"> <?php echo $row1['village']; ?></span>
                                                </div>
                                                
                                                <div class="col-md-3 ">
                                                    <span class="color">
                                                        Habitation :
                                                    </span>
                                                    <span class="fon"> <?php echo $row1['habitation']; ?></span>
                                                </div>
                                                
                                                
                                                <?php 
                                                $query2 = mysqli_query($con, "SELECT * FROM allocatedYojana WHERE yojanaId = '$yojanaId' AND designation = 'executiveEng'");
                                                $result2 = mysqli_fetch_assoc($query2);
                                                $userId = $result2['userId'];
                                                $q = mysqli_query($con, "SELECT * FROM users WHERE userId = '$userId'");
                                                $r = mysqli_fetch_assoc($q);
                                                ?>
                                    
                                                <div class="col-md-3 ">
                                                    <span class="color"> Sub Divisional Eng. : </span>
                                                    <span class="fon">   <?php echo $r['fullName']; ?></span>
                                                </div>
                                                
                                                <div class="col-md-1 no-print"></div>
                                                <div class="col-md-2 no-print"></div>
                                                
                                                <div class="col-md-3">
                                                    <?php 
                                                    $query3 = mysqli_query($con, "SELECT * FROM allocatedYojana WHERE yojanaId = '$yojanaId' AND designation = 'sectionEng'");
                                                    $result3 = mysqli_fetch_assoc($query3);
                                                    $userId = $result3['userId'];
                                                    $q = mysqli_query($con, "SELECT * FROM users WHERE userId = '$userId'");
                                                    $r = mysqli_fetch_assoc($q);
                                                    ?>
                                                    <span class="color"> Section Eng. : </span>
                                                   <span class="fon"> <?php echo $r['fullName']; ?></span>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <span class="color"> Expected Start Date : </span>
                                                    <span class="fon">
                                                        <?php
                                                        if($row1['exectedStartDate'] !="" && $row1['exectedStartDate'] != '0000-00-00'){
                                                            echo date('d-m-Y', strtotime($row1['exectedStartDate']));
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <span class="color"> Expected End Date : </span>
                                                    <span class="fon">
                                                        <?php 
                                                        if($row1['expectedDate'] !="" && $row1['expectedDate'] !="0000-00-00"){
                                                            echo date('d-m-Y', strtotime($row1['expectedDate'])) ;
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                                
                                                <div class="col-md-10 no-print">
                                                    <div class="row">
                                                    <?php 
                                                    $query3 = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND document != '' AND stepNo = 0");
                                                    if(mysqli_num_rows($query3)>0){
                                                    ?>
                                                    <h4 class="card-title" style="font-size:15px; margin-top:20px;margin-bottom:-18px;">Scheme related document </h4>
                                                    <?php
                                                    }
                                                    while($row3 = mysqli_fetch_assoc($query3)){
                                                        if($row3['document'] != ""){
                                                            
                                                        
                                                    ?>
                                                        
                                                    <div class="col-md-3 " style="padding-top:10px;">
                                                        <br>
                                                        <a href="uploadedDoc/<?php echo $row3['document']; ?>" <?php echo $file ?> style="text-decoration:none;"><span style="font-size: 15px;color: black;"> <?php echo $row3['docName'] ?>
                                                            </span> 
                                                            View
                                                            <!--<i class="bi bi-arrow-right"></i>-->
                                                        </a>
                                                    </div>
                                                    <?php 
                                                        }
                                                    } 
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7" id="subWorkDiv" style="padding:0px;">
                                          <div class="table-responsive">
                                            <table class="table table-striped" >
                                                    <thead>
                                                        <tr class="tablehead table-striped">
                                                            <th>Sub Works </th>
                                                            <!--<th>प्रस्ताविक किंमत </th>-->
                                                            <th>Sanctioned Cost </th>
                                                            <th>Planned Date</th>
                                                            <th>Actual Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $totalCost = 0;
                                                        
                                                        $percolationWellCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $percolationWellCount++.". ".$result['subWork']." (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $approachBundCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $approachBundCount++.". ".$result['subWork']." (Length -".$result['length']." m)";?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $switchRoomCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $switchRoomCount++.". ".$result['subWork'];?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $pumpingMachineryCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $pumpingMachineryCount++.". ".$result['subWork']." (".$result['bhp']." bhp)";?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];     
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $risingMainCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $risingMainCount++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm<sup>2</sup> = ".$result['length']." m)";?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];     
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $rccEsrCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'RCC ESR' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $rccEsrCount++.". ".$result['subWork']." (".$result['capacity']." ltr.)";?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];     
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $distributionSystemCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $distributionSystemCount++.". ".$result['subWork']." (".$result['depth']." mm ".$result['typePipe']." ".$result['length']." m)";?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];     
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $msedcWork = 0;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $msedcWork++.". ".$result['subWork'];?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];     
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        
                                                        $trialRunCount = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Trial & Run' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $trialRunCount++.". ".$result['subWork']. " (Months - ".$result['month'].")";?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['actualPrice'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualPrice'];    
                                                                    $totalCost = $totalCost + $result['actualPrice'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['plannedDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['plannedDate'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php 
                                                                if($result['actualDate'] == "0000-00-00"){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['actualDate'];     
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        <tr>
                                                            <th>
                                                                Total Cost
                                                            </th>
                                                            <td class="center">
                                                                <?php
                                                                // echo $totalCost;
                                                                
                                                                $q2 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
                                                                $r2 = mysqli_fetch_assoc($q2);
                                                                $gst = $r2['gst'];
                                                                
                                                                $finialCost = ($totalCost * $gst)/100;
                                                                $finialCost = $finialCost + $totalCost;
                                                                echo $totalCost." + ".$gst."% = <b>".$finialCost."</b>";
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr class="tablehead table-striped">
                                                            <th> </th>
                                                            <th style="color: white;">Year - Population</th>
                                                            <th style="color: white;">Year - Population  </th>
                                                            <th style="color: white;">Year - Population</th>
                                                            <!--<th style="color: white;">Year - Population</th>-->
                                                        </tr>
                                                        <?php
                                                        $q = mysqli_query($con, "SELECT * FROM subWorkMaster WHERE type = 'date'");
                                                        while($r = mysqli_fetch_assoc($q)){
                                                            $id = $r['id'];
                                                            if($id == 14){
                                                                $subWork = "Year - Population";
                                                            } else {
                                                                $subWork = "Year - Demand ";
                                                            }
                                                            $query = mysqli_query($con, "SELECT * FROM subWork WHERE subWork = '$subWork' AND yojanaId = '$yojanaId'");
                                                            $result = mysqli_fetch_assoc($query);
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $r['subWork'];?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['yearPopulation1'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['yearPopulation1'];    
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['yearPopulation2'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['yearPopulation2'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="center">
                                                                <?php
                                                                if($result['yearPopulation3'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['yearPopulation3'];     
                                                                }
                                                                ?>
                                                            </td>
                                                            <!--<td class="center">
                                                                <?php 
                                                                if($result['yearPopulation4'] == ""){
                                                                    echo "-";
                                                                } else {
                                                                    echo $result['yearPopulation4'];     
                                                                }
                                                                ?>
                                                            </td>-->
                                                        </tr>
                                                        <?php
                                                            }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-5 break" id="stepDiv" >
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="tablehead table-striped">
                                                            <th>Stage (Tappa) </th>
                                                            <th> </th>
                                                            <th> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query4 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
                                                        $result4 = mysqli_fetch_assoc($query4);
                                                        if($result4['stepOne'] == "Yes"){
                                                        ?>
                                                        <tr>
                                                            <td>Source</td>
                                                            <td>
                                                                Dia (In M)
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Depth (In M)
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Type of Structure
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Remark
                                                            </td>

                                                            <?php
                                                            $query5 = mysqli_query($con, "SELECT * FROM stepOne WHERE yojanaId = '$yojanaId' ") or die ($con->error);
                                                            
                                                            $result5 = mysqli_fetch_assoc($query5);
                                                            ?>
                                                            <td>
                                                                <?php
                                                                if($result5['diameter'] != ""){ 
                                                                    echo $result5['diameter']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                                
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result5['depth'] != ""){ 
                                                                    echo $result5['depth']; 
                                                                } else { 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                                
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php if($result5['typeOfStructure'] != ""){ 
                                                                    echo $result5['typeOfStructure']; 
                                                                }else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result5['remark'] != ""){
                                                                    echo $result5['remark']; 
                                                                } else { 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                            </td>
                                                        </tr>
                                                        <?php 
                                                        }
                                                        if($result4['stepTwo'] == "Yes"){
                                                        ?>
                                                        <tr>
                                                            <td>Pump & Rising Main</td>
                                                            <td>
                                                                No of pump
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Power (In HP)
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Discharge in Lph
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Pump Hours
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Dia (In MM)
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Length (In Meter)
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Material
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Remark
                                                            </td>
                                                            
                                                            <?php
                                                            $i = 0;
                                                            $query6 = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId' ") or die ($con->error); 
                                                            while($result6 = mysqli_fetch_assoc($query6)){
                                                                if(!empty($result6['pumpNumber'])){
                                                                    $pumpNumbers[$i] = $result6['pumpNumber'];
                                                                }
                                                                if(!empty($result6['power'])){
                                                                    $powers[$i] = $result6['power'];
                                                                }
                                                                if(!empty($result6['pumpingHours'])){
                                                                    $pumpingHourss[$i] = $result6['pumpingHours'];
                                                                }
                                                                if(!empty($result6['pumpHouse'])){
                                                                    $pumpHouses[$i] = $result6['pumpHouse'];
                                                                }
                                                                
                                                                if(!empty($result6['diameter'])){
                                                                    $diameters[$i] = $result6['diameter'];
                                                                }
                                                                if(!empty($result6['material'])){
                                                                    $materials[$i] = $result6['material'];
                                                                }
                                                                if(!empty($result6['length'])){
                                                                    $lengths[$i] = $result6['length'];
                                                                }
                                                                $i++;
                                                            }
                                                            ?>
                                                            
                                                            <td>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($pumpNumbers as $pumpNumber){
                                                                    if($pumpNumber != "0"){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$pumpNumber."</span>";
                                                                        } else {
                                                                            echo "<span>".$pumpNumber."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                }
                                                                
                                                                if(count($pumpNumbers) == "0"){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>
                                                                
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php
                                                                $i = 1;
                                                                foreach ($powers as $power){
                                                                    if($power != "0"){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$power."</span>";
                                                                        } else {
                                                                            echo "<span>".$power."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                }
                                                                if(count($powers) == 0){
                                                                    echo "<span >-</span>";
                                                                }
                                                                ?>

                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($pumpingHourss as $pumpingHours){
                                                                    if($pumpingHours != ""){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$pumpingHours."</span>";
                                                                        } else {
                                                                            echo "<span>".$pumpingHours."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                }
                                                                
                                                                if(count($pumpingHourss) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>

                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($pumpHouses as $pumpHouse){
                                                                    if($pumpHouse != ""){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$pumpHouse."</span>";
                                                                        } else {
                                                                            echo "<span>".$pumpHouse."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                } 
                                                                
                                                                if(count($pumpHouses) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>

                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($diameters as $diameter){
                                                                    if($diameter != "0"){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$diameter."</span>";
                                                                        } else {
                                                                            echo "<span>".$diameter."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                } 
                                                                if(count($diameters) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($lengths as $length){
                                                                    if($length != "0"){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$length."</span>";
                                                                        } else {
                                                                            echo "<span>".$length."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                }
                                                                if(count($lengths) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>

                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($materials as $material){
                                                                    if($material != ""){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$material."</span>";
                                                                        } else {
                                                                            echo "<span>".$material."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                } 
                                                                if(count($materials) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result6['remarks'] != ""){ 
                                                                    echo $result6['remarks']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        if($result4['stepThree'] == "Yes"){
                                                        ?>
                                                        <tr>
                                                            <td>ESR</td>
                                                            <td>
                                                                Location survey No.
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Capacity (In Ltrs)
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Staging Height (In M)
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Type of Construction
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Remark
                                                            </td>

                                                            <?php         
                                                            $i = 0;
                                                            $query7 = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$yojanaId' ") or die ($con->error);
                                                            while($result7 = mysqli_fetch_assoc($query7)){
                                                                $surveyNos[$i] = $result7['surveyNo'];
                                                                $capacitys[$i] = $result7['capacity'];
                                                                $heights[$i] = $result7['height'];
                                                                $i++;
                                                            }
                                                            ?>
                                                            
                                                            <td>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($surveyNos as $surveyNo){
                                                                    if($surveyNo != ""){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$surveyNo."</span>";
                                                                        } else {
                                                                            echo "<span>".$surveyNo."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                } 
                                                                if(count($surveyNo) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($capacitys as $capacity){
                                                                    if($capacity != "0"){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$capacity."</span>";
                                                                        } else {
                                                                            echo "<span>".$capacity."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                } 
                                                                
                                                                if(count($capacity) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>
                                                                

                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                $i = 1;
                                                                foreach ($heights as $height){
                                                                    if($height != "0"){
                                                                        if($i >1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>".$height."</span>";
                                                                        } else {
                                                                            echo "<span>".$height."</span>";
                                                                        }
                                                                    } else {
                                                                        if($i > 1){
                                                                            echo "<span style='margin-left: 3rem;float: right;'>-</span>";
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    }
                                                                    $i++;
                                                                } 
                                                                if(count($heights) == 0){
                                                                    echo "<span>-</span>";
                                                                }
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result7['typeOfConstruction'] != ""){ 
                                                                    echo $result7['typeOfConstruction']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result7['remark'] != ""){ 
                                                                    echo $result7['remark']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        if($result4['stepFour'] == "Yes"){
                                                        ?>
                                                        <tr>

                                                            <td>Distribution System</td>
                                                            <td>
                                                                Length
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Material
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Completion Percentage
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Remark

                                                            </td>

                                                            <?php
                                                            $query8 = mysqli_query($con, "SELECT * FROM stepFour WHERE yojanaId = '$yojanaId' ") or die ($con->error);
                                                            $result8 = mysqli_fetch_assoc($query8);         
                                                            ?>
                                                            <td>
                                                                <?php 
                                                                if($result8['length'] != ""){ 
                                                                    echo $result8['length']; 
                                                                } else{
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result8['Material'] != ""){ 
                                                                    echo $result8['Material']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result8['completionPercentage'] != ""){ 
                                                                    echo $result8['completionPercentage'];
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result8['remark'] != ""){ 
                                                                    echo $result8['remark']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } ?>

                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        if($result4['stepFive'] == "Yes"){
                                                        ?>
                                                        <tr>
                                                            <td>Trial Run</td>
                                                            <td>
                                                                Has the scheme been completed?
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Reason for non-completion
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Date of Commissioning
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Date of Handing Over
                                                                
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Date Of TPI Visit - 1
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Date Of TPI Visit - 2
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Date Of TPI Visit - 3
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Date of Completion
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Completion Percentage
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                Remark
                                                            </td>
                                                            
                                                            <?php
                                                            $query8 = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId' ") or die ($con->error);
                                                            $result8 = mysqli_fetch_assoc($query8);         
                                                            ?>
                                                            <td>
                                                                <?php 
                                                                if($result8['yojanaComplete'] != ""){ 
                                                                    if($result8['yojanaComplete'] == "on"){
                                                                        echo "Yes";
                                                                    } else {
                                                                        echo "No";
                                                                    }
                                                                    // echo $result8['yojanaComplete']; 
                                                                }else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php
                                                                if($result8['reason'] != "") {
                                                                    echo $result8['reason'];
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php
                                                                if($result8['dateOfCommissioning'] != "0000-00-00" && !empty($result8['dateOfCommissioning'])) {
                                                                    echo date('d-m-Y', strtotime($result8['dateOfCommissioning']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                
                                                                <?php
                                                                if($result8['dateOfHandingOver'] != "0000-00-00" && !empty($result8['dateOfHandingOver']) ) {
                                                                    echo date('d-m-Y', strtotime($result8['dateOfHandingOver']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php
                                                                if($result8['datesOfTpiVisit1'] != "0000-00-00" && !empty($result8['datesOfTpiVisit1'])) {
                                                                    echo date('d-m-Y', strtotime($result8['datesOfTpiVisit1']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php
                                                                if($result8['datesOfTpiVisit2'] != "0000-00-00" && !empty($result8['datesOfTpiVisit2'])) {
                                                                    echo date('d-m-Y', strtotime($result8['datesOfTpiVisit2']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php
                                                                if($result8['datesOfTpiVisit3'] != "0000-00-00" && !empty($result8['datesOfTpiVisit3'])) {
                                                                    echo date('d-m-Y', strtotime($result8['datesOfTpiVisit3']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php
                                                                if($result8['dateOfCompletion'] != "0000-00-00" && !empty($result8['dateOfCompletion'])) {
                                                                    echo date('d-m-Y', strtotime($result8['dateOfCompletion']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result8['completionPercentage'] != ""){
                                                                    echo $result8['completionPercentage'];
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                                <div style="display: flex;justify-content: center;"><hr></div>
                                                                <?php 
                                                                if($result8['remark'] != ""){
                                                                    echo $result8['remark']; 
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
        
        function printFun(){
            window.print();
            // $('#subWorkDiv').removeClass()
        }
    
        var count = 2;
        var count2 = 1;
        $("#remove").hide();
        var suspected = Number(4);
        $("#add").on("click", function on() {
            if (count <= 4) {
                var type = $('#element').val();
                // $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>दस्तऐवजाचा प्रकार </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='img[]' class='file-upload-default' /><div class='input-group col-xs-12'><input type='text' class='form-control file-upload-info' disabled placeholder='Upload Image' /><span class='input-group-append'> <button class='file-upload-browse btn btn-primary' type='button'> Upload </button></span></div></div></div>");
                $("#textboxDiv").append("<div class='row'><div class='col-md-6'><div class='form-group'><label>दस्तऐवजाचा प्रकार </label><input type='text' onkeyup='referred()' class='form-control' required name='doc" + count + "' id='doc'></div></div><div class='col-md-6'> <div class='form-group'><label>Upload File</label><input type='file' name='document[]' accept='.jpeg,.jpg,.png,.pdf,.pptx,.xls,.xlsx,.docx' class='form-control' /></div></div></div>");
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

        /*$(function () {
            $('#datepicker').datepicker();
        });*/
    </script>

    <!-- End custom js for this page -->
</body>

</html>