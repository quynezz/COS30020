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

// Check if user is logged in
if (!isset($_SESSION["loggedEmail"]) || !isset($_SESSION["loggedUserId"])) {
    echo "You have not authenticated!<br>";
    echo "Please click the link below to log in<br>";
    echo "<a href='index.php'>Click here to go back</a>";
    die();
}

try {
    $dsn = "mysql:host=$host;dbname=$sql_db";
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    );
    $pdo = new PDO($dsn, $user, $pwd, $options);

    $userProfile = array();
    $stmt = $pdo->prepare("SELECT profile_name, profile_picture FROM friends WHERE friend_id = ?");
    $stmt->execute(array($_SESSION["loggedUserId"]));
    $userProfile = $stmt->fetch();

    $errors = array();
    $successMessage = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $friendId = isset($_POST["friend_id"]) ? (int)$_POST["friend_id"] : 0;
        $userId = $_SESSION["loggedUserId"];
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        if ($friendId <= 0 || $friendId == $userId) {
            $errors[] = "Invalid friend selection!";
        } else {
            try {
                $pdo->beginTransaction();

                // Check if the friendship already exists in either direction
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM myfriends WHERE (friend_id1 = ? AND friend_id2 = ?) OR (friend_id1 = ? AND friend_id2 = ?)");
                $stmt->execute(array($userId, $friendId, $friendId, $userId));
                $existingCount = $stmt->fetchColumn();

                if ($existingCount == 0) {
                    // Insert only one row since the relationship is mutual
                    $stmt = $pdo->prepare("INSERT INTO myfriends (friend_id1, friend_id2) VALUES (?, ?)");
                    $stmt->execute(array($userId, $friendId));
                    $pdo->exec("UPDATE friends SET num_of_friends = num_of_friends + 1 WHERE friend_id IN ($userId, $friendId)");
                }

                $pdo->commit();
                $_SESSION['showToast'] = true; // Set flag to show toast
                $successMessage = "Friend added successfully!";
            } catch (PDOException $e) {
                $pdo->rollBack();
                $errors[] = "Error adding friend: " . $e->getMessage();
            }
        }
    }

    $usersPerPage = 5;
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $offset = ($page - 1) * $usersPerPage;

    try {
        $userId = $_SESSION["loggedUserId"];
        $stmt = $pdo->prepare("
            SELECT f.friend_id, f.profile_name, f.friend_email, f.profile_picture,
                   (SELECT COUNT(*) FROM myfriends mf1 WHERE mf1.friend_id1 = f.friend_id AND mf1.friend_id2 IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = ?)) AS mutual_friends
            FROM friends f
            WHERE f.friend_id != ?
            AND f.friend_id NOT IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = ?)
            ORDER BY f.profile_name
            LIMIT ? OFFSET ?
        ");
        $stmt->execute(array($userId, $userId, $userId, $usersPerPage, $offset));
        $nonFriends = $stmt->fetchAll();

        // Fetch mutual friend avatars
        $mutualFriendAvatars = [];
        if (!empty($nonFriends)) {
            $friendIds = implode(',', array_column($nonFriends, 'friend_id'));
            $stmt = $pdo->prepare("
                SELECT mf.friend_id1, f.profile_picture
                FROM myfriends mf
                JOIN friends f ON mf.friend_id2 = f.friend_id
                WHERE mf.friend_id1 IN ($friendIds)
                AND mf.friend_id2 IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = ?)
                LIMIT 2
            ");
            $stmt->execute(array($userId));
            $mutualFriends = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_COLUMN);
            foreach ($mutualFriends as $friendId => $avatars) {
                $mutualFriendAvatars[$friendId] = array_map(fn($pic) => $pic ?: 'style/images/default-avatar.jpg', $avatars);
            }
        }

        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM friends f
            WHERE f.friend_id != ?
            AND f.friend_id NOT IN (SELECT friend_id2 FROM myfriends WHERE friend_id1 = ?)
        ");
        $stmt->execute(array($userId, $userId));
        $totalNonFriends = $stmt->fetchColumn();
        $totalPages = ceil($totalNonFriends / $usersPerPage);
    } catch (PDOException $err) {
        $errors[] = "Error fetching users: " . $err->getMessage();
        $nonFriends = array();
        $totalNonFriends = 0;
        $totalPages = 1;
    }

    // Clear toast flag after displaying
    if (isset($_SESSION['showToast'])) {
        $successMessage = $_SESSION['showToast'] ? $successMessage : "";
        unset($_SESSION['showToast']);
    }

    $pdo = null;
} catch (PDOException $err) {
    echo "Failed to connect to MySQL: " . $err->getMessage();
    exit();
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
    <title>My Friend System - Add Friends</title>
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

    <main>
        <div class="heading-wrapper">
            <h1><i class="fa-solid fa-user-group"></i> People You May Know</h1>
            <div class="underline-cross"></div>
        </div>
        <p>Total number of available friends: <strong><?php echo htmlspecialchars($totalNonFriends); ?></strong></p>

        <?php if ($successMessage): ?>
            <div class="toast"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($nonFriends)): ?>
            <p>No users available to add as friends.</p>
        <?php else: ?>
            <div class="friend-grid">
                <?php foreach ($nonFriends as $user): ?>
                    <div class="friend-card">
                        <div class="profile-pic-container">
                            <?php if ($user['profile_picture']): ?>
                                <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-pic">
                            <?php else: ?>
                                <i class="fas fa-user-circle profile-pic"></i>
                            <?php endif; ?>
                        </div>
                        <div class="friend-card-content">
                            <div class="friend-card-info">
                                <p class="profile-name"><?php echo htmlspecialchars($user['profile_name']); ?></p>
                                <?php
                                $avatars = $mutualFriendAvatars[$user['friend_id']] ?? [];
                                $avatars = array_slice($avatars, 0, 2); // Limit to 2 avatars
                                ?>
                                <?php if (!empty($avatars)): ?>
                                    <div class="mutual-friends">
                                        <?php foreach ($avatars as $avatar): ?>
                                            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="Mutual Friend Avatar" class="mutual-avatar">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <p class="mutual-friends-text"><?php echo $user['mutual_friends']; ?> mutual friend<?php echo $user['mutual_friends'] != 1 ? 's' : ''; ?></p>
                            </div>
                            <div class="friend-card-actions">
                                <form method="POST" action="friendadd.php?page=<?php echo $page; ?>" class="transparent-form">
                                    <input type="hidden" name="friend_id" value="<?php echo $user['friend_id']; ?>">
                                    <button type="submit"><i class="fas fa-plus"></i> Add Friend</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="pagination">
            <?php if ($page > 1): ?>
                <a class="previous" href="friendadd.php?page=<?php echo $page - 1; ?>">
                    <span><i class="fas fa-arrow-left"></i> Previous</span>
                </a>
            <?php endif; ?>
            <?php if ($page < $totalPages): ?>
                <a href="friendadd.php?page=<?php echo $page + 1; ?>">
                    <span>Next <i class="fa-solid fa-arrow-right"></i></span>
                </a>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
    </footer>
</body>
</html>
