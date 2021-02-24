<?php
    require_once 'navbar.php';
?>
        <main>
            <h1 class="fontcolor textcentered">Istruzioni</h1>
            <p id="instructions">
                BobiJump è un gioco ispirato a doodlejump. Il giocatore ha lo scopo di raggiungere il punteggio più alto possibile saltando su delle piattaforme.<br><br>
                Il gioco si trova nella scheda "Home" e si avvia cliccando con il mouse sul simbolo di PLAY.
                L'utente può muovere il giocatore usando i tasti A e D della tastiera, il salto è invece gestito automaticamente.
                In alto a destra, quando la partita è avviata, è presente un bottone per mettere il gioco momentaneamente in pausa.
                Le piattaforme, generate in posizioni casuali, possono talvolta scomparire quando ci si salta sopra.<br><br>
                Quando il gioco è avviato in alto a sinistra è presente uno contatore che indica lo score attuale. 
                Lo score viene aumentato ad ogni salto e varia in base all'altezza: più si è in basso e più punti vengono aggiunti allo score.
                Il gioco ha una difficoltà incrementale nel tempo: via via che si gioca sempre meno piattaforme si creeranno e la velocità con cui scendono incrementa fino a raggiungere un limite.<br><br>
                Occasionalmente viene creato un power up, segnalato dall'icona di una stella, il quale raddoppia i punti assegnati ad ogni salto. Ha una durata di 8 secondi, che viene segnalata
                accanto allo score da un "X2".<br><br>
                È possibile registrarsi nel sito cliccando su "Sign Up" in alto a destra sulla barra di navigazione.
                Avere un account permette di memorizzare il proprio <em>highscore</em> e partecipare nella <em>scoreboard</em> la quale si trova nella scheda "Scoreboard".
                Permette inoltre di sbloccare altre skin per il personaggio oltre a quella di default fra le quali:<br>
                - <em>clown</em> (si sblocca facendo 50.000 punti)<br>
                - <em>trump</em> (si sblocca facendo 75.000 punti)<br>
                I personaggi sbloccabili hanno una capacità di salto maggiore rispetto al personaggio precedente.<br><br>
                Per gli utenti che si sono registrati, è possibile fare il login cliccando in alto a destra sulla barra di navigazione il pulsante "Login".<br>
                Nella scheda "Profilo" è possibile, per gli utenti che si sono registrati, cambiare la skin del personaggio, vedere le loro statistiche come il personaggio più usato,
                per quanto tempo è stato usato e l'highscore.<br><br>
            </p>
        </main>

    </body>
</html>
