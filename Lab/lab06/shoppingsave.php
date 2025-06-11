<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>Shopping Save</title>
</head>

<!--Student_Name: LauNgocQuyen-->
<!--Student_ID: 104198996-->

<body>
  <h1>Web Programming - Lab 6</h1>


<?php
// change later
$filename = "./data/shop.txt";

if (isset($_POST["item"]) && isset($_POST["qty"]) && !empty(trim($_POST["item"])) && !empty(trim($_POST["qty"]))) {
    $item = stripslashes(trim($_POST["item"]));
    $qty = stripslashes(trim($_POST["qty"]));

    $alldata = array();
    $itemdata = array();

    if (file_exists($filename) && filesize($filename) > 0) {
        $handle = fopen($filename, "r");
        while (!feof($handle)) {
            $onedata = fgets($handle);
            if ($onedata && trim($onedata) !== '') {
                $data = explode(",", trim($onedata));
                if (count($data) >= 2 && !empty(trim($data[0])) && !empty(trim($data[1]))) {

                    // Could use push or unshift
                    $alldata[] = $data;
                    $itemdata[] = $data[0];
                }
            }
        }
        fclose($handle);
    }

    $newdata = in_array($item, $itemdata);
    if (!$newdata) {
        $handle = fopen($filename, "a");
        $data = $item . "," . $qty . "\n";
        fputs($handle, $data);
        fclose($handle);

        $alldata[] = array($item, $qty);

        echo "<p>Shopping item added</p>";

        // Sort by name
        usort($alldata, function($a, $b) {
            return $a[0] > $b[0];
        });

        echo "<p>Shopping List</p>";
        foreach ($alldata as $data) {
            echo htmlspecialchars(trim($data[0])) . " --- " . htmlspecialchars(trim($data[1])) . "<br>\n";
        }
    } else {
        echo "<p>Shopping item already exists</p>";
    }
} else {
    echo "<p>Please enter item name and quantity</p>";
}
?>
</body>

</html>
