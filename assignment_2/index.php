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

try {
    $dsn = "mysql:host=$host;dbname=$sql_db";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    );
    $pdo = new PDO($dsn, $user, $pwd, $options);

    // Initialize database and populate if empty
    initializeDatabase($pdo);
} catch (PDOException $err) {
    $message = "Error connecting to database: " . $err->getMessage();
}

$userProfile = array();
if (isset($_SESSION["loggedUserId"])) {
    try {
        $stmt = $pdo->prepare("SELECT profile_name, profile_picture FROM friends WHERE friend_id = ?");
        $stmt->execute(array($_SESSION["loggedUserId"]));
        $userProfile = $stmt->fetch();
    } catch (PDOException $err) {
        $message = "Error fetching user profile: " . $err->getMessage();
    }
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Lau Ngoc Quyen" id="104198996">
    <title>My Friend System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo"><a href="index.php">My Friend System</a></div>
            <ul class="nav-links">
                <?php if (isset($_SESSION["loggedEmail"])): ?>
                    <li><a href="friendadd.php">Add friends</a></li>
                    <li><a href="friendlist.php">Friend list</a></li>
                    <li><a href="about.php">About us</a></li>
                    <li><a href="signup.php">Contact us</a></li>
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

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Welcome to </h1>
                <h1 style="color: #9d8400;">My Friend System</h1>
                <p style="font-style: italic;">Connect with friends and build your network effortlessly!</p>
                <div class="user-stats">
                    <p><strong>Over 10,000 people</strong> are using My Friend System!</p>
                    <div class="avatar-group">
                        <img src="style/images/avatar_user1.png" alt="User Avatar" class="avatar">
                        <img src="style/images/avatar_user2.PNG" alt="User Avatar" class="avatar">
                        <img src="style/images/avatar_user3.PNG" alt="User Avatar" class="avatar">
                        <img src="style/images/avatar_user4.PNG" alt="User Avatar" class="avatar">
                        <div class="avatar-more">+1000</div>
                        <div class="rating">
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span class="star">★</span>
                            <span> (5/5)</span>
                        </div>
                    </div>
                </div>
                <div class="hero-action">
                    <form action="signup.php" method="get" class="email-form">
                        <input type="email" name="email" placeholder="Enter email to contact us" >
                        <button type="submit">Contact Us</button>
                    </form>
                </div>
            </div>
            <div class="hero-vector-container">
                <video src="style/images/0_Social_Media_Hashtag_3840x2160.mp4" class="hero-vector" autoplay loop muted></video>
            </div>
        </section>


    <!-- Features Section -->
    <section class="features">
        <h2>Explore Our Features</h2>
        <div class="feature-cards">
            <div class="feature-card">
                <i class="fas fa-users"></i>
                <h3>Friend List</h3>
                <p>View and manage your connections with ease on the Friend List page.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-user-plus"></i>
                <h3>Add Friends</h3>
                <p>Expand your network by adding new friends effortlessly.</p>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-file-shield"></i>
                <h3>Secure Authentication</h3>
                <p>Highly secure data using advanced one-way encrypted</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-envelope"></i>
                <h3>Contact Us</h3>
                <p>Get in touch with us for support or inquiries.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-info-circle"></i>
                <h3>About Us</h3>
                <p>Learn more about My Friend System and our mission.</p>
            </div>
            <div class="feature-card">
                <i class="fa-solid fa-comments"></i>
                <h3>Great Community</h3>
                <p>Friendly and open-minded community to sharing and connecting</p>
            </div>

        </div>
    </section>

        <!-- Reviewer Section -->
        <section class="reviewers">
            <h2>What Our Users Say</h2>
            <div class="review-cards">
                <div class="review-card">
                    <img src="style/images/reviewer_1.jpg" alt="Reviewer Avatar" class="review-avatar">
                    <p>"I would say this is the best platform to connect with friends! Highly recommend!"</p>
                    <div class="rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p class="author">David Jr.</p>
                </div>
                <div class="review-card">
                    <img src="style/images/reviewer_2.jpg" alt="Reviewer Avatar" class="review-avatar">
                    <p>"It really user-friendly, easy to use and mavolous features. Significantly Love the friend list!"</p>
                    <div class="rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p class="author"> Sarah L.</p>
                </div>
                <div class="review-card">
                    <img src="style/images/reviewer_3.jpg" alt="Reviewer Avatar" class="review-avatar">
                    <p>"Best social tool I've used. Keeps me connected!"</p>
                    <div class="rating">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                    </div>
                    <p class="author"> Alice T.</p>
                </div>
            </div>
        </section>

        <!-- Assignment Section -->
       <section class="assignment-section">
            <div class="heading-wrapper">
                <h1>Assignment Home Page</h1>
                <div class="underline-cross"></div>
            </div>
            <section class="intro">
                <p><strong>Name:</strong> Lau Ngoc Quyen</p>
                <p><strong>Student ID:</strong> 104198996</p>
                <p><strong>Email:</strong> 104198996@swin.edu.au</p>
                <p>I declare that this assignment is my <strong>individual</strong> work. I have not worked collaboratively nor have I copied from any other student’s work or from any other source.</p>
                <?php if (isset($message)): ?>
                    <p class="message"><?php echo htmlspecialchars($message); ?></p>
                <?php endif; ?>
            </section>
        </section>
    </main>

    <footer>
        <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
    </footer>
    </body>
</html>
