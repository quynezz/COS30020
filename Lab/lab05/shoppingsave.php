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
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"]) && isset($_POST["quantity"])) { // check if both form data exists
    // Variables
    $filename = "./data/shop.txt";
    $item = $_POST["name"]; // obtain the form item data
    $qty = $_POST["quantity"]; // obtain the form quantity data
    if ($qty > 0) {
        $handle = fopen($filename, "a"); // open the file in append mode
        $data = "$item," . $qty . PHP_EOL; // concatenate item and qty delimited by comma
        echo fwrite($handle, $data); // write string to text file
        fclose($handle); // close the text file

        echo "<p>Shopping List</p>"; // generate shopping list
        $handle = fopen($filename, "r"); // open the file in read mode
        while (!feof($handle)) { // loop while not end of file
            $data = fgets($handle); // read a line from the text file
            echo "<p>", $data, "</p>"; // generate HTML output of the data
        }
        fclose($handle); // close the text file
    } else {
        echo "<p> Please enter an valid quantity </p>";
    }
} else { // no input
    echo "<p>Please enter item and quantity in the input form.</p>";
}

?>
</body>

</html>
