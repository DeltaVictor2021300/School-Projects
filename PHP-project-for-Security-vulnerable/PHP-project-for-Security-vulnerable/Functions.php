<?php

include_once 'EntityClassLib.php';

function getPDO() {
    $dbConnection = parse_ini_file("DBConnection.ini");
    extract($dbConnection);
    return new PDO($dsn, $scriptUser, $scriptPassword);
}

function ValidateIdLogIn($x) {
    if (empty($x)) {
        $_SESSION['inputErrors']['id'] = "Student ID can not be blank";
    } else {
        unset($_SESSION['inputErrors']['id']);
        $xClean = trim($x);
        $_SESSION['id'] = $xClean;
    }
}

function ValidatePasswordLogIn($x) {
    if (empty($x)) {
        $_SESSION['inputErrors']['password'] = "Password can not be blank";
    } else {
        unset($_SESSION['inputErrors']['password']);
        $xClean = trim($x);
        $_SESSION['password'] = $xClean;
    }
}

// inject: anything' OR '1'='1
function getUserByIdAndPassword($userId, $password) {
    $pdo = getPDO();
    $sql = "SELECT UserId, Name, Phone FROM user WHERE UserId = $userId AND Password = '$password'";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return new User($row['UserId'], $row['Name'], $row['Phone']);
    } else {
        return null;
    }
}

function getUserById($userId) {
    $pdo = getPDO();

    $sql = "SELECT UserId, Name, Phone FROM user WHERE userId = :userId";
    $pStmt = $pdo->prepare($sql);
    $pStmt->execute(['userId' => $userId]);
    $row = $pStmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        return new User($row['UserId'], $row['Name'], $row['Phone']);
    } else {
        return null;
    }
}

function getNameById($userId) {

    $pdo = getPDO();

    $sql = "SELECT Name FROM user WHERE UserId = :userId";
    $pStmt = $pdo->prepare($sql);
    $pStmt->execute(['userId' => $userId]);
    $row = $pStmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['Name'] : null;
}

function userExists($userId) {
    $pdo = getPDO();

    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM user WHERE UserId = :userId");
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchColumn() > 0; // Returns true if user exists, false otherwise
    } catch (PDOException $e) {
        die("Error checking user existence: " . $e->getMessage());
    }
}

function friendshipExists($userId, $friendUserId) {
    $pdo = getPDO();
    $sql = "SELECT COUNT(*) as count FROM friendship WHERE (Friend_RequesterId = :userId AND Friend_RequesteeId = :friendUserId) OR (Friend_RequesterId = :friendUserId AND Friend_RequesteeId = :userId)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':friendUserId', $friendUserId);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return ($result['count'] > 0);
}

