<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Lab 03 - Task - Prime Number</h1>
  <hr>
  <?php
  function primeCheck($number)
  {
    if ($number == 1)
      return 0;
    for ($i = 2; $i <= $number / 2; $i++) {
      if ($number % $i == 0)
        return 0;
    }
    return 1;
  }

  if (isset($_GET["num"])) {
    $num = $_GET["num"];
    if (is_numeric($num) && $num > 0 && $num == round($num)) {
      primeCheck($num)
        ? print("<p style='color: blue'>The number you entered $num <storng>is</strong> a prime number.</p>")
        : print("<p style='color: red'>The number you entered $num <strong>is not</strong> a prime number.</p>");
    } else {
      echo "<p>Please enter a positive integer.</p>";
    }
  } else {
    echo "<p>Please enter a positive integer.</p>";
  }
?>
</body>

</html>
