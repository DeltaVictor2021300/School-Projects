<?php
ob_start();
include_once 'EntityClassLib.php';
include_once 'Functions.php';
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: Login.php');
    exit();
}

$userId = $_SESSION['userId'];
$loggedInUserName = getNameById($userId);
$friendUserId = $_SESSION['friendUserId'];

include_once 'Header.php';
?>

<div class="container-fluid">
    <h1 class="text-center">Shared Pictures</h1>
    <br>
    <div class="row">
        <div class="col-md-8">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                <?php
                $albums = fetchSharedAlbums($friendUserId);
                $albumId = isset($_GET['albumId']) ? $_GET['albumId'] : null;

                echo "<select name='albumId' class='form-control' onchange='submitAlbumForm()' title='Choose an album'>";
                echo "<option value='-1' " . ($albumId == -1 ? 'selected' : '') . ">Select an Album...</option>";
                foreach ($albums as $album) {
                    $selected = (isset($album['Album_Id']) && $album['Album_Id'] == $albumId) ? 'selected' : '';
                    echo "<option value='{$album['Album_Id']}' $selected>{$album['Title']}</option>";
                }
                echo "</select>";
                ?>
                <br>
            </form>

            <?php
            if ($albumId !== -1) {
                if (!is_numeric($albumId) || $albumId <= 0) {
                    echo "Hi <span style='color: blue; font-weight: bold;'>$loggedInUserName</span>! Start with selecting an album";
                } else {
                    $pictures = fetchPicturesForAlbum($albumId);
                }
                if (!empty($pictures)) {
                    $currentPictureIndex = isset($_GET['selectedPictureIndex']) ? $_GET['selectedPictureIndex'] : 0;

                    if (!isset($pictures[$currentPictureIndex])) {
                        $currentPictureIndex = 0;
                    }

                    $basePath = "./img/" . $pictures[$currentPictureIndex]['File_Name'];
                    echo "<div class='main-picture' style='width: 100%; box-sizing: border-box;'>";
                    echo "<h2 id='mainPictureName' class='text-center' style='margin: 0 0 10px;'>{$pictures[$currentPictureIndex]['Title']}</h2>";
                    echo "<img id='mainPicture' src='{$basePath}' alt='{$pictures[$currentPictureIndex]['Description']}' style='width: 100%; object-fit: cover;'>";
                    echo "</div>";
                    echo "<div class='scroll-container' style='margin-bottom: 20px;'>";
                    foreach ($pictures as $index => $picture) {
                        $thumbnailPath = "./thumbnails/" . $picture['File_Name'];
                        echo "<form action='{$_SERVER['PHP_SELF']}' method='get' style='display:inline;'>";
                        echo "<input type='hidden' name='albumId' value='$albumId'>";
                        echo "<input type='hidden' name='selectedPictureIndex' value='$index'>";
                        echo "<button type='submit' class='thumbnail-button' onclick='changePicture($index)'>";
                        echo "<img src='$thumbnailPath' alt='{$picture['Description']}' class='demo cursor thumbnail'>";
                        echo "</button>";
                        echo "</form>";
                    }
                    echo "</div>";
                }else {
                    echo "No pictures in this album yet.";
                }
            }
            ?>
        </div>
        <div class="col-md-4">
            <?php
            if (!empty($pictures)) {
                // Display the picture description
                echo "<div class='picture-description'>";
                $description = $pictures[$currentPictureIndex]['Description'];
                echo "<p><span style='font-weight: bold;'>Description:&nbsp;</span>";
                if (!empty($description)) {
                    echo $description;
                } else {
                    echo "This image does not have a description.";
                }
                echo "</p>";
                echo "</div>";

                // Display comments
                echo "<p><span style='font-weight: bold;'>Comments:</span></p>";
                echo "<div class='description-comment-area'>";
                echo "<div class='comments'>";

                $selectedPictureId = $pictures[$currentPictureIndex]['Picture_Id'];

                $comments = fetchCommentsForPicture($selectedPictureId);

                if (empty($comments)) {
                    echo "<p>No comments yet. Be the first!</p>";
                } else {
                    foreach ($comments as $comment) {
                        $authorName = getNameById($comment['Author_Id']);
                        echo "<p class='comment-author'><span style='color: blue; font-style: italic; font-weight: bold;'>{$authorName}:&nbsp;</span>{$comment['Comment_Text']}</p>";
                    }
                }
                echo "</div>";
                echo "</div>";

                // Comment form
                echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8') . "?albumId=$albumId&selectedPictureIndex=$currentPictureIndex' method='post'>";

                echo "<div class='form-group'>";
                echo "<textarea id='commentText' name='commentText' class='form-control' placeholder='Leave a comment'></textarea>";
                echo " </div>";
                echo "<input type='hidden' name='pictureId' value='" . $pictures[$currentPictureIndex]['Picture_Id'] . "'>";

                echo " <input type='hidden' name='albumId' value='$albumId'>";
                echo " <input type='hidden' name='selectedPictureIndex' value='$currentPictureIndex'>";
                echo "<button type='submit' name='addComment' class='btn btn-primary'>Add Comment</button>";
                echo "</form>";

                // Process comment submission
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addComment'])) {
                    if (isset($_POST['commentText']) && isset($_POST['pictureId'])) {
                        $commentText = $_POST['commentText'];
                        $pictureId = $_POST['pictureId'];
                        commentAdd($userId, $pictureId, $commentText);
                        echo '<script>window.location.href = "' . $_SERVER['PHP_SELF'] . '?albumId=' . $albumId . '&selectedPictureIndex=' . $currentPictureIndex . '";</script>';
                        exit();
                    } else {
                        echo "Invalid comment data.";
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
include 'Footer.php';
ob_end_flush();
?>

<script>
    function submitAlbumForm() {
        document.querySelector('form').submit();
    }


    function changePicture(index) {
        console.log('Change Picture Called with Index:', index);
        // Change the source of the main picture
        var mainPicture = document.querySelector('.main-picture img');
        mainPicture.src = "./img/" . pictures[index]['File_Name'];
        mainPicture.alt = pictures[index]['Description'];
        pictureId = pictures[index]['Picture_Id'];
        fetchCommentsForPicture(pictures[index]['Picture_Id']);
        var mainPictureName = document.getElementById('mainPictureName');
        mainPictureName.innerText = pictures[index]['Name'];

        // Remove the selected class and border from all thumbnails
        var thumbnails = document.querySelectorAll('.scroll-container img');
        thumbnails.forEach(function (thumbnail, i) {
            thumbnail.classList.remove('selected');
            thumbnail.style.border = 'none';

            // Add the selected class and apply the blue border to the clicked thumbnail
            if (i === index) {
                thumbnail.classList.add('selected');
                thumbnail.style.border = '5px solid blue';
            }
        });
    }
</script>
