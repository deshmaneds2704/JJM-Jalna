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

    // create data
    
    var data = [
        
        <?php
    
    /*SUBWORK*/
    
    $sql = mysqli_query($con,"select distinct subWork from scheduleMaster");
    while($res = mysqli_fetch_assoc($sql)){
     $subwork = $res['subWork'];
         
     $query = mysqli_query($con,"SELECT DISTINCT(yojanaId),SUM(percentage) FROM `schedule` WHERE subWork='$subwork' GROUP BY yojanaId HAVING SUM(percentage)=100");
    $count = mysqli_num_rows($query);
       
    ?>
        
      ["<?php echo $subwork;?>",<?php echo $count;?>],
    
     <?php
        
    }  
     ?>
    ];
       

    // create a chart
    var chart = anychart.column();

    // create a column series and set the data
    var series = chart.column(data);
    series.name("Total no. of schemes");

    // set the chart title
    chart.title(" ");

    // set the titles of the axes
    chart.xAxis().title("Subwork");
    chart.yAxis().title("No. of schemes");
    
    // set the container id
    chart.container("container");

    // initiate drawing the chart
    chart.draw();
});
</script>
 
</body>
</html>
                