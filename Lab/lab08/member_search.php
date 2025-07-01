<html lang="en">
<!DOCTYPE html>

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Search for VIP Members</title>
  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->
</head>

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

require_once("settings.php");

// Check if the Variables exists
if (isset($_POST["lname"]) && !empty($_POST["lname"])) {
    $lname = $_POST["lname"];
    $connect_to_db = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($connect_to_db->connect_error) {
        die("Failed to connect to database" . @mysqli_errno($connect_to_db) . @mysqli_error($connect_to_db));
    }

    $query_to_retrieve_data = "SELECT member_id, fname, lname, gender, phone
        FROM vipmembers
        WHERE lname
        LIKE '%$lname%' ";
    $result = @mysqli_query($connect_to_db, $query_to_retrieve_data);
    if ($result === false) {
        echo "Error to fetch data: " . @mysqli_errno($connect_to_db) . @mysqli_error($connect_to_db);
    }

    // Fetching rows
    $row = @mysqli_fetch_row($result);

    // Displaying the number of rows found
    $rowLength = @mysqli_num_rows($result);
    echo "<h1>Search results for: $rowLength </h1>";
    if ($rowLength < 0) {
        echo "<h1>No result rows!</h1>";
    } else {
        // Displaying the table
        echo "<table width='36%' border='1'>";
        echo "<tr>
            <th>MemberID:</th>
            <th>First Name:</th>
            <th>Last Name:</th>
            <th>Gender:</th>
            <th>Phone:</th>
            </tr>";
    while ($row) {
        echo "<tr><td>{$row[0]}</td>";
        echo "<td>{$row[1]}</td>";
        echo "<td>{$row[2]}</td>";
        echo "<td>{$row[3]}</td>";
        echo "<td>{$row[4]}</td>";
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
