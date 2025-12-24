<?php 
    include('include/con.php');
    $username = $_POST['username'];
    $password = $_POST['password'];
    $check = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");
    $count = mysqli_num_rows($check);
    $res = mysqli_fetch_assoc($check);
    if($count>0)
    {
        $result["status"] = TRUE;
	    $result["remarks"] = $res['userId'];
	    
    }
    else {
        $result["status"] = FALSE;
	    $result["remarks"] = "Username or Password is incorrect";
    }
    print(json_encode($result));
?>