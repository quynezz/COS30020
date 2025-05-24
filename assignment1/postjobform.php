<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="LauNgocQuyen" id="104198996">
  <title>Post a Job Vacancy</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="postjobform">
<?php
session_start();
$position_id = $_SESSION["positionID"] ?? "";
$title = $_SESSION["title"] ?? "";
$description = $_SESSION["description"] ?? "";
$closing_date = $_SESSION["closingDate"] ?? date('d/m/y');
$position = $_SESSION["position"] ?? "";
$contract = $_SESSION["contract"] ?? "";
$location = $_SESSION["location"] ?? "";
$application_by = $_SESSION["applicationBy"] ?? [];
$app_post = in_array("Post", $application_by) ? "Post" : "";
$app_email = in_array("Email", $application_by) ? "Email" : "";
?>

  <header>
    <h1> Post a Job Vacancy</h1>
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
      <h2 style="justify-content: center;"><i class="fas fa-plus-circle"></i> Job Vacancy Form</h2>
      <form action="postjobprocess.php" method="POST" class="form-grid">
        <div class="form-group">
          <label for="position_id"><i class="fas fa-id-badge"></i> Position ID*:</label>
          <input type="text" id="position_id" name="positionID"  placeholder="For example: ID001" maxlength="5" value="<?php echo htmlspecialchars($position_id); ?>">
        </div>
        <div class="form-group">
          <label for="title"><i class="fas fa-heading"></i> Title*:</label>
          <input type="text" id="title" name="title" maxlength="10" placeholder="For example: Back-end" value="<?php echo htmlspecialchars($title); ?>">
        </div>
        <div class="form-group">
          <label for="closing_date"><i class="fas fa-calendar-alt"></i> Closing Date:</label>
          <input type="text" id="closing_date" name="closingDate" placeholder="Format: dd/mm/yy (01/01/20)" value="<?php echo htmlspecialchars($closing_date); ?>">
        </div>
        <div class="form-group full-width">
          <label for="description"><i class="fas fa-file-alt"></i> Description:</label>
          <textarea id="description" name="description" maxlength="250"><?php echo htmlspecialchars($description); ?></textarea>
        </div>
        <div class="form-group">
          <fieldset>
            <legend><i class="fas fa-briefcase"></i> Position:</legend>
            <div class="radio-group">
              <div class="radio-option">
                <input type="radio" id="full_time" name="position" value="fullTime" <?php echo $position === 'fullTime' ? 'checked' : ''; ?>>
                <label for="full_time">Full-time</label>
              </div>
              <div class="radio-option">
                <input type="radio" id="part_time" name="position" value="partTime" <?php echo $position === 'partTime' ? 'checked' : ''; ?>>
                <label for="part_time">Part-time</label>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset>
            <legend><i class="fas fa-file-contract"></i> Contract:</legend>
            <div class="radio-group">
              <div class="radio-option">
                <input type="radio" id="ongoing" name="contract" value="onGoing" <?php echo $contract === 'onGoing' ? 'checked' : ''; ?>>
                <label for="ongoing">On-going</label>
              </div>
              <div class="radio-option">
                <input type="radio" id="fixed_term" name="contract" value="fixedTerm" <?php echo $contract === 'fixedTerm' ? 'checked' : ''; ?>>
                <label for="fixed_term">Fixed Term</label>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset>
            <legend><i class="fas fa-map-marker-alt"></i> Location:</legend>
            <div class="radio-group">
              <div class="radio-option">
                <input type="radio" id="onsite" name="location" value="onSite" <?php echo $location === 'onSite' ? 'checked' : ''; ?>>
                <label for="onsite">On site</label>
              </div>
              <div class="radio-option">
                <input type="radio" id="remote" name="location" value="remote" <?php echo $location === 'remote' ? 'checked' : ''; ?>>
                <label for="remote">Remote</label>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="form-group">
          <fieldset>
            <legend><i class="fas fa-envelope"></i> Accept By:</legend>
            <div class="checkbox-group">
              <div class="checkbox-option">
                <input type="checkbox" id="post" name="applicationBy[]" value="post" <?php echo in_array('post', $application_by) ? 'checked' : ''; ?>>
                <label for="post">Post</label>
              </div>
              <div class="checkbox-option">
                <input type="checkbox" id="email" name="applicationBy[]" value="email" <?php echo in_array('email', $application_by) ? 'checked' : ''; ?>>
                <label for="email">Email</label>
              </div>
            </div>
          </fieldset>
        </div>
        <!-- Im adding this for less negative space -->
        <div class="form-group">
                <input type="checkbox" id="policy_agreed">
                <label for="policy_agreed">I have read and agree to the terms and policies</label>
        </div>
        <div class="form-group">
          <button type="submit"><i class="fa-regular fa-square-plus"></i> Publish job</button>
        </div>
      </form>
    </section>
  </main>
  <footer>
    <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
  </footer>
</body>
</html>
