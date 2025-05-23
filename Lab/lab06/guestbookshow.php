<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Guestbook</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      max-width: 800px;
      margin-left: auto;
      margin-right: auto;
    }

    h1,
    h2 {
      color: #333;
    }

    hr {
      border: 1px solid #ccc;
      margin: 20px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
      color: #333;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    tr:hover {
      background-color: #f5f5f5;
    }
  </style>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Lab 06 - Task 2 - Guestbook</h1>
  <h2>Sign Guestbook</h2>
  <hr>
  <?php
  $filename = "./data/shop.txt";

  if (file_exists($filename)) {
    $file_open = fopen($filename, "r");
    $file_arr = array();
    while (!feof($file_open)) {
      $single_arr = fgets($file_open);
      $single_arr = explode(",", $single_arr);
      $name = $single_arr[0];
      $email = $single_arr[1];

      // 2d array
      $temporary_arr = array($name, $email);
      array_push($file_arr, $temporary_arr);
    }
    fclose($file_open); // Close the file
  }

  echo "<table>";
  echo "<tr>";
  echo "<th>Number</th>";
  echo "<th>Name</th>";
  echo "<th>Email</th>";
  echo "</tr>";

  $k = 1; // Start numbering from 1
  // Loop through the results and print each row
  for ($i = 0; $i < count($file_arr) - 1; $i++) {
    $name = trim($file_arr[$i][0]); // Trim whitespace
    $email = trim($file_arr[$i][1]); // Trim whitespace
    echo "<tr>";
    echo "<td>$k</td>";
    echo "<td>$name</td>";
    echo "<td>$email</td>";
    echo "</tr>";
    $k++;
  }
  // Close the table
  echo "</table>";
  ?>
  <a href="guestbookform.php">Add new visitor</a>
</body>

</html>
