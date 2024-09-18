<?php
include_once 'Functions.php';
include_once 'EntityClassLib.php';
session_start();
extract($_POST);
$loginErrorMsg = '';
$_SESSION['inputErrors'] = null;

if (isset($btnLogin)) {
    ValidateIdLogIn($txtId);
    ValidatePasswordLogIn($txtPassword);
    if (!$_SESSION['inputErrors']) {
        $password = $txtPassword;
        //$password = hash("sha256", $txtPassword);
        try {
            $user = getUserByIdAndPassword($txtId, $password);
        } catch (Exception $e) {
            die("The system is currently not available, try again later");
        }
        if ($user == null) {
            $loginErrorMsg = 'Incorrect Student ID and/or Password!';
        } else {
            $_SESSION['userId'] = $user->getUserId();
            $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'MyAlbums.php';
            unset($_SESSION['redirect_url']);
            header('Location: ' . $redirect_url);
            exit();
        }
    }
}
include 'Header.php';
?>
<div class="content-container">
    <h1>Log In</h1>

    <p>You need to <a href='NewUser.php'>sign up</a> if you are a new user</p>

    <form action='Login.php' method='post'>
        <table>
            <tr><td colspan='2' style='color:Red'><?php echo $loginErrorMsg; ?></td></tr>
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
                <td>&nbsp;</td>
                <td style='text-align: center'>
                    <button type="submit" name='btnLogin' class="btn btn-primary">Submit</button>
                    <button type='reset' class="btn btn-primary">Clear</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include 'Footer.php'; ?>
</body>
</html>