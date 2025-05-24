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
  <h1>Lab05 - Task 2 - Sign Guestbook</h1>
<?php // read the comments for hints on how to answer each item

umask(0007);
$dir = "../../data/lab05";
if(!file_exists($dir)) {
    mkdir($dir, 02770);
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["first_name"]) && isset($_POST["last_name"])) { // check if both form data exists
    // Variables
    $filename = "../../data/lab05/guessbook.txt";
    $firstName = $_POST["first_name"]; // obtain the form item data
    $lastName = $_POST["last_name"]; // obtain the form quantity data
    if(!empty($firstName) && !empty($lastName)) {
        $handle = fopen($filename, "a"); // open the file in append mode
        $data = "$firstName," . $lastName. PHP_EOL; // concatenate item and qty delimited by comma
        fwrite($handle,$data);
        fclose($handle); // close the text file
        echo "<p style='color: green;'><strong>Thank you for sigining our guest book!</strong></p>\n";
    }else{
        echo "<p style='color: red;'><strong>You must enter your first and last name !</strong></p>\n";
        echo "<p style='color: red;'><strong>Use the Browers's \"Go Back\" to return to the Guestbook form</strong></p>\n";
    }
} else { // no input
    echo "<p>Please enter your first name and last name in the input form.</p>";
}
echo "<p><a href='guessbookshow.php'>Show guest book</p>"
?>
</body>

</html>


