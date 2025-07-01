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
$gender = $_POST["gender"];
$phone = $_POST["phone"];

require_once("settings.php");

if (isset($fname) && isset($lname) && isset($email) && !empty($fname) && !empty($lname) && !empty($email) && !empty($gender) && !empty($phone)) {
    // connect to db
    $connnect_to_db = @mysqli_connect($host, $user, $pwd, $sql_db);


    if ($connnect_to_db->connect_error) {
        echo ("Failed to connect to db: " . @mysqli_errno($connnect_to_db) . @mysqli_error($connnect_to_db));
    }

    // check if the table is existed
    $query_check_exists = "SHOW TABLES LIKE 'vipmembers'";
    $table_exists = @mysqli_query($connnect_to_db, $query_check_exists);


    if (@mysqli_num_rows($table_exists) == 0) {
        // if no table, crreate new one
        $create_new_db_query = "CREATE TABLE vipmembers (
            member_id MEDIUMINT NOT NULL AUTO_INCREMENT,
            fname varchar(255) NOT NULL,
            lname varchar(255),
            gender varchar(1),
            email varchar(255),
            phone varchar(20),
            PRIMARY KEY (member_id)
)";
        @mysqli_query($connnect_to_db, $create_new_db_query);
    } else {
        // sanitize user inputs
        $fname = @mysqli_real_escape_string($connnect_to_db, $fname);
        $lname = @mysqli_real_escape_string($connnect_to_db, $lname);
        $email = @mysqli_real_escape_string($connnect_to_db, $email);
        $gender = @mysqli_real_escape_string($connnect_to_db, $gender);
        $phone = @mysqli_real_escape_string($connnect_to_db, $phone);
        // check if the email is already existed
        $check_email_query = "SELECT email FROM vipmembers WHERE email = '$email'";
        $email_exists = @mysqli_query($connnect_to_db, $check_email_query);
        if (@mysqli_num_rows($email_exists) > 0) {
            echo "<h1> This email already exists in the database! </h1>";
            echo "<a href='member_add_form.php'>Go back to add new member</a>";
            exit();
        }
        // sanitize the email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        // validate the email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<h1> Invalid email format! </h1>";
            echo "<a href='member_add_form.php'>Go back to add new member</a>";
            exit();
        }
        // validate the phone number
        if (!preg_match('/^\d{10}$/', $phone)) {
            echo "<h1> Invalid phone number! </h1>";
            echo "<a href='member_add_form.php'>Go back to add new member</a>";
            exit();
        }
        // validate the gender length
        // G for ... (iykyk =))) )
        if (strlen($gender) > 1 || !in_array($gender, ['M', 'F', 'G'])) {
            echo "<h1> Invalid Gender input! </h1>";
        }
        // insert new data from user
        $insert_new_member_query = "INSERT INTO vipmembers (fname,lname,email, gender, phone)
            VALUES ('$fname','$lname','$email', '$gender', '$phone')";

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
