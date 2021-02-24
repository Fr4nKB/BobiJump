<?php
    require_once 'navbar.php';
    require_once 'util/BobiJumpDB.php';
?>
        <main class = "fontcolor">
            <h1 class = "textcentered">Scoreboard</h1>
            <p class = "textcentered" id = "fontsizeP">Qui puoi vedere come te la cavi contro tutti gli altri giocatori..</p>
            <table class = "centered" id = "scoreboard">
                <tr><th>Posizione</th><th>Username</th><th>HighestScore</th><th>Tempo di gioco (hh:mm:ss)</th></tr>
                <?php
                    //ottengo dal db la scoreboard ordinata in base al punteggio e la stampo usando una tabella
                    $rows = mysqli_fetch_all(fetchScoreboard());
                    $rn = 1;    //indica il numero della riga nella tabella
                    foreach ($rows as $v) {
                        echo "<tr";
                        if (isLogged() && ($v[0] == $_SESSION['username'])) echo " id = 'highlight'";   //se l'utente ha effettuato l'accesso e lo username sulla riga è il suo lo metto in risalto
                        echo "><td class='posizione'>".$rn."</td><td>".$v[0]."</td><td>".$v[2]."</td><td>".$v[3]."</td></tr>";
                        $rn++;
                    }
                
                ?>
            </table>
        </main>
    </body>
</html>