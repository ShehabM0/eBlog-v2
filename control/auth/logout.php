<?php
    if(!isset($_SESSION))
        session_start();
    $_SESSION["user"] = null;
    array_push($_SESSION["messages"], "Logged Out.");
    header("location: /blog");
?>