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

$dir = "../../data";
umask(0007);
if(!is_dir($dir)) {
    mkdir($dir, 02770);
}
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["first_name"]) && isset($_POST["last_name"])) { // check if both form data exists
    // Variables
    $filename = "../../data/lab05/guestbook.txt";
    $firstName = $_POST["first_name"]; // obtain the form item data
    $lastName = $_POST["last_name"]; // obtain the form quantity data
    if(!empty($firstName) && !empty($lastName)) {
        $firstName= str_replace(" ", "", trim($firstName));
        $lastName= str_replace(" ", "", trim($lastName));
        $data = "$firstName," . $lastName. PHP_EOL;
        if(!file_exists($filename)){
            file_put_contents($filename,stripcslashes($data));
        }else{
            $handle = fopen($filename, "a"); // open the file in append mode
            fwrite($handle,addslashes($data));
            fclose($handle); // close the text file
            echo "<p style='color: green;'><strong>Thank you for sigining our guest book!</strong></p>\n";
        }
    }else{
        echo "<p style='color: red;'><strong>You must enter your first and last name !</strong></p>\n";
        echo "<p style='color: red;'><strong>Use the Browers's \"Go Back\" to return to the Guestbook form</strong></p>\n";
        echo "<p> or click the link below to navigate back";
    }
} else { // no input
    echo "<p>Please enter your first name and last name in the input form.</p>";
}
echo "<p><a href='guestbookshow.php'>Show guest book</p>";
echo "<p><a href='guestbookform.php'>Return to guest form</p>";
?>
</body>

</html>


