<?php 
/*    include('include/con.php');
  $fetch = mysqli_query($conn,"SELECT yojanaId, yojanaName, village, taluka, sec_eng FROM yojanaMaster");
  while($res=mysqli_fetch_assoc($fetch)){
      $data[] = $res;
  }
  print(json_encode($data));*/
?>


<?php 
include('include/con.php');
$fetch = mysqli_query($conn,"SELECT yojanaId, yojanaName, village, taluka, sec_eng FROM yojanaMaster");
while($res=mysqli_fetch_assoc($fetch)){
    $q = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '{$res['yojanaId']}' AND subWork = 'Percolation Well'");
    $r = mysqli_fetch_assoc($q);
    $percolationDiameter = $r['diameter'];
    $percolationDepth = $r['depth'];
    
    $q = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '{$res['yojanaId']}' AND subWork = 'Pumping Machinery' ORDER BY id DESC");
    $r = mysqli_fetch_assoc($q);
    $pumpingBhp = $r['bhp'];
    
    $q = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '{$res['yojanaId']}' AND subWork = 'Rising Main' ORDER BY id DESC");
    $r = mysqli_fetch_assoc($q);
    $risingLength = $r['length'];
    $risingMaterial = $r['typePipe'];
    
    $q = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '{$res['yojanaId']}' AND subWork = 'RCC ESR' ORDER BY id DESC");
    $r = mysqli_fetch_assoc($q);
    $esrCapacity = $r['capacity'];
    
    $q = mysqli_query($con, "SELECT * FROM subWork WHERE yojanaId = '{$res['yojanaId']}' AND subWork = 'Distribution System' ORDER BY id DESC");
    $r = mysqli_fetch_assoc($q);
    $distributionLength = $r['length'];
    $distributionMaterial = $r['typePipe'];
    
    $data[] = array(
        "yojanaId"=>$res['yojanaId'],
        "yojanaName"=>$res['yojanaName'],
        "village"=>$res['village'],
        "taluka"=>$res['taluka'],
        "sec_eng"=>$res['sec_eng'],
        "percolationDepth"=>$percolationDepth,
        "percolationDiameter"=>$percolationDiameter,
        "pumpingBhp"=>$pumpingBhp,
        "risingMaterial"=>$risingMaterial,
        "risingLength"=>$risingLength,
        "esrCapacity"=>$esrCapacity,
        "distributionMaterial"=>$distributionMaterial,
        "distributionLength"=>$distributionLength
        );
}
print_r(json_encode($data));
?>