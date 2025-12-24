<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
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

</head>

<body>
    
    
    <div id="physicalCompletionChart" style="height:20rem"></div>
   
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
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    
    <script>
    anychart.onDocumentReady(function () {
        // create data set on our data
        var chartData = {
            title: '% Physical Completion',
            header: [
                <?php
                $countPumping = 1;
                $countRising = 1;
                $countEsr = 1;
                $i = 0;
                $yojanaId = $_GET['yojanaId'];
                $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
                while($result = mysqli_fetch_assoc($query)){
                    if($result['subWork'] == "Percolation Well"){
                        $subWork = "Percolation Well  (Depth - ".$result['depth']." m & Dia - ".$result['diameter']." m)";
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[0] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[0] = 0;
                        }
                        
                    } else if($result['subWork'] == "Approach Bund"){
                        $subWork = $result['subWork']." (Length - ".$result['length']." m)";
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Approach Bund' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[1] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[1] = 0;
                        }
                        
                    } else if($result['subWork'] == "Pumping Machinery"){
                        $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[2] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[2] = 0;
                        }
                        
                    } else if($result['subWork'] == "Rising Main"){
                        $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm² = ".$result['length']." m)";
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[3] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[3] = 0;
                        }
                        
                    } else if($result['subWork'] == "RCC ESR"){
                        $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Elevated Service Reservoir' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[4] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[4] = 0;
                        }
                        
                    } else if($result['subWork'] == "Distribution System"){
                        $subWork = $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[5] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[5] = 0;
                        }
                        
                    } else if($result['subWork'] == "MSEDC Work"){
                        $subWork = $result['subWork'];
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'MSEDC Work' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[6] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[6] = 0;
                        }
                        
                    } else if($result['subWork'] == "Trial & Run"){
                        $subWork = $result['subWork']. " (Months - ".$result['month'].")";
                        $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Trial & Run' AND yojanaId = '$yojanaId'");
                        $r = mysqli_fetch_assoc($q);
                        $workDone[7] = $r['workDone'];
                        if(empty($workDone)){
                            $workDone[7] = 0;
                        }
                        
                    } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                        continue;
                    }
                    if($i == 0){
                        echo "'".$subWork."'";
                    } else {
                        echo ", '".$subWork."'";
                    }
                    $i++;
                }
                ?>
                ],
            rows: [
                [ '',
                <?php
                $i=0;
                foreach ($workDone as $competed){
                    if($i==0){
                        echo $competed;
                    } else {
                        echo ", ".$competed;
                    }
                    $i++;
                }
                ?>    
                ]
            ]
        };

        // create column chart
        var chart = anychart.column();

        // set chart data
        chart.data(chartData);

        // turn on chart animation
        chart.animation(true);

        chart.yAxis().labels().format('{%Value}{groupsSeparator: } %');

        // set titles for Y-axis
        chart.yAxis().title('Percentage');

        chart
            .labels()
            .enabled(true)
            .position('center-top')
            .anchor('center-bottom')
            .format('{%Value}{groupsSeparator: } %');
        chart.hovered().labels(false);

        // turn on legend and tune it
        chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);

        // interactivity settings and tooltip position
        chart.interactivity().hoverMode('single');

        chart
            .tooltip()
            .positionMode('point')
            .position('center-top')
            .anchor('center-bottom')
            .offsetX(0)
            .offsetY(5)
            .titleFormat('{%X}')
            .format('{%SeriesName} : {%Value}{groupsSeparator: } %');

        // set container id for the chart
        chart.container('physicalCompletionChart');

        // initiate chart drawing
        chart.draw();
    });
</script>
    <!--<script>
        var data = [
            <?php 
            $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
            while($result = mysqli_fetch_assoc($query)){
                if($result['subWork'] == "Percolation Well"){
                    $subWork = "Percolation Well  (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Percolation Well' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "Approach Bund"){
                    $subWork = $result['subWork']." (Length -".$result['length']." m)";
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Approach Bund' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "Pumping Machinery"){
                    $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Pumping Machinery' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "Rising Main"){
                    $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm<sup>2</sup> = ".$result['length']." m)";
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Rising Main' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "RCC ESR"){
                    $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Elevated Service Reservoir' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "Distribution System"){
                    $subWork = $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Distribution System' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "MSEDC Work"){
                    $subWork = $result['subWork'];
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'MSEDC Work' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "Trial & Run"){
                    $subWork = $result['subWork']. " (Months - ".$result['month'].")";
                    $q = mysqli_query($con, "SELECT SUM(percentage) as 'workDone' FROM `schedule` WHERE subWork = 'Trial & Run' AND yojanaId = '$yojanaId'");
                    $r = mysqli_fetch_assoc($q);
                    $workDone = $r['workDone'];
                    if(empty($workDone)){
                        $workDone = 0;
                    }
                    
                } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                    continue;
                }
            ?>
            {
                x: "Step one", value: 33,
                normal: {
                    fill: "#FFA500",
                    stroke: null,
                    label: { 
                        enabled: true
                    }
                }
            },
            <?php 
                
            } 
            ?>
        ];
    
        // create a chart
        chart = anychart.column();
    
        // create a bar series and set the data
        var series = chart.column(data);
        series.name("Completion percentage");
    
        // set the container id
        chart.container("container");
    
        // initiate drawing the chart
        chart.draw();
    
        // set the chart title
        chart.title("Column Chart: ");
    
        // set the titles of the axes
        chart.xAxis().title("Step no.");
        chart.yAxis().title("Completion percentage");
    </script>-->

    <!-- End custom js for this page -->
</body>

</html>