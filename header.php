<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once('include/sweetAlert.php');
?>
<!-- End layout styles -->
<link rel="shortcut icon" href="template/assets/images/favicon.png" />



<style>
    @import url("https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }


.ribbon {
  padding: 15px;
  height: 50px;
  background: #6a8ab8;
  -webkit-clip-path: polygon(100% 0, 95% 50%, 100% 100%, 0% 100%, 5% 50%, 0% 0%);
          clip-path: polygon(100% 0, 95% 50%, 100% 100%, 0% 100%, 5% 50%, 0% 0%);
  font-family: "font_condensed";
  text-transform: uppercase;
  color: #fff;
  letter-spacing: 0.18em;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  max-width: 450px;
}
.horizontal-menu .top-navbar .navbar-menu-wrapper
{
    height:0px;
}
   @media screen and (max-width: 600px) {
             .ribbon{
                 font-size: 100%;
             }
             .horizontal-menu .top-navbar .navbar-menu-wrapper {
    height: 58px;
}
.horizontal-menu.fixed-on-scroll + .page-body-wrapper {
    padding-top: 0px;
}
        }
        
    
    .content-text h2 {
        margin-top: 10px;
        width: 63%;
        color: #fff;
        font-size: 3em;
        position: absolute;
        transform: inherit;
    }
    
    .logout{
        position: fixed!important;
        margin-right: 13px;
    float: right;
    right: 0px;
    }
    
    .logo_1
    {
        width:33%;
    }
    
    .logo_2
    {
        width:49%;float:right;
    }
    
    .non
    {
        display:none;
    }
    
    .border_1
    {
        margin-top:10px;margin-bottom:10px;
    }
    
    @media (max-width: 991px)
    {
.page-body-wrapper {
    padding-top: 5px;
}
}

.zpname
{
    margin-top:70px;
    text-align:center;
}
    

    @media screen and (max-width: 600px) {
        
        .zpname
        {
        margin-top:34px;
        text-align:center;
        font-size:14px;
        }
    
        .mob_1
        {
            display:none;
        }
        
        .content-text h2 {
              width: 59%;
              margin-top: 3px;
            color: #fff;
            font-size: 1.5em;
            position: absolute;
            transform: inherit;
        }
        
        .border_1
    {
        margin-top:10px;margin-bottom:0px;border-bottom: 2px solid #0033c4;
    }
        
         .non
    {
        display:block;
    }
        
        .logo_1
    {
        width:100%;
        margin-bottom: 10px;
    }
    
    .logo_2
    {
        margin-top:10px;
        width:100%;
        float:right;
    }
        
 .logout{
        position: unset !important;
     }

        .mar {
            margin-top: -20px;
            margin-top: -20px;
        }

    }

    .content-text h2:nth-child(1) {
        color: transparent;
        -webkit-text-stroke: 1px #03a9f4;
    }

    .content-text h2:nth-child(2) {
        color: #03a9f4;
        animation: animate 4s ease-in-out infinite;
    }
    
    @media (max-width: 991px)
    {
.horizontal-menu {
    position:inherit;
}
}

    @keyframes animate {

        0%,
        100% {
            clip-path: polygon(0% 45%,
                    16% 44%,
                    33% 50%,
                    54% 60%,
                    70% 61%,
                    84% 59%,
                    100% 52%,
                    100% 100%,
                    0% 100%);
        }

        50% {
            clip-path: polygon(0% 60%,
                    15% 65%,
                    34% 66%,
                    51% 62%,
                    67% 50%,
                    84% 45%,
                    100% 46%,
                    100% 100%,
                    0% 100%);
        }
    }
    .horizontal-menu .bottom-navbar .page-navigation>.nav-item>.nav-link{
        padding: 22px 7px 22px 2px;
    }
    .horizontal-menu .bottom-navbar .page-navigation > .nav-item > .nav-link .admin {
        font-size: 0.755rem;
        font-weight: 400;
    }
    .logout{
        font-size: 0.775rem;
    }
    
     .n-it
    {
        margin-left:-80px;
    }
    
   @media only screen and (max-width: 600px) {
  #nav-text {
    display:none;
  }
     .n-it
    {
        margin-left:0px;
    }
} 
    
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #86b7fe;
    box-shadow: inset 0px 0px 3px #86b7fe !important;
}

