let currentSkin;
let velocityC;
let skinPath;
function fetchSkin(type, logged) {
    //questa richiesta AJAX preleva l'ultima skin usata dal database qualora l'utente si sia registrato
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 400) {
                alert('Errore 400');
            }
            else if (xmlhttp.status != 200) {
                alert('È stato ritornato un valore diverso da 200');
            }
            else {
                if (logged) currentSkin = "skin" + JSON.parse(this.responseText).skinid;
                if (type) document.getElementById(String(currentSkin)).style.boxShadow = "0px 0px 15px 5px rgb(255, 0, 157)";       //metto in evidenza la currentskin
            }
        }
    }
    
    xmlhttp.open("GET", "./util/getSkin.php", true);
    xmlhttp.send();
}

function fetchVelocity(logged) {
    if (logged==0) {
        velocityC = -20;
    } 
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                if (xmlhttp.status == 400) {
                    alert('Errore 400');
                }
                else if (xmlhttp.status != 200) {
                    alert('È stato ritornato un valore diverso da 200');
                }
                else {
                    velocityC = JSON.parse(this.responseText).result;
                }
            }
        }
        
        xmlhttp.open("GET", "./util/getVel.php", true);
        xmlhttp.send();
    }
}

function switchSkin(logged) {
    if (logged==0) {
        skinPath = "../images/larry.png";
    } 
    else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                if (xmlhttp.status == 400) {
                  alert('There was an error 400');
                }
                else if (xmlhttp.status != 200) {
                   alert('something else other than 200 was returned');
                }
                else {
                    skinPath = JSON.parse(this.responseText).path;
                }
            }
        }
    
        xmlhttp.open("GET", "./util/getSkin.php", true);
        xmlhttp.send();

    }
    
}


function chooseSkin(id) {
    if(id!=currentSkin) {
        document.getElementById(String(id)).style.boxShadow = "0px 0px 15px 5px rgb(255, 0, 157)";          //metto in evidenza la skin appena selezionata
        document.getElementById(String(currentSkin)).style.boxShadow = "0px 0px 0px 0px rgb(255, 0, 157)";      //tolgo l'evidenza alla vecchia currentskin
        currentSkin = String(id);       //aggiorno la skin corrente
        
        //la seguente richiesta AJAX serve per aggiornare nel database il campo currentskin così da poter prelevare la skin quando serve
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                if (xmlhttp.status == 400) {
                  alert('There was an error 400');
                }
                else if (xmlhttp.status != 200) {
                   alert('something else other than 200 was returned');
                }
            }
        }
    
        xmlhttp.open("GET", "./util/updateSkin.php?newSkin="+currentSkin.substring(4), true);
        xmlhttp.send();
    }
}
