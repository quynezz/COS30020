<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
    <link rel="stylesheet" href="style/index.css">
  <title>Guestbook</title>
  </head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Lab 06 - Task 2 - Guestbook</h1>
  <h2>Sign Guestbook</h2>
  <hr>
<?php
$filename = "./data/shop.txt";

$file_arr = array();
if (file_exists($filename)) {
    $file_open = fopen($filename, "r");
    while (!feof($file_open)) {
        $single_arr = fgets($file_open);
        $single_arr = explode(",", trim($single_arr));
        $name = $single_arr[0];
        $email = $single_arr[1];
        // there will be a endline line
        if($name == "" && $email == "") continue;
        // 2d array
        $temporary_arr = array($name, $email);
        array_push($file_arr, $temporary_arr);
    }
    sort($file_arr);
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
