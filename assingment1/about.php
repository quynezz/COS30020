<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="LauNgocQuyen" id="104198996">
    <title>About This Assignment</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="about">
    <header>
        <h1> About This Assignment</h1>
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
            <h2><i class="fa-solid fa-circle-info"></i> Assignment Details</h2>
            <ul>
                <li><strong>PHP Version:</strong> <?php echo phpversion(); ?></li>
                <li><strong>Tasks Not Attempted or Not Completed:</strong> All tasks (1–11) have been fully and successfully attempted and completed.  <i class="fa-solid fa-check" style="color: green;"></i></li>
                <li><strong>Special Features:</strong>
                    <ul>
                        <li>Enhanced user interface with responsive design using CSS Grid and Flexbox.</li>
                        <li>Comprehensive input validation for all form fields.</li>
                        <li>Advanced search functionality with multiple criteria.</li>
                        <li>Sorting of search results by closing date (most future first).</li>
                        <li>Error messages are user-friendly and include navigation links.</li>
                    </ul>
                </li>
                <li><strong>Discussion Board Participation:</strong> I did not participate in the discussion board due to time constraints and focusing on completing the assignment independently.</li>
            <p class="image-links">
                <a href="#" class="image-button">Image 1</a>
                <a href="#" class="image-button">Image 2</a>
                <a href="#" class="image-button">Image 3</a>
                <a href="#" class="image-button">Image 4</a>
            </p>
            </ul>
            <p><a href="index.php"><i class="fas fa-home"></i> Return to Home Page</a></p>
        </section>
    </main>
    <footer>
    <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
    </footer>
</body>
</html>
