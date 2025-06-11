<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Shopping Form</title>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Web Programming Form - Lab 5</h1>
  <form action="shoppingsave.php" method="POST">
    <label>Please enter the item name:</label>
        <br>
    <input type="text" name="name"></input>
        <br>
    <label>Please enter the quantity:</label>
        <br>
    <input type="number" name="quantity"></input>
        <br>
    <button type="submit">Save item</button>
  </form>
</body>

</html>
