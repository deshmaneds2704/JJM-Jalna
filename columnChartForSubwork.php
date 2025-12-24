<?php
require_once('include/con.php');
?>
<!doctype html>
<html>
<head>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  <style type="text/css">

    html,
    body,
    #container {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }
    .anychart-credits{
        display:none;
    }
  
</style>
</head>
<body>
  
  <div id="container"></div>
  

  <script>

    anychart.onDocumentReady(function () {
      // create data set on our data
      var chartData = {
          
          
          
        title: 'Subwork wise completion percentage',
        header: ['#', 'Trial Bore', 'Percolation Well', 'Approach Bund', 'Switch Room','Elevated Service Reservoir','Pumping Machinery','Rising Main','Distribution System','MSEDC Work'],
        rows: [
            
            <?php
          $query = mysqli_query($con,"select * from yojanaMaster order by id desc limit 5");
          while($data = mysqli_fetch_assoc($query)){
          $id=$data['yojanaId'];
          $village=$data['village'];
          
          //TRIAL BORE
          
          $query1 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Trial Bore'");
          $res1 = mysqli_fetch_assoc($query1);
          $per1 = $res1['percentage'];
          $count = mysqli_num_rows($query1);
          if($count==0){
              $per1=0;
          }
          
          //PERCOLATION WELL
          
          $per2=0;
          for($i=2;$i<8;$i++){
          $query2 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Percolation Well' and scheduleId=$i");
          $res2 = mysqli_fetch_assoc($query2);
          $per2 += $res2['percentage'];
          }
          
         //APPROACH BUND
          
          $per3=0;
          for($j=8;$j<10;$j++){
        $query3 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Approach Bund' and scheduleId=$j");
          $res3 = mysqli_fetch_assoc($query3);
          $per3 += $res3['percentage'];
          }
         
         //SWITCH ROOM
         
         $per4=0;
         for($k=10;$k<17;$k++){
        $query4 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Switch Room' and scheduleId=$k");
          $res4 = mysqli_fetch_assoc($query4);
          $per4 += $res4['percentage'];
          }
         
         //ELEVATED SERVICE RESERVOIR
         
         $per5=0;
         for($l=17;$l<30;$l++){
        $query5 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Elevated Service Reservoir' and scheduleId=$l");
          $res5 = mysqli_fetch_assoc($query5);
          $per5 += $res5['percentage'];
          }
         
         //PUMPING MACHINERY
         
         $per6=0;
         for($m=30;$m<33;$m++){
        $query6 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Pumping Machinery' and scheduleId=$m");
          $res6 = mysqli_fetch_assoc($query6);
          $per6 += $res6['percentage'];
          }
         
         //RISING MAIN
         
         $per7=0;
         for($n=33;$n<37;$n++){
        $query7 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Rising Main' and scheduleId=$n");
          $res7 = mysqli_fetch_assoc($query7);
          $per7 += $res7['percentage'];
          }
         
        //DISTRIBUTION SYSTEM
         
         $per8=0;
         for($o=37;$o<40;$o++){
        $query8 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='Distribution System' and scheduleId=$o");
          $res8 = mysqli_fetch_assoc($query8);
          $per8 += $res8['percentage'];
          }
         
         //MSEDC WORK
         
         $per9=0;
         for($p=40;$p<44;$p++){
        $query9 = mysqli_query($con,"select percentage from schedule where yojanaId='$id' and subWork='MSEDC Work' and scheduleId=$p");
          $res9 = mysqli_fetch_assoc($query9);
          $per9 += $res9['percentage'];
          }
         

         
         ?>
        
          ['<?php echo $village ;?>', <?php echo $per1; ?>, <?php echo $per2; ?>, <?php echo $per3; ?>, <?php echo $per4; ?>,<?php echo $per5; ?>,<?php echo $per6; ?>,<?php echo $per7; ?>,<?php echo $per8;?>,<?php echo $per9;?>],
          
          <?php
         
          }
          
          ?>
          
        ]
      };

      // create column chart
      var chart = anychart.column();

      // set chart data
      chart.data(chartData);

      // turn on chart animation
      chart.animation(true);

      chart.yAxis().labels().format('{%Value}% ');

      // set titles for Y-axis
      chart.yAxis().title('Percentage');
    

      chart
        .labels()
        .enabled(true).fontSize(10)
        .position('center-top')
        .anchor('center-bottom')
        .format('{%Value}%');
        
      chart.hovered().labels(false);

      // turn on legend and tune it
      chart.legend().enabled(true).fontSize(12).padding([0, 0, 20, 0]);

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
        .format('{%SeriesName} : {%Value}% ');

      // set container id for the chart
      chart.container('container');

      // initiate chart drawing
      chart.draw();
    });
  
</script>
</body>
</html>
                