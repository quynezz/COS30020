<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="LauNgocQuyen" id="104198996">
  <title>Search Job Results</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="searchjobprocess">
  <header>
    <h1><i class="fas fa-search"></i> Search Job Results</h1>
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

// Pre-defined dir and file
$data_dir = "../assingment1/data/jobs";
$data_file = "position.txt";

// Full file path
$file_path = "$data_dir/$data_file";


// GET and POST variables
$title = isset($_GET["title"]) ? trim($_GET["title"]) : "";
$position = isset($_GET["position"]) ? (array)$_GET["position"] : [];
$full_time = isset($_GET["fullTime"]) ? $_GET["fullTime"] : "";
$part_time = isset($_GET["partTime"]) ? $_GET["partTime"] : "";
$application_by = isset($_POST["applicationBy"]) ? (array)$_POST["applicationBy"] : [];
$app_post = in_array("post", $application_by) ? "post" : "";
$app_email = in_array("email", $application_by) ? "email" : "";
$contract = isset($_GET["contract"]) ? (array)$_GET["contract"] : [];
$con_on = in_array("onGoing", $contract) ? "onGoing" : "";
$con_fix = in_array("fixedTerm", $contract) ? "fixedTerm" : "";

function searchResults($file_path, $title)
{
    // Validate job title
    if (empty($title)) {
        echo '<p class="error-message"><i class="fas fa-times-circle"></i> Error: Please enter a job title to search.</p>';
        return;
    }

    // Validate file existence
    if (!is_file($file_path)) {
        echo '<p class="error-message"><i class="fas fa-times-circle"></i> Error: Job database file not found.</p>';
        return;
    }

    // Read and search file
    $file_content = file_get_contents($file_path);
    $file_lines = explode("\n", trim($file_content));
    $matched_jobs = [];

    // Search for matching job titles (case-insensitive, partial matches)
    foreach ($file_lines as $job) {
        $each_jobs = explode("\t",$job);
        $each_jobs_title = $each_jobs[1];
        if (!empty(trim($each_jobs_title))) {
            if (stripos($each_jobs_title, $title) !== false) {
                array_push($matched_jobs,$job);
            }
        }
    }

    // Display job count
    if (!empty($matched_jobs)) {
        echo '<div class="job-info"><i class="fas fa-briefcase"></i> Found ' . count($matched_jobs) . ' job(s) matching your search.</div>';
    }

    // Display results
    if (!empty($matched_jobs)) {
        echo '<div class="job-list">';
        for ($i = 0; $i < count($matched_jobs); $i++) {
            $job = $matched_jobs[$i];
            $fields = explode("\t", trim($job));

            // Ensure all expected fields are present (assuming 8 fields: Position ID, Title, Description, Closing Date, Position, Contract, Location, Application Method)
            $position_id = isset($fields[0]) ? htmlspecialchars($fields[0]) : 'N/A';
            $title = isset($fields[1]) ? htmlspecialchars($fields[1]) : 'N/A';
            $description = isset($fields[2]) ? htmlspecialchars($fields[2]) : 'N/A';
            $closing_date = isset($fields[3]) ? htmlspecialchars($fields[3]) : 'N/A';
            $position_type = isset($fields[4]) ? htmlspecialchars($fields[4]) : 'N/A';
            $contract_type = isset($fields[5]) ? htmlspecialchars($fields[5]) : 'N/A';
            $location = isset($fields[6]) ? htmlspecialchars($fields[6]) : 'N/A';
            $application_method = isset($fields[7]) ? htmlspecialchars($fields[7]) : 'N/A';

            // Truncate description to 50 words for display
            $words = explode(' ', $description);
            if (count($words) > 50) {
                $description = implode(' ', array_slice($words, 0, 50)) . '...';
            }

            // Display job card
            echo '
            <div class="job-item">
              <h3><i class="fas fa-briefcase"></i> ' . $title . '</h3>
              <p><strong>Position ID:</strong> ' . $position_id . '</p>
              <p><strong>Description:</strong> ' . $description . '</p>
              <p><strong>Closing Date:</strong> ' . $closing_date . '</p>
              <p><strong>Position Type:</strong> ' . $position_type . '</p>
              <p><strong>Contract Type:</strong> ' . $contract_type . '</p>
              <p><strong>Location:</strong> ' . $location . '</p>
              <p><strong>Application Method:</strong> ' . $application_method . '</p>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<p class="error-message"><i class="fas fa-times-circle"></i> No jobs found matching your search criteria.</p>';
    }
}

// Call the search function
searchResults($file_path, $title, $jobs_per_page);
?>
      <p class="links">
        <a href="index.php"><i class="fas fa-home"></i> Return to Home Page</a>
        <a href="searchjobform.php"><i class="fas fa-search"></i> Search Another Job</a>
      </p>
    </section>
  </main>
  <footer>
    <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
  </footer>
</body>
</html>
