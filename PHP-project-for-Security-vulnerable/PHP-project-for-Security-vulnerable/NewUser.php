<?php
include_once "Functions.php";
include_once "EntityClassLib.php";
session_start();
extract($_POST);
if (isset($regSubmit)) {
    ValidateId($txtId);
    ValidateName($txtName);
    //ValidatePhone($txtPhone);
    ValidatePassword($txtPassword);
    ValidateRepeatPassword($txtPassword, $txtPassword2);
    if (!$_SESSION['inputErrors']) {
        $password = $txtPassword;
        //$password = hash("sha256", $txtPassword);
        try {
            addNewUser($txtId, $txtName, $txtPhone, $password);
            $user = getUserByIdAndPassword($txtId, $password); 
            if ($user) 
        {
            $_SESSION['userId'] = $user->getUserId();
        } 
            header("Location: MyAlbums.php");
            exit();
        } catch (Exception $e) {
            die("The system is currently not available, try again later");
        }
        
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Algonquin College Online Course Registration</title>
        <style>
            body {
                
                padding-left: 0px; 
            }
            .content-container {
                margin-right: auto; 
                margin-left: auto;
                max-width: 800px; 
            }
        </style>
    </head>
    <body>
        <?php include 'Header.php'; ?>
        <div class="content-container">
        <h1>Sign Up</h1>
        <p>All fields are required</p>
        <form action="NewUser.php" method="post">
            <table>
                <tr>
                    <th>User ID:</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="text" name="txtId" value="<?php echo isset($txtId) ? $txtId : ''; ?>"/>
                            <?php
                            if (isset($_SESSION['inputErrors']['id'])) {
                                echo '<div style="color: red; margin-left: 10px;">' . $_SESSION['inputErrors']['id'] . '</div>';
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>&nbsp;</td>
                </tr>

                <tr>
                    <th>Name:</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="text" name="txtName" value="<?php echo isset($txtName) ? $txtName : ''; ?>"/>
                            <?php
                            if (isset($_SESSION['inputErrors']['name'])) {
                                echo '<div style="color: red; margin-left: 10px;">' . $_SESSION['inputErrors']['name'] . '</div>';
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>&nbsp;</td>
                </tr>


                <tr>
                    <th>Phone Number:<br>(nnn-nnn-nnnn)</th>
                                      <td>
                        <div style="display: flex; align-items: center;">
                            <input type="text" name="txtPhone" value="<?php echo isset($txtPhone) ? $txtPhone : ''; ?>"/>
                            <?php
                            if (isset($_SESSION['inputErrors']['phone'])) {
                                echo '<div style="color: red; margin-left: 10px;">' . $_SESSION['inputErrors']['phone'] . '</div>';
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>&nbsp;</td>
                </tr>
                <tr>
                    <th>Password:</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="password" name="txtPassword" value=""/>
                            <?php
                            if (isset($_SESSION['inputErrors']['password'])) {
                                echo '<div style="color: red; margin-left: 10px;">' . $_SESSION['inputErrors']['password'] . '</div>';
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>&nbsp;</td>
                </tr>

                <tr>
                    <th>Password Again:</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="password" name="txtPassword2" value=""/>
                            <?php
                            if (isset($_SESSION['inputErrors']['repeatPassword'])) {
                                echo '<div style="color: red; margin-left: 10px;">' . $_SESSION['inputErrors']['repeatPassword'] . '</div>';
                            }
                            ?>
                        </div>
                    </td>
                    <td >&nbsp;</td>	
                </tr>
                <tr>
                    <td colspan='2'>&nbsp;</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td style='text-align: center'>
                        <button type="submit" name='regSubmit' class="btn btn-primary">Submit</button>
                        <button type='reset' class="btn btn-primary">Clear</button>
                    </td>
                </tr>
            </table>
        </form>
        </div>
        <?php include 'Footer.php'; ?>
    </body>
</html>