function logout() {
    localStorage.removeItem("codiceFiscale");
    window.location = "index.php";
}

function modificaInfoUtente() {
    let infoUtente = document.getElementsByClassName("infoutenteModificabile");
    let button = document.getElementById("buttonModifica")

    if (infoUtente[0].disabled) {
        button.innerText= "Fatto";
        for(i = 0; i<infoUtente.length; i++) {
            infoUtente[i].disabled = false;
        }
        return;
    }

    if (!infoUtente[0].disabled) {
        button.innerText = "Modifica";
        for(i = 0; i<infoUtente.length; i++) {
            infoUtente[i].disabled = true;
        }
        updateDatiUtente();
        return;
    }
}

function updateDatiUtente() {
    cf = document.getElementById("cfUser").value;
    mail = document.getElementById("emailUser").value;
    tel = document.getElementById("telUtente").value;
    addr = document.getElementById("addressUser").value;
    //console.log(mail+tel+addr)
    query = "UPDATE InfoUtente SET mail ='"+mail+"', telefono ='"+tel+"', Indirizzo ='"+addr+ "' WHERE CF ='"+ cf+"'";
    console.log(query);
    ajaxConnect(query);
}

function getDatiUtente(cf) {
    var httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (httpReq.readyState === 4 && httpReq.status === 200) {
            if(httpReq.responseText!==false) {
                utenti = JSON.parse(httpReq.responseText);
                //Benvenuto

                document.getElementById("titoloNomeUtente").innerText = "Benvenuto, " + utenti[0].nome;

                document.getElementById("cfUser").value = utenti[0].cf;
                document.getElementById("userName").value = utenti[0].nome;
                document.getElementById("dataNascitaUser").value = utenti[0].dataNascita;
                document.getElementById("addressUser").value = utenti[0].indirizzo;
                document.getElementById("telUtente").value = utenti[0].telefono;
                document.getElementById("emailUser").value = utenti[0].mail;
            }
        }
    }

        httpReq.open("POST", "/utility/getDatiUtenteJSON.php?v=9o0o10o2", true);
        httpReq.setRequestHeader('Content-Type', 'application/json');
        httpReq.send(cf);

}

function getImmobili(cf) {
    var httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (httpReq.readyState === 4 && httpReq.status === 200) {
            immobili = JSON.parse(httpReq.responseText);
        }
    }

    httpReq.open("POST", "/utility/getImmobiliJSON.php?v=2", true);
    httpReq.setRequestHeader('Content-Type', 'application/json');
    httpReq.send(cf);

}

function salvaImmobile() {
let alias = document.getElementById("immAlias").value;
let regione = document.getElementById("immRegione").value;
let provincia = document.getElementById("immProvincia").value;
let citta = document.getElementById("immCitta").value;
let indirizzo = document.getElementById("immIndirizzo").value;
let accDisabili = document.getElementById("immDisabili").checked;
if(accDisabili)
    accDisabili = 1;
else
    accDisabili = 0;

if((alias.length===0) || (regione.length===0) || (provincia.length===0) || (citta.length===0) || (indirizzo.length===0)) {
    alert("Riempire tutti i campi!");
    return;
    }


let GPS = getCoordinate("IT",citta,indirizzo);
console.log("GPS: "+GPS);

let values = "('"+alias+"', '"+localStorage.codiceFiscale+"', '"+regione+"', '"+provincia+"', '"+citta+"', '"+indirizzo+"', '"+accDisabili+"', '"+latitudine+"', "+longitudine+" )";

query = "INSERT INTO Abitazioni (NomeAbitazione, Proprietario, Regione, Provincia, Citta, Indirizzo, AccessoDisabili, Latitudine, Longitudine) VALUES "+values;
console.log(query);
ajaxConnect(query);
setTimeout(function (){
    window.location.href='/mieimmobili.php'
    }, 500);
}

//AJAX UNIVERSALE PER INVIARE QUERY AL DB
function ajaxConnect(query) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", "/utility/dbquery.php", true);
    xhr.send(query);
}

function getCoordinate(stato,citta,indirizzo) {
    indirizzo = indirizzo+", "+citta+", +"+stato;
    indirizzo = indirizzo.replace(" ", "+");
    let coordinate = new Array();
    //window.location.href= 'https://maps.googleapis.com/maps/api/geocode/json?address='+indirizzo+'&key=AIzaSyDi6OYQpSp_dEjtGzJ3hkeZXBw-wlMBUk0';

    var httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (httpReq.readyState === 4 && httpReq.status === 200) {
            risultato = JSON.parse(httpReq.responseText);
            latitudine = risultato.results[0].geometry.location.lat;
            longitudine = risultato.results[0].geometry.location.lng;
            console.log(latitudine+","+longitudine);
            
        }

    }

    url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+indirizzo+'&key='+mapsAPIKey;
    //console.log(url);
    httpReq.open("POST", url, true);
    //httpReq.setRequestHeader('Content-Type', 'application/json');
    httpReq.send();

}



