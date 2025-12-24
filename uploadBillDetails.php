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
    <title>Upload Bill Details</title>
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
    .star{
        font-size:18px;
        color:red;
    }
     .select2-container--default .select2-selection--single{
            height:50px;
        }
        .tab {
            margin-top: 30px;
        }

        .tab .nav-tabs {
            border: none;
            border-bottom: 1px solid #e4e4e4;
        }

        .nav-tabs li a {
            padding: 15px 40px;
            border: 1px solid #ededed;
            border-top: 2px solid #ededed;
            border-right: 0px none;
            background: #7a81f4;
            color: #fff;
            border-radius: 0px;
            margin-right: 0px;
            font-weight: bold;
            transition: all 0.3s ease-in 0s;
            text-decoration:none;
        }

        .nav-tabs li a:hover {
            border-bottom-color: #ededed;
            border-right: 0px none;
            background: #00b0ad;
            color: #fff;
        }

        .nav-tabs li a i {
            display: inline-block;
            text-align: center;
            margin-right: 10px;
        }

        .nav-tabs li:last-child {
            border-right: 1px solid #ededed;
        }

        .nav-tabs li.active a,
        .nav-tabs li.active a:focus,
        .nav-tabs li.active a:hover {
            border-top: 3px solid #00b0ad;
            border-right: 1px solid #d3d3d3;
            margin-top: -15px;
            color: #444;
            padding: 22px 40px;
            background: white;
            text-decoration:none;
        }

        .tab .tab-content {
            padding: 20px;
            line-height: 22px;
            box-shadow: 0px 1px 0px #808080;
        }

        .tab .tab-content h3 {
            margin-top: 0;
        }

        @media only screen and (max-width: 767px) {
            .nav-tabs li {
                width: 100%;
                margin-bottom: 2rem;
            }

            .nav-tabs li a {
                padding: 15px;
               
            }

            .nav-tabs li.active a,
            .nav-tabs li.active a:focus,
            .nav-tabs li.active a:hover {
                padding: 15px;
                margin-top: 0;
               
            }
        }
    </style>
    
    <style>
        .thead{
            font-weight:bold;
        }
        
      
