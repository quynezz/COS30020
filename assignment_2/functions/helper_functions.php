<?php
// Redirect function
function redirect($url, $status_code) {
    header('Location: ' . $url, true, $status_code);
    exit();
}



function hashPassword($password) {
    $salt= './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $hashPassword = crypt($password, $salt);
    return $hashPassword;
}

function verifyPassword($password, $hash) {
    $hashedPassword = crypt($password, $hash);
    return hash_equals($hashedPassword, $hash);
}

// Generate a secure user token for maintaining login status
function userToken() {
    $bytes = openssl_random_pseudo_bytes(32);
    if ($bytes === false) {
        $bytes = '';
        for ($i = 0; $i < 32; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }
    }
    return bin2hex($bytes);
}

// Initialize database and populate if empty
function initializeDatabase($pdo) {
    try {
        $queryCreateFriendsTable = "
            CREATE TABLE IF NOT EXISTS friends (
                friend_id INT AUTO_INCREMENT NOT NULL,
                friend_email VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL,
                profile_name VARCHAR(30) NOT NULL,
                date_started DATETIME NOT NULL,
                num_of_friends INT UNSIGNED DEFAULT 0,
                profile_picture VARCHAR(100),
                PRIMARY KEY(friend_id),
                UNIQUE(friend_email)
            )";
        $pdo->exec($queryCreateFriendsTable);

        $queryCreateMyFriendsTable = "
            CREATE TABLE IF NOT EXISTS myfriends (
                friend_id1 INT NOT NULL,
                friend_id2 INT NOT NULL,
                PRIMARY KEY(friend_id1, friend_id2),
                FOREIGN KEY(friend_id1) REFERENCES friends(friend_id),
                FOREIGN KEY(friend_id2) REFERENCES friends(friend_id)
            )";
        $pdo->exec($queryCreateMyFriendsTable);

        // Check if friends table has records
        $stmt = $pdo->query("SELECT COUNT(*) FROM friends");
        $friendsCount = $stmt->fetchColumn();

        if ($friendsCount == 0) {
            $friendsData = "
                test1@example.com|".hashPassword('Password123')."|User1|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test2@example.com|".hashPassword('Password123')."|User2|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test3@example.com|".hashPassword('Password123')."|User3|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test4@example.com|".hashPassword('Password123')."|User4|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test5@example.com|".hashPassword('Password123')."|User5|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test6@example.com|".hashPassword('Password123')."|User6|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test7@example.com|".hashPassword('Password123')."|User7|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test8@example.com|".hashPassword('Password123')."|User8|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test9@example.com|".hashPassword('Password123')."|User9|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
                test10@example.com|".hashPassword('Password123')."|Use10|2025-06-26 17:57:00|0|style/images/profile_685d363dd3800.jpg
            ";
            $stmt = $pdo->prepare("INSERT INTO friends (friend_email, password, profile_name, date_started, num_of_friends, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");
            foreach (explode("\n", trim($friendsData)) as $line) {
                $data = explode("|", $line);
                $stmt->execute($data);
            }

            // Check if myfriends table has records
            $stmt = $pdo->query("SELECT COUNT(*) FROM myfriends");
            $myFriendsCount = $stmt->fetchColumn();

            if ($myFriendsCount == 0) {
                $myFriendsData = "
                    1|2
                    2|1
                    1|3
                    3|1
                    2|3
                    3|2
                    4|5
                    5|4
                    4|6
                    6|4
                    5|6
                    6|5
                    7|8
                    8|7
                    7|9
                    9|7
                    8|9
                    9|8
                    10|1
                    1|10
                ";
                $stmt = $pdo->prepare("INSERT INTO myfriends (friend_id1, friend_id2) VALUES (?, ?)");
                foreach (explode("\n", trim($myFriendsData)) as $line) {
                    $data = explode("|", $line);
                    if ($data[0] != $data[1]) {
                        $stmt->execute($data);
                    }
                }

                // Update num_of_friends
                $pdo->exec("UPDATE friends f SET num_of_friends = (SELECT COUNT(*) FROM myfriends mf WHERE mf.friend_id1 = f.friend_id)");
            }

            return "Database initialized and populated with initial data.";
        } else {
            return "Database already contains data.";
        }
    } catch (PDOException $err) {
        return "Error initializing database: " . $err->getMessage();
    }
}
?>

