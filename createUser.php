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
                                    <h4 class="card-title">Create User</h4>
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
                                            <label for="fullName">Full name <span class="star">*</span></label>
                                            <input type="text" class="form-control" required="" id="fullName" name="fullName" value="<?php echo $result['fullName'] ?>" placeholder="Full name" />
                                        </div>
                                        <!-- -->

                                        <!-- for Mobile No. & Designation -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobileNumber">Mobile number</label>
                                                    <input type="text" class="form-control" onkeypress="number(event)" id="mobileNumber" value="<?php echo $result['mobileNo'] ?>" maxlength="10" minlength="10" name="mobileNumber" placeholder="Mobile number" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="designation">Designation <span class="star">*</span></label><br>
                                                    <select class="js-example-basic-single" id="designation" required name="designation" style="width: 100%;">
                                                        <option value="" disabled="" selected=""></option>
                                                        <?php 
                                                        $designationArray = array(
                                                            'executiveEng' => 'Sub Divisional Engineer',
                                                            'sectionEng' => 'Section Engineer',
                                                            'contractor' => 'Contractor',
                                                            'clerk' =>  'ZP Clerk',
                                                            'admin' => 'Admin'
                                                            );
                                                        foreach ($designationArray as $key => $designation){
                                                            if($key == $result['designation']){
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        ?>
                                                        <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $designation ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- -->

                                        <!-- for Username -->
                                        <div class="form-group">
                                            <label for="username">Username <span class="star">*</span></label>
                                            <input type="text" class="form-control" required="" id="username" name="username" value="<?php echo $result['username'] ?>" autocomplete="off" placeholder="Username" />
                                        </div>
                                        <!-- -->

                                        <!-- for Password & CP -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password <span class="star">*</span></label>
                                                    <input type="password" class="form-control" required="" id="password" name="password" value="<?php echo $result['password'] ?>" onkeyup="match()" autocomplete="off" placeholder="Password" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="confirmPassword">Confirm Password<span class="star">*</span></label>
                                                    <input type="password" class="form-control" required="" id="confirmPassword" onkeyup="match()" value="<?php echo $result['password'] ?>" name="confirmPassword" autocomplete="off" placeholder="Confirm Password" />
                                                    <span style="color: red;font-size: 12px;" id="wrong"></span>
                                                </div>
                                            </div>
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

                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab" role="tabpanel">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-user-circle-o" ></i>Sub Divisional Engineer</a>
                                        </li>
                                        <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-user-circle"></i>Section Engineer</a></li>
                                        <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa-user"></i>ZP Clerk</a></li>
                                        <li role="presentation"><a href="#Section4" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa fa-user-plus"></i>Admin</a></li>
                                        <li role="presentation"><a href="#Section5" aria-controls="messages" role="tab" data-toggle="tab"><i class="fa fa fa-user-plus"></i>Contractor</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content tabs">
                                        <div role="tabpanel" class="tab-pane fade show active" id="Section1">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead >
                                                        <tr>
                                                            <th class="thead" style="font-weight:bold;">Full name </th>
                                                            <th class="thead" style="font-weight:bold;">Mobile number </th>
                                                            <th class="thead" style="font-weight:bold;" >Username</th>
                                                            <th class="thead" style="font-weight:bold;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'executiveEng'");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $result['fullName'] ?></td>
                                                            <td><?php 
                                                            if($result['mobileNo'] == 0){
                                                                echo "-";
                                                            } else {
                                                                echo $result['mobileNo'];
                                                            }
                                                            ?></td>
                                                            <td><?php echo $result['username'] ?></td>
                                                            <td>
                                                                <a href="createUser?id=<?php echo $result['id'] ?>"><i class="mdi mdi-pencil" style="font-size:20px;color:green;padding:5px;"></i></a>
                                                                <a onclick="deletefun('createUser_db', <?php echo $result['id'] ?>)"><i class="mdi mdi-delete" style="font-size:20px;color:red;padding:5px;"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade show" id="Section2">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="thead" style="font-weight:bold;">Full name </th>
                                                            <th class="thead" style="font-weight:bold;">Mobile number </th>
                                                            <th class="thead" style="font-weight:bold;">Username</th>
                                                            <th class="thead" style="font-weight:bold;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'sectionEng'");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $result['fullName'] ?></td>
                                                            <td><?php 
                                                            if($result['mobileNo'] == 0){
                                                                echo "-";
                                                            } else {
                                                                echo $result['mobileNo'];
                                                            }
                                                            ?></td>
                                                            <td><?php echo $result['username'] ?></td>
                                                            <td>
                                                                <a href="createUser?id=<?php echo $result['id'] ?>"><i class="mdi mdi-pencil" style="font-size:20px;color:green;padding:5px;"></i></a>
                                                                <a onclick="deletefun('createUser_db', <?php echo $result['id'] ?>)"><i class="mdi mdi-delete" style="font-size:25px;color:red;padding:5px;"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade show" id="Section3">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="thead" style="font-weight:bold;">Full name </th>
                                                            <th class="thead" style="font-weight:bold;">Mobile number </th>
                                                            <th class="thead" style="font-weight:bold;">Username</th>
                                                            <th class="thead" style="font-weight:bold;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'clerk'");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                        ?>
                                                        <tr> 
                                                            <td><?php echo $result['fullName'] ?></td>
                                                            <td><?php 
                                                            if($result['mobileNo'] == 0){
                                                                echo "-";
                                                            } else {
                                                                echo $result['mobileNo'];
                                                            }
                                                            ?></td>
                                                            <td><?php echo $result['username'] ?></td>
                                                            <td >
                                                                <a href="createUser?id=<?php echo $result['id'] ?>">
                                                                    <i class="mdi mdi-pencil" style="font-size:20px;color:green;padding:5px;"></i></a>
                                                                <a onclick="deletefun('createUser_db', <?php echo $result['id'] ?>)"><i class="mdi mdi-delete" style="font-size:20px;color:red;padding:5px;"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div role="tabpanel" class="tab-pane fade show" id="Section4">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="thead" style="font-weight:bold;">Full name </th>
                                                            <th class="thead" style="font-weight:bold;">Mobile number </th>
                                                            <th class="thead" style="font-weight:bold;">Username</th>
                                                            <th class="thead" style="font-weight:bold;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'admin'");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $result['fullName'] ?></td>
                                                            <td><?php 
                                                            if($result['mobileNo'] == 0){
                                                                echo "-";
                                                            } else {
                                                                echo $result['mobileNo'];
                                                            }
                                                            ?></td>
                                                            <td><?php echo $result['username'] ?></td>
                                                            <td>
                                                                <a href="createUser?id=<?php echo $result['id'] ?>"><i class="mdi mdi-pencil" style="font-size:20px;color:green;padding:5px;"></i></a>
                                                                <a onclick="deletefun('createUser_db', <?php echo $result['id'] ?>)"><i class="mdi mdi-delete" style="font-size:20px;color:red;padding:5px;"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div role="tabpanel" class="tab-pane fade show" id="Section5">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="thead" style="font-weight:bold;">Full name </th>
                                                            <th class="thead" style="font-weight:bold;">Mobile number </th>
                                                            <th class="thead" style="font-weight:bold;">Username</th>
                                                            <th class="thead" style="font-weight:bold;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $query = mysqli_query($con, "SELECT * FROM users WHERE designation = 'contractor'");
                                                        while($result = mysqli_fetch_assoc($query)){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $result['fullName'] ?></td>
                                                            <td><?php 
                                                            if($result['mobileNo'] == 0){
                                                                echo "-";
                                                            } else {
                                                                echo $result['mobileNo'];
                                                            }
                                                            ?></td>
                                                            <td><?php echo $result['username'] ?></td>
                                                            <td>
                                                                <a href="createUser?id=<?php echo $result['id'] ?>"><i class="mdi mdi-pencil" style="font-size:20px;color:green;padding:5px;"></i></a>
                                                                <a onclick="deletefun('createUser_db', <?php echo $result['id'] ?>)"><i class="mdi mdi-delete" style="font-size:20px;color:red;padding:5px;"></i></a>
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