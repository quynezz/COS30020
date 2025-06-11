<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="author" content="LauNgocQuyen" />
    <link rel="stylesheet" href="./style/index.css">
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["email"])) {
    $name = stripslashes($_POST["name"]) ?? "";
    $email =  stripslashes($_POST["email"]) ?? "";

    // Validate inputs
    if (empty($name) || empty($email)) {
        echo "<p class='error'>Name and email are required.</p>";
        // built-in function
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // this is traditional method regex
        //if (preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        echo "<p class='error'>Invalid email address.</p>";
    } else {

        // Read existing entries
        $entries = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];

        // If the file empty or does no exists
        if(count($entries) <= 0) {
            echo "<p class='error'>This file does not exists.</p>";
            return;
        }
        $names = [];
        $emails = [];
        foreach ($entries as $entry) {
            [$n, $e] = explode(",", $entry, 2);
            // this could use array_push()
            $names[] = trim($n);
            $emails[] = trim($e);
        }
        // Check for duplicates
        if (in_array($name, $names)) {
            echo "<p class='error'>This name already exists.</p>";
        } elseif (in_array($email, $emails)) {
            echo "<p class='error'>This email already exists.</p>";
        } else {
            // Ensure directory exists (return parent dir)
            $dir = dirname($filename);
            if (!is_dir($dir)) mkdir($dir, 0755, true);

            // Append new entry
            $data = "$name,$email\n";
            if (file_put_contents($filename, $data, FILE_APPEND) != 0) {
                echo "<p class='success'>Thank you for signing our guestbook!</p>";
                echo "<p><strong>Name</strong>: $name</p>";
                echo "<p><strong>Email:</strong> $email</p>";
            } else {
                echo "<p class='error'>Error saving new visitor.</p>";
            }
        }
    }
}
?>
  <hr>
  <a href="guestbookform.php">Add new visitor</a>
  <a href="guestbookshow.php">View guest book</a>
</body>

</html>
