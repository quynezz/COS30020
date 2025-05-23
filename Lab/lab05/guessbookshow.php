<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>TITLE</title>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Web Programming - Lab 5</h1>

  <?php // read the comments for hints on how to answer each item


  umask(0007);
  $filename = "../../data/lab05/guessbook.txt";
  if (!file_exists($dir)) {
    echo "<p style='color: red'>Guessbook is empy!</p>";
  } else {

    // Method 1: copy from the previous task
    $method_1 = fopen($filename, "r"); // open the file in read mode
    while (!feof($handle)) { // loop while not end of file
      $data = fgets($handle); // read a line from the text file
      echo "<p>", $data, "</p>"; // generate HTML output of the data
    fclose($method_1); // close the text file

    }


   // Method 2: Extra challange
  $method_2 = explode("\n", file_get_contents($filename));
  for ($item = 0; $item < count($method_2); $item++) {
    echo "$item: " . "$method_2[$item]" . PHP_EOL;
  }

 }


  ?>

</body>

</html>
