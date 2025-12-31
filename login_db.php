<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('include/con.php');
require_once('include/sweetAlert.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $query = mysqli_query(
        $con,
        "SELECT * FROM users WHERE username='$username' AND password='$password'"
    );

    if ($query && mysqli_num_rows($query) > 0) {

        $result = mysqli_fetch_assoc($query);

        $_SESSION['userId']      = $result['userId'];
        $_SESSION['designation'] = $result['designation'];
        $_SESSION['fullName']    = $result['fullName'];

        $userId   = $result['userId'];
        $dateTime = date('Y-m-d H:i:s');

        mysqli_query(
            $con,
            "INSERT INTO loginLog (userId, dateTime) VALUES ('$userId', '$dateTime')"
        );

        // Decide redirect URL
        $redirectUrl = 'home.php';

        if ($result['designation'] === 'clerk') {
            $redirectUrl = 'createYojana';
        } elseif (
            $result['designation'] === 'admin' ||
            $result['designation'] === 'executiveEng'
        ) {
            $redirectUrl = 'index';
        } elseif ($result['designation'] === 'contractor') {
            $redirectUrl = 'agreementReport';
        }

        echo "<script>window.location.href='$redirectUrl';</script>";
        exit;

    } else {

        $status = false;
        $msg = "Invalid Username or password. Please try again";
        setSession($status, $msg);

        echo "<script>window.location.href='login';</script>";
        exit;
    }
}
?>
