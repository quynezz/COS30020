<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="" />
  <title>Document</title>
</head>


<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Lab 04 - Task 2 - Perfect Palindrome</h1>
  <?php

  if (isset($_POST["str"])) {
    $str = $_POST["str"];
    // reverse_str for checking
    $reverse_str = strrev($str);
    if ($reverse_str == $str) {
      echo "The text you just type $str <strong>is </strong>a perfect palindrome!";
    } else {
      echo "The text you just type $str <strong>is not</strong> a perfect palindrome!";
    }
  } else {
    echo "<p>Please enter string from the input form.</p>";
  }


  ?>
</body>

</html>
