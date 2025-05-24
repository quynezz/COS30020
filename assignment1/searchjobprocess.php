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
  <style>
    .status-available {
      color: #28a745;
      font-weight: bold;
    }
    .status-closed {
      color: #dc3545;
      font-weight: bold;
    }
  </style>
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

// GET all fields variables
$title = isset($_GET["title"]) ? trim(str_replace(' ', '', $_GET["title"])) : "";
$full_time = isset($_GET["fullTime"]) ? trim($_GET["fullTime"]) : "";
$part_time = isset($_GET["partTime"]) ? trim($_GET["partTime"]) : "";
$post = isset($_GET["post"]) ? trim($_GET["post"]) : "";
$email = isset($_GET["email"]) ? trim($_GET["email"]) : "";
$on_going = isset($_GET["onGoing"]) ? trim($_GET["onGoing"]) : "";
$fixed_term = isset($_GET["fixedTerm"]) ? trim($_GET["fixedTerm"]) : "";
$on_site = isset($_GET["onSite"]) ? trim($_GET["onSite"]) : "";
$remote = isset($_GET["remote"]) ? trim($_GET["remote"]) : "";

function parseDate($dateString) {
    // Parse date in DD/MM/YY format
    $parts = explode('/', trim($dateString));
    if (count($parts) === 3) {
        $day = intval($parts[0]);
        $month = intval($parts[1]);
        $year = intval($parts[2]);

        // Convert two-digit year to four-digit year
        if ($year < 100) {
            $year = ($year <= 50) ? 2000 + $year : 1900 + $year;
        }

        return mktime(0, 0, 0, $month, $day, $year);
    }
    return false;
}


function getJobStatus($closingDate) {
    if (isValidClosingDate($closingDate)) {
        return 'Available';
    } else {
        return 'Closed';
    }
}

function isValidClosingDate($closingDate) {
    $today = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $jobDate = parseDate($closingDate);

    // Return true if job closing date is today or in the future
    return $jobDate !== false && $jobDate >= $today;
}

function displayJob($matched_jobs) {
    if (!empty($matched_jobs)) {
        echo '<div class="job-info"><i class="fas fa-briefcase"></i> Found ' . count($matched_jobs) . ' job(s) matching your search.</div>';
        echo '<div class="job-list">';
        foreach ($matched_jobs as $job) {
            $fields = explode("\t", trim($job));
            $position_id = isset($fields[0]) ? htmlspecialchars($fields[0]) : 'N/A';
            $title = isset($fields[1]) ? htmlspecialchars($fields[1]) : 'N/A';
            $description = isset($fields[2]) ? htmlspecialchars($fields[2]) : 'N/A';
            $closing_date = isset($fields[3]) ? htmlspecialchars($fields[3]) : 'N/A';
            $position_type = isset($fields[4]) ? htmlspecialchars($fields[4]) : 'N/A';
            $contract_type = isset($fields[5]) ? htmlspecialchars($fields[5]) : 'N/A';
            $location = isset($fields[6]) ? htmlspecialchars($fields[6]) : 'N/A';
            $application_method = isset($fields[7]) ? htmlspecialchars($fields[7]) : 'N/A';

            // Get job status
            $status = getJobStatus($closing_date);
            $status_class = ($status === 'Available') ? 'status-available' : 'status-closed';

            echo '
            <div class="job-item">
              <h3><i class="fas fa-briefcase"></i> ' . $title . '</h3>
              <p><strong>Position ID:</strong> ' . $position_id . '</p>
              <p><strong>Description:</strong> ' . $description . '</p>
              <p><strong>Closing Date:</strong> ' . $closing_date . '</p>
              <p><strong>Status:</strong> <span class="' . $status_class . '">' . $status . '</span></p>
              <p><strong>Position Type:</strong> ' . $position_type . '</p>
              <p><strong>Contract Type:</strong> ' . $contract_type . '</p>
              <p><strong>Location:</strong> ' . $location . '</p>
              <p><strong>Application Method:</strong> ' . $application_method . '</p>
            </div>';
        }
        echo '</div>';
    } else {
        echo '<p class="error-message"><i class="fas fa-times-circle"></i> No jobs found matching your search criteria. Try adjusting your filters.</p>';
    }
}

