<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="Lau Ngoc Quyen" id="104198996">
  <title>Job Vacancy Posting System</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- Using Font-awesome icons and Montserrat font  -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="index">
  <header>
    <h1> Job Vacancy Posting System</h1>
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
    <section class="card student-info">
      <h2><i class="fas fa-user"></i> Student Details</h2>
      <hr class="divider">
      <p><strong>Name:</strong> Lau Ngoc Quyen</p>
      <p><strong>Student ID:</strong> 104198996</p>
      <p><strong>Email:</strong> <a href="mailto:104198996@swin.edu.au" class="email-link">104198996@swin.edu.au</a></p>
    </section>
    <section class="card declaration">
      <h2><i class="fas fa-file-signature"></i> Declaration</h2>
      <hr class="divider">
      <p>I declare that this assignment is my <strong>individual</strong> work. I have not worked collaboratively, nor have I copied from any other student’s work or from any other source.</p>
    </section>
    <nav class="card">
      <h2><i class="fas fa-compass"></i> Navigation</h2>
      <hr class="divider">
      <ul>
        <li><a href="postjobform.php"><i class="fas fa-plus-circle"></i> Post a Job Vacancy</a></li>
        <li><a href="searchjobform.php"><i class="fas fa-search"></i> Search for a Job Vacancy</a></li>
        <li><a href="about.php"><i class="fas fa-info-circle"></i> About this Assignment</a></li>
      </ul>
    </nav>
  </main>
  <footer>
    <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
  </footer>
</body>

</html>
