<?php
    session_start();

    echo "Logging out. Please Wait";
    session_unset();
    session_destroy();
    header("location: /forum/index.php");
?>