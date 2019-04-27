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

                document.getElementById("titoloNomeUtente").innerText = "Benvenuto, " + utenti[0].nome+" "+utenti[0].cognome;

                document.getElementById("cfUser").value = utenti[0].cf;
                document.getElementById("userName").value = utenti[0].nome+" "+utenti[0].cognome;
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


function salvaImmobile() {
let alias = document.getElementById("immAlias").value;
let regione = document.getElementById("immRegione").value;
let provincia = document.getElementById("immProvincia").value;
let citta = document.getElementById("immCitta").value;
let indirizzo = document.getElementById("immIndirizzo").value;
let disponibilita = document.getElementById("immDisponibilita").value;
let posti = document.getElementById("immPosti").value;

let accDisabili = document.getElementById("immDisabili").checked;

if(accDisabili)
    accDisabili = 1;
else
    accDisabili = 0;

//Controllo che tutti i campi siano stati riempiti
if((alias.length===0) || (regione.length===0) || (provincia.length===0) || (citta.length===0) || (indirizzo.length===0) || (disponibilita.length===0)||(posti.length===0)) {
    alert("Riempire tutti i campi!");
    return;
    }

    // RECUPERO COORDINATE GPS
indirizzoEncoded = indirizzo+", "+citta+", +IT";
indirizzoEncoded = indirizzoEncoded.replace(" ", "+");

var httpReq = new XMLHttpRequest();
httpReq.onreadystatechange = function () {
   if (httpReq.readyState === 4 && httpReq.status === 200) {
       risultato = JSON.parse(httpReq.responseText);
       let latitudine = risultato.results[0].geometry.location.lat;
       let longitudine = risultato.results[0].geometry.location.lng;
       console.log(latitudine+","+longitudine);
        //Preparo i valori per la query
       let values = "('"+alias+"', '"+localStorage.codiceFiscale+"', '"+disponibilita+"', '"+posti+"', '"+regione+"', '"+provincia+"', '"+citta+"', '"+indirizzo+"', '"+accDisabili+"', '"+latitudine+"', "+longitudine+" )";

       query = "INSERT INTO Abitazioni (NomeAbitazione, Proprietario,scadenzaDisponibilita,postiTotali, Regione, Provincia, Citta, Indirizzo, AccessoDisabili, Latitudine, Longitudine) VALUES "+values;
       console.log(query);
       ajaxConnect(query); //Eseguo la query
       setTimeout(function (){ //aspetto un po' e poi torno alla pagina dei miei immobili
           window.location.href='/mieimmobili.php'
       }, 500);

   }

}

url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+indirizzoEncoded+'&key='+mapsAPIKey;
httpReq.open("POST", url, true);
httpReq.send();
}


function aggiornaImmobile(id) {
    let alias = document.getElementById("immAlias").value;
    let accDisabili = document.getElementById("immDisabili").checked;
    let disponibilita = document.getElementById("immDisponibilita").value;
    if(accDisabili)
        accDisabili = 1;
    else
        accDisabili = 0;

//Controllo che tutti i campi siano stati riempiti
    if((alias.length===0) || (disponibilita.length===0) ) {
        alert("Riempire tutti i campi!");
        return;
    }


     query = "UPDATE Abitazioni SET NomeAbitazione = '"+alias+"', AccessoDisabili = "+accDisabili+", scadenzaDisponibilita = '"+disponibilita+"' WHERE IDAbitazione = "+id; //Aggiungere data disponibilita
     console.log(query);
     ajaxConnect(query); //Eseguo la query

     setTimeout(function (){ //aspetto un po' e poi torno alla pagina dei miei immobili
         window.location.href='/mieimmobili.php'
     }, 500);
}

function eliminaImmobile(id) {
    query = "DELETE FROM Abitazioni WHERE IDAbitazione = "+id
    ajaxConnect(query);
    setTimeout(function (){ //aspetto un po' e poi torno alla pagina dei miei immobili
        window.location.href='/mieimmobili.php'
    }, 500);
}


//AJAX UNIVERSALE PER INVIARE QUERY AL DB
function ajaxConnect(query) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", "/utility/dbquery.php", true);
    xhr.send(query);
}



