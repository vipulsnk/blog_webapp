<?php
    include("config/config.php");
    session_start();
    session_unset();
    session_destroy();
    header("Location: ".ROOT_URL."");
?>