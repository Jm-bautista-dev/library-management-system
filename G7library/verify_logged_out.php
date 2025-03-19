<?php
    // Check if session is not already active before starting it
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['type'])) {
        // Do nothing; user is logged out.
    } else if (strcmp($_SESSION['type'], "librarian") == 0) {
        header("Location: ../librarian/home.php");
        exit();
    } else if (strcmp($_SESSION['type'], "member") == 0) {
        header("Location: ../member/home.php");
        exit();
    }
?>
