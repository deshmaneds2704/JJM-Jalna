<?php 
session_start();

require_once('include/con.php');
$dia = $_POST['diameter'];
$depth = $_POST['depth'];
$yoc = $_POST['yoc'];
$image = $_POST['image_name'];
$remark = $_POST['remark'];
$str_type = $_POST['str_type'];
$userId = $_POST['userId'];
$photo = $_POST['photo'];
$lat = $_POST['latitude'];
$longitude = $_POST['longitude'];
$yojanaId = $_POST['yojanaId'];

$query = mysqli_query($conn,"INSERT INTO stepOne(`typeOfSource`,`diameter`,`depth`,`yearOfConstruction`,`typeOfStructure`,`photo1`,`latitude`,`latitude`,`remark`,`userId`,`yojanaId`) VALUES('NA','$dia','$depth','$yoc','$str_type','$photo','$lat','$longitude','$remark','$userId','$yojanaId')");

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