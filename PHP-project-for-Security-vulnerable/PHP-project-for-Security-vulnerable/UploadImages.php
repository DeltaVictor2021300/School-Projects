<?php
//
include_once "Functions.php";
session_start();
$_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
if (!isset($_SESSION['userId'])) {
    header('Location: Login.php');
    exit();
}

//define constants for convenience
define("ORIGINAL_IMAGE_DESTINATION", "originals");

define("IMAGE_DESTINATION", "img");
define("IMAGE_MAX_WIDTH", 800);
define("IMAGE_MAX_HEIGHT", 600);

define("THUMB_DESTINATION", "thumbnails");
define("THUMB_MAX_WIDTH", 100);
define("THUMB_MAX_HEIGHT", 100);
$userId = $_SESSION['userId'];
$error = "";

$MyPdo = getPDO();

//Use an array to hold supported image types for convenience
$supportedImageTypes = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

if (isset($_POST['btnUpload'])) {
    $files = $_FILES['pictures'];
    $originalsFilePaths = save_uploaded_file(ORIGINAL_IMAGE_DESTINATION);

    foreach ($originalsFilePaths as $key => $filePath) {
        if ($files['error'][$key] == 0) {
            if ($filePath) {
                $imageDetails = getimagesize($filePath);

                if ($imageDetails && in_array($imageDetails[2], $supportedImageTypes)) {
                    resamplePicture($filePath, IMAGE_DESTINATION, IMAGE_MAX_WIDTH, IMAGE_MAX_HEIGHT);
                    resamplePicture($filePath, THUMB_DESTINATION, THUMB_MAX_WIDTH, THUMB_MAX_HEIGHT);
                    $albumSelected = $_POST['albumSelected'];
                    $pictureTitle = $_POST['pictureTitle'];
                    $pictureDescription = $_POST['pictureDescription'];

                    $fileName = pathinfo($filePath, PATHINFO_BASENAME);
                    $pdo = getPDO();

                    $query = "INSERT INTO picture (Album_Id, File_Name, Title, Description) VALUES ($albumSelected, '$fileName', '$pictureTitle', '$pictureDescription')";
                    $pdo->exec($query);
                } else {
                    $albumSelected = $_POST['albumSelected'];
                    $pictureTitle = $_POST['pictureTitle'];
                    $pictureDescription = $_POST['pictureDescription'];

                    $fileName = pathinfo($filePath, PATHINFO_BASENAME);
                    $pdo = getPDO();

                    $query = "INSERT INTO picture (Album_Id, File_Name, Title, Description) VALUES ($albumSelected, '$fileName', '$pictureTitle', '$pictureDescription')";
                    $pdo->exec($query);
                }
            } else {
                $error = "Move uploaded file failed.";
            }
        } elseif ($files['error'][$key] == 1) {
            $error = "Upload file is too large";
        } elseif ($files['error'][$key] == 4) {
            $error = "No upload file specified";
        } else {
            $error = "Error happened while uploading the file. Try again later";
        }
    }
}

include "Header.php"
?>
<div class="container">
    <h1 class="text-center">Upload Pictures</h1>
    <p>Accepted picture types: JPEG, GIF and PNG.</p>
    <p>You can upload multiple pictures at a time by pressing the shift key while selecting pictures.</p>
    <p>When uploading multiple pictures, the title and description fields will be applied to all pictures.</p>
    <span class="text-danger" style="color: red;"><?php echo $error; ?></span>

    <form method="post" action="UploadImages.php" id="UploadForm" enctype="multipart/form-data">
        <div class="form-group row">
            <label for="albumSelected" class="col-md-offset-1 col-md-2 col-form-label">Upload to Album:</label>
            <div class="col-md-6">
                <select name="albumSelected" class="form-control">
                    <option value="-1">Select an Album...</option>
                    <?php
                    $albums = $MyPdo->query("SELECT * FROM album WHERE Owner_Id = '$userId'")->fetchAll();
                    foreach ($albums as $album) {
                        echo ("<option value=\"{$album['Album_Id']}\">{$album['Title']}</option>");
                    }
                    ?>
                </select>
            </div>
            <?php
            if (isset($albumSelectionError)) {
                echo $albumSelectionError;
            }
            ?>
        </div>

        <div class="form-group row">
            <label for="pictures[]" class="col-md-offset-1 col-md-2 col-form-label">File to Upload:</label>
            <div class="col-md-6">
                <input type="file" name="pictures[]" class="form-control" accept="image/png, image/jpeg, image/gif" multiple>
            </div>
        </div>

        <div class="form-group row">
            <label for="pictureTitle" class="col-md-offset-1 col-md-2 col-form-label">Title:</label>
            <div class="col-md-6">
                <input type="text" name="pictureTitle" class="form-control">
            </div>
        </div>

        <div class="form-group row">
            <label for="pictureDescription" class="col-md-offset-1 col-md-2 col-form-label">Description:</label>
            <div class="col-md-6">
                <textarea class="form-control" name="pictureDescription" rows="4" placeholder="Enter text"></textarea>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-offset-3 col-md-6">
                <input type="submit" name="btnUpload" class="btn btn-primary" value="Upload">
                <button id="clearForm" class="btn btn-primary">Clear</button>
            </div>



        </div>
    </form> 
    <?php
    $formSubmitted = isset($_POST['btnUpload']);
    $noErrors = empty($error) && empty($albumSelectionError);

    if ($formSubmitted && $noErrors) {
        // Move the success message outside the form
        echo "<div class=\"container\">";
        echo "<div class=\"form-group row\">";
        echo "<div class=\"col-md-offset-3 col-md-6\">";
        echo "<span class=\"text-success\"> Picture was uploaded successfully!</span>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>   
<?php
include "Footer.php"
?>   