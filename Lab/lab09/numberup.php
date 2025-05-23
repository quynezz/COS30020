<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<?php
$url = "number.php";

session_start(); // start the session
$num = $_SESSION["number"]; // copy the value to a variable
$num++; // increment the value
$_SESSION["number"] = $num; // update the session variable
header('Location: ' . $url); // redirect to number.php
?>
