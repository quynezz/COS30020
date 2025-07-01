<!DOCTYPE html>
<html lang="en">
<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->
<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <link rel="stylesheet" href="style/style.css">
      <title>Add new VIP member form</title>
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
    <label for="gender">Gender:</label>
    <br>
    <input type="text" id="gender" name="gender" max="1"/>

    <br>
    <label for="phone">Phone number:</label>
    <br>
    <input type="phone" id="phone" name="phone" />

    <br>
    <br>

    <button type="submit">Sign</button>
    <button type="reset">Reset Form</button>
    <br>
    <br>
    <a href="member_display.php">View VIP member</a>
  </form>
</body>

</html>
