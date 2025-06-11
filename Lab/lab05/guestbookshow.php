<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Guess Book Show</title>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Web Programming - Lab 5</h1>

<?php
umask(0007);
$filename = "../../data/lab05/guestbook.txt";
if (!file_exists($filename)) {

    echo "<p style='color: red'>There is no guestbook file found!</p>";
    echo "<a href='guestbookform.php'>Click here to add again </a>";

} else {
    // Method 1: copy from the previous task
    echo "<h2> Method 1: Using traditional open, read and close</h2>";
    $method_1 = fopen($filename, "r");
    $count = 0;
    while (!feof($method_1)) {
        // Check for last empty line
            $data = fgets($method_1);
            if(!empty($data)){
                echo "<p>" , "$count: ", stripcslashes($data), "</p>";
                $count++;
            }
    }
    fclose($method_1); // close the text file



    echo "------------------------------------------------------------";
    echo "</br>";
    echo "</br>";

    // Method 2: Extra challenge
    // This method will explode each line and form it into a array
    echo "<h2> Method 2: Break each line into a sub-arr and using for-loop</h2>";
    $method_2 = explode("\n", file_get_contents($filename));

    // The reasion why i use "-1" but not the length is because after explode to the final line, it still end-of-line and put the empty line into a array;
    for ($i = 0; $i < count($method_2) - 1; $i++) {
        echo "$i:", stripslashes($method_2[$i]);
        echo "</br>";
        echo "</br>";
    }
}

echo "</br>";
echo "</br>";

echo "<a href='guestbookform.php' style='text-decoration: none; color: green; font-size: 24px;'>Click here to add again </a>";

?>

</body>

</html>
