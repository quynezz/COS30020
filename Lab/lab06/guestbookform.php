<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="author" content="LauNgocQuyen" />
  <title>Guestbook Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 600px;
      margin: 20px auto;
    }
    h1 {
      color: #333;
    }
    form {
      margin-top: 20px;
    }
    label {
      display: inline-block;
      width: 80px;
      margin-bottom: 10px;
      font-weight: bold;
    }
    input[type="text"] {
      width: 250px;
      padding: 6px;
      border: 1px solid #ddd;
      border-radius: 3px;
    }
    button, a {
      display: inline-block;
      padding: 6px 12px;
      margin: 5px 5px 5px 0;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 3px;
      text-decoration: none;
      cursor: pointer;
    }
    button[type="button"] {
      background-color: #ccc;
      color: #333;
    }
    button:hover, a:hover {
      background-color: #45a049;
    }
    button[type="button"]:hover {
      background-color: #bbb;
    }
  </style>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Lab 06 - Task 2 - Guestbook</h1>
  <form action="guestbooksave.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" />
    <br>
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" />
    <br>
    <button type="submit">Sign</button>
    <button type="reset">Reset Form</button>
    <br>
    <a href="guestbookshow.php">View Guestbook</a>
  </form>
</body>

</html>
