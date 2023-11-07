<?php
session_start();

// delete session 'token_session'
unset($_SESSION['token_session']);

// Destroy Session
session_destroy();

header("Location: index.php");
exit;
?>
