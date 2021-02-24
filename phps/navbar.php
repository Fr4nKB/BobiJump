<?php
    require_once 'util/sessionUtil.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/main.css">
        <title>BobiJump</title>
    </head>
    <body class="bg">
    <nav class="navbar main"> 
        <ul class="navbar left">
            <li class="website">BobiJump</li>
            <li><a href="index.php">Home</a></li>
            <?php if (isLogged()) { ?>
            <li><a href="profile.php">Profilo</a></li>
            <?php } ?>
            <li><a href="scoreboard.php">Scoreboard</a></li>
            <li><a href="instruction.php">Istruzioni</a></li>
        </ul>
        <ul class="navbar right">
            <?php if (isLogged()) { //stampo il tasto del profilo e il messaggio di benvenuto se l'utente è loggato ?>
            <li ><a><span id="welcome"><?php echo "Bentornato, ".$_SESSION['username']; ?></span></a></li>
            <li><a href="logout.php"><span></span> Logout</a></li>
            <?php } else { ?>
            <li><a href="signuppage.php"><span></span> Sign Up</a></li>
            <li><a href="loginpage.php"><span></span> Login</a></li>
            <?php } ?>
        </ul>
    </nav>