<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />


  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->

<body>
  <?php
  require_once("settings.php");
  $connect_to_db = @mysqli_connect($host, $user, $pwd, $sql_db);
  if ($connect_to_db->connect_error) {
    echo("Failed to connect to database" . @mysqli_errno($connect_to_db) . @mysqli_error($connect_to_db));
  }

  $query_to_retrieve_data = "SELECT member_id, fname, lname FROM vipmembers";
  $result = @mysqli_query($connect_to_db, $query_to_retrieve_data);

  if ($result === false) {
    echo "Error to fetch data: " . @mysqli_errno($connect_to_db) . @mysqli_error($connect_to_db);
  }

  // Fetching rows
  if ($row < 0) {
    echo "No result rows!";
  } else {
    // Displaying the table
    echo "<table width='36%' border='1'>";
    echo "<tr>
          <th>MemberID:</th>
          <th>First Name:</th>
          <th>Last Name:</th>
        </tr>";
  $row = @mysqli_fetch_row($result);
    while ($row = @mysqli_fetch_row($result)) {
      echo "<tr><td>{$row[0]}</td>";
      echo "<td>{$row[1]}</td>";
      echo "<td>{$row[2]}</td> </tr>";
    }
  }

  ?>

  <a href="member_add_form.php">Add new VIP member</a>
</body>

</html>
