<meta charset="utf-8">
<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}

require_once('include/con.php');
require_once('include/sweetAlert.php');

if(isset($_POST['talukaYojana'])){
    $taluka = $_POST['talukaYojana'];
    $query = mysqli_query($con, "SELECT DISTINCT yojanaId, yojanaName FROM yojanaMaster WHERE taluka = '$taluka'");
    ?>
    <label>Name of Scheme</label>
    <select class="js-example-basic-single" required id="yojanaId" name="yojanaId" style="width: 100%;">
        <?php
        if(mysqli_num_rows($query)>0){
        ?>
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
    $query = mysqli_query($con, "SELECT DISTINCT(gramPanchayat) FROM villages WHERE taluka = '$taluka'");
    ?>
    <select class="js-example-basic-single" id="gramPanchayat" required=""  name="gramPanchayat" style="width: 100%;">
        <option value="" selected="" disabled=""></option>
    <!--<select class="js-example-basic-multiple" name="village[]" multiple="multiple" style="width: 100%;">-->
        <?php
        while($result = mysqli_fetch_assoc($query)){
            $gramPanchayat = $result['gramPanchayat'];
        ?>
        <option value="<?php echo $gramPanchayat ?>"><?php echo $gramPanchayat ?></option>
        <?php
        }
        ?>
    </select>
    <script src="template/assets/js/select2.js"></script>
    <script>
        $("#gramPanchayat").on('change', function(){
            var taluka = $("#taluka").val();
            var gramPanchayat = $(this).val();
            var villageHtml = $("#villageHtml");
            villageHtml.html("Please Wait");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {taluka2:taluka, gramPanchayat:gramPanchayat},
                success:function(data){
                    villageHtml.html(data);
                }
            })
        })
    </script>
    <!--<script src="js/custom.js?v=1.0.1"></script>-->
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

if(isset($_POST['gramPanchayat'])){
    $taluka = $_POST['taluka2'];
    $gramPanchayat = $_POST['gramPanchayat'];
    $query = mysqli_query($con, "SELECT DISTINCT(village) FROM villages WHERE taluka = '$taluka' AND gramPanchayat = '$gramPanchayat'");
    ?>
    <select class="js-example-basic-single" id="village" required="" name="village" style="width: 100%;">
        <option value="" selected="" disabled=""></option>
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
    <script>
        $("#village").on('change', function(){
            var taluka = $("#taluka").val();
            var gramPanchayat = $("#gramPanchayat").val();
            var habitationHtml = $("#habitationHtml");
            var village = $(this).val();
            habitationHtml.html("Please Wait");
            $.ajax({
                type : 'POST',
                url  : 'villagesAjax',
                data : {taluka3:taluka, gramPanchayat2:gramPanchayat,village:village},
                success:function(data){
                    habitationHtml.html(data);
                }
            })
        })
    </script>
    <?php
}

if(isset($_POST['village'])){
    $taluka = $_POST['taluka3'];
    $gramPanchayat = $_POST['gramPanchayat2'];
    $village = $_POST['village'];
    $query = mysqli_query($con, "SELECT DISTINCT(habitation) FROM villages WHERE taluka = '$taluka' AND gramPanchayat = '$gramPanchayat' AND village = '$village'");
    ?>
    <select class="js-example-basic-single" id="habitation" required="" onchange="yojanaNameByVillage()" name="habitation" style="width: 100%;">
        <option value="" selected="" disabled=""></option>
        <?php
        while($result = mysqli_fetch_assoc($query)){
            $habitation = $result['habitation'];
        ?>
        <option value="<?php echo $habitation ?>"><?php echo $habitation ?></option>
        <?php
        }
        ?>
    </select>
    <script src="template/assets/js/select2.js"></script>
    <script>
        function yojanaNameByVillage(){
            var village = document.getElementById('habitation').value;
            var yojanaName = " Water Supply Scheme";//document.getElementById('yojanaName').value;
            yojanaName = village+yojanaName;
            console.log(yojanaName);
            document.getElementById('yojanaName').value = "";
            document.getElementById('yojanaName').value = yojanaName;
            
            var taluka = $("#taluka").val();
            var gramPanchayat = $("#gramPanchayat").val();
            var village = $("#village").val();
            var habitation  = $("#habitation").val();
            
            
            $.ajax({
                type : 'POST',
                url  : 'createYojana',
                data : {yojanaName:yojanaName, taluka2:taluka, gramPanchayat:gramPanchayat, village:village, habitation:habitation},
                success:function(data){
                    // console.log(data);
                    if(data == 1){
                        console.log(yojanaExit());
                        if(yojanaExit() == 1){
                            $("#habitation").val(null).trigger("change");
                        }
                        
                    }
                }
            });
        }
        
    </script>
    <?php
}

/*if(isset($_POST['village'])){
    $village = $_POST['village'];
    echo '<label for="yojanaName">Name of scheme</label><input type="text" class="form-control" id="yojanaName" name="yojanaName" value=" '.$village.' Water Supply Scheme "; placeholder="">';
}*/


?>