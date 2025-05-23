<!DOCTYPE html>
<html lang="en">

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Add new VIP member form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f5f5f5;
      color: #333;
    }

    h1 {
      color: #2c3e50;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
      max-width: 500px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
    }

    input {
      padding: 8px;
      width: 100%;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin-bottom: 10px;
    }

    button {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #2980b9;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      max-width: 600px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #3498db;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    a {
      display: inline-block;
      margin-top: 20px;
      color: #3498db;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>

</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Lab 08 - Vip Member Form</h1>
  <form action="member_add.php" method="POST">
    <label for="fname">Enter your first name:</label>
    <br>
    <input type="text" id="fname" name="fname" />

    <br>
    <label for="lname">Enter your last name:</label>
    <br>
    <input type="text" id="lname" name="lname" />

    <br>
    <label for="email">Email:</label>
    <br>
    <input type="text" id="email" name="email" />

    <br>
    <button type="submit">Sign</button>
    <button type="reset">Reset Form</button>

    <br>
    <a href="member_display.php">View VIP member</a>
  </form>
</body>

</html>
