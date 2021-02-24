<?php

    require_once "BobiJumpDB.php";

    session_start();
    if(!isset($_SESSION['username'])){
        echo "ACCESSO NEGATO";
        exit();
    }

    newhighscore($_SESSION['username'], $_GET['score']);
    updateTime($_SESSION['username'], $_GET['time']);

?>