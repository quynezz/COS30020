<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development"/>
  <meta name="keywords" content="PHP"/>
  <meta name="LauNgocQuyen" content="104198996"/>
  <title>Shopping Save</title>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Web Programming - Lab 5</h1>

<?php // read the comments for hints on how to answer each item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["quantity"]) && !empty($_POST["name"]) && !empty($_POST["quantity"])) { // check if both form data exists
    umask(0777);

    $filename = "../../data/lab05/shop.txt";

    $item = $_POST["name"];
    $qty = $_POST["quantity"];

    $item = str_replace(" ", "", $item);
    //$item = preg_replace("#[[:punct:]]#", "", trim($item));

    $item = addslashes($item);

    if ($qty > 0) {
        $data = "$item," . $qty . PHP_EOL;
        if(!file_exists($filename)){
            chmod($filename,02770);
            file_put_contents($filename,$data);
            // Set permission inorder to save the data
        }else{
            $handle = fopen($filename, "a");
            fwrite($handle, $data);
            fclose($handle); // close the text file
        }
        echo "<p>Shopping List</p>";
        $handle = fopen($filename, "r");
        while (!feof($handle)) {
            $data = fgets($handle);
            echo "<p>", stripcslashes($data), "</p>";
        }
        fclose($handle);
    } else {
        echo "<p> Please enter an valid quantity </p>";
        echo "<a href='shoppingform.php'>Click here to enter quantity</a>";
    }
} else { // no input
    echo "<p>Please enter item and quantity in the input form.</p>";
    echo "<a href='shoppingform.php'>Click here to enter item and quanity</a>";
}

?>
</body>

</html>
