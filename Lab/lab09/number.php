<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<?php
session_start(); // start the session
if (!isset($_SESSION["number"])) { // check if session variable exists
  $_SESSION["number"] = 0; // create the session variable
}
$num = $_SESSION["number"]; // copy the value to a variable
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Lab 9</title>
</head>

<body>
  <h1>Web Programming - Lab09</h1>
  <?php
  echo "<p>The number is $num</p>"; // displays the number
  ?>
  <p><a href="numberup.php">Up</a></p>
  <p><a href="numberdown.php">Down</a></p>
  <p><a href="numberreset.php">Reset</a></p>
</body>

</html>
