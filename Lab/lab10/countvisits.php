<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="description" content="Web application development" />
<meta name="keywords" content="PHP" />
<meta name="LauNgocQuyen" content="104198996" />
<title></title>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
<h1>Hit counter - Lab10</h1>
<?php

// Declare variables
$hit = 0;
$id = 0;
$table = "hitcounter";


// Require HitCounter Class
require_once ("hitcounter.php"); // include the monster class


// Require connection
require_once("mykeys.inc.php");

// Constructor
$counter = new HitCounter($hit,$id);

// DB connection
$conn = $counter->connection($host,$user,$pwd,$sql_db);

// Get hit and reassing the hit value with class data
$counter->getHits($conn,$table);
$hit = $counter->hit;
echo "<p> This is hit value after call <strong>getHits()</strong> function: $hit</p>";


// Set hit and increment the hit value
$counter->setHits($conn,$table);
$hit = $counter->hit;
echo "<p> This is hit value after call <strong>setHits()</strong> function: $hit </p>";

// Close the connection
$counter->closeConnection($conn);


echo "<a href='startover.php'>Start Over</a>"


?>
</body>
</html>