.table thead th{
    font-weight: 800 !important;
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
                    <!--<div class="page-header">-->
                    <!--    <h3 class="page-title">Create User</h3>-->
                    <!--    <nav aria-label="breadcrumb">-->
                    <!--        <ol class="breadcrumb">-->
                    <!--            <li class="breadcrumb-item"><a href="#">Forms</a></li>-->
                    <!--            <li class="breadcrumb-item active" aria-current="page"> Form elements </li>-->
                    <!--        </ol>-->
                    <!--    </nav>-->
                    <!--</div>-->
                    <div class="row">
                        <div class="col-md-6=12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body pt-2">
                                  
                                    <div class="row" style="padding:17px;display: flex;justify-content: center;">
                                <div class="col-md-12">
                                    <center style="padding-bottom:30px;">
                                        <h3 class="ribbon">Upload Bill Detail</h3>
                                    </center>
                                </div>
                               
                            </div>
                                    <form class="forms-sample" action="uploadBillDetails_db" method="POST" enctype="multipart/form-data">
                                        
                                        <?php 
                                        if(isset($_GET['id'])){
                                            $id = $_GET['id'];
                                        ?> 
                                        <?php
                                        } else {
                                            $id = 0;
                                        }
                                        $query = mysqli_query($con, "SELECT * FROM users WHERE id = '$id'");
                                        $result = mysqli_fetch_assoc($query);
                                        $userId = $result['userId'];
                                        ?>
                                        <input type="hidden" value="<?php echo $userId ?>" name="userId">
                                        <!-- for Fullname -->
                                        <!-- -->

                                        <!-- for Mobile No. & Designation -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fullName">Name of Agent <span class="star">*</span></label>
                                                    <input type="text" class="form-control" required="" id="contractor" name="contractor" value="<?php echo $result['contractor'] ?>" placeholder="Name of Constructors" />
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Scheme <span class="star">*</span></label>
                                                    <select class="js-example-basic-single" required="" id="yojanaId" name="yojanaId" style="width: 100%;">
                                                        <option value="" selected="" disabled="">-- Select Scheme --</option>
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
                                                    <label for="mobileNumber">Bill Details<span class="star">*</span></label>
                                                    <input type="text" class="form-control" id="billDetails" value="" name="billDetails" placeholder="Bill Details" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="mobileNumber">Date of Work Order<span class="star">*</span></label>
                                                    <input type="date" class="form-control" id="dateOrder" name="dateOrder" />
                                                </div>
                                            </div>
                                            

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="expenditureGross">Expenditure Gross <span class="star">*</span></label>
                                                    <input type="number" class="form-control" required="" id="expenditureGross" name="expenditureGross" placeholder="Expenditure Gross" />
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="expenditureNet">Expanditure Net<span class="star">*</span></label>
                                                    <input type="number" class="form-control" required="" id="expenditureNet" name="expenditureNet" placeholder="Expanditure Net" />
                                                    <span style="color: red;font-size: 12px;" id="wrong"></span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="remark">Remark <span class="star">*</span></label>
                                                    <input type="text" class="form-control"  name="remark" value="" autocomplete="off" placeholder="Remark" />
                                                </div>
                                            </div>
                                            
                                            <!--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="photo">Photo<span class="star">*</span></label>
                                                    <input type="file" id="photo" name="photo[]" multiple class="form-control" accept=".jpg,.png,.jpeg" />
                                                </div>
                                            </div>-->

                                            <div class="col-md-12" id="video-div">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="photo">Photo<span class="star">*</span></label>
                                                            <input type="file" id="photo" name="photo[]" class="form-control" accept=".jpg,.png,.jpeg" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label for="video">Video<span class="star">*</span></label>
                                                            <input type="text" id="video" name="video[]" class="form-control"  placeholder="Video" />
                                                        </div>    
                                                    </div>
                                                    <div class="col-md-2" style="margin-top:2rem">
                                                        <button class="btn btn-primary"  type="button" id="addVideo">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- for Username -->
                                        
                                        <!-- -->
                                        
                                        <?php
                                        if(isset($_GET['id'])){
                                        ?>
                                        <button type="submit" name="update" id="submitBtn" class="btn btn-primary me-2"> Update </button>
                                        <?php
                                        } else {
                                        ?>
                                        <button type="submit" name="submit" id="submitBtn" class="btn btn-primary me-2"> Submit </button>
                                        <button class="btn btn-light" type="reset">Cancel</button>
                                        <?php
                                        }
                                        ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name of Agent</th>
                                                    <th>Date of Work order</th>
                                                    <th>Bill details</th>
                                                    <th>Expenditure Gross</th>
                                                    <th>Expenditure Net</th>
                                                    <th>Photo</th>
                                                    <th>Video</th>
                                                    <th>Remarks</th>
                                                    <th>Yojana</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $q = mysqli_query($con, "SELECT * FROM bill_details");
                                                while($r = mysqli_fetch_assoc($q)){
                                                ?>
                                                <tr>
                                                    <td><?php echo $r['contractor'] ?></td>
                                                    <td><?php echo $r['dateofWorkorder'] ?></td>
                                                    <td><?php echo $r['bill_details'] ?></td>
                                                    <td><?php echo $r['expenditureGross'] ?></td>
                                                    <td><?php echo $r['expenditureNet'] ?></td>
                                                    <td>
                                                        <?php 
                                                        if($r['photo'] !="" ){
                                                            $r['photo'];
                                                            $explode = explode('<br>', $r['photo']);
                                                            $i = 1;
                                                            foreach($explode as $photo){
                                                                if($photo != ""){
                                                        ?>
                                                        <a target="_blank" href="uploadedDoc/<?php echo $photo ?>" class="mb-2">Photo <?php echo $i ?></a><br><br>
                                                        <?php
                                                                }
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        if($r['video'] !="" ){
                                                            $explode = explode('<br>', $r['video']);
                                                            $i = 1 ;
                                                            foreach($explode as $video){
                                                                if($video != ""){
                                                        ?>
                                                        <a target="_blank" href="<?php echo $video ?>" class="mb-2">View Link <?php echo $i ?></a><br><br>
                                                        <?php
                                                                }
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $r['remarks'] ?></td>
                                                    <td>
                                                        <?php
                                                        $q1 = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '{$r['yojanaId']}'");
                                                        $r1 = mysqli_fetch_assoc($q1);
                                                        echo $r1['yojanaName'];
                                                        ?>
                                                        
                                                    </td>
                                                    <td>
                                                        <button onclick="deletefun('uploadBillDetails_db', '<?php echo $r['id'] ?>')" class="btn btn-primary">Delete</button>
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
                        
                        <!--<div class="col-md-6 text-center">
                        
                        <img class="img-fluid" src="img/user1.png">    
                            
                        </div>-->
                    
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
    <!-- tab section-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!-- end tab section-->
    
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
        function number(evt) {
            var num = String.fromCharCode(evt.which);
            if (!(/[0-9.]/.test(num))) {
                evt.preventDefault();
            }
        }
        
        
        var count = 2;
        $("#addVideo").on('click', function(){
            $("#video-div").append('<div class="row"><div class="col-md-5"><div class="form-group"><label for="photo">Photo<span class="star">*</span></label><input type="file" id="photo" name="photo[]" class="form-control" accept=".jpg,.png,.jpeg" /></div></div><div class="col-md-5"><div class="form-group"><label for="video">Video<span class="star">*</span></label><input type="text" id="video" name="video[]" class="form-control" placeholder="Video" /></div></div><div class="col-md-2" style="margin-top:2rem"><button class="btn btn-danger"  type="button" id="removeVideo">-</button></div></div>');
            
            if(count >= 2){
                count = count + 1;
                $("#removeVideo").show();
            }
        });
        
        $("#video-div").on('click', '#removeVideo', function () {
            $(this).closest('.row').remove();
            count = count - 1;
            
            if(count <2){
                $("#removeVideo").hide();
            }
        });
        
        function match() {
            
            var password = $("#password").val();
            var confirmPassword = $("#confirmPassword").val();
            var msg = $("#wrong");
            var submitBtn = $("#submitBtn");
            
            submitBtn.prop('disabled', true);
            submitBtn.css('cursor', 'no-drop');
            
            if(password != '' && confirmPassword != ''){
                if(password == confirmPassword) {
                    msg.html('');
                    submitBtn.prop('disabled', false);
                    submitBtn.css('cursor', 'pointer');
                }
                else {
                    msg.html("Password did not match!");
                    submitBtn.prop('disabled', true);
                    submitBtn.css('cursor', 'no-drop');
                }            
            } else {
                msg.html('');
                submitBtn.prop('disabled', true);
                submitBtn.css('cursor', 'no-drop');
            }
    
        }
    </script>
</body>

</html>