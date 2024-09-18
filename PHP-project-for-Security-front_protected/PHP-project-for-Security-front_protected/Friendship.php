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
$selError = "Make your selection first!";
$boxSelected = false;
$msgs = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accept']) && empty($_POST['selectedRequests'])) {
        $msgs[] = "Please choose a name to accept the request";
    } elseif (isset($_POST['accept']) && !empty($_POST['selectedRequests'])) {
        acceptFriendRequests($userId, $_POST['selectedRequests']);
    }

    if (isset($_POST['defriend']) && empty($_POST['selectedFriends'])) {
        $msgs[] = "Please choose a name to defriend it";
    } elseif (isset($_POST['defriend']) && !empty($_POST['selectedFriends'])) {
        defriendSelected($userId, $_POST['selectedFriends']);
    }

    if (isset($_POST['deny']) && empty($_POST['selectedRequests'])) {
        $msgs[] = "Please choose a name to decline request";
    } elseif (isset($_POST['deny']) && !empty($_POST['selectedRequests'])) {
        denyFriendRequests($userId, $_POST['selectedRequests']);
    }
}
$friends = fetchAcceptedFriends($userId);
$loggedInUserName = getNameById($userId);
include 'Header.php';
?>

<div class="content-container">
    <h1 class="text-center">My Friends</h1>
    <?php
    echo "<p>Welcome <span style='font-weight: bold; color: black;'>$loggedInUserName</span>! (not you? change user <a href='LogOut.php'>here</a>)</p>";
    if (!empty($msgs)) {
        foreach ($msgs as $msg) {
            echo "<p style='color: red;'>$msg</p>";
        }
    }
    ?>
    <form action="" method="post" id="">
        <?php
        $friendCount = count($friends);
        echo "<table class='table'>";
        echo "<thead><tr><th>Friends:</th><th>     </th><th class='text-center'><a href='AddFriend.php'>Add Friends</a></th></tr></thead>";
        echo "</table>";
        if ($friendCount > 0) {
            echo "<table class='table'>";
            echo "<thead><tr><th>Name</th><th>Shared Albums</th><th>Defriend</th></tr></thead>";
            echo "<tbody>";

            foreach ($friends as $friend) {
                echo "<tr>";
                echo "<td><a href='MyFriendAlbums.php?friendId={$friend['FriendId']}'>{$friend['Name']}</a></td>";

                echo "<td>{$friend['SharedAlbums']}</td>";
                echo "<td><input type='checkbox' name='selectedFriends[]' value='{$friend['FriendId']}' id='{$friend['FriendId']}'></td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "<div class='text-right' style='margin-bottom: 20px;'>";
            echo '<button type="submit" class="btn btn-primary" name="defriend" onclick="return confirmAction(\'defriend\');">Defriend Selected</button>';
            echo "</div>";
        } else {
            echo "<p>No Shared Albums.</p>";
        }
        ?>

    </form>
    <form action="" method="post" id="">
        <?php
        $friendRequests = fetchFriendRequests($userId);

        if (empty($friendRequests)) {
            echo "<p>No friend requests.</p>";
        } else {
            echo "<table class='table'>";
            echo "<thead><tr><th>Name</th><th>Accept or Deny</th></tr></thead>";
            echo "<tbody>";

            foreach ($friendRequests as $request) {

                $userId = $request['UserId'] ?? null;

                if ($userId !== null) {
                    $friendUser = getUserById($userId);

                    if ($friendUser instanceof User) {
                        echo "<tr>";
                        echo "<td>{$request['Name']}</td>";
                        echo "<td><input type='checkbox' name='selectedRequests[]' value='{$friendUser->getUserId()}' id='{$friendUser->getUserId()}'></td>";
                        echo "</tr>";
                    } else {
                        echo "<p>Error: Friend user not found.</p>";
                    }
                } else {
                    echo "<p>Error: 'UserId' not found in friend request.</p>";
                }
            }
            echo "</tbody></table>";
            echo "<div class='text-right' style='margin-bottom: 20px;'>";
            echo "<button type='submit' class='btn btn-primary' name='accept' >Accept Selected</button>";
            echo "<span style='margin-right: 10px;'></span>";
            echo '<button type="submit" class="btn btn-primary" name="deny" onclick="return confirmAction(\'deny\');">Deny Selected</button>';
            echo "</div>";
        }
        ?>
    </form>
</div>
<script>
    function confirmAction(actionType) {
        var selectedFriends = document.querySelectorAll("input[name='selectedFriends[]']:checked");
        var selectedRequests = document.querySelectorAll("input[name='selectedRequests[]']:checked");

        if (actionType === 'defriend' && selectedFriends.length === 0) {
            return true; // No confirmation needed if nothing is selected for defriending
        }

        if (actionType === 'deny' && selectedRequests.length === 0) {
            return true; // No confirmation needed if nothing is selected for denying
        }

        var confirmationMessage;

        if (actionType === 'defriend') {
            confirmationMessage = "The selected friends will be defriended! Are you sure?";
        } else if (actionType === 'deny') {
            confirmationMessage = "The selected friend requests will be denied! Are you sure?";
        }

        var isConfirmed = confirm(confirmationMessage);

        return isConfirmed;
    }
</script>
<?php include 'Footer.php'; ?>
