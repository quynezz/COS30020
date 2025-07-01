<?php
session_start();
require_once("./functions/settings.php");
require_once("./functions/helper_functions.php");

if (isset($_SESSION["loggedUserId"])) {
    // User is already logged in, redirect to friendlist page
    header("Location: friendlist.php");
    exit();
}

// Check session timeout (30 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}
$_SESSION['last_activity'] = time();

$showToast = false;
$toastMessage = "";
$errors = array();
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email must be in a valid format!";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required!";
    }

    if (empty($errors)) {
        try {
            $dsn = "mysql:host=$host;dbname=$sql_db";
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            );
            $pdo = new PDO($dsn, $user, $pwd, $options);
            $stmt = $pdo->prepare("SELECT friend_id, friend_email, password FROM friends WHERE friend_email = ?");
            $stmt->execute(array($email));
            $user = $stmt->fetch();
            if ($user && verifyPassword($password, $user['password'])) {
                $showToast = true;
                $toastMessage = "Login successful!";
                $_SESSION["loggedEmail"] = $user['friend_email'];
                $_SESSION["loggedUserId"] = $user['friend_id'];
                $_SESSION["last_activity"] = time();
                redirect("friendlist.php", 302);
                exit();
            } else {
                $errors['general'] = "Invalid email or password!";
            }
        } catch (PDOException $e) {
            $errors['general'] = "Database error: " . $e->getMessage();
        }
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
    <title>Login Page</title>
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

    <main class="fade-in">
        <div class="heading-wrapper">
            <h1>Login Page</h1>
            <div class="underline-cross"></div>
        </div>
        <?php if ($showToast): ?>
            <div class="toast"><?php echo htmlspecialchars($toastMessage); ?></div>
        <?php endif; ?>

        <div class="form-wrapper">
            <form method="POST" action="login.php" class="login-form">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="text" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email">
                    <?php if (isset($errors['email'])): ?>
                        <span class="field-error"><?php echo htmlspecialchars($errors['email']); ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter your password">
                    <?php if (isset($errors['password'])): ?>
                        <span class="field-error"><?php echo htmlspecialchars($errors['password']); ?></span>
                    <?php endif; ?>
                    <?php if (isset($errors['general'])): ?>
                        <span class="field-error"><?php echo htmlspecialchars($errors['general']); ?></span>
                    <?php endif; ?>

                </div>
                <div class="form-actions">
                    <button type="submit">Login now!</button>
                    <button type="reset">Clear</button>
                </div>
                <div class="form-footer">
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
    </footer>
</body>
</html>
