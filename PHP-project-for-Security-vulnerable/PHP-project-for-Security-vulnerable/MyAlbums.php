<?php
include_once 'EntityClassLib.php';
include_once 'Functions.php';
session_start();
$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['userId'])) {
    header('Location: Login.php');
    exit();
}
$userId = $_SESSION['userId'];
$userName = getNameById($userId);
if (isset($_GET['deleteAlbumId'])) {
    $deleteAlbumId = $_GET['deleteAlbumId'];
    deleteAlbum($deleteAlbumId);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['albumId']) && isset($_POST['accessibility'])) {
        $albumId = $_POST['albumId'];
        $newAccessibility = $_POST['accessibility'];
        updateAlbumAccessibility($albumId, $newAccessibility);
        $albums = fetchAlbums($userId);
    }
}
if ($userId && userExists($userId)) {
    $albums = fetchAlbums($userId);
    echo "<div class='content-container'>";
    echo "<h1 class='text-center'>My Albums</h1>";
    echo "<p>Welcome <span style='font-weight: bold; color: black;'>$userName</span>! (not you? change user <a href='LogOut.php'>here</a>)</p>";
    echo "<table class='table'>";
    echo "<thead><tr><th></th><th></th><th class='text-right'><a href='AddAlbum.php'>Create new album</a></th></tr></thead>";
    echo "</table>";
    if (!empty($albums)) {
        echo "<table class='table'>";
        echo "<thead><tr><th>Title</th><th>Number of Pictures</th><th>Accessibility</th></tr></thead>";
        echo "<tbody>";

        foreach ($albums as $album) {
            echo "<tr>";
            echo "<td><a href='MyPictures.php?albumId={$album['Album_Id']}'>{$album['Title']}</a></td>";
            echo "<td>{$album['PicCount']}</td>";
            echo "<td>";
            echo "<form method='POST' action='MyAlbums.php' id='form_{$album['Album_Id']}'>"; // Add the unique form ID
            echo "<input type='hidden' name='albumId' value='{$album['Album_Id']}'>";
            echo "<select class='form-control' name='accessibility' onchange='document.getElementById(\"form_{$album['Album_Id']}\").submit()'>";
            $accessibilityOptions = fetchAccessibilityOptions();

            foreach ($accessibilityOptions as $option) {
                $selected = ($option['Description'] == $album['Accessibility']) ? 'selected' : '';
                echo "<option value=\"{$option['Accessibility_Code']}\" $selected>{$option['Description']}</option>";
            }

            echo "</select>";
            echo "</form>";
            echo "</td>";
            echo "<td>";
            echo "<a href='#' onclick='confirmDelete({$album['Album_Id']})'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No albums</p>";
    }
} else {
    echo "<p>Invalid friend ID.</p>";
}
echo "</div>";
include 'Header.php';
include 'Footer.php';
?>

<script>
    function confirmDelete(albumId) {
        var confirmDelete = confirm("Are you sure you want to delete this album? All pictures in the album will be deleted as well.");

        if (confirmDelete) {
            // If the user confirms, redirect to the same page with the albumId as a parameter
            window.location.href = 'MyAlbums.php?deleteAlbumId=' + albumId;
        }
    }
</script>
