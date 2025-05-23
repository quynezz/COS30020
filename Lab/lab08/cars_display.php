<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="author" content="Your Name" />
  <title>TITLE</title>
</head>

<body>
  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->

  <h1>Web Programming - Lab08</h1>
  <?php
  require_once("settings.php");
  // complete your answer based on Lecture 8 slides 26 and 44
  // ## 1. open the connection
  $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
  // Connect to mysql server
  if ($conn->error) {
    die("Connection failed: " . @mysqli_errno($conn) . " " . @mysqli_error($conn));
  }
  if (!@mysqli_select_db($conn, $sql_db)) {
    die("No match database" . @mysqli_error($conn));
  }
  $string_query = "SELECT car_id, make, model, price FROM cars";
  $queryResult = @mysqli_query($conn, $string_query);
  // ## 2. Display the cars table
  echo "<table width='50%' border='1'>";
  echo "<tr>
          <th>Car_id</th>
          <th>Make</th>
          <th>Model</th>
          <th>Price</th>
        </tr>";
  $row = mysqli_fetch_row($queryResult);
  while ($row) {
    echo "<tr><td>{$row[0]}</td>";
    echo "<td>{$row[1]}</td>";
    echo "<td>{$row[2]}</td>";
    echo "<td>{$row[3]}</td></tr>";
    $row = mysqli_fetch_row($queryResult);
  }
  echo "</table>";
  // ## 3. close the connection
  mysqli_free_result($queryResult);
  mysqli_close($conn);
  ?>
</body>

</html>
