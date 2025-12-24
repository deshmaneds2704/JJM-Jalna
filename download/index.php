<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>जल जीवन मिशन  -  Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://zpsunoneha.in/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../template/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../template/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../template/assets/vendors/select2/select2.min.css" />
    <link rel="stylesheet" href="../template/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../template/assets/css/demo_2/style.css" />
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../template/assets/images/favicon.png" />
    <style>
        @media screen and (max-width: 600px) {
            #loginimg {
                display: none;
            }
            
        .mdi-menu
        {
            display:none;
        }
            .non
        {
            display:none !important;
        }
        }
        .content-wrapper {
            min-height: calc(90vh - 161px) !important;
        }
        
        
    </style>
    
    <style>
        .login {
            width: 100%;
        }
    
        .content-wrapper {
            background: #ffffff;
            padding: 2.375rem;
            width: 100%;
            -webkit-flex-grow: 1;
            flex-grow: 1;
        }
    
        .auth .brand-logo {
            margin-bottom: 2rem;
            margin-top: 2rem;
        }
    
        #img {
            width: 7%;
            padding: 5px 0px;
        }
    
        .img-fluid {
            max-width: 15%;
        }
    
        @media only screen and (max-width: 600px) {
            .login {
                width: 75%;
            }
    
            #img {
                margin-bottom: 16px;
                width: 25%;
            }
    
            .img-fluid {
                margin-bottom: 16px;
                max-width: 40%
            }
        }
    
        .hero-image {
            background-image: url("../../images/header-bg1.png");
            background-color: #cccccc;
            height: 166px;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
    
        .site_logo {
            width: 36%;
            padding-top: 19px;
            padding-bottom: 15px;
        }
    
        .site_logo3 {
            width: 29%;
            padding-top: 5px;
        }
    
        .site_logo1 {
            float: right;
            width: 57%;
            padding-top: 18px;
            padding-bottom: 15px;
        }
    
        .heading {
            color: white;
            font-weight: bold;
            padding-top: 5px;
            padding-top: 5px;
        }
    
        .heading2 {
            style="font-size: 2.525rem;"
        }
    
        .card-body {
            margin-top: 58px;
        }
    
        .paddi2 {
            margin-top: 3rem;
        }
    
    
        .page-body-wrapper {
            min-height: calc(86vh - 60px);
        }
    
        .page-body-wrapper.full-page-wrapper {
            min-height: 74vh;
        }
    
        @media screen and (max-width: 600px) {
            .btn-block {
                width: 56%;
            }
    
            .paddi2 {
                margin-top: 1rem;
            }
    
            .site_logo {
                display: none;
            }
    
            .site_logo1 {
                display: none;
            }
    
            .site_logo3 {
                width: 85%;
                margin-top: 10px;
            }
    
            .hero-image {
                height: 134px;
            }
    
            .card-body {
                margin-top: 0px;
            }
        }
    </style>
    <style>
        .responsive {
            width: 200px;
    
        }
    
        @media (max-width: 767px) {
    
            .responsive {
                width: 50%;
                height: auto;
            }
        }
    
        a {
            text-decoration: none;
        }
    
        .btn {
    
            background: #0094d6;
            border-radius: 100px;
            /*  padding: 10px 70px; */
            color: #fff;
            text-decoration: none;
            font-size: 1em;
            margin: 0 15px;
            box-shadow: 1px 1px 2px black, 0 0 12px #0094d6, 0 0 5px #0094d6
        }
    
        .btn2 {
            background: #61bc43;
            box-shadow: 1px 1px 2px black, 0 0 12px #61bc43, 0 0 5px #61bc43;
            /*  padding: 10px 60px; */
        }
    
    
        .navbar-light {
            background: rgb(255, 153, 51);
            background: linear-gradient(90deg, rgba(255, 153, 51, 0.6) 0%, rgba(255, 255, 255, 0.48783263305322133) 54%, rgba(19, 136, 8, 0.5) 100%);
        }
    
        .text {
            font-size: 13px;
            color: white;
            text-align: center;
        }
    
        .h3 {
            color: #4b49ac;
            font-weight: 600;
            text-align: center;
        }
    
        .h4 {
            padding: 10px;
            text-align: center;
        }
    
        .padd {
            padding: 30px;
        }
    
        @media screen and (max-width: 600px) {
            .h3 {
                color: #4b49ac;
                font-weight: 600;
                text-align: center;
                font-size: 16px;
    
            }
    
            .h4 {
                padding: 10px;
                text-align: center;
                font-size: 14px;
            }
    
            .padd {
                padding: 0px 10px 0px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <?php
        include('../header.php');
        ?>
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                
            
        
                <div class="row">
                    <div class="col-md-5 padd">
                        <center>
                            <br>
                            <h3>ऍप डाउनलोड करा </h3>
                            <br>
                            <a download href="Jal Jeevan Mission Jalna.apk">
                                <button type="button" class="btn  btn2 ">Download for Android
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" fill="currentColor" class="bi bi-android" viewBox="0 0 16 16">
  <path d="M2.76 3.061a.5.5 0 0 1 .679.2l1.283 2.352A8.94 8.94 0 0 1 8 5a8.94 8.94 0 0 1 3.278.613l1.283-2.352a.5.5 0 1 1 .878.478l-1.252 2.295C14.475 7.266 16 9.477 16 12H0c0-2.523 1.525-4.734 3.813-5.966L2.56 3.74a.5.5 0 0 1 .2-.678ZM5 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"/>
</svg>
                                </button>
                            </a>
                        </center>
                        <br>
                        <h3 class="h3">Official app of Zilla Parishad Jalna for track Schemes under Jal Jeevan Mission.</h3>
                
                        <!--<h4 class="h4">SunoNeha is an official app of Zilla Parishad Nanded to monitor the progress of mission to track kids with hearing disabilities, opthalmic disabilities, neurological deficiencies at anganwadi and school level. This app provides real-time tracking of daily surveys which will help higher authorities for timely decision making.</h4>-->
                    </div><!--col-md-5 end -->
                 
                    <div class="col-md-7" style="text-align:center;">
                        <img src="img/mob jjm.png" style="width:100%">
                    </div> <!--col-md-7 end -->
                </div><!--row end -->
                </div>
            </div>
        </div>
    </div>
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
</body>
</html>