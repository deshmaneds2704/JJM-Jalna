<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

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
    .w-100
    {
        height:300px;
    }
    
        .range-slider {
            margin: 2px 0 0 0;
        }

        .range-slider input[type="range"] {
            width: calc(100% - (68px));
            height: 10px;
            border-radius: 5px;
            background: #d7dcdf;
            outline: none;
            float: left;
            -webkit-appearance: none;
        }

        .range-slider input[type="range"]::-webkit-slider-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #2c3e50;
            cursor: pointer;
            transition: background .15s ease-in-out;
            -webkit-appearance: none;
            appearance: none;
        }

        .range-slider input[type="range"]::-webkit-slider-thumb:hover,
        .range-slider input[type="range"]:active::-webkit-slider-thumb {
            background: #4cb2ef;
        }

        .range-slider input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border: 0;
            border-radius: 50%;
            background: #2c3e50;
            cursor: pointer;
            transition: background .15s ease-in-out;
        }

        .range-slider input[type="range"]::-moz-range-thumb:hover,
        .range-slider input[type="range"]:active::-moz-range-thumb {
            background: #4cb2ef;
        }

        .range-slider .range-value {
            display: inline-block;
            width: 60px;
            background: #2c3e50;
            border-radius: 3px;
            padding: 5px 10px;
            margin-left: 8px;
            line-height: 20px;
            color: #fff;
            text-align: center;
            position: relative;
            top: -10px;
        }

        .range-slider .range-value:after {
            content: "";
            border-right: 7px solid #2c3e50;
            border-top: 7px solid transparent;
            border-bottom: 7px solid transparent;
            position: absolute;
            top: 8px;
            left: -7px;
        }

        ::-moz-range-track {
            background: #d7dcdf;
            border: 0;
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
        }

        .steps>.step:after {
            content: "";
            position: absolute;
            display: block;
            background: #e6e6e6;
            width: 100%;
            height: 0.125rem;
            top: 1rem;
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

        .steps>.step.is-complete:after {
            background: #3CB371;
        }

        .steps>.step.is-active {
            font-weight: bold;

        }

        .steps>.step.is-active:before {
            color: #FFF;
            border: 2px solid #0033c4;
            background: #0033c4;
            margin-bottom: -4.9rem;
        }

        .steps {
            margin-top: 3em;
        }



        .can-toggle {
            position: relative;
        }

        .can-toggle *,
        .can-toggle *:before,
        .can-toggle *:after {
            box-sizing: border-box;
        }

        .can-toggle input[type=checkbox] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
        }

        .can-toggle input[type=checkbox][disabled]~label {
            pointer-events: none;
        }

        .can-toggle input[type=checkbox][disabled]~label .can-toggle__switch {
            opacity: 0.4;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:before {
            content: attr(data-unchecked);
            left: 0;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            content: attr(data-checked);
        }

        .can-toggle label {
            user-select: none;
            position: relative;
            display: flex;
            align-items: center;
        }

        .can-toggle label .can-toggle__label-text {
            flex: 1;
            padding-left: 32px;
        }

        .can-toggle label .can-toggle__switch {
            position: relative;
        }

        .can-toggle label .can-toggle__switch:before {
            content: attr(data-checked);
            position: absolute;
            top: 0;
            text-transform: uppercase;
            text-align: center;
        }

        .can-toggle label .can-toggle__switch:after {
            content: attr(data-unchecked);
            position: absolute;
            z-index: 5;
            text-transform: uppercase;
            text-align: center;
            background: white;
            transform: translate3d(0, 0, 0);
        }

        .can-toggle input[type=checkbox][disabled]~label {
            color: rgba(234, 0, 48, 0.5);
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch {
            background-color: #ea0030;
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
            color: #b70026;
        }

        .can-toggle input[type=checkbox]:hover~label {
            color: #d1002b;
        }

        .can-toggle input[type=checkbox]:checked~label:hover {
            color: #55bc49;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch {
            background-color: #70c767;
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            color: #4fb743;
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch {
            background-color: #5fc054;
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            color: #47a43d;
        }

        .can-toggle label .can-toggle__label-text {
            flex: 1;
        }

        .can-toggle label .can-toggle__switch {
            transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
            background: #ff0538;
        }

        .can-toggle label .can-toggle__switch:before {
            color: rgba(255, 255, 255, 0.5);
        }

        .can-toggle label .can-toggle__switch:after {
            -webkit-transition: -webkit-transform 0.3s cubic-bezier(0, 1, 0.5, 1);
            transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
            color: #ea0030;
        }

        .can-toggle input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:hover~label .can-toggle__switch:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle input[type=checkbox]:checked~label .can-toggle__switch:after {
            transform: translate3d(65px, 0, 0);
        }

        .can-toggle input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle label {
            font-size: 14px;
        }

        .can-toggle label .can-toggle__switch {
            height: 36px;
            flex: 0 0 134px;
            border-radius: 4px;
        }

        .can-toggle label .can-toggle__switch:before {
            left: 67px;
            font-size: 12px;
            line-height: 36px;
            width: 67px;
            padding: 0 12px;
        }

        .can-toggle label .can-toggle__switch:after {
            top: 2px;
            left: 2px;
            border-radius: 2px;
            width: 65px;
            line-height: 32px;
            font-size: 12px;
        }

        .can-toggle label .can-toggle__switch:hover:after {
            box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:focus~label .can-toggle__switch:after,
        .can-toggle.can-toggle--size-small input[type=checkbox]:hover~label .can-toggle__switch:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:checked~label .can-toggle__switch:after {
            transform: translate3d(44px, 0, 0);
        }

        .can-toggle.can-toggle--size-small input[type=checkbox]:checked:focus~label .can-toggle__switch:after,
        .can-toggle.can-toggle--size-small input[type=checkbox]:checked:hover~label .can-toggle__switch:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }

        .can-toggle.can-toggle--size-small label {
            font-size: 13px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch {
            height: 28px;
            flex: 0 0 90px;
            border-radius: 2px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:before {
            left: 45px;
            font-size: 10px;
            line-height: 28px;
            width: 45px;
            padding: 0 12px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:after {
            top: 1px;
            left: 1px;
            border-radius: 1px;
            width: 44px;
            line-height: 26px;
            font-size: 10px;
        }

        .can-toggle.can-toggle--size-small label .can-toggle__switch:hover:after {
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }
        
        .pointer{
            cursor: pointer;
        }
        .center{
            text-align: center;
        }

    </style>



</head>

<body>
    <div class="container-scroller">
        <?php
       
      
        include("include/con.php");
        include('header.php');
        ?>
    
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="row">
                                <?php
                                $yojanaId = $_GET['yojanaId'];
                                $query = mysqli_query($con,"SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'") ;
                                $result = mysqli_fetch_assoc($query);
                                
                                ?>
                                <center style="padding-bottom:30px;" ><a href="yojanaReport" style="float: left;"><button type="button" class="btn btn-primary me-2">Back</button></a><h5 ><?php echo $result['yojanaName']." (".$result['yojanaId'].")" ?></h5></center>
                            </div>
                            <div class="row">
                                <?php 
                                $yojanaId = $_GET['yojanaId'];
                                
                                $stepArray = array("One", "Two", "Three", "Four", "Five");
                                
                                foreach($stepArray as $step){
                                
                                    $q = mysqli_query($con, "SELECT * FROM step$step WHERE yojanaId = '$yojanaId'");
                                    if(mysqli_num_rows($q) > 0){
                                        $r = mysqli_fetch_assoc($q);
                                        if($r['video_link'] != ""){
                                            $explode = explode('/', $r['video_link']);
                                            $link = $explode['3'];
                                            if(strpos($link, 'watch') !== false){
                                                $link;
                                                $explode = explode('?v=',$link);
                                                $link = $explode['1'];
                                            } else if(strpos($link, 'shorts') !== false || strpos($link, 'embed') !== false ){
                                                $link;
                                                $link = $explode['4'];
                                            }
                                ?>
                                <div class="col-sm-4 stretch-card grid-margin">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <iframe width="100%" src="https://www.youtube.com/embed/<?php echo $link ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                        </div>
                                        <div class="card-body px-3 text-dark">
                                            
                                            <h5 class="font-weight-semibold" style="text-align:center;color:#0033c4;"><span>( Step - <?php echo $step ?> )</span></h5>
                                            <!--<div class=" font-weight-semibold">
                                                <p class="mb-0" style="text-align:center">  <?php
                                                
                                                $scheduleId = $result1['scheduleId']; 
                                                $query2 = mysqli_query($con,"SELECT * FROM scheduleMaster WHERE id = '$scheduleId'") ;
                                                $result2 = mysqli_fetch_assoc($query2);
                                                
                                                echo $result2['schedule'];
                                                
                                                ?></p>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                            
                            <div class="row">
                                <?php
                                $yojanaId = $_GET['yojanaId'];
                                $query = mysqli_query($con,"SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'") ;
                                $result = mysqli_fetch_assoc($query);
                                
                                ?>
                                <center style="padding-bottom:30px;" ><h5 ><?php echo $result['yojanaName'] ?></h5></center>
                                <?php
                                $stepsArray = array(
                                    "stepOne" => "Source",
                                    "stepTwo" => "Pump / Rising Main",
                                    "stepThree" => "ESR",
                                    "stepFour" => "Distribution",
                                    "stepFive" => "Trial Run"
                                    );
                                $extension = array("jpeg","jpg","png");
                                $j=1;
                                foreach ($stepsArray as $stepNo => $stepName){
                                    $query = mysqli_query($con, "SELECT * FROM `".$stepNo."` WHERE yojanaId = '$yojanaId'");
                                    
                                    while($result = mysqli_fetch_assoc($query)){
                                        for($i=1;$i<=4;$i++){
                                            $photo = $result['photo'.$i];
                                            $docName = $result['docName'.$i];
                                            $explode = explode('.', $photo);
                                            if(in_array($explode[1], $extension) == true){
                                            ?>
                                            <div class="col-sm-4 stretch-card grid-margin">
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <img class="img-fluid w-100"  src="uploadedDoc/<?php echo $photo ?>" alt="" />
                                                    </div>
                                                    <div class="card-body px-3 text-dark">
                                                        <h5 class="font-weight-semibold"> <?php echo $docName ?> </h5>
                                                        <div class="d-flex justify-content-between font-weight-semibold">
                                                            <p class="mb-0"><?php echo "Step ".$j++." (".$stepName.")" ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            
                            <div class="row">
                                
                                <?php 
                                
                                $query1 = mysqli_query($con,"SELECT * FROM schedule WHERE yojanaId = '$yojanaId'") ;
                              
                                  while($result1 = mysqli_fetch_assoc($query1)){
                                      
                                      if($result1['document']!='')
                                      {
                                
                                ?>
                                
                                
                                
                                <div class="col-sm-4 stretch-card grid-margin">
                                                <div class="card">
                                                    <div class="card-body p-0">
                                                        <img class="img-fluid w-100"  src="uploadedDoc/<?php echo $result1['document']; ?>" alt="" />
                                                    </div>
                                                    <div class="card-body px-3 text-dark">
                                                        
                                                        <h5 class="font-weight-semibold" style="text-align:center;color:#0033c4;"><?php echo $result1['subWork']; ?><span>( Step - <?php echo $result1['step']; ?> )</span></h5>
                                                        
                                                       
                                                          
                                                            
                                                         
                                                        <div class=" font-weight-semibold">
                                                            <p class="mb-0" style="text-align:center">  <?php
                                                            
                                                             $scheduleId = $result1['scheduleId']; 
                                                            $query2 = mysqli_query($con,"SELECT * FROM scheduleMaster WHERE id = '$scheduleId'") ;
                                                            $result2 = mysqli_fetch_assoc($query2);
                                                            
                                                            echo $result2['schedule'];
                                                            
                                                            ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                      <?php } } ?>      
                                            
                                
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
    <script>
        function redirect(location, yojanaId){
            if(location != ""){
                window.location = location+"?yojanaId="+yojanaId;   
            }
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
    </script>
</body>

</html>