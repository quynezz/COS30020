<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="LauNgocQuyen" id="104198996">
  <title>Process Job Posting</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="postjobprocess">
  <header>
    <h1><i class="fas fa-check-circle"></i> Process Job Posting</h1>
    <nav>
      <ul>
        <li><a href="index.php" <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'class="active"' : ''; ?>><i class="fas fa-home"></i> Home</a></li>
        <li><a href="searchjobform.php" <?php echo basename($_SERVER['PHP_SELF']) === 'searchjobform.php' ? 'class="active"' : ''; ?>><i class="fas fa-search"></i> Search</a></li>
        <li><a href="postjobform.php" <?php echo basename($_SERVER['PHP_SELF']) === 'postjobform.php' ? 'class="active"' : ''; ?>><i class="fas fa-briefcase"></i> Post</a></li>
        <li><a href="about.php" <?php echo basename($_SERVER['PHP_SELF']) === 'about.php' ? 'class="active"' : ''; ?>><i class="fas fa-info-circle"></i> About</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <section class="card">
<?php
session_start();

// Validation each field functions
function isValidPositionID($id)
{
    return preg_match('/^ID\d{3}$/', $id);
}

function isValidTitle($title)
{
    return preg_match('/^[a-zA-Z0-9,.! ]{1,10}$/', $title);
}

function isValidDescription($desc)
{
    return strlen($desc) <= 250;
}

function isValidDate($date)
{
    return preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $date);
}

function isPositionIDUnique($id, $file)
{
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $fields = explode("\t", $line);
        if ($fields[0] === $id) return false;
    }
    return true;
}

// Initialize errors arrays
$errors = [];

// In case change it from testing enviroment to Mercury server
$data_dir = "../assingment1/data/jobs";
$data_file = "position.txt";

// Full file path
$file_path = "$data_dir/$data_file";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $position_id = trim($_POST["positionID"] ?? "");
    $title = trim($_POST["title"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $closing_date = trim($_POST["closingDate"] ?? "");
    $position = $_POST["position"] ?? "";
    $contract = $_POST["contract"] ?? "";
    $location = $_POST["location"] ?? "";
    $application_by = $_POST["applicationBy"] ?? [];
    $app_post = in_array("post", $application_by) ? "post" : "";
    $app_email = in_array("email", $application_by) ? "email" : "";

    // Store all form data in session for repopulation
    $_SESSION["positionID"] = $position_id;
    $_SESSION["title"] = $title;
    $_SESSION["description"] = $description;
    $_SESSION["closingDate"] = $closing_date;
    $_SESSION["position"] = $position;
    $_SESSION["contract"] = $contract;
    $_SESSION["location"] = $location;
    $_SESSION["applicationBy"] = $application_by;

    // Validate inputs
    if (empty($position_id) || !isValidPositionID($position_id)) {
        $errors[] = "<strong>Position</strong> ID must be 5 characters starting with 'ID' followed by 3 digits.";
    } elseif (!isPositionIDUnique($position_id, $file_path)) {
        $errors[] = "<strong>Position ID</strong> must be unique.";
    }
    if (empty($title) || !isValidTitle($title)) {
        $errors[] = "<strong>Title</strong> can only contain a maximum of 10 alphanumeric characters including spaces, comma, period (full stop), and exclamation point";
    }
    if (empty($description) || !isValidDescription($description)) {
        $errors[] = "<strong>Description</strong> must be up to 250 characters.";
    }
    if (empty($closing_date) || !isValidDate($closing_date)) {
        $errors[] = "<strong>Closing Date</strong> must be in dd/mm/yy format.";
    }
    if (empty($position)) {
        $errors[] = "<strong>Position</strong> is required.";
    }
    if (empty($contract)) {
        $errors[] = "<strong>Contract</strong> is required.";
    }
    if (empty($location)) {
        $errors[] = "<strong>Location</strong> is required.";
    }
    if (empty($application_by)) {
        $errors[] = "At least <strong>one</strong> application method is required.";
    }

    // If no errors, proceed to save
    if (empty($errors)) {
        // Create directory -> and then store a 'position.txt' if both of them not exists
        if (!file_exists($data_dir)) {
            mkdir($data_dir, 0755, true);
            if(!is_file($file_path)){ // Check if the txt file exists
                // fully open, write and close
                file_put_contents($file_path, '');
            }
        }
        // Prepare data for error handling and saving data to file
        $record = implode("\t", [
            $position_id,
            $title,
            $description,
            $closing_date,
            $position,
            $contract,
            $location,
            $app_post,
            $app_email
        ]) . "\n";

        // Save to file
        $file = fopen($file_path, "a");
        if ($file) {
            fwrite($file, $record);
            fclose($file);
            // Clear session data after successful posting
            session_unset();
            session_destroy();
            echo '<p class="success-message"><i class="fas fa-check-circle"></i> Job vacancy posted successfully!</p>';
        }
        // Print out error message for process handling
        else {
            echo '<p class="error-message"><i class="fas fa-times-circle"></i> Error: Unable to save job vacancy.</p>';
        }
    } else {
        // Display filling errors section
        echo "<h2>Error(s) occurred:</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo '<p><a href="postjobform.php"> Re-fill the posting form</a><i class="fa-solid fa-question fa-bounce" style="color: #000000;"></i></p>';
    }
} else {
    echo '<p class="error-message"><i class="fas fa-times-circle"></i> Error: Invalid request method.</p>';
}
?>
      <p><a href="index.php"><i class="fas fa-home"></i> Return to home page</a> <a href="postjobform.php"><i class="fas fa-briefcase"></i> Post another job</a></p>
    </section>
  </main>
  // Footer section
  <footer>
    <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
  </footer>
</body>

</html>
