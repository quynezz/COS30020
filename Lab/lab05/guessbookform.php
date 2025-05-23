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
  <hr>
  <h3>Enter your detail to sign our guest book</h3>
  <form action="guessbooksave.php" method="post">

    <label>FirstName:</label>
    <input type="text" name="first_name"></input><br>

    <label>LastName:</label>
    <input type="text" name="last_name"></input><br><br>

    <button type="submit" value="Submit">Save item</button><br>

  </form>
</body>

</html>
