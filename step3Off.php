<?php 
session_start();

require_once('include/con.php');

$surveyNo = $_POST['surveyNo'];
$capacity = $_POST['capacity'];
$yearOfConstruction = $_POST['yearOfConstruction'];
$height = $_POST['height'];
$typeOfConstruction = $_POST['typeOfConstruction'];
$photo1 = $_POST['photo1'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$completionPercentage = $_POST['completionPercentage'];
$remark = $_POST['remark'];
$yojanaId = $_POST['yojanaId'];
$userId = $_POST['userId'];
$dateTime = null;

$query = mysqli_query($conn,"INSERT INTO stepThree(`surveyNo`,`capacity`,`yearOfConstruction`,`height`,`typeOfConstruction`,`photo1`,`longitude`,`latitude`,`completionPercentage`,`remark`,`yojanaId`,`userId`,`dateTime`) VALUES('$surveyNo','$capacity','$yearOfConstruction','$height','$typeOfConstruction','$photo1','$longitude','$latitude','$completionPercentage','$remark','$yojanaId','$userId','$dateTime')");

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