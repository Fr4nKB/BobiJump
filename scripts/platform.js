let velocityP = 3;
let pfheight = 55;
let pfwidth = 110;

// costruttore della classe Platform
function Platform (position, ix, iy) {
    this.position = position;
    
    this.element = document.createElement('img');
    this.element.alt = "";
    this.element.src = '../images/platform.png';
    this.element.classList.add('platform');
    this.type = 0;
    
    $('playground').appendChild(this.element);
    
    this.x = ix;
    this.y = iy;
    
    this.element.style.top = this.y + 'px';
    this.element.style.left = this.x + 'px';
}

// funzione che fa scendere le piattaforme
Platform.prototype.down = function(){
    if(this.y >= bgheight) {
        this.element.remove();
        JMPpos--;       //quando rimuovo una piattaforma l'indice della piattaforma cambia, diminuendo di uno so sempre su quale piattaforma mi trovo
        return 1;
    }
    
    this.y = this.y + velocityP;
    this.element.style.top = this.y + 'px';
    return 0;
}