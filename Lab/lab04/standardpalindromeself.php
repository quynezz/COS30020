 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="utf-8" />
   <meta name="description" content="Web application development" />
   <meta name="keywords" content="PHP" />
   <meta name="LauNgocQuyen" content="" />
   <title>TITLE</title>
 </head>


 <!--Student_Name: LauNgocQuyen-->
 <!--Student_ID: 104198996-->


 <!--HTML-->

 <body>
   <h1>Lab04 - Task 3 - Extra Challange Palindrome</h1>
   <form action="standardpalindromeself.php" method="post">
     <p>Enter a string: </p>
     <input type="text" name="str" />
     <br>
     <br>
     <button type="submit" value="Submit">Check palindrome</button>
   </form>
 </body>


 <!--PHP-->
 <?php

  if ($_SERVER["REQUEST_METHOD"] && isset($_POST["str"]) && !empty($_POST["srt"]) ) {
    // trim all the white space,remove all the punctuation and convert all into lower case
    $str = $_POST["str"];
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    $str = str_replace(" ", "", strtolower($str));
    $str = preg_replace("#[[:punct:]]#", "", $str);

    // reverse_str for checking
    $reverse_str = strrev($str);

    echo "<br>";
    if ($reverse_str == $str) {
      echo "The text you just type $str <strong>is </strong>a standard palindrome!";
    } else {
      echo "The text you just type $str <strong>is not</strong> a standard palindrome!";
    }
  } else {
    echo "<p>Please enter string from the input form.</p>";
  }
  ?>
 </html>