.select2-search--dropdown .select2-search__field {
    line-height: 2;
    font-size: 16px;
}

.select2-search--dropdown .select2-search__field {
    padding: 4px 15px !important;
}
</style>

<div class="container-fluid border_1">
    <div class="row">
        <div class="col-2">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/55/Emblem_of_India.svg" class="logo_1">
        </div>
          <div class="col-8">
             <div class="content-text">
                    <center>
                        <h2 class="mar">जल जीवन मिशन </h2>
                        <h2 class="mar">जल जीवन मिशन </h2>
                    </center>
                </div>
             
                <h4 class="zpname">जिल्हा परिषद, जालना</h4>
                
        </div>
          <div class="col-2">
            <img src="https://mahasarkar.co.in/wp-content/uploads/2019/07/ZP-jalna-2-1200x1200.png" class="logo_2">
        </div>
    </div>
</div>


<div class="horizontal-menu">

    <nav class="navbar top-navbar  p-0">

        <div class="container">


            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end ">

               <a class="text-black non" onclick="loginfun('logout')" style="text-decoration:none;font-size:13px;"><span >Hello,&nbsp;&nbsp;
              
               <?php echo $_SESSION['fullName']?> ( <?php echo $_SESSION['designation']?> )</span>&nbsp;&nbsp;<i class="mdi mdi-power"></i></a>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center " type="button"
                    data-toggle="horizontal-menu-toggle">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </div>
    </nav>
    
    <?php 
    if(isset($_SESSION['userId'])){
    ?>
    <nav class="bottom-navbar">
        <div class="container-fluid">
            <ul class="nav page-navigation" style="justify-content: space-between;">
                <?php
                $designation = $_SESSION['designation'];
                if($designation == "clerk"){
                ?>
                <style>
                     .n-it
    {
        margin-left: -180px;
    }
    
    @media only screen and (max-width: 600px) {
     .n-it
    {
        margin-left:0px;
    }
} 
                </style>
                
                <li class="nav-item">
                    <a class="nav-link" href="createYojana">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Create Scheme</span>
                    </a>
                </li>
                <li class="nav-item n-it">
                    <a class="nav-link" href="yojanaList">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Scheme List</span>
                    </a>
                </li>
                <li class="nav-item n-it">
                    <a class="nav-link" href="agreement">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Add Agreement</span>
                    </a>
                </li>
                <li class="nav-item n-it">
                    <a class="nav-link" href="agreementReport">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Show Agreements</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a class="nav-link" href="acceptExtension">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title">Extension Approve/Reject</span>
                    </a>
                </li>
                
                
                <li class="nav-item" id="nav-text" style="/*right: -94px;*/">
                    <a class="nav-link" onclick="loginfun('logout')">
                        <span >Hello,&nbsp;&nbsp;<?php echo $_SESSION['fullName']?> ( <?php echo $_SESSION['designation']?> )</span>&nbsp;&nbsp;<i class="mdi mdi-power"></i>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center " type="button"
                    data-toggle="horizontal-menu-toggle">
                    <span class="mdi mdi-menu"></span>
                </button>
                    </a>
                </li>
                
                <?php 
                } else if($designation == "sectionEng") {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="home">
                        <i class="mdi mdi-compass-outline menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <!--
             <li class="nav-item">
               <a href="#" class="nav-link">
                 <i class="mdi mdi-monitor-dashboard menu-icon"></i>
                 <span class="menu-title">UI Elements</span>
                 <i class="menu-arrow"></i>
               </a>
               <div class="submenu">
                 <ul class="submenu-item">
                   <li class="nav-item">
                     <a class="nav-link" href="../../pages/ui-features/buttons.html">Buttons</a>
                   </li>
                   <li class="nav-item">
                     <a class="nav-link" href="../../pages/ui-features/dropdowns.html">Dropdown</a>
                   </li>
                   <li class="nav-item">
                     <a class="nav-link" href="../../pages/ui-features/typography.html">Typography</a>
                   </li>
                 </ul>
               </div>
             </li>
             -->
                <li class="nav-item n-it">
                    <a class="nav-link" href="qualityCertificate">
                        <i class="mdi mdi-table-large menu-icon"></i>
                        <span class="menu-title">Quality Certificate</span>
                    </a>
                </li>
                <li class="nav-item n-it">
                    <a class="nav-link" href="qualityCertificateReport">
                        <i class="mdi mdi-chart-bar menu-icon"></i>
                        <span class="menu-title">Quality Certificate Report</span>
                    </a>
                </li>
                <li class="nav-item n-it">
                    <a class="nav-link" href="finance">
                        <i class="mdi mdi-table-large menu-icon"></i>
                        <span class="menu-title">Expenditures</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a class="nav-link" href="uploadBillDetails">
                        <i class="mdi mdi-table-large menu-icon"></i>
                        <span class="menu-title">Uploade Bill Details</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a class="nav-link" href="financeReport">
                        <i class="mdi mdi-chart-bar menu-icon"></i>
                        <span class="menu-title">Expenditures Report</span>
                    </a>
                </li>
                
                <li class="nav-item" id="nav-text">
                    <a class="nav-link" onclick="loginfun('logout')" style="right: 0;">
                        <span >Hello,&nbsp;&nbsp;<?php echo $_SESSION['fullName']?> ( <?php echo $_SESSION['designation']?> )</span>&nbsp;&nbsp;<i class="mdi mdi-power"></i>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center " type="button"
                    data-toggle="horizontal-menu-toggle">
                    <span class="mdi mdi-menu"></span>
                </button>
                    </a>
                </li>
                
                <?php 
                } else if($designation == "admin" || $designation == "executiveEng"){
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="index">
                        <i class="mdi mdi-compass-outline menu-icon"></i>
                        <span class="menu-title admin">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item n-it">
                    <a class="nav-link" href="createUser">
                        <i class="mdi mdi-contacts menu-icon"></i>
                        <span class="menu-title admin">Create User</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a class="nav-link" href="yojanaReport">
                        <i class="mdi mdi-table-large menu-icon"></i>
                        <span class="menu-title admin">Scheme Report</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a href="#" class="nav-link">
                        <i class="mdi mdi-monitor-dashboard menu-icon"></i>
                        <span class="menu-title admin">Reports</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="submenu">
                        <ul class="submenu-item">
                            <li class="nav-item">
                                <a class="nav-link" href="agreementReport_sk">Taluka Wise Scheme Report</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="schemeprogress">Scheme Progress</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="delayreport">Delay Scheme Report</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="tpiReport">TPI Report</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="excessExpenditure">Excess Expenditure</a>
                            </li>
                            
                            <div class="dropdown-divider"></div>
                            <li class="nav-item">
                                <a class="nav-link" href="schemeSpecific">Scheme Specific Graph</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="barChartForTaluka">Physical Vs Expenditure</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="lineChartForMultipleSchemeSubwork">Physical Work Progress</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="lineChartForExpenditure">Expenditure Progress</a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!--<li class="nav-item">
                    <a class="nav-link" href="schemeSpecific">
                        <i class="mdi mdi-chart-bar menu-icon"></i>
                        <span class="menu-title admin">Scheme Specific Graph</span>
                    </a>
                </li>-->
                <!--<li class="nav-item">
                    <a class="nav-link" href="yojanaSubWorkReport">
                        <i class="mdi mdi-table-large menu-icon"></i>
                        <span class="menu-title">Scheme Detail Report</span>
                    </a>
                </li>-->
                <li class="nav-item n-it">
                    <a class="nav-link" href="financeReportAdmin">
                        <i class="mdi mdi-chart-bar menu-icon"></i>
                        <span class="menu-title admin">Expenditures Report</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a class="nav-link" href="yojanaTracker">
                        <i class="mdi mdi-chart-bar menu-icon"></i>
                        <span class="menu-title admin">Scheme Tracking</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a class="nav-link" href="agreementReport">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title admin">Show Agreements</span>
                    </a>
                </li>
                
                <li class="nav-item n-it">
                    <a class="nav-link" href="acceptExtension">
                        <i class="mdi mdi-clipboard-text menu-icon"></i>
                        <span class="menu-title admin">Extension Approve/Reject</span>
                    </a>
                </li>
                
                 
                <li class="nav-item" id="nav-text" >
                    <a class="nav-link" onclick="loginfun('logout')" 
                    <?php
                   if($designation == "admin"){
                  ?>
                    style="padding: 18px 0 15px 0px; font-size: 0.675rem;
    right: 0;"
                    <?php }else{ ?>
                    style="padding: 18px";
                    <?php } ?>
                    >
                        <span >Hello,&nbsp;&nbsp;<?php echo $_SESSION['fullName']?> ( <?php echo $_SESSION['designation']?> )</span>&nbsp;&nbsp;<i class="mdi mdi-power"></i>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center " type="button"
                    data-toggle="horizontal-menu-toggle">
                    <span class="mdi mdi-menu"></span>
                </button>
                    </a>
                </li>
                
                <?php
                } else if($designation == "contractor"){
                ?>
                <!--<li class="nav-item">
                    <a class="nav-link" href="agreementReport">
                        <i class="mdi mdi-compass-outline menu-icon"></i>
                        <span class="menu-title">Home</span>
                    </a>
                </li>-->
                <li class="nav-item" id="nav-text">
                    <a class="nav-link" onclick="loginfun('logout')" style="padding: 18px 0 15px 23rem;">
                        <span >Hello,&nbsp;&nbsp;<?php echo $_SESSION['fullName']?> ( <?php echo $_SESSION['designation']?> )</span>&nbsp;&nbsp;<i class="mdi mdi-power"></i>
                        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center " type="button" data-toggle="horizontal-menu-toggle"> <span class="mdi mdi-menu"></span>
                        </button>
                    </a>
                </li>
                <script>
                    document.querySelector('.page-navigation').setAttribute('style', 'justify-content: flex-end;');
                    // $(".page-navigation").attr('style', 'justify-content: flex-end;")
                </script>
                <?php
                }
                ?>
                <!--
             <li class="nav-item">
               <a href="https://www.bootstrapdash.com/demo/plus-free/documentation/documentation.html" class="nav-link" target="_blank">
                 <i class="mdi mdi-file-document-box menu-icon"></i>
                 <span class="menu-title">Docs</span></a>
             </li>
             -->
               
            <!--  <li class="nav-item logout"> 
                    <div class="nav-link d-flex">
                       
                       <?php 
                       $designation = $_SESSION['designation'];
                       if($designation == "executiveEng"){
                           $designation = "subDivisionalEng";
                       }
                       ?>
                       <!-- <a class="text-white mob_1" onclick="loginfun('logout')" style="text-decoration:none;"><span>Hello,&nbsp;&nbsp;<?php echo $_SESSION['fullName']?>&nbsp;( <?php echo $designation ?> )</span>&nbsp;&nbsp;<i class="mdi mdi-power"></i></a>
                    
                        
                    </div>
                </li>       -->
                       
                        
            
            </ul>
                        
               
                <!--<a class="text-white mob_1" onclick="loginfun('logout')" style="text-decoration:none;float:right;margin-top:-41px;"><span>Hello,&nbsp;&nbsp;<?php echo $_SESSION['fullName']?>&nbsp;( <?php echo $_SESSION['designation']?> )</span>&nbsp;&nbsp;<i class="mdi mdi-power"></i></a>-->

        </div>
    </nav>
    <?php
    }
    ?>
</div>
<!-- partial -->