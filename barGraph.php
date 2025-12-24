<?php
require_once('include/con.php');
?>
<!doctype html>
<html>
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
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

   <!-- bar graph -->
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  <!-- -->
    </head>
    <body>
        
        <div id="container" style="width: 500px; height: 400px;"></div>
        <script>
        anychart.onDocumentReady(function () {
      // create data set on our data
      
         var dataSet = anychart.data.set([ 
            
          <?php
          $query=mysqli_query($con,"select distinct(taluka),yojanaId from yojanaMaster");
          while($row=mysqli_fetch_assoc($query)){
              $id=$row['yojanaId'];
              $taluka=$row['taluka'];
              
         $query1=mysqli_query($con,"select completionPercentage from stepFive where yojanaId='$id' ");
        
        $row1=mysqli_fetch_assoc($query1);
        $percentage=$row1['completionPercentage'];
        
        $a=100-$percentage;
        
        /*$query111=mysqli_query($con,"select completionPercentage from stepOne where yojanaId='$id'");
        $res111=mysqli_fetch_assoc($query111);
        $count1=mysqli_num_rows($query111);
        $row111 = $res111['completionPercentage'];
        
        if($count1==0){
            $row111=0;
        }
        
        $query112=mysqli_query($con,"select completionPercentage from stepTwo where yojanaId='$id'");
        $res112=mysqli_fetch_assoc($query112);
        $count2=mysqli_num_rows($query112);
        $row112 = $res112['completionPercentage'];
        
        if($count2==0){
            $row112=0;
        }
        
        $query113=mysqli_query($con,"select completionPercentage from stepThree where yojanaId='$id'");
        $res113=mysqli_fetch_assoc($query);
        $count3=mysqli_num_rows($query113);
        $row113 = $res113['completionPercentage'];
        
        if($count3==0){
            $row113=0;
        }
        
        $query114=mysqli_query($con,"select completionPercentage from stepFour where yojanaId='$id'");
        $res114=mysqli_fetch_assoc($query);
        $count4=mysqli_num_rows($query114);
        $row114 = $res114['completionPercentage'];
        
        if($count4==0){
            $row114=0;
        }
    
        $query115=mysqli_query($con,"select completionPercentage from stepFive where yojanaId='$id'");
        $res115=mysqli_fetch_assoc($query);
        $count5=mysqli_num_rows($query115);
        $row115 = $res115['completionPercentage'];
        
        if($count5==0){
            $row115=0;
        }
        
        $add = $row111 + $row112 + $row113 + $row114 +$row115;
        $rowpercentage = $add/5;
        
       $a=100-$rowpercentage;
        */
          
    ?>
    
        ['<?php echo $taluka ?>',<?php echo $percentage ?>,<?php echo $a ?>],  
<?php } ?>
      
      ]);
     // map data for the first series, take x from the zero column and value from the first column of data set
      var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });

      // map data for the second series, take x from the zero column and value from the second column of data set
      var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });

      // create bar chart
      var chart = anychart.bar();

      // turn on chart animation
      chart.animation(true);
      
      // force chart to stack values by Y scale.
      chart.yScale().stackMode('percent');

      // set chart title text settings
      chart.title('Completion of Yojana according to Taluka');

      // set yAxis labels formatting, force it to add % to values
      chart.yAxis(0).labels().format('{%Value}%');

      // helper function to setup label settings for all series
      var setupSeriesLabels = function (series, name) {
        series.name(name).stroke('3 #fff 1');
        series.hovered().stroke('3 #fff 1');
      };

      // temp variable to store series instance
      var series;
      // create first series with mapped data
      series = chart.bar(firstSeriesData);
      setupSeriesLabels(series, 'Completed');

      // create second series with mapped data
      series = chart.bar(secondSeriesData);
      setupSeriesLabels(series, 'Pending');

      // turn on legend
      chart.legend().enabled(true).fontSize(14).padding([0, 0, 15, 0]);
      chart.interactivity().hoverMode('by-x');

      chart.tooltip().displayMode('union').valuePrefix('');

      // set container id for the chart
      chart.container('container');
      // initiate chart drawing
      chart.draw();
    });
 
     </script> 
    
    
    
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
    </body>
</html>