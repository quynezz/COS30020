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
<h1>Start Over</h1>
<?php

// Declare variables
$table = "hitcounter";
$url = "countvisits.php";

// Require HitCounter Class
require_once("hitcounter.php"); // include the monster class

// Require connection
require_once("mykeys.inc.php");

// Constructor
$counter = new HitCounter($hit, $id);

// DB connection
$conn = $counter->connection($host, $user, $pwd, $sql_db);


$counter->startOver();
echo "Successfully reset !";


// Close the connection
$counter->closeConnection($conn);


echo "<br>";
echo "<a href='$url'>Count Again</a>"

?>
</body>
</html>


