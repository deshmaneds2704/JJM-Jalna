<?php
session_start();
if(!isset($_SESSION['userId'])){
    header('location:login');
    die();
}
require_once('include/con.php');
require_once('include/sweetAlert.php');
if(isset($_POST['submit'])){
    $userId = $_SESSION['userId'];
    $createdDate = date("Y-m-d H:i:s");
    
    if(!isset($_GET['yojanaId'])){
        
         /*
        
        Scheme insert by clerk;
        
        
        */
        
        $yojanaId = $_POST['yojanaId'];
        $number = $_POST['number'];
        $yojanaName = addslashes($_POST['yojanaName']);
        $subDivision = $_POST['subDivision'];
        $taluka = $_POST['taluka'];
        $exectedStartDate = $_POST['exectedStartDate'];
        $expectedDate = $_POST['expectedDate'];
        $villages = $_POST['village'];
        $habitation = $_POST['habitation'];
        $gramPanchayat = $_POST['gramPanchayat'];
        
        /*$i = 1;
        foreach ($_POST['village'] as $village){
            if($i == 1){
                $villages .= $village;   
            } else {
                $villages .= ", ".$village;   
            }
            $i++;
        }*/
        
        $query = mysqli_query($con, "SELECT * FROM yojanaMaster WHERE yojanaId = '$yojanaId'");
        if(mysqli_num_rows($query) >0 ){
        ?>
        <html>
            <head>
                
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Scheme is already created'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'createYojana';
                        } else {
                            window.location = 'createYojana';
                        }
                    });
        
                </script>
            </body>
        </html>
        
        <?php
            die();
        }
        
        $userId = $_SESSION['userId'];
        $createdDate = date("Y-m-d H:i:s");
        $executiveEng = $_POST['executiveEng'];
        $sectionEng = $_POST['sectionEng'];
        $gst = $_POST['gst'];
        $totalSanctionedCost = $_POST['totalSanctionedCost'];
        
        
        //Create Yojana
        $query1 = mysqli_query($con, "INSERT INTO `yojanaMaster` (`number`, `yojanaId`, `yojanaName`, `habitation`, `village`, `gramPanchayat`, `taluka`, `subDivision`, `gst`, `totalSanctionedCost`, `userId`, `expectedDate`, `exectedStartDate`, `createdDate`, `sec_eng`,`exe_eng`) VALUES ('$number', '$yojanaId', '$yojanaName', '$habitation', '$villages', '$gramPanchayat', '$taluka', '$subDivision', '$gst', '$totalSanctionedCost', '$userId', '$expectedDate', '$exectedStartDate', '$createdDate','$sectionEng','$executiveEng')");
        
        
        
        //For executive eng & section eng.
        $query2 = mysqli_query($con, "INSERT INTO `allocatedYojana`(`yojanaId`, `userId`, `designation`, `allocatedBy`, `dateTime`) VALUES ('$yojanaId', '$executiveEng', 'executiveEng', '$userId', '$createdDate'), ('$yojanaId', '$sectionEng', 'sectionEng', '$userId', '$createdDate') ");
        
        //For multiple section eng.
        /*$query2 = mysqli_query($con, "INSERT INTO `allocatedYojana`(`yojanaId`, `userId`, `designation`, `allocatedBy`, `dateTime`) VALUES ('$yojanaId', '$executiveEng', 'executiveEng', '$userId', '$createdDate')");
        
        foreach ($_POST['sectionEng'] as $sectionEng){
            $query2 = mysqli_query($con, "INSERT INTO `allocatedYojana`(`yojanaId`, `userId`, `designation`, `allocatedBy`, `dateTime`) VALUES ('$yojanaId', '$sectionEng', 'sectionEng', '$userId', '$createdDate')");
        }*/
        
        
        //Upload Document
        $i=0;
        foreach ($_POST['docName'] as $docName){
            $docName = addslashes($docName);
            $document = addslashes($_FILES['photo']['name'][$i]);
            $type = $_FILES['photo']['type'][$i];
            $tmp = $_FILES['photo']['tmp_name'][$i];
            move_uploaded_file($tmp,"uploadedDoc/".$document);
            
            $query3 = mysqli_query($con, "INSERT INTO `uploadDoc`( `yojanaId`, `stepNo`, `docName`, `document`, `type`, `userId`, `uploadedDate`) VALUES ('$yojanaId', '0', '$docName', '$document', '$type', '$userId', '$createdDate')");   
            $i++;
        }
        
        //Sub-Work
        //Trial Bore
        if(isset($_POST['trialBore'])){
            $i=0;
            foreach ($_POST['depthTrial'] as $depthTrial){
                // $depthTrial = $_POST['depthTrial'];
                $diameterTrial = $_POST['diameterTrial'][$i];
                $amountTrial = $_POST['amountTrialBore'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `depth`, `diameter`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Trial Bore', '$depthTrial', '$diameterTrial', '$amountTrial', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepOne = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        
        
        //Percolation Well
        if(isset($_POST['percolationWell'])){
            $i=0;
            foreach ($_POST['depthPercolation'] as $depthPercolation){
                // $depthPercolation = $_POST['depthPercolation'];
                $diameterPercolation = $_POST['diameterPercolation'][$i];
                $amountPercolation = $_POST['amountPercolation'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `depth`, `diameter`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Percolation Well', '$depthPercolation', '$diameterPercolation', '$amountPercolation', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepOne = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        //Approach Bund
        if(isset($_POST['approachBund'])){
            $i=0;
            foreach ($_POST['lengthApproach'] as $lengthApproach){
                // $lengthApproach = $_POST['lengthApproach'][$i];
                $amountApproach = $_POST['amountApproach'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `length`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Approach Bund', '$lengthApproach', '$amountApproach', '$yojanaId', '$userId', '$createdDate')");       
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepOne = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        //Pumping Machinery
        if(isset($_POST['pumpingMachinery'])){
            $i = 0;
            foreach ($_POST['bhpPumping'] as $bhpPumping){
                $bhpPumping1 = $bhpPumping;
                $amountPumping1 = $_POST['amountPumping'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `bhp`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Pumping Machinery', '$bhpPumping1', '$amountPumping1', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }   
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepTwo = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        
        //Switch Room
        if(isset($_POST['switchRoom'])){
            $i = 0;
            foreach ($_POST['amountSwitch'] as $amountSwitch){
                // $bhpSwitch1 = $bhpSwitch;
                $amountSwitch1 = $_POST['amountSwitch'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Switch Room', '$amountSwitch1', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepTwo = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        
        //Rising Main
        if(isset($_POST['risingMain'])){
            $i = 0;
            foreach ($_POST['diameterRising'] as $diameterRising){
                $diameterRising1 = $_POST['diameterRising'][$i];
                $typePipeRising = $_POST['typePipeRising'][$i];
                $kg_cmRising = $_POST['kg_cmRising'][$i];
                $lengthRising = $_POST['lengthRising'][$i];
                $amountRising = $_POST['amountRising'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `diameter`, `typePipe`, `kg_cm`, `length`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Rising Main', '$diameterRising1', '$typePipeRising', '$kg_cmRising', '$lengthRising', '$amountRising', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepTwo = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        //RCC ESR
        if(isset($_POST['rccEsr'])){
            $i = 0;
            foreach ($_POST['capacityEsr'] as $capacityEsr){
                $capacityEsr1 = $capacityEsr;
                $amountEsr1 = $_POST['amountEsr'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `capacity`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('RCC ESR', '$capacityEsr1', '$amountEsr1', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepThree = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        //Distribution System
        if(isset($_POST['distributionSystem'])){
            $i = 0;
            foreach ($_POST['diameterDistribution'] as $diameterDistribution){
                // $diameterDistribution = $_POST['diameterDistribution'];
                $typePipeDistribution = $_POST['typePipeDistribution'][$i];
                $lengthDistribution = $_POST['lengthDistribution'][$i];
                $amountDistribution = $_POST['amountDistribution'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `diameter`, `typePipe`, `length`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Distribution System', '$diameterDistribution', '$typePipeDistribution', '$lengthDistribution', '$amountDistribution', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepFour = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        //MSEDC Work
        if(isset($_POST['msedcWork'])){
            foreach ($_POST['amountMsedc'] as $amountMsedc){
                // $amountMsedc = $_POST['amountMsedc'];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('MSEDC Work', '$amountMsedc', '$yojanaId', '$userId', '$createdDate')");
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepFive = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        //Trial & Run
        if(isset($_POST['trialRun'])){
            $i = 0;
            foreach ($_POST['monthTrial'] as $monthTrial){
                // $monthTrial = $_POST['monthTrial'];
                $amountTrial = $_POST['amountTrial'][$i];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `month`, `actualPrice`, `yojanaId`, `userId`, `dateTime`) VALUES ('Trial & Run', '$monthTrial', '$amountTrial', '$yojanaId', '$userId', '$createdDate')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepFive = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        
        
        //Year Population
        foreach ($_POST['subWorkId'] as $subWorkId){
            if($subWorkId == 14 || $subWorkId == 15){
                
                if($subWorkId == 14){
                    $subWork = "Year - Population";
                } else {
                    $subWork = "Year - Demand";
                }
                $yearPopulation1 = $_POST['yearPopulation1'.$subWorkId];
                $yearPopulation2 = $_POST['yearPopulation2'.$subWorkId];
                $yearPopulation3 = $_POST['yearPopulation3'.$subWorkId];
                $yearPopulation4 = $_POST['yearPopulation4'.$subWorkId];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `yearPopulation1`, `yearPopulation2`, `yearPopulation3`, `yearPopulation4`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWork', '$yearPopulation1', '$yearPopulation2', '$yearPopulation3', '$yearPopulation4', '$yojanaId', '$userId', '$createdDate')");
            }
        }
        
        //Msg
        if($query4 && $query3 && $query2 && $query1){
            $status = true;
            $msg = "Scheme has been created successfully";
        } else {
            $status = false;
            $msg = "Sorry, Scheme can't be created. Please try again";
        }
        setSession($status, $msg);
        header('location: createYojana');
        
        
        
        
    } else if(isset($_GET['yojanaId']) && $_SESSION['designation'] == "clerk") {
        
        echo "lskdjflskf";
        
        /*
        
        Scheme update by clerk;
        
        
        */
        
        
        $number = $_POST['number'];
        $yojanaId = $_GET['yojanaId'];
        $yojanaName = addslashes($_POST['yojanaName']);
        $exectedStartDate = $_POST['exectedStartDate'];
        $expectedDate = $_POST['expectedDate'];
        $taluka = $_POST['taluka'];
        $subDivision = $_POST['subDivision'];
        $villages = $_POST['village'];
        $habitation = $_POST['habitation'];
        $gramPanchayat = $_POST['gramPanchayat'];
        $executiveEng = $_POST['executiveEng'];
        $sectionEng = $_POST['sectionEng'];
        $gst = $_POST['gst'];
        $totalSanctionedCost = $_POST['totalSanctionedCost'];
        
        mysqli_query($con, "DELETE FROM `allocatedYojana` WHERE yojanaId = '$yojanaId'");
        
        //For executive eng & section eng.
        $query2 = mysqli_query($con, "INSERT INTO `allocatedYojana`(`yojanaId`, `userId`, `designation`, `allocatedBy`, `dateTime`) VALUES ('$yojanaId', '$executiveEng', 'executiveEng', '$userId', '$createdDate'), ('$yojanaId', '$sectionEng', 'sectionEng', '$userId', '$createdDate') ");
        
        
        
        //Sub-Work
        // mysqli_query($con, "DELETE FROM `subWork` WHERE yojanaId = '$yojanaId'");
        
        
        //Trial Bore
        if(isset($_POST['trialBore'])){
            $i=0;
            foreach ($_POST['depthTrial'] as $depthTrial){
                // $depthTrial = $_POST['depthTrial'];
                $trialBoreId = $_POST['trialBoreId'][$i];
                $diameterTrial = $_POST['diameterTrial'][$i];
                $amountTrial = $_POST['amountTrialBore'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$trialBoreId' AND subWork = 'Trial Bore' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `depth`, `diameter`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Trial Bore', '$depthTrial', '$diameterTrial', '$amountTrial', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepOne = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepOne = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Trial Bore' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Trial Bore' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //Percolation Well
        if(isset($_POST['percolationWell'])){
            $i=0;
            foreach ($_POST['depthPercolation'] as $depthPercolation){
                // $depthPercolation = $_POST['depthPercolation'];
                $percolationWellId = $_POST['percolationWellId'][$i];
                $diameterPercolation = $_POST['diameterPercolation'][$i];
                $amountPercolation = $_POST['amountPercolation'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$percolationWellId' AND subWork = 'Percolation Well' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `depth`, `diameter`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Percolation Well', '$depthPercolation', '$diameterPercolation', '$amountPercolation', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepOne = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepOne = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Percolation Well' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Percolation Well' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        
        //Approach Bund
        if(isset($_POST['approachBund'])){
            $i=0;
            foreach ($_POST['lengthApproach'] as $lengthApproach){
                // $lengthApproach = $_POST['lengthApproach'][$i];
                $approachBundId = $_POST['approachBundId'][$i];
                $amountApproach = $_POST['amountApproach'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$approachBundId' AND subWork = 'Approach Bund' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `length`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Approach Bund', '$lengthApproach', '$amountApproach', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");       
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepOne = 'Yes' WHERE yojanaId = '$yojanaId'");
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Approach Bund' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Approach Bund' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //Pumping Machinery
        if(isset($_POST['pumpingMachinery'])){
            $i = 0;
            foreach ($_POST['bhpPumping'] as $bhpPumping){
                $bhpPumping1 = $bhpPumping;
                $pumpingMachineryId = $_POST['pumpingMachineryId'][$i];
                $amountPumping1 = $_POST['amountPumping'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$pumpingMachineryId' AND subWork = 'Pumping Machinery' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `bhp`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Pumping Machinery', '$bhpPumping1', '$amountPumping1', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }   
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepTwo = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepTwo = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Pumping Machinery' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Pumping Machinery' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //Switch Room
        if(isset($_POST['switchRoom'])){
            $i = 0;
            foreach ($_POST['amountSwitch'] as $amountSwitch){
                // $bhpSwitch1 = $bhpSwitch;
                $risingMainId = $_POST['risingMainId'][$i];
                $amountSwitch1 = $_POST['amountSwitch'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$risingMainId' AND subWork = 'Switch Room' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Switch Room', '$amountSwitch1', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepTwo = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepTwo = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Switch Room' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Switch Room' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //Rising Main
        if(isset($_POST['risingMain'])){
            $i = 0;
            foreach ($_POST['diameterRising'] as $diameterRising){
                $pumpingMachineryId = $_POST['pumpingMachineryId'][$i];
                $diameterRising1 = $_POST['diameterRising'][$i];
                $typePipeRising = $_POST['typePipeRising'][$i];
                $kg_cmRising = $_POST['kg_cmRising'][$i];
                $lengthRising = $_POST['lengthRising'][$i];
                $amountRising = $_POST['amountRising'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$pumpingMachineryId' AND subWork = 'Rising Main' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `diameter`, `typePipe`, `kg_cm`, `length`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Rising Main', '$diameterRising1', '$typePipeRising', '$kg_cmRising', '$lengthRising', '$amountRising', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepTwo = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepTwo = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Rising Main' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Rising Main' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //RCC ESR
        if(isset($_POST['rccEsr'])){
            $i = 0;
            foreach ($_POST['capacityEsr'] as $capacityEsr){
                $rccEsrId = $_POST['rccEsrId'][$i];
                $capacityEsr1 = $capacityEsr;
                $amountEsr1 = $_POST['amountEsr'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$rccEsrId' AND subWork = 'RCC ESR' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `capacity`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('RCC ESR', '$capacityEsr1', '$amountEsr1', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepThree = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepThree = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'RCC ESR' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'RCC ESR' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //Distribution System
        if(isset($_POST['distributionSystem'])){
            $i = 0;
            foreach ($_POST['diameterDistribution'] as $diameterDistribution){
                $distributionSystemId = $_POST['distributionSystemId'][$i];
                // $diameterDistribution = $_POST['diameterDistribution'];
                $typePipeDistribution = $_POST['typePipeDistribution'][$i];
                $lengthDistribution = $_POST['lengthDistribution'][$i];
                $amountDistribution = $_POST['amountDistribution'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$distributionSystemId' AND subWork = 'Distribution System' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `diameter`, `typePipe`, `length`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Distribution System', '$diameterDistribution', '$typePipeDistribution', '$lengthDistribution', '$amountDistribution', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepFour = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepFour = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Distribution System' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Distribution System' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //MSEDC Work
        if(isset($_POST['msedcWork'])){
            foreach ($_POST['amountMsedc'] as $amountMsedc){
                // $amountMsedc = $_POST['amountMsedc'];
                $msedcWorkId = $_POST['msedcWorkId'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$msedcWorkId' AND subWork = 'MSEDC Work' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('MSEDC Work', '$amountMsedc', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepFive = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepFive = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'MSEDC Work' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'MSEDC Work' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //Trial & Run
        if(isset($_POST['trialRun'])){
            $i = 0;
            foreach ($_POST['monthTrial'] as $monthTrial){
                // $monthTrial = $_POST['monthTrial'];
                $trialRunId = $_POST['trialRunId'][$i];
                $amountTrial = $_POST['amountTrial'][$i];
                
                $q = mysqli_query($con, "SELECT * FROM subWork WHERE id = '$trialRunId' AND subWork = 'Trial & Run' AND `update` != 'Yes'");
                $r = mysqli_fetch_assoc($q);
                $plannedDate = $r['plannedDate'];
                $plannedEndDate = $r['plannedEndDate'];
                $actualDate = $r['actualDate'];
                $actualEndDate = $r['actualEndDate'];
                
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `month`, `actualPrice`, `yojanaId`, `userId`, `dateTime`, `plannedDate`, `plannedEndDate`, `actualDate`, `actualEndDate`, `update`) VALUES ('Trial & Run', '$monthTrial', '$amountTrial', '$yojanaId', '$userId', '$createdDate', '$plannedDate', '$plannedEndDate', '$actualDate', '$actualEndDate', 'Yes')");
                $i++;
            }
            $q1 = mysqli_query($con, "UPDATE yojanaMaster SET stepFive = 'Yes' WHERE yojanaId = '$yojanaId'");
            $stepFive = "Yes";
        }
        $q = mysqli_query($con, "DELETE FROM subWork WHERE `subWork` = 'Trial & Run' AND `update` != 'Yes' AND `yojanaId` = '$yojanaId'");
        $q = mysqli_query($con, "UPDATE subWork SET `update` = '' WHERE `subWork` = 'Trial & Run' AND `update` = 'Yes' AND `yojanaId` = '$yojanaId'");
        
        
        //Year Population
        
        foreach ($_POST['subWorkId'] as $subWorkId){
            if($subWorkId == 14 || $subWorkId == 15){
            
                if($subWorkId == 14){
                    $subWork = "Year - Population";
                } else {
                    $subWork = "Year - Demand";
                }
                echo "<br>".$yearPopulation1 = $_POST['yearPopulation1'.$subWorkId];
                echo "<br>".$yearPopulation2 = $_POST['yearPopulation2'.$subWorkId];
                echo "<br>".$yearPopulation3 = $_POST['yearPopulation3'.$subWorkId];
                echo "<br>".$yearPopulation4 = $_POST['yearPopulation4'.$subWorkId];
                $query4 = mysqli_query($con, "INSERT INTO subWork (`subWork`, `yearPopulation1`, `yearPopulation2`, `yearPopulation3`, `yearPopulation4`, `yojanaId`, `userId`, `dateTime`) VALUES ('$subWork', '$yearPopulation1', '$yearPopulation2', '$yearPopulation3', '$yearPopulation4', '$yojanaId', '$userId', '$createdDate')");
            }
        }
        
        //Upload Document
        $i=0;
        foreach ($_POST['docName'] as $docName){
            $docName = addslashes($docName);
            echo $document = addslashes($_FILES['photo']['name'][$i]);
            if($_FILES['photo']['name'][$i] && isset($document) ){
                // $q = mysqli_query($con, "SELECT * FROM uploadedDoc WHERE ")
                $type = $_FILES['photo']['type'][$i];
                $tmp = $_FILES['photo']['tmp_name'][$i];
                move_uploaded_file($tmp,"uploadedDoc/".$document);
                
                $q = mysqli_query($con, "SELECT * FROM uploadDoc WHERE yojanaId = '$yojanaId' AND docName = '$docName'");
                
                if(mysqli_num_rows($q) <=0){
                    $query3 = mysqli_query($con, "INSERT INTO `uploadDoc`( `yojanaId`, `stepNo`, `docName`, `document`, `type`, `userId`, `uploadedDate`) VALUES ('$yojanaId', '0', '$docName', '$document', '$type', '$userId', '$createdDate')");     
                } else {
                    $query3 = mysqli_query($con, "UPDATE uploadDoc SET `stepNo` = '0', `docName` = '$docName', `document` = '$document', `type` = '$type', `userId` = '$userId', `uploadedDate` = '$createYojana' WHERE yojanaId = '$yojanaId' AND docName = '$docName' ");
                }
            }
            $i++;
        }
        
        mysqli_query($con, "DELETE FROM `yojanaMaster` WHERE yojanaId = '$yojanaId'");
        
        // echo "INSERT INTO `yojanaMaster` (`number`, `yojanaId`, `yojanaName`, `habitation`, `village`, `gramPanchayat`, `taluka`, `subDivision`, `gst`, `totalSanctionedCost`, `userId`, `expectedDate`, `exectedStartDate`, `createdDate`, `sec_eng`, `exe_eng`) VALUES ('$number', '$yojanaId', '$yojanaName', '$habitation' '$villages', '$gramPanchayat', '$taluka', '$subDivision', '$gst', '$totalSanctionedCost', '$userId', '$expectedDate', '$exectedStartDate', '$createdDate', '$sectionEng', '$executiveEng')";
        
        $query1 = mysqli_query($con, "INSERT INTO `yojanaMaster` (`number`, `yojanaId`, `yojanaName`, `habitation`, `village`, `gramPanchayat`, `taluka`, `subDivision`, `gst`, `totalSanctionedCost`, `userId`, `expectedDate`, `exectedStartDate`, `createdDate`, `sec_eng`, `exe_eng`, `stepOne`, `stepTwo`, `stepThree`, `stepFour`, `stepFive`) VALUES ('$number', '$yojanaId', '$yojanaName', '$habitation', '$villages', '$gramPanchayat', '$taluka', '$subDivision', '$gst', '$totalSanctionedCost', '$userId', '$expectedDate', '$exectedStartDate', '$createdDate', '$sectionEng', '$executiveEng', '$stepOne', '$stepTwo', '$stepThree', '$stepFour', '$stepFive')") or die($con->error);
        
        if(true){
            $status = true;
            $msg = "Scheme is updated successfully.";
        } else {
            $status = false;
            $msg = "Sorry, Scheme can't be update. Please try again";
        }
        
        setSession($status, $msg);
        header('location: createYojana?yojanaId='.$yojanaId);
        
        
        
        
    } else if(isset($_GET['yojanaId'])){
        
        /*
        
        Scheme plannedDate and actualDate by section eng;
        
        
        */
        
        
        $yojanaId = $_GET['yojanaId'];
        foreach ($_POST['subWorkId'] as $subWorkId){
            if($subWorkId == 14 || $subWorkId == 15){
                continue;
            }
            $subWorkId;
            $plannedDate = $_POST['plannedDate'.$subWorkId];
            $plannedEndDate = $_POST['plannedEndDate'.$subWorkId];
            $actualDate = $_POST['actualDate'.$subWorkId];
            $actualEndDate = $_POST['actualEndDate'.$subWorkId];
            $query = mysqli_query($con, "UPDATE `subWork` SET `plannedDate` = '$plannedDate', `plannedEndDate` = '$plannedEndDate', `actualDate` = '$actualDate', `actualEndDate` = '$actualEndDate' WHERE yojanaId = '$yojanaId' AND id = '$subWorkId'") or die($con->error);
        }
        
        if($query){
            $status = true;
            $msg = "Planned date and actual date is submitted successfully.";
        } else {
            $status = false;
            $msg = "Sorry, Planned date and actual date can't be submit. Please try again";
        }
        setSession($status, $msg);
        header('location: createYojana?yojanaId='.$yojanaId);
        
        
    }    
}

if(isset($_POST['expectionSubmit'])){
    
    // Requrest Extension
    
    $yojanaId = $_POST['yojanaId'];
    $expectionDate = $_POST['expectionDate'];
    $dateTime = date("Y-m-d H:i:s");
    $userId = $_SESSION['userId'];
    echo "INSERT INTO extension (`extensionDate`, `status`, `yojanaId`, `userId`, `dateTime`) VALUES ('$expectionDate', '$yojanaId', '$userId', '$dateTime')";
    $query = mysqli_query($con, "INSERT INTO extension (`extensionDate`, `status`, `yojanaId`, `userId`, `dateTime`) VALUES ('$expectionDate', 'processing', '$yojanaId', '$userId', '$dateTime')");
    if($query){
        $status = true;
        $msg = "Extension requires is send successfully.";
    } else {
        $status = false;
        $msg = "Sorry, extension requires can't be send. Please try again";
    }
    setSession($status, $msg);
    header('location: home');
}

if(isset($_GET['approved'])){
    
    // Approve Extension
    
    $id = $_GET['approved'];
    $dateTime = date("Y-m-d H:i:s");
    $userId = $_SESSION['userId'];
    $query = mysqli_query($con, "UPDATE `extension` SET `status`='approved', `userId`='$userId', `dateTime`='$dateTime' WHERE id =  '$id'");
    if($query){
        $status = true;
        $msg = "Extension approved successfully.";
    } else {
        $status = false;
        $msg = "Sorry, extension can't be approve. Please try again";
    }
    setSession($status, $msg);
    header('location: acceptExtension');
}


if(isset($_GET['rejected'])){
    
    // Reject Extension
    
    $id = $_GET['rejected'];
    $dateTime = date("Y-m-d H:i:s");
    $userId = $_SESSION['userId'];
    $query = mysqli_query($con, "UPDATE `extension` SET `status`='rejected', `userId`='$userId', `dateTime`='$dateTime' WHERE id =  '$id'");
    if($query){
        $status = true;
        $msg = "Extension rejected successfully.";
    } else {
        $status = false;
        $msg = "Sorry, extension can't be rejecte. Please try again";
    }
    setSession($status, $msg);
    header('location: acceptExtension');
}


if(isset($_GET['delete'])){
    
     /*
        
        Scheme delete by clerk;
        
        
    */
    
    $yojanaId = $_GET['delete'];
    $query1 = mysqli_query($con, "DELETE FROM `subWork` WHERE yojanaId = '$yojanaId' ");
    $query2 = mysqli_query($con, "DELETE FROM `uploadDoc` WHERE yojanaId = '$yojanaId' ");
    $query3 = mysqli_query($con, "DELETE FROM `allocatedYojana` WHERE yojanaId = '$yojanaId' ");
    $query4 = mysqli_query($con, "DELETE FROM `yojanaMaster` WHERE yojanaId = '$yojanaId' ");
    $query5 = mysqli_query($con, "DELETE FROM `stepOne` WHERE yojanaId = '$yojanaId' ");
    $query6 = mysqli_query($con, "DELETE FROM `stepTwo` WHERE yojanaId = '$yojanaId' ");
    $query7 = mysqli_query($con, "DELETE FROM `stepThree` WHERE yojanaId = '$yojanaId' ");
    $query8 = mysqli_query($con, "DELETE FROM `stepFour` WHERE yojanaId = '$yojanaId' ");
    $query9 = mysqli_query($con, "DELETE FROM `stepFive` WHERE yojanaId = '$yojanaId' ");
    $query10 = mysqli_query($con, "DELETE FROM `finance` WHERE yojanaId = '$yojanaId' ");
    $query11 = mysqli_query($con, "DELETE FROM `uploadDoc` WHERE yojanaId = '$yojanaId' ");
    $query12 = mysqli_query($con, "DELETE FROM `extension` WHERE yojanaId = '$yojanaId' ");
    $query13 = mysqli_query($con, "DELETE FROM `schedule` WHERE yojanaId = '$yojanaId' ");
    $query14 = mysqli_query($con, "DELETE FROM `agreement` WHERE yojanaId = '$yojanaId' ");
    
    if($query4 && $query3 && $query2 && $query1){
            $status = true;
            $msg = "Scheme is deleted successfully.";
        } else {
            $status = false;
            $msg = "Sorry, Scheme can't be delete. Please try again";
        }
    setSession($status, $msg);
    header('location: yojanaList');
}

?>