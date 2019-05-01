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

function filtroRegioni(){

    var idRegione = document.getElementById("immRegione").value;
    var prov = document.getElementById("immProvincia");

    prov.value = 0;
    if (idRegione == 0){
        prov.disabled = true;
    }
    else{
        prov.disabled = false;
    }

    for(var i=1;i<prov.length;i++) {
        if (prov.options[i].value == idRegione) {
            prov.options[i].style.display = "inline";
        } else {
            prov.options[i].style.display = "none";
        }
    }
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

console.log("posti: " + posti);

if(accDisabili)
    accDisabili = 1;
else
    accDisabili = 0;

//se mettevo zero come numero di posti, mi faceva comunque inserire la casa
if(posti<=0){
    alert("Il numero di posti non può essere minore o uguale a zero!");
    return;
}



//Controllo che tutti i campi siano stati riempiti
if((alias.length===0) || (regione.length===0) || (provincia.length===0) || (citta.length===0) || (indirizzo.length===0) || (disponibilita.length===0)||(posti.length===0)) {
    alert("Riempire tutti i campi!");
    return;
    }

currentDate = new Date();
    if(checkDateAntecedent(currentDate,disponibilita)===-1) {
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

    if(checkDateAntecedent(localStorage.getItem("originalDate"),document.getElementById("immDisponibilita").value)=== -1) {
        return;
    }

    currentDate = new Date();

    if(checkDateAntecedent(currentDate,document.getElementById("immDisponibilita").value)=== -1) {
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

function checkDateAntecedent(originalDate,newDate) { //In formato AAAA-MM-GG
    originalDate = new Date(originalDate);
    newDate = new Date(newDate);

    if (originalDate > newDate) {
        alert('ATTENZIONE: La data di disponibilità si può estendere, ma non abbreviare\nInoltre, la data non può essere antecedente a quella attuale.');
        return -1;
    }

    else return 0;
}

//AJAX UNIVERSALE PER INVIARE QUERY AL DB
function ajaxConnect(query) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", "/utility/dbquery.php", true);
    xhr.send(query);
}
