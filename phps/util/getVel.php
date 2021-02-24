<?php

    require_once "BobiJumpDB.php";

    session_start();
    if(!isset($_SESSION['username'])){
        echo "ACCESSO NEGATO";
        exit();
    }

    $result = fetchvel($_SESSION['username']);
    echo json_encode(["result"=>$result]);

?>