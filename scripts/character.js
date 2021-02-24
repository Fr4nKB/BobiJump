let accelerationC = 1;
let cwidth = 70;
let cheight = 70;
let JMPpos;

// costruttore della classe Character
function Character () {

    this.velocity = 0;
    this.element = document.createElement('img');
    this.element.alt = "";
    this.element.src = "../images/larry.png";
    this.element.classList.add('character');

    $('playground').appendChild(this.element);

    this.x = (bgwidth/2)-(cwidth/2);
    this.y = bgheight;

    this.element.style.left = this.x + 'px';
    this.element.style.top = this.y + 'px';

}

// funzione della classe Character che gestisce i salti
Character.prototype.gravity = function(type) {
    if (type==0) {      //se il tipo è 0 ho il salto iniziale
        this.y = this.y + this.velocity;
        if(time>=8) this.velocity = this.velocity + accelerationC;
        this.element.style.top = this.y + 'px';
        if (this.velocity > 0)
            t = 1;  //t è la variabile che si passa a questa funzione, con t=0 si fa il salto di inizio partita mentre per t=1 i salti vengono gestiti sotto
        return;
    }
    //vari controlli per capire se il personaggio deve saltare o meno
    for (var i = 0; i < platforms.length; i++) {
        var tmp = (platforms[i].y-this.y);
        if((this.velocity > 0) &&           //se la velocità è positiva signfica che sto andando verso il basso quindi posso saltare
            ((tmp >= cheight) && (tmp <= cheight+this.velocity)) &&     //controllo che la piattaforma non si trovi fuori dallo schermo in fondo
            (this.x + cwidth/2 >= platforms[i].x) &&
            (this.x + cwidth/2 <= platforms[i].x + pfwidth) &&
            (this.y <= bgheight - cheight) &&       //non salto se il personaggio è in fondo allo schermo
            platforms[i].type == 0) {       //controllo che la piattaforma sia del tipo visibile
                if (JMPpos != i) {          //con JMPpos controllo se sto saltando sempre sulla stessa piattaforma e in tal caso non aumento lo score
                    score += (time < putime+400) ? Math.round(2*(bgheight - this.y)) : Math.round((bgheight - this.y));   //i punti vengono assegnati in base all'altezza, se ci si trova più in basso si guadagnano più punti
                    JMPpos = i;         //salvo l'ultima piattaforma su cui ho saltato
                }

                if (this.y <= bgheight/3)   //se ci si trova nel 1/3 più alto del playground si salta meno in alto, evita di finire troppo tempo fuori dallo schermo nel caso si fosse in cima
                    this.velocity = velocityC*0.8;
                else this.velocity = velocityC;

                if (time >= 500) {          //lascio passare almeno 20 secondi (ogni secondo il time aumenta di 50)
                    platforms[i].type = (Math.round(9*Math.random())==1) ? 1:0;        //ho una possibilità su 10 che la piattaforma su cui ho saltato scompaia
                    if (platforms[i].type) {
                        platforms[i].element.classList.add('fadeOut');      //aggiungo la classe fadeOut che fa scomparire la piattaforma
                    }
                }

                break;      //se sono arrivato fin qui significa che ho fatto un salto quindi posso evitare di controllare le altre piattaforme
            }
    }
        this.y = this.y + this.velocity;
        this.velocity = this.velocity + accelerationC;
        this.element.style.top = this.y + 'px';
}

// funzione che controlla quando il personaggio è caduto
Character.prototype.dead = function() {
    if (this.y >= bgheight) {
        this.element.remove();
        if (end()) {
            //output della schermata di fine gioco
            document.getElementById("scoreDS1").classList.remove("hidden");
            document.getElementById("startbtn").style.marginTop = "750px";
            document.getElementById("scoreDS1e").innerText = score.toString();
        }
    }     
}
