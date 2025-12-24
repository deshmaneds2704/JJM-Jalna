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
?>
<!DOCTYPE html>
<html lang="en">
    

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Scheme List</title>

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bulma.min.css">-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">-->
    <!-- End layout styles -->
    
    
    
    <style>
        .tablehead {
            background: #0033c4;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        .table thead th {
            font-weight: bold;
        }
        .center{
            text-align: center;
        }
        .color{
            color: #212529;
            font-weight: bold;
            font-size: 18px;
        }
        @media print{
            .btn, .bottom-navbar>.contain, .mdi-menu, .footer, .no-print, .horizontal-menu {
                display: none;
            }
            @page {
                size: landscape
            }
            .page-body-wrapper{
                margin-top: -5rem;
            }
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
            
        body {
            /* Set "my-sec-counter" to 0 */
            counter-reset: my-sec-counter;
        }

        .count::before {
            /* Increment "my-sec-counter" by 1 */
            counter-increment: my-sec-counter;
            content:  counter(my-sec-counter);
        }
        
        .printBtn, .bachBtn {
            margin-bottom: 1rem;
        }
        
        @media print {
       .main-panel
        {
            margin-top:70px;
        }
        .content-text h2
        {
            margin-top:0px !important;
        }
        }
    </style>
<!--<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">-->
<!--  <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>-->
</svg>
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
                                if(!isset($_GET['yojanaId'])){
                                ?>
                                <div class="card-body">
                                   <div >
                                        <a href="from_to_date.php" >
                                    <button style="margin-bottom: -6%;" type="submit"  name="submit" class="btn btn-primary me-2"><i class="bi bi-arrow-return-left"></i></button>
                                    </a>
                                    <center style="padding-bottom:30px;">
                                        <h3 class="ribbon">Date Wise Scheme</h3>
                                    </center>
                                    </div>
                                    <?php
                                        $result=mysqli_query($con,"SELECT * FROM yojanaMaster ORDER BY id DESC") ;
                                        
                                        if(mysqli_num_rows($result)>0){
                                    ?>
        
                                    <div class="table-responsive">
                                        <table class="table table-striped" id="dataTable">
                                            <thead>
                                                <tr>
                                                    <th >#</th>
                                                    <th style="display:none">Id</th>
                                                    <th>Scheme Id</th>
                                                    <th style="font-weight: bold;">Name of Scheme</th>
                                                    <th style="font-weight: bold;">Taluka</th>
                                                    <th style="font-weight: bold;">Date</th>
                                                    <th style="font-weight: bold;">Action</th>
                                                    
                                                </tr>
                                            </thead>
        
                                            <tbody>
                                                <?php
                                                
                                                $from = $_REQUEST['from_date'];
                                                $to = $_REQUEST['to_date'];
                                        		$sql="SELECT * FROM yojanaMaster WHERE createdDate BETWEEN '$from' AND '$to' ";
                                                $result1=mysqli_query($con,$sql)or die($con->error);
                                                $i= 1;
                                                while ($row =mysqli_fetch_assoc($result1) ){
                                                    $yojanaId = $row['yojanaId'];
                                                ?>
        
                                                <tr>
                                                    <td class="count">
                                                        <?php //echo  $i++; ?>
                                                    </td>
                                                    <td  style="display:none">
                                                        <?php echo $row['id'];  ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['yojanaId']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['yojanaName']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['taluka'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date('d-m-Y', strtotime($row['createdDate'])) ?>
                                                    </td>
                                                    <td>
                                                        <a href="date_wise_shceme?yojanaId=<?php echo $yojanaId ?>&from_date=<?php echo $from ?>&to_date=<?php echo $to ?>"><i class="bi bi-box-arrow-right" style="font-size: 30px; color:#0033c4;"></i></a>
                                                        <!--<a href="createYojana?yojanaId=<?php echo $yojanaId ?>"><i class="mdi mdi-pencil" style="font-size:20px;color:green;padding:5px;"></i></a>
                                                        <a onclick="deletefun('createYojana_db','<?php echo $yojanaId ?>')"><i class="mdi mdi-delete" style="font-size:20px;color:red;padding:5px;"></i></a>-->
                                                    </td>
                                                </tr>
                                                <?php 
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                                    } else{
                                        echo "<div class='card-body' style='text-align:center'><img src='img/no-records.png'></div>";
                                    }
                                }
                                
                                if(isset($_GET['yojanaId'])){
                                    
                                    $yojanaId = $_GET['yojanaId'];
                                    $query1 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId ='$yojanaId' ") or die ($con->error); 
                                    $row1= mysqli_fetch_assoc($query1);
                                ?>
                                <a href="date_wise_shceme" class="backBtn"><i class="fa fa-mail-reply"></i></a>
                                <div class="card-body">
                                    <a href="date_wise_shceme?from_date=<?php echo $_REQUEST['from_date'] ?>&to_date=<?php echo $_REQUEST['to_date'] ?>" style="text-algin: left !important;margin-bottom:3rem;"><button type="button" class="btn btn-primary me-2 bachBtn">Back</button></a>
                                    <button type="button" id="printBtn" onclick="window.print()" class="btn btn-primary me-2 printBtn">Print</button>
                                    <center>
                                        <h4 class="card-title" style="color: #ff0854c9;">
                                            <?php echo $row1['yojanaName'] ." (".$row1['yojanaId'].")" ; ?>
                                        </h4>
                                    </center>
                                    <div class="row">
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
                                        </div>
                                        
                                        <div class="col-md-1"></div>
                                        
                                        <div class="col-md-10">
                                            <br>
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
                                                        $j = 1;
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Trial Bore' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']." (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";?>
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
                                                        
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Percolation Well' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']." (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";?>
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
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Approach Bund' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']." (Length -".$result['length']." m)";?>
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
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Switch Room' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork'];?>
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
                                                        
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Pumping Machinery' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']." (".$result['bhp']." bhp)";?>
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
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Rising Main' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm<sup>2</sup> = ".$result['length']." m)";?>
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
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'RCC ESR' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']." (".$result['capacity']." ltr.)";?>
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
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Distribution System' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";?>
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
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'MSEDC Work' ");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork'];?>
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
                                                        
                                                        $j = 1;
                                                        $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId' AND subWork = 'Trial & Run'");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                            $id = $result['name'];     
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $j++.". ".$result['subWork']. " (Months - ".$result['month'].")";?>
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
                                                            <th class="center">
                                                                <?php
                                                                // echo $totalCost;
                                                                
                                                                $q2 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
                                                                $r2 = mysqli_fetch_assoc($q2);
                                                                $gst = $r2['gst'];
                                                                
                                                                $finialCost = ($totalCost * $gst)/100;
                                                                $finialCost = $finialCost + $totalCost;
                                                                echo $totalCost." + ".$gst."% = <b>".$finialCost."</b>";
                                                                ?>
                                                            </th>
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
                                    </div>
                                </div>
                                <?php 
                                }
                                ?>
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
    
    <!-- datatable -->
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <!--<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bulma.min.js"></script>-->

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
        $(document).ready(function(){
            $('#dataTable').DataTable({
                'columnDefs': [ {
                    'targets': [3], // column index (start from 0)
                    'orderable': false, // set orderable false for selected columns
                }],
                order: [[1, 'desc']],
            });
        })
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