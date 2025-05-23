<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="description" content="Web application development" />
  <meta name="keywords" content="PHP" />
  <meta name="LauNgocQuyen" content="104198996" />
  <title>TITLE</title>
</head>

<body>
  <!--Student_Name: LauNgocQuyen-->
  <!--Student_ID: 104198996-->

  <h1>Task 2: Guess Game</h1>
  <br>
  <p>Enter a number between 1 and 100,</p>
  <p>then press the Guess button</p>

  <!-- Guessing Section -->
  <form method="POST" action="guessgame.php">
    <input name="user_number" />
    <button type="submit">Guess</button>
  </form>



  <?php
  session_start();
  $generated_random_number = rand(10, 20);
  $random_number = 0;

  if (!isset($_SESSION["guess_number"])) {
    $_SESSION["guess_number"] = $generated_random_number;
    $random_number = $_SESSION["guess_number"];
  } else {
    $random_number = $_SESSION["guess_number"];
  }

  if (!isset($_SESSION["guessing_count"])){
    $_SESSION["guessing_count"] = 0;
  }


  // User guess number POST method
  $user_number = $_POST["user_number"];

  // Check if the input is number or not
  if (!is_numeric($user_number)) {
    echo "<p>Please enter number only!</p>";
    return;
  }



  if (isset($user_number) && !empty($user_number)) {
    // Increment the count
    $guessing_count = $_SESSION["guessing_count"];
    $guessing_count++;
    $_SESSION["guessing_count"] = $guessing_count;
    if ($user_number == $random_number) {
      echo "<p> Congratulation, You guessed the hidden number</p>";
      echo "<p>You have guess $guessing_count time!</p>";
    } else if ($user_number > $random_number) {
      echo "<p>Lower!</p>";
    } else {
      echo "<p>Higher!</p>";
    }
  } else {
    echo "<p class='danger'>Please enter your number</p>";
  }

  ?>
  <a href='giveup.php'>Give Up</a>
  <br>
  <a href='startover.php'>Start Over</a>


</body>


</html>
