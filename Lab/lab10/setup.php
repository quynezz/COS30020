<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title></title>
</head>

<body>
  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->

  <h1>Web Programming - Lab10</h1>

  <?php
  require_once("mysql_settings.php");


  // Main database
  $conn = @mysqli_connect($host, $user, $pwd, $sql_db);

  // Connect to mysql server
  if ($conn->error) {
    echo ("Connection failed: " . @mysqli_errno($conn) . " " . @mysqli_error($conn));
  } else {
    echo "<p> No error at connection</p>";
  }

  // check if table exists
  if (!@mysqli_select_db($conn, $sql_db)) {
    echo ("No match database" . @mysqli_error($conn));
  } else {
    echo "<p> Database setted successfully!</p>";
  }

  // check if the table is exist in the database
  $table = 'hitcounter';

  $query = "SELECT TABLE_NAME
          FROM INFORMATION_SCHEMA.TABLES
          WHERE TABLE_SCHEMA = '$sql_db'
          AND TABLE_NAME = '$table'";

  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) {
    echo "Table $table exists";
  } else {

    // Creating table if not exists
    $create_table_query = "CREATE TABLE $table (
      id SMALLINT NOT NULL,
      hits SMALLINT NOT NULL,
      PRIMARY KEY (id)
    )";
    $table_created = @mysqli_query($conn, $create_table_query);
    if (!$table_created) {
      echo "Failed to creating $table table" . @mysqli_errno($conn) . " " . @mysqli_error($conn);
    } else {
      echo "Successfully created the $table table";
      echo "<br>";
    }
  }
  // Inser value int hitcounter table
  $insert_query =  "INSERT INTO hitcounter (id,hits)
                    VALUES ('1','0')";

  if(@mysqli_query($conn,$insert_query)){
    echo "Successfully insert value into $table";
  }


  mysqli_close($conn);
  ?>
</body>

</html>
