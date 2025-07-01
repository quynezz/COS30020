<?php
session_start();
require_once("./functions/settings.php");
require_once("./functions/helper_functions.php");

// Check session timeout (30 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
$_SESSION['last_activity'] = time();

$userProfile = array();
if (isset($_SESSION["loggedUserId"])) {
    try {
        $dsn = "mysql:host=$host;dbname=$sql_db";
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );
        $pdo = new PDO($dsn, $user, $pwd, $options);
        $stmt = $pdo->prepare("SELECT profile_name, profile_picture FROM friends WHERE friend_id = ?");
        $stmt->execute(array($_SESSION["loggedUserId"]));
        $userProfile = $stmt->fetch();
        $pdo = null;
    } catch (PDOException $err) {
        $message = "Error fetching user profile: " . $err->getMessage();
    }
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Lau Ngoc Quyen" id="104198996">
    <title>About Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
    <style>

    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo"><a href="index.php">My Friend System</a></div>
            <ul class="nav-links">
                <?php if (isset($_SESSION["loggedEmail"])): ?>
                    <li><a href="friendadd.php" class="<?php echo ($current_page == 'friendadd.php') ? 'active' : ''; ?>">Add friends</a></li>
                    <li><a href="friendlist.php" class="<?php echo ($current_page == 'friendlist.php') ? 'active' : ''; ?>">Friend list</a></li>
                    <li><a href="about.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About us</a></li>
                    <li><a href="signup.php" class="<?php echo ($current_page == 'signup.php') ? 'active' : ''; ?>">Contact us</a></li>
                <?php endif; ?>
            </ul>
            <div class="auth-section">
                <?php if (isset($_SESSION["loggedEmail"])): ?>
                    <div class="user-profile">
                        <?php if (!empty($userProfile['profile_picture'])): ?>
                            <img src="<?php echo htmlspecialchars($userProfile['profile_picture']); ?>" alt="Profile Picture" class="profile-pic">
                        <?php else: ?>
                            <i class="fas fa-user-circle"></i>
                        <?php endif; ?>
                        <span><?php echo htmlspecialchars($userProfile['profile_name'] ?? $_SESSION["loggedEmail"]); ?></span>
                    </div>
                    <a class="logout" href="logout.php">Logout</a>
                <?php else: ?>
                    <ul class="auth-links">
                        <li><a href="login.php">Login</a></li>
                        <li><a href="signup.php">Sign Up</a></li>
                    </ul>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main class="fade-in">
        <div class="heading-wrapper">
            <h1>About Page</h1>
            <div class="underline-cross"></div>
        </div>
        <section class="intro-about">
            <p>This is a social networking system built for <strong>COS30020 Web Application Development assignment.</strong></p>
            <p>Developed by <strong>Lau Ngoc Quyen</strong> (<strong>Student ID:</strong> 104198996).</p>
            <p>Features include <strong>user registration</strong>, <strong>login</strong>, <strong>friend management</strong>, and <strong>profile picture uploads.</strong></p>
            <p><strong>Contact:</strong> 104198996@swin.edu.au</p>
        </section>
        <?php if (isset($message)): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
    </footer>
</body>
</html>
