<?php

include_once 'EntityClassLib.php';
include_once 'Functions.php';
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: Login.php');
    exit();
}
$loggedInUserId = $_SESSION['userId'];
$friendUserId = isset($_GET['friendId']) ? $_GET['friendId'] : null;
$_SESSION['friendUserId'] = $friendUserId;
$loggedInUserName = getNameById($loggedInUserId);
if ($friendUserId && userExists($friendUserId)) {
    $sharedAlbums = fetchSharedAlbums($friendUserId);
    echo "<div class='content-container'>";
    echo "<h1 class='text-center'>Shared Albums</h1>";
    echo "<p>Welcome <span style='font-weight: bold; color: black;'>$loggedInUserName</span>! (not you? change user <a href='LogOut.php'>here</a>)</p>";
    if (!empty($sharedAlbums)) {
        echo "<table class='table'>";
        echo "<thead><tr><th>Title</th><th>Number of Pictures</th><th>Accessibility</th></tr></thead>";
        echo "<tbody>";

        foreach ($sharedAlbums as $album) {
            echo "<tr>";
            echo "<td><a href='FriendPictures.php?albumId={$album['Album_Id']}'>{$album['Title']}</a></td>";
            echo "<td>{$album['PicCount']}</td>";
            echo "<td>{$album['Accessibility']}</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No shared albums with {$loggedInUserName}.</p>";
    }
} else {
    echo "<p>Invalid friend ID.</p>";
}
echo "</div>";
include 'Header.php';
?>
<?php include 'Footer.php'; ?>
   

