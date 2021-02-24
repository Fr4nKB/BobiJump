<?php
    require_once 'navbar.php';
    require_once 'util/BobiJumpDB.php';
?>
        <main class = "fontcolor">
            <h1 class = "textcentered" id = "username"><?php echo $_SESSION['username']; ?></h1>
            <p class = "textcentered">Il tuo personaggio più usato</p>
            <div class = "centered" id = "mostUsed" style="
                <?php //prelevo il path dal db della skin più usata dall'utente con la funzione mostUsed
                    $result = mysqli_fetch_row(mostUsed($_SESSION['username']));
                    echo "background-image:url(".$result[1].")";
                ?>">
            </div>
            <?php   //stamp i risultati trovati prima quali nome della skin e tempo di utilizzo
                echo "<p class = 'textcentered fontsizeP'>Hai usato <b><em>".$result[0]."</em></b> per un totale di ".$result[2]. " (hh:mm:ss)";
            ?>
            <p class = "textcentered">Personaggi sbloccati</p>
            <div id="skinLib" class="skin centered">
                <?php   //stampa di tutte le skin sbloccate dall'utente per consentire di sceglierne una per giocare
                    foreach(charList($_SESSION['username']) as $d) { ?>
                        <img alt="" onclick=<?php echo "chooseSkin('skin" . $d['characterId'] . "');"; ?> id="<?php echo "skin" . $d['characterId']; ?>" src="<?php echo $d['path']; ?>">
                <?php } ?>
            </div>
            <p class = "textcentered fontsizeP">Puoi selezionare uno dei personaggi cliccandoci sopra, il rettangolo illuminato indica quale personaggio è attualmente in uso.</p>
        </main>
        <script src="../scripts/manageChar.js"></script>
        <script>fetchSkin(1,1);</script>
    </body>
</html>