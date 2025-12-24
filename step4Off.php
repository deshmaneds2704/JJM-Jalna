<?php 
session_start();

require_once('include/con.php');

$length = $_POST['length'];
$material = $_POST['material'];
$photo1 = $_POST['photo1'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$completionPercentage = $_POST['completionPercentage'];
$remark = $_POST['remark'];
$yojanaId = $_POST['yojanaId'];
$userId = $_POST['userId'];
$dateTime = $_POST['dateTime'];

$query = mysqli_query($conn,"INSERT INTO stepFour(`length`,`material`,`photo1`,`longitude`,`latitude`,`completionPercentage`,`remark`,`yojanaId`,`userId`,`dateTime`) VALUES('$length','$material','$photo1','$longitude','$latitude','$completionPercentage','$remark','$yojanaId','$userId','$dateTime')");

if($query){
        $result["status"] = TRUE;
    	$result["remarks"] = "Data Uploaded Successfully...";
}
else {
        $result["status"] = FALSE;
		$result["remarks"] = "Something went wrong...";
}
print(json_encode($result));
?>