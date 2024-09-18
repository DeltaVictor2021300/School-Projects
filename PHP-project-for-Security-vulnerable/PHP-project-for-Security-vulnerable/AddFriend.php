<?php
include_once 'EntityClassLib.php';
include_once 'Functions.php';
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: Login.php');
    exit();
}
$userId = $_SESSION['userId'];
$friendUserId = null;
$requestSent = null;
$msgs = array();
$friendName = null; 

if (isset($_POST['friendUserId'])) {
    $friendUserId = $_POST['friendUserId'];
    $friendUser = getUserById($friendUserId);
    if ($friendUser) {
        $friendName = getNameById($friendUserId);
    } else {
        $msgs[] = "User with ID $friendUserId does not exist!";
    }
    if (userExists($friendUserId)) {
        if ($userId != $friendUserId) {
            if (areFriends($userId, $friendUserId)) {
                $msgs[] = "You and $friendName are already friends.";
            } elseif (friendshipRequestExists($userId, $friendUserId)) {
                try {
                    automaticallyAcceptFriendRequests($userId, [$friendUserId]);
                    $msgs[] = "Friendship created automatically!";
                } catch (PDOException $e) {
                    echo "Error creating friendship request: " . $e->getMessage();
                }
            } else {
                try {
                    createFriendshipRequest($userId, $friendUserId);
                    $requestSent = <<<specifier
                    Your request has been sent to $friendName(ID: $friendUserId ).<br>
                    Once $friendName accepts your request, you and $friendName <br>
                    will be friends and be able to view each other's shared<br>
                    albums.<br>
                    specifier;
                } catch (PDOException $e) {
                    echo "Error creating friendship request: " . $e->getMessage();
                }
            }
        } else {
            $msgs[] = "You can't send a friend request to yourself!";
        }
    } 
}
$loggedInUserName = getNameById($userId);
include 'Header.php'; 
?>
        <div class="content-container">
        <h1 class="text-center">Add Friend</h1>
        <?php
        echo "<p>Welcome <span style='font-weight: bold; color: black;'>$loggedInUserName</span>! (not you? change user <a href='LogOut.php'>here</a>)</p>";
        echo "<p>Enter the ID of the user you want to be friends with</p>";
        if (!empty($msgs)) {
            foreach ($msgs as $msg) {
                echo "<p style='color: red;'>$msg</p>";
            }
        }
        if (isset($requestSent)) {
            echo "<p style='color: red;font-weight: bold;'>$requestSent</p>";
        }
        ?>
        <form action='' method='post'>
            <table>
                <tr>
                    <th>ID:</th>
                    <td>
                        <div style="display: flex; align-items: center;">
                            <input type="text" name="friendUserId" value="<?php echo isset($friendUserId) ? $friendUserId : ''; ?>"/>
                        </div>
                    </td>
                    <td>&nbsp;</td>
                    <td colspan='2'>&nbsp;</td>
                    <td colspan='2'>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style='text-align: center'>
                        <button type="submit" name='btnFrRequest' class="btn btn-primary">Send Friend Request</button>
                    </td>
                </tr>
            </table>
        </form>
        <?php include 'Footer.php'; ?>
    </body>
    </div>
    <?php include 'Footer.php'; ?>
</html>
