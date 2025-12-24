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
                                    <a href="index" style="text-align: left;"><button type="button"class="btn btn-primary me-2">Back</button></a>
                                    <button type="button" id="printBtn" class="btn btn-primary me-2" onclick="printFun()">Print</button>
                                    <center>
                                        <h4 class="card-title" style="color: #ff0854c9;">
                                            <?php echo $row1['yojanaName'] ." (".$row1['yojanaId'].")" ; ?>
                                        </h4>
                                    </center>
                                    <div class="row">
                                        <div class="col-md-12" style="padding-bottom:20px;">
                                            <div class="row" style="justify-content: flex-end">
                                               
                                                    <div class="col-md-3 ">
                                                        <span class="color">
                                                            Village -
                                                        </span>
                                                        <span class="fon"> <?php echo $row1['village']; ?></span>
                                                    </div>
                                                    <div class="col-md-3 ">
                                                        <span class="color">
                                                            Sub Division -
                                                        </span>
                                                        <span class="fon"> <?php echo $row1['subDivision']; ?></span>
                                                    </div>
                                                
                                                <div class="col-md-4">
                                                    <span class="color">
                                                        Taluka -
                                                    </span>
                                                    <?php echo $row1['taluka']; ?>
                                                </div>
                                                
                                                    <?php 
                                                    
                                                    $query2 = mysqli_query($con, "SELECT * FROM allocatedYojana where yojanaId = '$yojanaId' && designation = 'executiveEng'");
                                                    $result2 = mysqli_fetch_assoc($query2);
                                                    
                                                    $q = mysqli_query($con, "SELECT * FROM users WHERE userId = '{$result2['userId']}'");
                                                    $r = mysqli_fetch_assoc($q);
                                                    
                                                    ?>

                                                    <div class="col-md-4 ">
                                                        <span class="color"> Sub Divisional Engineer - </span>
                                                        <?php echo $r['fullName']; ?>
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <?php 
                                                        $query3 = mysqli_query($con, "SELECT * FROM allocatedYojana where yojanaId = '$yojanaId' && designation = 'sectionEng'");
                                                        $result3 = mysqli_fetch_assoc($query3);
                                                        
                                                        $q = mysqli_query($con, "SELECT * FROM users WHERE userId = '{$result3['userId']}'");
                                                        $r = mysqli_fetch_assoc($q);
                                                        
                                                        ?>
                                                        
                                                        <span class="color"> Section Engineer - </span>
                                                        <?php echo $r['fullName']; ?>
                                                    </div>
                                                    
                                                    <div class="col-md-2"></div>

                                                    <?php 
                                                    $query3 = mysqli_query($con, "SELECT * FROM uploadDoc where yojanaId = '$yojanaId' && stepNo = '0'");
                                                    
                                                    if(mysqli_num_rows($query3)>0){
                                                    ?>
                                                    <h4 class="card-title no-print" style="font-size:15px; margin-top:20px;margin-bottom:-18px;">
                                                        Scheme related document </h4>
                                                    <?php
                                                        while($row3 = mysqli_fetch_assoc($query3)){
                                                        ?>

                                                    <div class="col-md-3 no-print" style="padding-top:10px;">
                                                        <br>
                                                        <a href="uploadedDoc/<?php echo $row3['document']; ?>" <?php echo $file ?> style="text-decoration:none;"><span style="font-size: 15px;color: black;">
                                                            <?php echo $row3['docName'] ?></span> <i class="bi bi-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                    <?php
                                                        }
                                                    } 
                                                    ?>
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
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork']." (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";?>
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
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork']." (Length -".$result['length']." m)";?>
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
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork']." (".$result['bhp']." bhp)";?>
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
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm<sup>2</sup> = ".$result['length']." m)";?>
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
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'RCC ESR' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork']." (".$result['capacity']." ltr.)";?>
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
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork']." (".$result['depth']." mm ".$result['typePipe']." ".$result['length']." m)";?>
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
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork'];?>
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
                                                        
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Trial & Run' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $result['subWork']. " (Months - ".$result['month'].")";?>
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
                                                                echo $totalCost;
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
                                                        <tr>
                                                            <td>Source</td>
                                                            <td>
                                                                Dia (In M)
                                                                <br>
                                                                Depth (In M)
                                                                <br>
                                                                Year of construction
                                                                <br>
                                                                Type of Structure
                                                                <br>
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
                                                                
                                                                <br>
                                                                <?php 
                                                                if($result5['depth'] != ""){ 
                                                                    echo $result5['depth']; 
                                                                } else { 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result5['yearOfConstruction'] != ""){ 
                                                                    echo $result5['yearOfConstruction']; 
                                                                }else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                                
                                                                <br>
                                                                <?php if($result5['typeOfStructure'] != ""){ 
                                                                    echo $result5['typeOfStructure']; 
                                                                }else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result5['remark'] != ""){
                                                                    echo $result5['remark']; 
                                                                } else { 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pump & Rising Main</td>
                                                            <td>
                                                                No of pump
                                                                <br>
                                                                Power (In HP)
                                                                <br>
                                                                Installtion Year
                                                                <br>
                                                                Discharge in Lph
                                                                <br>
                                                                Pump house
                                                                <br>
                                                                Dia (In MM)
                                                                <br>
                                                                Length (In Meter)
                                                                <br>
                                                                Material
                                                                <br>
                                                                Remark
                                                            </td>
                                                            
                                                            <?php
                                                            $query6 = mysqli_query($con, "SELECT * FROM stepTwo WHERE yojanaId = '$yojanaId' ") or die ($con->error); 
                                                            $result6 = mysqli_fetch_assoc($query6);         
                                                            ?>
                                                            
                                                            <td>
                                                                <?php 
                                                                if($result6['pumpNumber'] != ""){ 
                                                                    echo $result6['pumpNumber']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                                
                                                                <br>
                                                                <?php
                                                                if($result6['power'] != ""){ 
                                                                    echo $result6['power']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result6['installationYear'] != ""){ 
                                                                    echo $result6['installationYear']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result6['pumpingHours'] != ""){ 
                                                                    echo $result6['pumpingHours']; 
                                                                }else{
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result6['pumpHouse'] != ""){ 
                                                                    echo $result6['pumpHouse']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result6['diameter'] != ""){ 
                                                                    echo $result6['diameter']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result6['length'] != ""){ 
                                                                    echo $result6['length']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result6['material'] != ""){ 
                                                                    echo $result6['material']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result6['remarks'] != ""){ 
                                                                    echo $result6['remarks']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>ESR</td>
                                                            <td>
                                                                Location survey No.
                                                                <br>
                                                                Capacity (In Ltrs)
                                                                <br>
                                                                Year of construction
                                                                <br>
                                                                Staging Height (In M)
                                                                <br>
                                                                Type of Construction
                                                                <br>
                                                                Remark
                                                            </td>

                                                            <?php                                                       
                                                            $query7 = mysqli_query($con, "SELECT * FROM stepThree WHERE yojanaId = '$yojanaId' ") or die ($con->error);
                                                            $result7 = mysqli_fetch_assoc($query7);         
                                                            ?>
                                                            
                                                            <td>
                                                                <?php 
                                                                if($result7['surveyNo'] != ""){ 
                                                                    echo $result7['surveyNo']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result7['capacity'] != ""){ 
                                                                    echo $result7['capacity'];    
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result7['yearOfConstruction'] != ""){ 
                                                                    echo $result7['yearOfConstruction']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result7['height'] != ""){ 
                                                                    echo $result7['height']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result7['typeOfConstruction'] != ""){ 
                                                                    echo $result7['typeOfConstruction']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php 
                                                                if($result7['remark'] != ""){ 
                                                                    echo $result7['remark']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>

                                                            <td>Distribution System</td>
                                                            <td>
                                                                Length
                                                                <br>
                                                                Material
                                                                <br>
                                                                Completion Percentage
                                                                <br>
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


                                                                <br>
                                                                <?php 
                                                                if($result8['Material'] != ""){ 
                                                                    echo $result8['Material']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result8['completionPercentage'] != ""){ 
                                                                    echo $result8['completionPercentage'];
                                                                } else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>

                                                                <br>
                                                                <?php 
                                                                if($result8['remark'] != ""){ 
                                                                    echo $result8['remark']; 
                                                                } else{ 
                                                                    echo "-"; 
                                                                } ?>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Trial Run</td>
                                                            <td>
                                                                Has the scheme been completed?
                                                                <br>
                                                                Reason for non-completion
                                                                <br>
                                                                Date of Commissioning
                                                                <br>
                                                                Date of Handing Over
                                                                <br>
                                                                Dates Of TPI Visit
                                                                <br>
                                                                1.
                                                                <br>
                                                                2.
                                                                <br>
                                                                3.
                                                                <br>
                                                                Date of Completion
                                                                <br>
                                                                Completion Percentage
                                                                <br>
                                                                Remark
                                                            </td>
                                                            
                                                            <?php
                                                            $query8 = mysqli_query($con, "SELECT * FROM stepFive WHERE yojanaId = '$yojanaId' ") or die ($con->error);
                                                            $result8 = mysqli_fetch_assoc($query8);         
                                                            ?>
                                                            <td>
                                                                <?php 
                                                                if($result8['yojanaComplete'] != ""){ 
                                                                    echo $result8['yojanaComplete']; 
                                                                }else{ 
                                                                    echo "-"; 
                                                                } 
                                                                ?>


                                                                <br>
                                                                <?php
                                                                if($result8['reason'] != "") {
                                                                    echo $result8['reason'];
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <br>
                                                                <?php
                                                                if($result8['dateOfCommissioning'] != "0000-00-00") {
                                                                    echo date('d-m-Y', strtotime($result8['dateOfCommissioning']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <br>
                                                                
                                                                <?php
                                                                if($result8['dateOfHandingOver'] != "0000-00-00") {
                                                                    echo date('d-m-Y', strtotime($result8['dateOfHandingOver']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <br>
                                                                <?php
                                                                if($result8['datesOfTpiVisit1'] != "0000-00-00") {
                                                                    echo date('d-m-Y', strtotime($result8['datesOfTpiVisit1']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <br>
                                                                <br>
                                                                <?php
                                                                if($result8['datesOfTpiVisit2'] != "0000-00-00") {
                                                                    echo date('d-m-Y', strtotime($result8['datesOfTpiVisit2']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <br>
                                                                <?php
                                                                if($result8['datesOfTpiVisit3'] != "0000-00-00") {
                                                                    echo date('d-m-Y', strtotime($result8['datesOfTpiVisit1']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <br>
                                                                
                                                                <br>
                                                                <?php
                                                                if($result8['dateOfCompletion'] != "0000-00-00") {
                                                                    echo date('d-m-Y', strtotime($result8['dateOfCompletion']));
                                                                } else {
                                                                    echo "-" ; 
                                                                };
                                                                ?>
                                                                <br>
                                                                <?php 
                                                                if($result8['completionPercentage'] != ""){
                                                                    echo $result8['completionPercentage'];
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                                <br>
                                                                <?php 
                                                                if($result8['remark'] != ""){
                                                                    echo $result8['remark']; 
                                                                } else {
                                                                    echo "-";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
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