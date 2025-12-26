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
    <title>Quality Certificate Report</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    
    <link rel="stylesheet" href="../assets/vendors/jquery-bar-rating/css-stars.css" />
    <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../assets/css/demo_2/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../assets/images/favicon.png" />

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
        .tablehead {
            background: #0033c4;
            
            color: white;
            font-weight: bold;
        }

        .table thead th {
            font-weight: bold;
        }
        
        .ribbon
        {
          font-size:19px;  
        }

        @media only screen and (max-width: 600px) {
            .ribbon
        {
          font-size:12px;  
        }
            #norecord {
                height: 200px;
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
                <div class="content-wrapper pb-0">

                    <div class="row">

                        <!-- table-->

                        <div class="col-md-12 stretch-card grid-margin">
                            <div class="card">

                                <!-- -->
                                <?php
                                if(!isset($_GET['yojanaId'])){
                                ?>
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <center style="padding-bottom:30px;">
                                            <h3 class="ribbon">Quality Certificate Report</h3>
                                        </center>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            id="search_field">
                                    </div>
                                    </div>
                                    <?php
                                        $result=mysqli_query($con,"SELECT * FROM yojanaMaster") ;
                                        
                                        if(mysqli_num_rows($result)>0){
                                    ?>

                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th style="font-weight: bold;">Scheme Id</th>
                                                    <th style="font-weight: bold;">Name of Scheme</th>
                                                    <th style="font-weight: bold;">Taluka</th>
                                                    <th style="font-weight: bold;">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody id="yojanatable">
                                                <?php
                                        		$sql="SELECT * FROM yojanaMaster ORDER BY id DESC";
                                                $result1=mysqli_query($con,$sql);
                                                $i= 1;
                                                while ($row =mysqli_fetch_assoc($result1) ){
                                                    $yojanaId = $row['yojanaId'];
                                                ?>

                                                <tr>
                                                    <td>
                                                        <?php echo  $i++; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['yojanaId']; ?>
                                                    </td>
                                                    <td style="width:400px;">
                                                        <?php echo $row['yojanaName']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['taluka']; ?>
                                                    </td>
                                                    <td><a
                                                            href="qualityCertificateReport?yojanaId=<?php echo $yojanaId ?>">Show
                                                            Quality Certificates</a></td>
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
                                ?>
                                <!-- -->
                                <?php
                                          $i=1;
                                if(isset($_GET['yojanaId'])){
                                        $yojanaId = $_GET['yojanaId'];
                                ?>
                                
                                <div class="row" style="padding:17px">
                                    <a href="qualityCertificateReport" style="float: left;margin-bottom:1rem"><button type="button" class="btn btn-primary me-2">Back</button></a>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <center style="padding-bottom:30px;">
                                            <h3 class="ribbon" style="font-size:19px">Quality certificate REPORT</h3>
                                        </center>
                                    </div>
                                    <?php
                                    $result3=mysqli_query($con,"SELECT * FROM uploadDoc WHERE yojanaId='$yojanaId' AND stepNo != '0'") ;
                                            
                                    if(mysqli_num_rows($result3)>0){
                                    ?>


                                    <div class="col-md-4">
                                        <input type="text" class="form-control" placeholder="Search..."
                                            id="search_field">
                                    </div>
                                </div>


                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table  text-dark" >
                                            <thead>
                                                <tr id="t_head">
                                                    <th>#</th>
                                                    <th>Taluka</th>
                                                    <th>Village</th>
                                                    <th>scheme Id</th>
                                                    <th>Name of scheme</th>
                                                    <th>Sub Work</th>
                                                    <!--<th>Step no.</th>-->
                                                    <th>Document name</th>
                                                </tr>
                                            </thead>
                                            <tbody id="yojanatable">
                                                <?php
                                                    $id=$_GET['yojanaId'];
                                                    $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$id'");
                                                    $result = mysqli_fetch_assoc($query);
                                                 
                                                    while($result1=mysqli_fetch_assoc($result3)){
                                                ?>


                                                <tr>
                                                    <td>
                                                        <?php echo $i++ ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $result['taluka']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $result['village']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $result['yojanaId']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $result['yojanaName']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $result1['subWork'] ?>
                                                    </td>
                                                    
                                                    <!--<td>
                                                        <?php echo $result1['stepNo']; ?>
                                                    </td>-->
                                                    <td>
                                                        <a <?php echo $file ?> href="uploadedDoc/<?php echo $result1['document']; ?>"
                                                            style="text-decoration:none;"><span
                                                                style="font-size: 15px;color: black;">
                                                                <?php echo $result1['docName'] ?>
                                                            </span> <i class="bi bi-arrow-right"></i>
                                                        </a>


                                                    </td>

                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                    } 
                                    else{
                                        echo "<div class='card-body' style='text-align:center' ><img src='img/no-records.png' id='norecord' class='img-fluid'></div>";
                                    }      
                                        ?>
                                            </tbody>

                                        </table>
                                        <?php
                                        }              
                                                     
                                                      
                                              ?>

                                    </div>

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
    <!-- master search-->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <!-- -->
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