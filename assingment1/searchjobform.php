<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="LauNgocQuyen" id="104198996">
  <title>Search Job Vacancy</title>
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="searchjobform">
  <header>
    <h1><i class="fas fa-search"></i> Search Job Vacancy</h1>
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
      <h2 style="justify-content: center;"><i class="fas fa-search-plus"></i> Job Vacancy Search</h2>
      <form action="searchjobprocess.php" method="GET" class="form-grid">
        <div class="form-group full-width">
          <label for="title"><i class="fas fa-heading" ></i> Job Title:</label>
          <input type="text" id="title" name="title" placeholder="Cloud Architecter, Data Analyst, ...">
        </div>
        <p class="hint"><i class="fa-solid fa-lightbulb" style="color: #FFD43B;"></i><strong>Most look-up keywords:</strong> Web developer, Front-end developer, Back-end developer,...</p>
        <div class="form-group legends">
          <fieldset>
            <legend><i class="fas fa-briefcase"></i> Position:</legend>
            <div class="checkbox-group">
              <div class="checkbox-option">
                <input type="checkbox" id="full_time" name="fullTime" value="fullTime">
                <label for="full_time">Full Time</label>
              </div>
              <div class="checkbox-option">
                <input type="checkbox" id="part_time" name="partTime" value="partTime">
                <label for="part_time">Part Time</label>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend><i class="fas fa-file-contract"></i> Contract:</legend>
            <div class="checkbox-group">
              <div class="checkbox-option">
                <input type="checkbox" id="ongoing" name="onGoing" value="onGoing">
                <label for="ongoing">On-going</label>
              </div>
              <div class="checkbox-option">
                <input type="checkbox" id="fixed_term" name="fixedTerm" value="fixedTerm">
                <label for="fixed_term">Fixed Term</label>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend><i class="fas fa-envelope"></i> Application By:</legend>
            <div class="checkbox-group">
              <div class="checkbox-option">
                <input type="checkbox" id="post" name="post" value="post">
                <label for="post">Post</label>
              </div>
              <div class="checkbox-option">
                <input type="checkbox" id="email" name="email" value="email">
                <label for="email">Email</label>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend><i class="fas fa-map-marker-alt"></i> Location:</legend>
            <div class="checkbox-group">
              <div class="checkbox-option">
                <input type="checkbox" id="onsite" name="onSite" value="onSite">
                <label for="onsite">On site</label>
              </div>
              <div class="checkbox-option">
                <input type="checkbox" id="remote" name="remote" value="remote">
                <label for="remote">Remote</label>
              </div>
            </div>
          </fieldset>
        </div>
        <button type="submit"><i class="fas fa-search"></i> Search jobs</button>
      </form>
    </section>
  </main>
  <footer>
    <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
  </footer>
</body>

</html>
