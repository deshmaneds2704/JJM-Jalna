<?php 
session_start();

require_once('include/con.php');

$yojanaComplete = $_POST['yojanaComplete'];
$reason = $_POST['reason'];
$dateOfCommissioning = $_POST['dateOfCommissioning'];
$dateOfHandingOver = $_POST['dateOfHandingOver'];
$datesOfTpiVisit1 = $_POST['datesOfTpiVisit1'];
$datesOfTpiVisit2 = $_POST['datesOfTpiVisit2'];
$datesOfTpiVisit3 = $_POST['datesOfTpiVisit3'];
$dateOfCompletion = $_POST['dateOfCompletion'];
$photo1 = $_POST['photo1'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$completionPercentage = $_POST['completionPercentage'];
$remark = $_POST['remark'];
$yojanaId = $_POST['yojanaId'];
$userId = $_POST['userId'];
$dateTime = $_POST['dateTime'];

$query = mysqli_query($conn,"INSERT INTO stepFive(`yojanaComplete`,`reason`,`dateOfCommissioning`,`dateOfHandingOver`,`datesOfTpiVisit1`,`datesOfTpiVisit2`,`datesOfTpiVisit3`,`dateOfCompletion`,`photo1`,`longitude`,`latitude`,`completionPercentage`,`remark`,`yojanaId`,`userId`,`dateTime`) VALUES('$yojanaComplete','$reason','$dateOfCommissioning','$dateOfHandingOver','$datesOfTpiVisit1','$datesOfTpiVisit2','$datesOfTpiVisit3','$dateOfCompletion','$photo1','$longitude','$latitude','$completionPercentage','$remark','$yojanaId','$userId','$dateTime')");

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