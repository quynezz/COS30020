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
  <h1>Web Programming - Lab 6</h1>
  <?php

  $filename = "./data/shop.txt";

  if (isset($_POST["item"]) && isset($_POST["qty"])) {
    $item = $_POST["item"];
    $qty = $_POST["qty"];

    $alldata = array();
    if (file_exists($filename)) {
      $itemdata = array();
      $handle = fopen($filename, "r");
      while (!feof($handle)) {
        $onedata = fgets($handle);
        if ($onedata != "") {
          $data = explode(",", $onedata);
          $alldata[] = $data;
          $itemdata[] = $data[0];
        }
      }
      fclose($handle);
      $newdata = in_array($item, $itemdata);
      if (!$newdata) {
        $handle = fopen($filename, "a");
        $data = $item . "," . $qty . "\n";

        fputs($handle, $data);

        fclose($handle);

        $alldata[] = array($item, $qty);

        echo "<p>Shopping item added</p>";
      } else {
        echo "<p>Shopping item already exists</p>";
      }
      sort($alldata);
      echo "<p>Shopping List</p>";
      foreach ($alldata as $data) { // loop using for each
        echo "<p>", $data[0], " -- ", $data[1], "</p>";
      }
    } else {
      echo "<p>Please enter item and quantity in the input form</p>";
    }
  }
  ?>
</body>

</html>
