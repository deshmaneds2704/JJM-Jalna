<meta charset="utf-8">
<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}

require_once('include/con.php');

if(isset($_POST['talukaYojana'])){
    $taluka = $_POST['talukaYojana'];
    $query = mysqli_query($con, "SELECT DISTINCT(yojanaId), yojanaName FROM yojanaMaster WHERE taluka = '$taluka' GROUP BY yojanaId");
    ?>
    <label>Name of Scheme</label>
    <select class="js-example-basic-single" required id="yojanaId" name="yojanaId[]" style="width: 100%;" multiple>
        <?php
        if(mysqli_num_rows($query)>0){
        ?>
        <option value="all_schemes">All scheme</option>
        <option value="" disabled selected></option>
        <?php
        }
        ?>
        <?php
        while($result = mysqli_fetch_assoc($query)){
            $yojanaName = $result['yojanaName'];
            $yojanaId = $result['yojanaId'];
        ?>
        <option value="<?php echo $yojanaId ?>"><?php echo $yojanaId." - ".$yojanaName ?></option>
        <?php
        }
        ?>
    </select>
    <script src="template/assets/js/select2.js"></script>
    <!--<script src="js/custom.js?v=1.0.6"></script>-->
    
    <?php
    die();
}


if(isset($_POST['taluka'])){
    $taluka = $_POST['taluka'];
    $query = mysqli_query($con, "SELECT DISTINCT(village) FROM villages WHERE taluka = '$taluka'");
    ?>
    <select class="js-example-basic-multiple" id="village" required="" onchange="yojanaNameByVillage()" name="village[]" style="width: 100%;" multiple="multiple">
        <option value="" selected="" disabled=""></option>
        <option value="all_schemes">All scheme</option>
    <!--<select class="js-example-basic-multiple" name="village[]" multiple="multiple" style="width: 100%;">-->
        <?php
        while($result = mysqli_fetch_assoc($query)){
            $village = $result['village'];
        ?>
        <option value="<?php echo $village ?>"><?php echo $village ?></option>
        <?php
        }
        ?>
    </select>
    <script src="template/assets/js/select2.js"></script>
    <!--<script src="js/custom.js?v=1.0.1"></script>-->
    <script>
        function yojanaNameByVillage(){
            var village = document.getElementById('village').value;
            var yojanaName = " Water Supply Scheme" ;//document.getElementById('yojanaName').value;
            console.log(yojanaName+" "+village);
            document.getElementById('yojanaName').value = "";
            document.getElementById('yojanaName').value = village+yojanaName;
        }
        $("#village").on("change", function(){
            var village = $(this).val();
            console.log(village);
            /*$.ajax({
                type : 'POST',
                url : 'villagesAjax',
                data : {village:village}
                success:function(data){
                    $("yojanaNameHTML").html(data);
                }
            })*/
            // var yojanaName = $("#yojanaName").val();
            // console.log(village);
            // // if(yojanaName == "पाणी पुरवठा योजना"){
            //     yojanaName.val("पाणी पुरवठा योजना "+village)
            // // }
        })
    </script>
    <!--<script>
        $("#village").on("change", function(){
            var village = $(this).val();
            var yojanaName = $("#yojanaName").val();
            console.log(village);
            if(yojanaName == "पाणी पुरवठा योजना"){
                yojanaName.val("पाणी पुरवठा योजना "+village)
            } 
        })
    </script>-->
    <?php
    die();
}

if(isset($_POST['village'])){
    $village = $_POST['village'];
    echo '<label for="yojanaName">Name of scheme</label><input type="text" class="form-control" id="yojanaName" name="yojanaName" value=" '.$village.' Water Supply Scheme "; placeholder="">';
}


?>