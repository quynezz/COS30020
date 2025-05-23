<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<?php
$url = "number.php";
session_start(); // start the session

session_unset(); // unset all the session variables

session_destroy(); // destroy all data associated with the session

header('Location: ' . $url);

?>
