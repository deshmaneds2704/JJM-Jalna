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
    <title>Create User</title>
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
                        <div class="col-md-6 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Upload Bill Detail</h4>
                                    <form class="forms-sample" action="createUser_db" method="POST">
                                        
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
                                        <div class="form-group">
                                            <label for="fullName">Name of Constructors <span class="star">*</span></label>
                                            <input type="text" class="form-control" required="" id="fullName" name="fullName" value="<?php echo $result['fullName'] ?>" placeholder="Name of Constructors" />
                                        </div>
                                        <!-- -->

                                        <!-- for Mobile No. & Designation -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobileNumber">Bill Details<span class="star">*</span></label>
                                                    <input type="text" class="form-control" id="mobileNumber" value="" name="" placeholder="Bill Details" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobileNumber">Date of Work Order<span class="star">*</span></label>
                                                    <input type="date" class="form-control" onkeypress="number(event)" id="mobileNumber" value=""  name="mobileNumber" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- -->

                                   <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobileNumber">Photo<span class="star">*</span></label>
                                                    <input type="file" id="myFile" name="filename" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobileNumber">Video<span class="star">*</span></label>
                                                    <input type="text" id="myFile" name="filename" class="form-control"  placeholder="Video" />
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <!-- -->

                                        <!-- for Password & CP -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Expenditure Gross <span class="star">*</span></label>
                                                    <input type="text" class="form-control" required="" id="password" name="password" placeholder="Expenditure Gross" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="confirmPassword">Expanditure Net<span class="star">*</span></label>
                                                    <input type="text" class="form-control" required="" id="confirmPassword" placeholder="Expanditure Net" />
                                                    <span style="color: red;font-size: 12px;" id="wrong"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- for Username -->
                                        <div class="form-group">
                                            <label for="username">Remark <span class="star">*</span></label>
                                            <input type="text" class="form-control"  name="username" value="" autocomplete="off" placeholder="Remark" />
                                        </div>
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
                        
                        <div class="col-md-6 text-center">
                        
                        <img class="img-fluid" src="img/user1.png">    
                            
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