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
    // Retrieve success message from session and clear it
    $successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : '';
    unset($_SESSION['successMessage']); // Clear after retrieval

    // Pagination logic
    $perPage = 5; // Number of friends per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page); // Ensure page is at least 1

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $friendId = isset($_POST["friend_id"]) ? (int)$_POST["friend_id"] : 0;
        $userId = $_SESSION["loggedUserId"];

        if ($friendId <= 0 || $friendId == $userId) {
            $errors[] = "Invalid friend selection!";
        } else {
            try {
                $pdo->beginTransaction();
                $stmt = $pdo->prepare("DELETE FROM myfriends WHERE (friend_id1 = ? AND friend_id2 = ?) OR (friend_id1 = ? AND friend_id2 = ?)");
                $stmt->execute(array($userId, $friendId, $friendId, $userId));

                // Check and update num_of_friends only if greater than 0
                $stmt = $pdo->prepare("SELECT num_of_friends FROM friends WHERE friend_id = ?");
                $stmt->execute(array($userId));
                $userFriendCount = $stmt->fetchColumn() ?: 0;
                if ($userFriendCount > 0) {
                    $pdo->exec("UPDATE friends SET num_of_friends = num_of_friends - 1 WHERE friend_id = $userId");
                }

                $stmt->execute(array($friendId));
                $friendFriendCount = $stmt->fetchColumn() ?: 0;
                if ($friendFriendCount > 0) {
                    $pdo->exec("UPDATE friends SET num_of_friends = num_of_friends - 1 WHERE friend_id = $friendId");
                }

                $pdo->commit();
                // Store success message in session
                $_SESSION['successMessage'] = "Friend removed successfully!";
                // Redirect to avoid resubmission
                header("Location: friendlist.php?page=" . $page);
                exit();
            } catch (PDOException $e) {
                $pdo->rollBack();
                $errors[] = "Error removing friend: " . $e->getMessage();
            }
        }
    }

    $userId = $_SESSION["loggedUserId"];
    // Count total friends for pagination
    $stmt = $pdo->prepare("
        SELECT COUNT(*) FROM (
            SELECT friend_id2 FROM myfriends WHERE friend_id1 = ?
            UNION
            SELECT friend_id1 FROM myfriends WHERE friend_id2 = ?
        ) AS friend_ids
        WHERE friend_id2 != ?
    ");
    $stmt->execute(array($userId, $userId, $userId));
    $totalFriendsCount = $stmt->fetchColumn();
    $totalPages = ceil($totalFriendsCount / $perPage);

    // Fetch friends with pagination
    $offset = ($page - 1) * $perPage;
    $stmt = $pdo->prepare("
        SELECT f.friend_id, f.profile_name, f.profile_picture
        FROM friends f
        WHERE f.friend_id IN (
            SELECT friend_id2 FROM myfriends WHERE friend_id1 = ?
            UNION
            SELECT friend_id1 FROM myfriends WHERE friend_id2 = ?
        )
        AND f.friend_id != ?
        ORDER BY f.profile_name
        LIMIT ? OFFSET ?
    ");
    $stmt->execute(array($userId, $userId, $userId, $perPage, $offset));
    $friends = $stmt->fetchAll();

    $stmt = $pdo->prepare("SELECT num_of_friends FROM friends WHERE friend_id = ?");
    $stmt->execute(array($userId));
    $totalFriends = $stmt->fetchColumn() ?: 0;
} catch (PDOException $err) {
    $errors[] = "Error fetching friends: " . $err->getMessage();
    $friends = array();
    $totalFriends = 0;
    $totalPages = 1; // Default to 1 page if error
}

$pdo = null;

// Get the current page
$current_page = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Lau Ngoc Quyen" id="104198996">
    <title>My Friend List Page</title>
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
            <h1>Your Friend List</h1>
            <div class="underline-cross"></div>
        </div>
        <p>Total number of friends: <strong><?php echo htmlspecialchars($totalFriends); ?></strong></p>

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

        <?php if (empty($friends)): ?>
            <p class="no-friends"><strong>You have no friends yet</strong>. Start adding friends to see them here! 😊</p>
        <?php else: ?>
            <div class="friend-grid">
                <?php foreach ($friends as $friend): ?>
                    <div class="friend-card">
                        <div class="profile-pic-container">
                            <?php if ($friend['profile_picture']): ?>
                                <img src="<?php echo htmlspecialchars($friend['profile_picture']); ?>" alt="Profile Picture" class="profile-pic">
                            <?php else: ?>
                                <i class="fas fa-user-circle profile-pic"></i>
                            <?php endif; ?>
                        </div>
                        <div class="friend-card-content">
                            <div class="friend-card-info">
                                <p class="profile-name"><?php echo htmlspecialchars($friend['profile_name']); ?></p>
                            </div>
                            <form method="POST" action="friendlist.php?page=<?php echo $page; ?>" class="transparent-form">
                                <input type="hidden" name="friend_id" value="<?php echo $friend['friend_id']; ?>">
                                <button class="unfriend-button" type="submit"><i class="fas fa-user-minus"></i> Unfriend</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Pagination -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="friendlist.php?page=<?php echo $page - 1; ?>">
                        <span><i class="fas fa-angle-left"></i> Previous</span>
                    </a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="friendlist.php?page=<?php echo $page + 1; ?>">
                        <span>Next <i class="fas fa-angle-right"></i></span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2025 Lau Ngoc Quyen 104198996. All rights reserved.</p>
    </footer>
</body>
</html>
