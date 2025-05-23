<!DOCTYPE html> <html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />


  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->

<body>
  <?php
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $email = $_POST["email"];

  require_once("settings.php");

  if (isset($fname) && isset($lname) && isset($email) && !empty("$fname") && !empty("$lname") && !empty("$email")) {
    // connect to db
    $connnect_to_db = @mysqli_connect($host, $user, $pwd, $sql_db);


    if ($connnect_to_db->connect_error) {
      echo ("Failed to connect to db: " . @mysqli_errno($connnect_to_db) . @mysqli_error($connnect_to_db));
    }

    // check if the table is existed
    $query_check_exists = "DESCRIBE vipmembers";
    $table_exists = @mysqli_query($connnect_to_db, $query_check_exists);


    if ($table_exists === false) {
      // if no table, crreate new one
      $create_new_db_query = "CREATE TABLE vipmembers (
        member_id MEDIUMINT NOT NULL AUTO_INCREMENT,
        fname varchar(255) NOT NULL,
        lname varchar(255),
        email varchar(255),
        PRIMARY KEY (member_id)
)";
      $create_new_table = @mysqli_query($connnect_to_db, $create_new_db_query);
    } else {
      // insert new data from user
      $insert_new_member_query = "INSERT INTO vipmembers (fname,lname,email)
                                  VALUES ('$fname','$lname','$email')
";

      // successfully inserted
      if (@mysqli_query($connnect_to_db, $insert_new_member_query)) {
        echo "<h1> New VIP member have successfully inserted </h1>";
        echo "FirstName: $fname";
        echo "<br>";
        echo "LastName: $lname";
        echo "<br>";
        echo "Email: $email";
        echo "<br>";

      } else {
        // display err code and err mess
        echo "Failed to insert new member:" . @mysqli_errno($connnect_to_db) . ' ' . @mysqli_error($connnect_to_db);
      }
    }
  } else {
    echo "Please fill all the required inputs!";
  }

  ?>

  <a href="member_display.php">Display VIP members</a>
</body>

</html>
