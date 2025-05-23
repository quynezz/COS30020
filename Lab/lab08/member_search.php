<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Search for VIP Members</title>
  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->


</head>

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

  p {
    color: red;
  }
</style>

<body>
  <form action="member_search.php" method="POST">
    <label name="lname">Search for VIP members</label>
    <br>
    <input name="lname" id="lname" />
    <br>
    <br>
    <button type="submit">Find Now 🔍</button>
  </form>

  <?php

  // Variables declarations
  $lname = $_POST["lname"];

  // Check if the Variables exists
  if (isset($lname) && !empty($lname)) {
    require_once("settings.php");
    $connect_to_db = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($connect_to_db->connect_error) {
      die("Failed to connect to database" . @mysqli_errno($connect_to_db) . @mysqli_error($connect_to_db));
    }
    $query_to_retrieve_data = "SELECT member_id, fname, lname
      FROM vipmembers
      WHERE lname
      LIKE '%$lname%'
      ";
    $result = @mysqli_query($connect_to_db, $query_to_retrieve_data);
    if ($result === false) {
      echo "Error to fetch data: " . @mysqli_errno($connect_to_db) . @mysqli_error($connect_to_db);
    }

    // Fetching rows
    $row = @mysqli_fetch_row($result);
    if ($row < 0) {
      echo "<h1>No result rows!</h1>";
    } else {
      // Displaying the table
      echo "<table width='36%' border='1'>";
      echo "<tr>
          <th>MemberID:</th>
          <th>First Name:</th>
          <th>Last Name:</th>
        </tr>";
      while ($row) {
        echo "<tr><td>{$row[0]}</td>";
        echo "<td>{$row[1]}</td>";
        echo "<td>{$row[2]}</td>";
        $row = mysqli_fetch_row($result);
      }
    }
  } else {
    echo "<p>Please fill the search input</p>";
  }





  ?>

  <a href="member_add_form.php">Add new VIP member</a>
</body>

</html>
