<?php

    require_once "BobiJumpDB.php";

    session_start();
    if(!isset($_SESSION['username'])){
        echo "ACCESSO NEGATO";
        exit();
    }

    updateSkin($_SESSION['username'], $_GET['newSkin']);

?>