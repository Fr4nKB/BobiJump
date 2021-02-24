let pudim = 60;
let putime = 0;     //variabile per controllare quando il power up è stato preso
let puduration = 400;       //indica quanto tempo dura un power up, circa 8 secondi
// costruttore della classe PowerUp
function PowerUp (ix, iy) {

    this.element = document.createElement('img');
    this.element.src = '../images/multiplier.png';
    this.element.classList.add('powerup');
    this.element.style.zIndex = "2";
    
    $('playground').appendChild(this.element);
    
    this.x = ix + 25;       //il powerup si deve trovare al centro della piattaforma (110/2-60/2)
    this.y = iy - 60;
    
    this.element.style.top = this.y + 'px';
    this.element.style.left = this.x + 'px';
}

// funzione che fa scendere il powerup assieme ad una piattaforma
PowerUp.prototype.down = function(){
    if(this.y >= bgheight) {
        this.element.remove();
        return 1;
    }
    
    this.y = this.y + velocityP;        //uso la stessa velocità delle piattaforme
    this.element.style.top = this.y + 'px';
    return 0;
}