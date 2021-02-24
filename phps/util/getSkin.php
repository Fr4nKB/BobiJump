<?php

    require_once "BobiJumpDB.php";

    session_start();
    if(!isset($_SESSION['username'])){
        echo "ACCESSO NEGATO";
        exit();
    }

    $result = fetchskin($_SESSION['username']);
    echo json_encode(["skinid"=>$result[0],"path"=>$result[1]]);    //restituisco sottoforma di array il risultato
    
?>