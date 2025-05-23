<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="author" content="LauNgocQuyen" />
  <title>Guestbook</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 600px;
      margin: 20px auto;
    }
    h1, h2 {
      color: #333;
    }
    hr {
      border: 1px solid #ddd;
      margin: 15px 0;
    }
    .success {
      color: green;
    }
    .error {
      color: red;
    }
    a {
      display: inline-block;
      margin: 5px 0;
      padding: 6px 12px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 3px;
    }
    a:hover {
      background-color: #45a049;
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

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    // Validate inputs
    if (empty($name) || empty($email)) {
      echo "<p class='error'>Name and email are required.</p>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "<p class='error'>Invalid email address.</p>";
    } else {
      // Read existing entries
      $entries = file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
      $names = [];
      $emails = [];
      foreach ($entries as $entry) {
        [$n, $e] = explode(",", $entry, 2);
        $names[] = trim($n);
        $emails[] = trim($e);
      }

      // Check for duplicates
      if (in_array($name, $names)) {
        echo "<p class='error'>This name already exists.</p>";
      } elseif (in_array($email, $emails)) {
        echo "<p class='error'>This email already exists.</p>";
      } else {
        // Ensure directory exists
        $dir = dirname($filename);
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        // Append new entry
        $data = "$name,$email\n";
        if (file_put_contents($filename, $data, FILE_APPEND) !== false) {
          echo "<p class='success'>Thank you for signing our guestbook!</p>";
          echo "<p>Name: $name</p>";
          echo "<p>Email: $email</p>";
          echo "<hr>";
        } else {
          echo "<p class='error'>Error saving new visitor.</p>";
        }
      }
    }
  }
  ?>
  <a href="guestbookform.php">Add new visitor</a>
  <br>
  <a href="guestbookshow.php">View guest book</a>
</body>

</html>
