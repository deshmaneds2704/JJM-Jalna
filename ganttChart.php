
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.css"
        integrity="sha512-57KPd8WI3U+HC1LxsxWPL2NKbW82g0BH+0PuktNNSgY1E50mnIc0F0cmWxdnvrWx09l8+PU2Kj+Vz33I+0WApw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .gantt-container {
            width: 90vw;
            margin: 0 auto;
        }

        .chart-controls {
            text-align: center;
        }

        .chart-controls>p {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .chart-label {
            font-size: 1.5rem;
            text-align: center;
            font-weight: 500;
        }

        .gantt-container .popup-wrapper {
            width: 200px;
            padding: 0 5px;
        }
    </style>

</head>

<body>
    <p class="chart-label">
        <!--Timescale: <span id="current-timescale">Day</span>-->
        Gantt Chart
    </p>
    <div>
        <svg id="gantt" height="390">
        </svg>
    </div>

    <!--<div class="chart-controls">
        <p>Change Chart Timescale</p>
        <div class="button-cont">
            <button id="day-btn">
                Day
            </button>

            <button id="week-btn">
                Week
            </button>

            <button id="month-btn">
                Month
            </button>
        </div>
    </div>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/frappe-gantt/0.6.1/frappe-gantt.min.js"
        integrity="sha512-HyGTvFEibBWxuZkDsE2wmy0VQ0JRirYgGieHp0pUmmwyrcFkAbn55kZrSXzCgKga04SIti5jZQVjbTSzFpzMlg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let tasks = [
            <?php
            $countPumping = 1;
            $countRising = 1;
            $countEsr = 1;
            $i = 1;
            $yojanaId = $_GET['yojanaId'];
            $query = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '$yojanaId'");
            while($result = mysqli_fetch_assoc($query)){
                $subWorkId = $result['id'];
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
                
                
                $start = $result['actualDate'];
                $end = $result['actualEndDate'];
                $progress = $workDone;
                if($i > 1){
                    echo ", ";
                }
                
            ?>
            {
                id: '<?php echo $subWorkId ?>',
                name: '<?php echo $subWork ?>',
                start: '<?php echo $start ?>',
                end: '<?php echo $end ?>',
                progress: <?php echo $progress ?>,
            }
            
            <?php
                $i++;
            }
            ?>
        ]

        let ganttChart = new Gantt("#gantt", tasks, {

            on_view_change: function (mode) {
                // document.getElementById("current-timescale").innerText = mode;
            },

            custom_popup_html: function (task) {
                // the task object will contain the updated
                // dates and progress value
                return `
            <div class="details-container">
                <h5>${task.name}</h5>
                <p>Task started on: ${task._start.getDate()} / ${task._start.getMonth()}}</p>
                <p>Expected to finish by ${task._end.getDate()} / ${task._start.getMonth()}}</p>
                <p>${task.progress}% completed!</p>
            </div>
            `;
            }
        });
        
        ganttChart.change_view_mode('Week');

        document.querySelector(".chart-controls #day-btn").addEventListener("click", () => {
            ganttChart.change_view_mode("Day");
        })

        document.querySelector(".chart-controls #week-btn").addEventListener("click", () => {
            ganttChart.change_view_mode("Week");
        })

        document.querySelector(".chart-controls #month-btn").addEventListener("click", () => {
            ganttChart.change_view_mode("Month")
        })
    </script>
</body>

</html>