function searchResults($file_path, $title, $full_time, $part_time, $post, $email, $on_going, $fixed_term, $on_site, $remote) {
    // Validate file existence
    if (!is_file($file_path)) {
        echo '<p class="error-message"><i class="fas fa-times-circle"></i> Error: Job database file not found.</p>';
        return;
    }

    // Read and search file
    $file_content = file_get_contents($file_path);
    if ($file_content === false || trim($file_content) === '') {
        echo '<p class="error-message"><i class="fas fa-times-circle"></i> Error: Job database is empty or unreadable.</p>';
        return;
    }

    $file_lines = array_filter(explode("\n", trim($file_content)));
    $matched_jobs = [];

    // Log input parameters for debugging
    error_log("Search criteria: title=$title, full_time=$full_time, part_time=$part_time, post=$post, email=$email, on_going=$on_going, fixed_term=$fixed_term, on_site=$on_site, remote=$remote");

    // Check if any search criteria are provided
    $has_criteria = $title !== '' || $full_time !== '' || $part_time !== '' ||
        $post !== '' || $email !== '' || $on_going !== '' ||
        $fixed_term !== '' || $on_site !== '' || $remote !== '';

    // Process each job line
    foreach ($file_lines as $job) {
        $fields = explode("\t", trim($job));


        $job_title = trim($fields[1]);
        $job_position = trim($fields[4]);
        $job_contract = trim($fields[5]);
        $job_location = trim($fields[6]);
        $job_application = trim($fields[7]); // Comma-separated, e.g., "post,email"

        // Log parsed job for debugging
        error_log("Parsed job: ID={$fields[0]}, application=$job_application");

        $is_match = true;

        // If no criteria, include all valid jobs (not expired)
        if ($has_criteria) {
            // Filter by title
            if ($title !== '' && stripos($job_title, $title) === false) {
                $is_match = false;
                error_log("Title mismatch: job_title=$job_title, search_title=$title");
            }

            // Filter by position type
            $position_types = array_filter([$full_time, $part_time]);
            if (!empty($position_types) && !in_array(strtolower($job_position), array_map('strtolower', $position_types))) {
                $is_match = false;
                error_log("Position mismatch: job_position=$job_position, selected=" . implode(',', $position_types));
            }

            // Filter by contract type
            $contract_types = array_filter([$on_going, $fixed_term]);
            if (!empty($contract_types) && !in_array(strtolower($job_contract), array_map('strtolower', $contract_types))) {
                $is_match = false;
                error_log("Contract mismatch: job_contract=$job_contract, selected=" . implode(',', $contract_types));
            }

            // Filter by application method
            $application_methods = array_filter([$post, $email]);
            if (!empty($application_methods)) {
                $job_app_methods = array_map('strtolower', array_filter(explode(',', $job_application)));
                $search_app_methods = array_map('strtolower', $application_methods);
                $app_match = false;
                foreach ($search_app_methods as $search_method) {
                    if (in_array($search_method, $job_app_methods)) {
                        $app_match = true;
                        break;
                    }
                }
                if (!$app_match) {
                    $is_match = false;
                    error_log("Application mismatch: job_application=$job_application, selected=" . implode(',', $application_methods));
                }
            }

            // Filter by location (case-insensitive)
            $locations = array_filter([$on_site, $remote]);
            if (!empty($locations) && !in_array(strtolower($job_location), array_map('strtolower', $locations))) {
                $is_match = false;
                error_log("Location mismatch: job_location=$job_location, selected=" . implode(',', $locations));
            }
        }

        // If all criteria match, add job to results
        if ($is_match) {
            error_log("Match found: ID={$fields[0]}");
            $matched_jobs[] = $job;
        }
    }

    // Sort matched jobs by closing date (most future first, then descending to today)
    usort($matched_jobs, function($a, $b) {
        $fieldsA = explode("\t", trim($a));
        $fieldsB = explode("\t", trim($b));

        $dateA = parseDate(trim($fieldsA[3]));
        $dateB = parseDate(trim($fieldsB[3]));

        // Sort in descending order (most future date first)
        return $dateB - $dateA;
    });

    // Log final results
    error_log("Matched jobs: " . count($matched_jobs));

    // Display results
    displayJob($matched_jobs);
}

// Call the search function
searchResults($file_path, $title, $full_time, $part_time, $post, $email, $on_going, $fixed_term, $on_site, $remote);
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