function areFriends($userId, $friendUserId) {
    $pdo = getPDO();

    try {

        $sql = "SELECT COUNT(*) as count FROM friendship WHERE " .
                "((Friend_RequesterId = :userId AND Friend_RequesteeId = :friendUserId) " .
                "OR (Friend_RequesterId = :friendUserId AND Friend_RequesteeId = :userId)) " .
                "AND Status = 'accepted'";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userId' => $userId, 'friendUserId' => $friendUserId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result !== false && isset($result['count'])) {
            return ($result['count'] > 0);
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function friendshipRequestExists($userId, $friendUserId) {
    try {
        $pdo = getPDO();
        $sql = "SELECT COUNT(*) as count FROM friendship WHERE (Friend_RequesteeId = :userId AND Friend_RequesterId = :friendUserId) AND Status='request'";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindParam(':friendUserId', $friendUserId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result['count'] > 0);
    } catch (PDOException $e) {
        die("Error checking friendship request: " . $e->getMessage());
    }
}

function createFriendshipRequest($userId, $friendUserId) {
    try {
        $pdo = getPDO();
        $sql = "INSERT INTO friendship (Friend_RequesterId, Friend_RequesteeId, Status) VALUES (:userId, :friendUserId, 'request')";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':userId', $userId);
        $stmt->bindValue(':friendUserId', $friendUserId);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        throw $e;
    }
}

function fetchFriendRequests($userId) {
    $pdo = getPDO();

    $sql = "SELECT u.UserId, u.Name " .
            "FROM friendship f " .
            "JOIN user u ON f.Friend_RequesterId = u.UserId " .
            "WHERE f.Friend_RequesteeId = :userId " .
            "AND f.Status = 'request'";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function acceptFriendRequests($userId, $selectedRequests) {
    $pdo = getPDO();
    try {
        

        $sanitizedUserIds = array_map([$pdo, 'quote'], $selectedRequests);

        $sql = "UPDATE friendship SET Status = 'accepted' WHERE Friend_RequesteeId = :userId " .
                "AND Friend_RequesterId IN (" . implode(',', $sanitizedUserIds) . ")";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);
    } catch (PDOException $e) {
        return "Error updating data: " . $e->getMessage();
    }
}

function automaticallyAcceptFriendRequests($userId, $friendUserId) {
    $pdo = getPDO();

    try {
        $selectedFriends = is_array($friendUserId) ? $friendUserId : [$friendUserId];
        $placeholders = implode(', ', array_map(function ($friend) {
                    return ':' . $friend;
                }, $selectedFriends));

        $sql = "UPDATE friendship SET Status = 'accepted' WHERE 
            (Friend_RequesterId = :userId AND Friend_RequesteeId IN ($placeholders)) OR
            (Friend_RequesteeId = :userId AND Friend_RequesterId IN ($placeholders))";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':userId', $userId);

        foreach ($selectedFriends as $friend) {
            $stmt->bindValue(':' . $friend, $friend);
        }

        $stmt->execute();
    } catch (PDOException $e) {
        return "Error updating data: " . $e->getMessage();
    }
}

function fetchAcceptedFriends($userId) {
    $pdo = getPDO();

    try {
        $sql = "SELECT u.Name, COUNT(DISTINCT CASE " .
                "WHEN a.Owner_Id = :userId THEN NULL " .
                "ELSE a.Album_Id " .
                "END) AS SharedAlbums,u.UserId AS FriendId " .
                "FROM Friendship AS f " .
                "JOIN user AS u ON (CASE " .
                "WHEN f.Friend_RequesterId = :userId THEN f.Friend_RequesteeId " .
                "WHEN f.Friend_RequesteeId = :userId THEN f.Friend_RequesterId " .
                "END = u.UserId) " .
                "LEFT JOIN album AS a ON ((f.Friend_RequesterId = a.Owner_Id OR f.Friend_RequesteeId = a.Owner_Id) AND a.Accessibility_Code = 'shared') " .
                "LEFT JOIN Accessibility AS ac ON a.Accessibility_Code = ac.Accessibility_Code " .
                "WHERE (:userId IN (f.Friend_RequesterId, f.Friend_RequesteeId)) AND f.Status = 'accepted' " .
                "GROUP BY u.UserId";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);

        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $friends;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function defriendSelected($userId, $selectedFriends) {
    $pdo = getPDO();

    try {
        $placeholders = implode(', ', array_map(function ($friend) {
                    return ':' . $friend;
                }, $selectedFriends));

        $sql = "DELETE FROM friendship WHERE 
            (Friend_RequesterId = :userId AND Friend_RequesteeId IN ($placeholders)) OR
            (Friend_RequesteeId = :userId AND Friend_RequesterId IN ($placeholders))";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':userId', $userId);

        foreach ($selectedFriends as $friend) {
            $stmt->bindValue(':' . $friend, $friend);
        }

        $stmt->execute();
    } catch (PDOException $e) {
        return "Error updating data: " . $e->getMessage();
    }
}

function fetchSharedAlbums($friendUserId) {
    $pdo = getPDO();

    try {
        $sql = "SELECT a.Album_Id, a.Title, COUNT(p.Picture_Id) AS PicCount, ac.Description AS Accessibility  FROM album a " .
                "LEFT JOIN picture p ON a.Album_Id = p.Album_Id " .
                "LEFT JOIN accessibility ac ON a.Accessibility_Code = ac.Accessibility_Code " .
                "WHERE a.Owner_Id = :friendUserId AND a.Accessibility_Code = 'shared' " .
                "GROUP BY a.Album_Id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':friendUserId', $friendUserId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function fetchAlbums($userId) {
    $pdo = getPDO();

    try {
        $sql = "SELECT a.Album_Id, a.Title, COUNT(p.Picture_Id) AS PicCount, ac.Description AS Accessibility  FROM album a " .
                "LEFT JOIN picture p ON a.Album_Id = p.Album_Id " .
                "LEFT JOIN accessibility ac ON a.Accessibility_Code = ac.Accessibility_Code " .
                "WHERE a.Owner_Id = :userId " .
                "GROUP BY a.Album_Id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function denyFriendRequests($userId, $selectedRequests) {
    $pdo = getPDO();
    try {
        $sql = "DELETE FROM friendship WHERE Status = 'request' AND Friend_RequesteeId = :userId " .
                "AND Friend_RequesterId IN (" . implode(',', $selectedRequests) . ")";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userId' => $userId]);
    } catch (PDOException $e) {
        return "Error updating data: " . $e->getMessage();
    }
}

function isAnyCheckboxSelected($checkboxArray) {
    return !empty($checkboxArray);
}

function ValidateId($x) {
    if (empty($x)) {
        $_SESSION['inputErrors']['id'] = "Student ID can not be blank";
    } else {
        try {
            $xClean = trim($x);
            $user = getUserById($xClean);
            if ($user) {
                $_SESSION['inputErrors']['id'] = "Student ID already exists in the system";
            } else {
                unset($_SESSION['inputErrors']['id']);
                $_SESSION['id'] = $xClean;
            }
        } catch (Exception $e) {
            die("An error occurred: " . $e->getMessage());
        }
    }
}

function ValidateName($x) {
    if (empty($x)) {
        $_SESSION['inputErrors']['name'] = "Name can not be blank";
    } else {
        $xClean = trim($x);
        unset($_SESSION['inputErrors']['name']);
        $_SESSION['name'] = $xClean;
    }
}

function ValidatePhone($x) {
    if (empty($x)) {
        $_SESSION['inputErrors']['phone'] = "Phone Number can not be blank";
    } else {
        $xClean = trim($x);
        $pattern = "/^(?![01]\d{2}-[01]\d{2}-\d{4})[2-9]\d{2}-[2-9]\d{2}-\d{4}$/";
        if (!preg_match($pattern, $xClean)) {
            $_SESSION['inputErrors']['phone'] = "Phone number format is incorrect. It should be in the format nnn-nnn-nnnn.";
        } else {
            unset($_SESSION['inputErrors']['phone']);
            $_SESSION['phone'] = $xClean;
        }
    }
}

function ValidatePassword($x) {
    if (empty($x)) {
        $_SESSION['inputErrors']['password'] = "Password can not be blank";
    } elseif (strlen($x) < 6 || !preg_match('/[A-Z]/', $x) || !preg_match('/[a-z]/', $x) || !preg_match('/[0-9]/', $x)) {
        $_SESSION['inputErrors']['password'] = "Password must be at least 6 characters long, contain at least one uppercase letter, one lowercase letter, and one digit.";
    } else {
        $xClean = trim($x);
        unset($_SESSION['inputErrors']['password']);
        $_SESSION['password'] = $xClean;
    }
}

function ValidateRepeatPassword($password, $repeatPassword) {
    if (empty($repeatPassword)) {
        $_SESSION['inputErrors']['repeatPassword'] = "Repeat Password can not be blank";
    } elseif ($password !== $repeatPassword) {
        $_SESSION['inputErrors']['repeatPassword'] = "Repeat Password must match the original password.";
    } else {
        $xClean = trim($repeatPassword);
        unset($_SESSION['inputErrors']['repeatPassword']);
        $_SESSION['repeatPassword'] = $xClean;
    }
}

function addNewUser($userId, $name, $phone, $password) {
    $pdo = getPDO();

    $sql = "INSERT INTO user VALUES( :userId, :name, :phone, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['userId' => $userId, 'name' => $name, 'phone' => $phone, 'password' => $password]);
}

function fetchAccessibilityOptions() {
    $pdo = getPDO();

    try {
        $sql = "SELECT Accessibility_Code, Description FROM accessibility";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function deleteAlbum($albumId) {
    $pdo = getPDO();

    try {
        $stmtPicture = $pdo->prepare("DELETE FROM picture WHERE Album_Id = :albumId");
        $stmtPicture->bindParam(':albumId', $albumId);
        $stmtPicture->execute();

        $stmtAlbum = $pdo->prepare("DELETE FROM album WHERE Album_Id = :albumId");
        $stmtAlbum->bindParam(':albumId', $albumId);
        $stmtAlbum->execute();
    } catch (PDOException $e) {
        return [];
    }
}

function createAlbum($title, $description, $ownerId, $accessibilityCode) {
    $pdo = getPDO();
    try {
        $stmtAlbum = $pdo->prepare("INSERT INTO album (Title, Description, Owner_Id, Accessibility_Code) VALUES (:title, :description, :ownerId, :accessibilityCode)");
        $stmtAlbum->bindParam(':title', $title, PDO::PARAM_STR);
        $stmtAlbum->bindParam(':description', $description, PDO::PARAM_STR);
        $stmtAlbum->bindParam(':ownerId', $ownerId, PDO::PARAM_STR);
        $stmtAlbum->bindParam(':accessibilityCode', $accessibilityCode, PDO::PARAM_STR);

        $stmtAlbum->execute();
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        return false;
    }
}

function updateAlbumAccessibility($albumId, $newAccessibility) {
    $pdo = getPDO();
    $sql = "UPDATE album SET Accessibility_Code = :newAccessibility WHERE Album_Id = :albumId";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':newAccessibility', $newAccessibility);
        $stmt->bindParam(':albumId', $albumId);
        $stmt->execute();
    } catch (PDOException $e) {
        return [];
    }
}

function fetchAlbumNames($userId) {
    $pdo = getPDO();
    try {
        $sql = "SELECT Album_Id, Title FROM album WHERE Owner_Id = :userId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle the exception, log or display an error message
        die("Error fetching album names: " . $e->getMessage());
    }
}

function fetchPicturesForAlbum($albumId) {
    $pdo = getPDO();
    try {
        $sql = "SELECT * FROM picture WHERE Album_Id = :albumId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':albumId', $albumId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle the exception, log or display an error message
        die("Error fetching pictures for album: " . $e->getMessage());
    }
}

function createThumbnail($sourcePath, $thumbnailPath, $width, $height) {
    list($sourceWidth, $sourceHeight, $sourceType) = getimagesize($sourcePath);
    switch ($sourceType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }
    $thumbnailImage = imagecreatetruecolor($width, $height);
    imagecopyresampled($thumbnailImage, $sourceImage, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);

    switch ($sourceType) {
        case IMAGETYPE_JPEG:
            imagejpeg($thumbnailImage, $thumbnailPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbnailImage, $thumbnailPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($thumbnailImage, $thumbnailPath);
            break;
        default:
            return false;
    }
    imagedestroy($thumbnailImage);
    imagedestroy($sourceImage);

    return true;
}

function albumPhotoFetch() {
// Fetch photos for the selected album
    $selectedAlbum = isset($_GET['album']) ? $_GET['album'] : (count($albums) > 0 ? $albums[0] : null);
    $stmt = $conn->prepare("SELECT * FROM photos WHERE album_id = :album_id");
    $stmt->bindParam(':album_id', $selectedAlbum);
    $stmt->execute();
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function commentAdd($authorId, $pictureId, $commentText) {

    $pdo = getPDO();

    try {
        $sql = "INSERT INTO comment (Author_Id, Picture_Id, Comment_Text) VALUES ($authorId, $pictureId, '$commentText')";
        $pdo->exec($sql);
        return "Comment added successfully";
    } catch (PDOException $e) {
        error_log("Error: " . $e->getMessage(), 0);
        echo "Error: " . $e->getMessage();
    }
}

function fetchCommentsForPicture($pictureId) {
    $pdo = getPDO();
    try {
        $sql = "SELECT * FROM comment WHERE Picture_Id = $pictureId ORDER BY Comment_Id DESC";
        $stmt = $pdo->query($sql);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    } catch (PDOException $e) {
        die("Error fetching album names: " . $e->getMessage());
    }
}

function createResizedImage($sourcePath, $destinationPath, $maxWidth, $maxHeight, $quality = 85) {
    list($sourceWidth, $sourceHeight, $sourceType) = getimagesize($sourcePath);

    switch ($sourceType) {
        case IMAGETYPE_JPEG:
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $sourceImage = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }

    list($newWidth, $newHeight) = calculateResizedDimensions($sourceWidth, $sourceHeight, $maxWidth, $maxHeight);

    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

    imagejpeg($resizedImage, $destinationPath, $quality);

    imagedestroy($resizedImage);
    imagedestroy($sourceImage);

    return true;
}

function calculateResizedDimensions($sourceWidth, $sourceHeight, $maxWidth, $maxHeight) {
    $aspectRatio = $sourceWidth / $sourceHeight;

    if ($maxWidth / $maxHeight > $aspectRatio) {
        $newWidth = $maxHeight * $aspectRatio;
        $newHeight = $maxHeight;
    } else {
        $newWidth = $maxWidth;
        $newHeight = $maxWidth / $aspectRatio;
    }

    return [$newWidth, $newHeight];
}

function save_uploaded_file($destinationPath) {
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }
    $filePaths = array();
    foreach ($_FILES['pictures']['tmp_name'] as $key => $tempFilePath) {
        $originalFileName = $_FILES['pictures']['name'][$key];

        $pathInfo = pathinfo($originalFileName);
        $dir = isset($pathInfo['dirname']) ? $pathInfo['dirname'] : '';
        $fileName = isset($pathInfo['filename']) ? $pathInfo['filename'] : '';
        $ext = isset($pathInfo['extension']) ? $pathInfo['extension'] : '';
        $filePath = $destinationPath . "/" . $fileName . "." . $ext;
        $i = 1;
        while (file_exists($filePath)) {

            $filePath = $destinationPath . "/" . $fileName . "_" . $i . "." . $ext;
            $i++;
        }
        move_uploaded_file($tempFilePath, $filePath);
        $filePaths[] = $filePath;
    }
    return $filePaths;
}

function resamplePicture($filePath, $destinationPath, $maxWidth, $maxHeight) {
    if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $imageDetails = getimagesize($filePath);

    $originalResource = null;
    if ($imageDetails[2] == IMAGETYPE_JPEG) {
        $originalResource = imagecreatefromjpeg($filePath);
    } elseif ($imageDetails[2] == IMAGETYPE_PNG) {
        $originalResource = imagecreatefrompng($filePath);
    } elseif ($imageDetails[2] == IMAGETYPE_GIF) {
        $originalResource = imagecreatefromgif($filePath);
    }
    $widthRatio = $imageDetails[0] / $maxWidth;
    $heightRatio = $imageDetails[1] / $maxHeight;
    $ratio = max($widthRatio, $heightRatio);

    $newWidth = $imageDetails[0] / $ratio;
    $newHeight = $imageDetails[1] / $ratio;

    $newImage = imagecreatetruecolor($newWidth, $newHeight);
//the imagecopyresampled function in PHP does not handle animated GIFs well.!!!!!!
    $success = imagecopyresampled($newImage, $originalResource, 0, 0, 0, 0,
            $newWidth, $newHeight, $imageDetails[0], $imageDetails[1]);

    $pathInfo = pathinfo($filePath);
    $newFilePath = $destinationPath . "/" . $pathInfo['filename'];
    if ($imageDetails[2] == IMAGETYPE_JPEG) {
        $newFilePath .= ".jpg";
        $success = imagejpeg($newImage, $newFilePath, 100);
    } elseif ($imageDetails[2] == IMAGETYPE_PNG) {
        $newFilePath .= ".png";
        $success = imagepng($newImage, $newFilePath, 0);
    } elseif ($imageDetails[2] == IMAGETYPE_GIF) {
        $newFilePath .= ".gif";
        $success = imagegif($newImage, $newFilePath);
    }


    if (!$success) {
        imagedestroy(newImage);
        imagedestroy(originalResource);
        return "";
    } else {
        return $newFilePath;
    }
}
