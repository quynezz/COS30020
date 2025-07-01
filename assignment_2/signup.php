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

$errors = [
    'email' => '',
    'profile_name' => '',
    'password' => '',
    'confirm_password' => '',
    'profile_picture' => ''
];
$email = $profile_name = "";
$showToast = false;
$toastMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $profile_name = isset($_POST["profile_name"]) ? trim($_POST["profile_name"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
    $confirm_password = isset($_POST["confirm_password"]) ? trim($_POST["confirm_password"]) : "";

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email must be in a valid format!";
    } else {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$sql_db", $user, $pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM friends WHERE friend_email = ?");
            $stmt->execute(array($email));
            if ($stmt->fetchColumn() > 0) {
                $errors['email'] = "Email already exists!";
            }
        } catch (PDOException $e) {
            $errors['email'] = "Database connection error: " . $e->getMessage();
            error_log("Signup DB Connection Error: " . $e->getMessage());
        }
    }

    if (strlen($profile_name) < 3 || strlen($profile_name) > 30) {
        $errors['profile_name'] = "Profile name must be between 3 and 20 characters!";
    }
    else if (empty($profile_name) || !preg_match("/^[\p{L}\p{Nd}\p{M}\s_.-]{1,20}$/u", $profile_name)) {
        $errors['profile_name'] = "Profile name must contain only letters and spaces!";
    }

    if (empty($password) || !preg_match("/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password)) {
        $errors['password'] = "Password must be at least 8 characters long and contain letters and numbers!";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match!";
    }

    $profile_picture = "";
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $allowed = array('jpg', 'jpeg', 'png');
        $filename = $_FILES["profile_picture"]["name"];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $errors['profile_picture'] = "Profile picture must be JPG, JPEG, or PNG!";
        } elseif ($_FILES["profile_picture"]["size"] > 2000000) {
            $errors['profile_picture'] = "Profile picture must be less than 2MB!";
        } else {
            $new_filename = "profile_" . uniqid() . "." . $ext;
            $upload_path = "style/images/" . $new_filename;
            if (!is_dir("style/images/")) {
                mkdir("style/images/", 0777, true);
            }
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $upload_path)) {
                $profile_picture = $upload_path;
            } else {
                $errors['profile_picture'] = "Failed to upload profile picture! Check directory permissions.";
                error_log("File Upload Error: Failed to move profile picture to $upload_path");
            }
        }
    }

    if (empty(array_filter($errors))) {
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$sql_db", $user, $pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $hashed_password = hashPassword($password);
            $stmt = $pdo->prepare("
                    INSERT INTO friends (friend_email, profile_name, password, date_started, num_of_friends, profile_picture)
                    VALUES (?, ?, ?, NOW(), 0, ?)
                ");
            $stmt->execute(array($email, $profile_name, $hashed_password, $profile_picture));

            $_SESSION["loggedEmail"] = $email;
            $_SESSION["loggedUserId"] = $pdo->lastInsertId();
            $_SESSION["last_activity"] = time();

            error_log("User successfully registered: email=$email, user_id=" . $_SESSION["loggedUserId"]);
            redirect("friendadd.php", 302);
            exit();
        } catch (PDOException $e) {
            $errors['general'] = "Database insert error: " . $e->getMessage();
            error_log("Signup DB Insert Error: " . $e->getMessage());
        }
    }
}

// Get the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Lau Ngoc Quyen" id="104198996">
    <title>Sign Up Page</title>
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
            <h1>Registration Page</h1>
            <div class="underline-cross"></div>
        </div>
        <?php if ($showToast): ?>
            <div class="toast"><?php echo htmlspecialchars($toastMessage); ?></div>
        <?php endif; ?>

        <div class="form-wrapper">
            <form method="POST" action="signup.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" name="email" type="text" value="<?php echo htmlspecialchars($email); ?>">
                    <span class="field-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                </div>
                <div class="form-group">
                    <label for="profile_name">Profile Name:</label>
                    <input id="profile_name" name="profile_name" type="text" value="<?php echo htmlspecialchars($profile_name); ?>">
                    <span class="field-error"><?php echo htmlspecialchars($errors['profile_name']); ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input id="password" name="password" type="password">
                    <span class="field-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input id="confirm_password" name="confirm_password" type="password">
                    <span class="field-error"><?php echo htmlspecialchars($errors['confirm_password']); ?></span>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Profile Picture (JPG/PNG, max 2MB, optional):</label>
                    <input id="profile_picture" name="profile_picture" type="file" accept="image/jpeg,image/png">
                    <span class="field-error"><?php echo htmlspecialchars($errors['profile_picture']); ?></span>
                </div>
                <div class="form-actions">
                    <button type="submit">Register</button>
                    <button type="reset">Clear</button>
                </div>
                <div class="form-footer">
                    <p>Already have an account? <a href="login.php">Login</a></p>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
    </footer>

    </html>
</body>
