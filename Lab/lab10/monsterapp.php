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
<h1>Web Programming – Lab10</h1>
<?php
require_once ("monsterclass.php"); // include the monster class
$monster1 = new Monster("1","red"); // creates a red monster with 1 eye
$monster2 = new Monster("3","blue"); // creates a blue monster with 3 eyes


$mess1 = $monster1->describe();
$mess2 = $monster2->describe();

echo "<p> $mess1</p>";
echo "<p> $mess2</p>";

?>
</body>
</html>
