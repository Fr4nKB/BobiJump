<?php
    require_once 'navbar.php';
    require_once 'util/BobiJumpDB.php';
?>
        <main>
            <div>
                <div class="verticalborder centered top">
                </div>
                <div class = "row"> 
                    <div id = "cover"></div>
                    <div class = "backgroundstart" id = "playground">
                        <em class = "hidden score centered" id = "score">0</em>
                        <svg onclick = "pause()" id="pausebtn" xmlns = "http://www.w3.org/2000/svg" fill = "currentColor" class = "hidden bi bi-pause-circle-fill" viewBox = "0 0 16 16">
                            <path d = "M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.25 5C5.56 5 5 5.56 5 6.25v3.5a1.25 1.25 0 1 0 2.5 0v-3.5C7.5 5.56 6.94 5 6.25 5zm3.5 0c-.69 0-1.25.56-1.25 1.25v3.5a1.25 1.25 0 1 0 2.5 0v-3.5C11 5.56 10.44 5 9.75 5z"/>
                        </svg>
                        <div id = "deathscreen"></div>
                        <p id = "scoreDS1" class = "score hidden">Il tuo punteggio è<br><em id = "scoreDS1e">0</em></p>
                        <p id = "scoreDS2" class = "score hidden"></p>
                        <svg onclick = "resume()" id = "resumebtn" xmlns="http://www.w3.org/2000/svg" id="startbtn" fill="currentColor" class="hidden bi bi-play-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/>
                        </svg>
                        <svg onclick = "start()" xmlns="http://www.w3.org/2000/svg" id="startbtn" fill="currentColor" class="bi bi-play-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/>
                        </svg>
                    </div>
                </div>
                <div class="verticalborder centered">
                </div>
                
            </div>
        </main>
        <script src="../scripts/manageChar.js"></script>
        <?php 
            if(isLogged()) {    //se l'utente è loggato prelevo dal db l'ultima skin usata, il relativo path e velocità
                echo "<script>fetchSkin(0,1); fetchVelocity(1); switchSkin(1);</script>";
            }
            else
                echo "<script>fetchSkin(0,0); fetchVelocity(0); switchSkin(0);</script>";   //altrimenti do i valori di default
        ?>
        <script src="../scripts/powerup.js"></script>
        <script src="../scripts/character.js"></script>
        <script src="../scripts/handle.js"></script>
        <script src="../scripts/platform.js"></script>

    </body>
</html>
