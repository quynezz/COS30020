<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>TITLE</title>
</head>

<body>
  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->

  <h1>Task 2: Guess Game</h1>


  <?php
  session_start();


  $hidden_number = $_SESSION["guess_number"];

  if (isset($hidden_number) && !empty($hidden_number)) {
    echo "<p>The hidden number was: $hidden_number</p>";
  }
  ?>


  <a href="startover.php">Start Over</a>
</body>

</html>
