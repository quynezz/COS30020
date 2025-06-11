<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
<link rel="stylesheet" href="./style/index.css">
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Guestbook Form</title>
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
    <br>
    <br>
    <a href="guestbookshow.php">View Guestbook</a>
  </form>
</body>

</html>
