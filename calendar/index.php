<?php 
session_start();
if(!isset($_SESSION['userId'])){
    header('location:../login');
    die();
}

require_once("../include/con.php");

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link href='fullcalendar/packages/core/main.css' rel='stylesheet' />
    <link href='fullcalendar/packages/daygrid/main.css' rel='stylesheet' />


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>Calendar #10</title>
    
    <style>
        .fc-timeGridWeek-button, .fc-timeGridDay-button, .fc-listWeek-button {
            display: none;
        }
    </style>
</head>

<body>


    <div id='calendar-container'>
        <div id='calendar'></div>
    </div>



    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

     <script src='fullcalendar/packages/core/main.js'></script>
    <script src='fullcalendar/packages/interaction/main.js'></script>
    <script src='fullcalendar/packages/daygrid/main.js'></script>
    <script src='fullcalendar/packages/timegrid/main.js'></script>
    <script src='fullcalendar/packages/list/main.js'></script> 



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                height: 'parent',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                defaultView: 'dayGridMonth',
                defaultDate: '<?php echo date('Y-m-d') ?>',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    <?php
                    $countPumping = 1;
                    $countRising = 1;
                    $countEsr = 1;
                    $i = 1;
                    
                    $yojanaId = $_GET['yojanaId'];
                    $query = mysqli_query($con, "SELECT * FROM `subWork` WHERE yojanaId = '$yojanaId'") or die($con->error);
                    while($result = mysqli_fetch_assoc($query)){
                        
                        
                        $subWorkId = $result['id'];
                        if($result['subWork'] == "Percolation Well"){
                            $subWork = "Percolation Well  (Depth -".$result['depth']." m & Dia - ".$result['diameter']." m)";
                            
                        } else if($result['subWork'] == "Approach Bund"){
                            $subWork = $result['subWork']." (Length -".$result['length']." m)";
                            
                            
                        } else if($result['subWork'] == "Pumping Machinery"){
                            $subWork = $countPumping++.". ".$result['subWork']." (".$result['bhp']." bhp)";
                            
                        } else if($result['subWork'] == "Rising Main"){
                            $subWork = $countRising++.". ".$result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['kg_cm']." kg/cm<sup>2</sup> = ".$result['length']." m)";
                            
                        } else if($result['subWork'] == "RCC ESR"){
                            $subWork = $countEsr++.". ".$result['subWork']." (".$result['capacity']." ltr.)";
                            
                        } else if($result['subWork'] == "Distribution System"){
                            $subWork = $result['subWork']." (".$result['diameter']." mm ".$result['typePipe']." ".$result['length']." m)";
                            
                        } else if($result['subWork'] == "MSEDC Work"){
                            $subWork = $result['subWork'];
                            
                        } else if($result['subWork'] == "Trial & Run"){
                            $subWork = $result['subWork']. " (Months - ".$result['month'].")";
                            
                        } else if($result['subWork'] == "Year - Demand" || $result['subWork'] == "Year - Population"){
                            continue;
                        }
                        $start = $result['actualDate'];
                        $end = $result['actualEndDate'];
                        if($i > 1){
                            echo ",";
                        }
                    ?>
                    
                    {
                        title: '<?php echo $subWork ?>',
                        start: '<?php echo $start ?>',
                        end: '<?php echo $end ?>'
                    }
                    <?php
                        $i++;
                    }
                    ?>
                ]
            });

            calendar.render();
        });

    </script>

    <script src="js/main.js"></script>
</body>

</html>