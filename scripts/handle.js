function $(id) { return document.getElementById(id); }
// variabili globali di utilità
let bgwidth = 500;
let bgheight = 900;

let ratio;      //lo spawn delle piattaforme avviene al valore di questa variabile
let time;
let t;      //serve per effettuare il salto iniziale
let paused;
let platforms = [];
let logged = 0;     //segnala se l'utente è loggato
let pu;     //oggetto powerup

let Timer;
let score;
let c = new Character();

function start() {
    //overlay di gioco
    c.velocity = velocityC;
    document.getElementById("startbtn").classList.add("hidden");
    document.getElementById("scoreDS1").classList.add("hidden");
    document.getElementById("scoreDS2").classList.add("hidden");
    document.getElementById("score").classList.remove("hidden");
    document.getElementById("pausebtn").classList.remove("hidden");
    c.element.src = skinPath;
    document.getElementById("deathscreen").classList.remove("backgroundend");
    document.getElementById("playground").classList.add("backgroundstart");
    document.getElementById("cover").classList.add("hidden");

    //inizializzazione delle variabili alle condizioni iniziali
    ratio = 20;
    time = 0;
    t = 0;
    velocityP = 3;
    accelerationC = 1;
    score = 0;
    paused = 0;
    putime = 0;

    platforms = new Array();
    var ppos = 1;
    for (var i = 0; i < 12; i++) {        //spawn delle piattaforme dall'alto verso il basso ogni 100px
        blocks(1, ppos);
        ppos+=100;
    }

    //questo event si occupa di ascoltare gli input dell'utente sulla tastiera e spostare il personaggio in base ad essi
    document.onkeydown = function (evt) {
        if (!paused) {
            if (evt.code == 'KeyA' && c.x > 0) {
                c.x += -20;
                c.element.style.transform = "scaleX(-1)";       //il personaggio si gira a seconda della direzione che do
            }
            else if (evt.code == 'KeyD' && c.x < (bgwidth-cwidth)) {
                c.element.style.transform = "scaleX(1)";
                c.x += 20;
            }
        }   
        c.element.style.left = c.x + 'px';
    };

    run();

}

function run() {
    Timer = setInterval(() => {
        time += 1;      //time aumenta di 1 ogni 20ms cioè aumenta di 50 ogni secondo
        score = Math.round(score);
        c.gravity(t);
        c.dead();

        if(pu != undefined) {       //eseguo solo se esiste un powerup a schermo
            pu.down();      //traslo insieme alla piattaforma il powerup
            if (pu.y >= bgheight) {         //se sono in fondo allo schermo posso eliminare il powerup
                pu.element.remove();
                pu = undefined;
            }
            //controllo che il centro del personaggio e del powerup siano dentro un raggio di 50 px di distanza
            else if ((Math.abs((c.x+cwidth/2)-(pu.x+pudim/2)) <= 50) && (Math.abs((c.y+cheight/2)-(pu.y+pudim/2)) <= 50)) {
                putime = time;      //memorizzo il momento in cui il powerup è stato preso
                pu.element.remove();        //lo elimino
                pu = undefined;
            }
        }

        if (time % 1000==0 && ratio <= 40)      //diminuisco le piattaforme da creare, il modulo con 1000 indica ogni quanto spesso avviene cioè circa 20sec
            ratio+=2;
        
        if (time % 1500==0 && ratio <= 40)      //aumento la velocità delle piattaforme
            velocityP+=1;
        
        for(let i = platforms.length - 1 ; i >= 0 ; i--){
            if(platforms[i].down(velocityP))
               platforms.splice(i, 1); 
        }
        
        if (time%ratio == 0) {
            blocks(1,-65);
            if (Math.round(Math.random()*29)==1 && pu==undefined && time >= putime+puduration) {      //una possibilità su 30 che si crei un powerup
                var highest = bgheight;    //le altre condizioni controllano che non ci siano powerup in uso o sullo schermo
                var j;
                for (var i = 0; i < platforms.length; i++) {        //per creare il powerup cerco la piattaforma che si trova più in alto delle altre così da non crearla in una piattaforma casuale
                    if (platforms[i].y < highest) {
                        highest = platforms[i].y;
                        j = i;
                    }
                }
                pu = new PowerUp (platforms[j].x, platforms[j].y);
            }
        }

        if (putime!=0 && time < putime+puduration && time!=0) {     //finchè deve essere attivo il powerup lo segnalo vicino allo score
            var text = score + " X2";
            document.getElementById("score").textContent = text.toString();
        }
        else document.getElementById("score").textContent = score.toString();
    }, 20);
}

//funzione che genera piattaforme in posizioni casuali
function blocks(num, iy=0) {
    var check;
    var i;

    for (i = 0; i < num; i++) {
        do {
            var rndx = (bgwidth-pfwidth)*Math.random();
            var rndy = (iy == 0)?(bgheight-pfheight)*Math.random():iy;
            check = 0;
            for (var j = 0; j < platforms.length; j++){
                if ((Math.abs(rndx-platforms[j].x) >= pfwidth) || 
                    (Math.abs(rndy-platforms[j].y) >= pfheight)) {
                    check = 1;
                }
            }
        } while (iy==0 && check == 1)      //ciclo finchè non ho dei valori randomici che non si intersecano con piattaforme già esistenti

        platforms.push(new Platform(platforms.length, rndx, rndy)); 
    }
}

function pause () {
    clearInterval(Timer);
    paused = 1;
    document.getElementById("cover").classList.remove("hidden");
    document.getElementById("cover").style.zIndex = "2000";
    document.getElementById("resumebtn").classList.remove("hidden");
    document.getElementById("resumebtn").style.zIndex = "2001";
    document.getElementById("score").classList.add("hidden");
    document.getElementById("pausebtn").classList.add("hidden");
}

function resume () {
    paused = 0;
    document.getElementById("cover").classList.add("hidden");
    document.getElementById("cover").style.zIndex = "0";
    document.getElementById("resumebtn").style.zIndex = "1000";
    document.getElementById("resumebtn").classList.add("hidden");
    document.getElementById("score").classList.remove("hidden");
    document.getElementById("pausebtn").classList.remove("hidden");
    run();
}

function end() {
    clearInterval(Timer);
    for (var i = platforms.length - 1; i >= 0 ; i--) {
        platforms[i].element.remove();
        platforms.splice(i,1);
    }
    if(pu) {
        pu.element.remove();
        pu = undefined;
    }

    //richiesta AJAX per passare lo score e il tempo di gioco al database per aggiornare il profilo e la classifica
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
           if (xmlhttp.status == 400) {
                alert('Errore 400');
           }
           else if (xmlhttp.status != 200) {
                alert('È stato ritornato un valore diverso da 200');
           }
           else if(logged) {
               let data = JSON.parse(this.responseText);
               document.getElementById("scoreDS2").innerText = data.result;
           }
        }
    }

    xmlhttp.open("GET", "./util/end.php?score="+score+"&time="+(time/50), true);        //(time/50) mi da i secondi veri passati in gioco
    xmlhttp.send();

    document.getElementById("startbtn").classList.remove("hidden");
    document.getElementById("pausebtn").classList.add("hidden");
    document.getElementById("scoreDS1").classList.remove("hidden");
    document.getElementById("scoreDS2").classList.remove("hidden");
    document.getElementById("score").classList.add("hidden");
    document.getElementById("deathscreen").classList.remove("hidden");
    document.getElementById("deathscreen").classList.add("backgroundend");
    document.getElementById("playground").classList.remove("backgroundstart");
    c = new Character();
    return 1;
}