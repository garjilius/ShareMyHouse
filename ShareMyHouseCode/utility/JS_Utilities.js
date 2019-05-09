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
    //console.log(query);
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

    if(this.document.getElementById("immRegione")) {
        //caso in aggiungi immobile
        var idRegione = document.getElementById("immRegione").value;
        var prov = document.getElementById("immProvincia");
    }else if (this.document.getElementById("regione")){
        //caso registrazione
        var idRegione = document.getElementById("regione").value;
        var prov = document.getElementById("provincia");
    }

    //Abilito le province solo se è stata selezionata una regione
    prov.value = 0;

    if (idRegione == 0){
        prov.disabled = true;
    }
    else{
        prov.disabled = false;
    }

    var httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (httpReq.readyState === 4 && httpReq.status === 200) {
            //Svuoto prima la combobox
            svuotaComboBox(prov);

            //Prendo le nuove province relative alla regione e popolo la combobox
            risultato = JSON.parse(httpReq.responseText);
            option = document.createElement('option');
            option.text = "Provincia";
            option.value = 0;
            prov.add(option);

            for (let i = 0; i < risultato.length; i++) {
                option = document.createElement('option');
                option.text = risultato[i].siglaProvincia;
                option.value = risultato[i].id;
                prov.add(option);
            }

            getImmobili();
        }

    }

    query = "Select * from province where id_regione = "+idRegione;



    httpReq.open("POST", '/utility/getProvinceJSON.php?<?php echo date(\'l jS \\of F Y h:i:s A\'); ?>', true);
    httpReq.send(query);


}


function salvaImmobile() {
let alias = document.getElementById("immAlias").value;
let regione = document.getElementById("immRegione").selectedOptions[0].text;
let provincia = document.getElementById("immProvincia").selectedOptions[0].text;
let citta = document.getElementById("immCitta").value;
let indirizzo = document.getElementById("immIndirizzo").value;
let disponibilita = document.getElementById("immDisponibilita").value;
let posti = document.getElementById("immPosti").value;

let accDisabili = document.getElementById("immDisabili").checked;

console.log(regione+provincia);

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
if((alias.length===0) || (regione.length===0)|| (provincia.length===0) || (citta.length===0) || (indirizzo.length===0) || (disponibilita.length===0)||(posti.length===0)) {
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
       //console.log(latitudine+","+longitudine);
        //Preparo i valori per la query
       let values = "('"+alias+"', '"+localStorage.codiceFiscale+"', '"+disponibilita+"', '"+posti+"', '"+regione+"', '"+provincia+"', '"+citta+"', '"+indirizzo+"', '"+accDisabili+"', '"+latitudine+"', "+longitudine+" )";

       query = "INSERT INTO Abitazioni (NomeAbitazione, Proprietario,scadenzaDisponibilita,postiTotali, Regione, Provincia, Citta, Indirizzo, AccessoDisabili, Latitudine, Longitudine) VALUES "+values;
       //console.log(query);
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
     //console.log(query);
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

function svuotaComboBox(combobox) {
    while (combobox.options.length > 0) {
        combobox.remove(0);
    }
}

function nuovoUtente(tipoUtente) {

    document.getElementById("alertErroreDialog").hidden = true;

    var nome = document.getElementById("nome").value;
    var cognome = document.getElementById("cognome").value;
    var dataNascita = document.getElementById("dataNascita").value;
    var cfNuovoUtente = document.getElementById("cfNuovo").value;
    var mailNuovoUtente = document.getElementById("mailNuovo").value;
    var via = document.getElementById("via").value;
    var citta = document.getElementById("citta").value;
    var provincia = document.getElementById("provincia").selectedOptions[0].text;
    var regione = document.getElementById("regione").selectedOptions[0].text;
    var telefono = document.getElementById("telefono").value;

    console.log("regione "+regione);
    console.log("provincia "+provincia);

    // CONTROLLO INSERIMENTO VALORI
    if (cfNuovoUtente.length == 0 || cfNuovoUtente.length != 16) {
        document.getElementById("alertErroreDialog").innerHTML = "Controllare il <strong>codice fiscale</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (nome.length == 0) {
        document.getElementById("alertErroreDialog").innerHTML = "Inserire un <strong>nome</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (cognome.length == 0) {
        document.getElementById("alertErroreDialog").innerHTML = "Inserire un <strong>cognome</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (dataNascita.length == 0) {
        document.getElementById("alertErroreDialog").innerHTML = "Inserire una <strong>data di nascita</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (via.length == 0) {
        document.getElementById("alertErroreDialog").innerHTML = "Inserire un <strong>indirizzo</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (citta.length == 0) {
        document.getElementById("alertErroreDialog").innerHTML = "Inserire una <strong>città</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (regione == 'default' || provincia == 'default') {
        document.getElementById("alertErroreDialog").innerHTML = "Inserire una <strong>regione</strong> o una <strong>provincia</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (telefono.length == 0 || telefono.length != 10) {
        document.getElementById("alertErroreDialog").innerHTML = "Controllare il <strong>numero di telefono inserito</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (mailNuovoUtente.length == 0) {
        document.getElementById("alertErroreDialog").innerHTML = "Inserire un <strong>indirizzo mail</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    } else if (!validazione_email(mailNuovoUtente)) {
        document.getElementById("alertErroreDialog").innerHTML = "Indirizzo mail <strong>non valido</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;


    } else if (!validazione_data(dataNascita)) {
        document.getElementById("alertErroreDialog").innerHTML = "Formato data <strong>non valido</strong>.";
        document.getElementById("alertErroreDialog").hidden = false;
        return;

    }

    if(tipoUtente==0) { //Le cose sulla password vengono controllate solo sul tipo di utente che deve inserire la password
        var pass1 = document.getElementById("pass1").value;
        var pass2 = document.getElementById("pass2").value;

        if (pass1.length == 0 || pass2.length == 0) {
            document.getElementById("alertErroreDialog").innerHTML = "Verificare i campi <strong>password</strong>.";
            document.getElementById("alertErroreDialog").hidden = false;
            return;

        } else if (pass1 !== pass2) {
            document.getElementById("alertErroreDialog").innerHTML = "Le due password <strong>non corrispondono</strong>.";
            document.getElementById("alertErroreDialog").hidden = false;
            return;
        }
    }

    indirizzoEncoded = via+", "+citta+", +IT";
    indirizzoEncoded = indirizzoEncoded.replace(" ", "+");
    console.log("indirizzo encoded "+indirizzoEncoded);

    var httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {

        if (httpReq.readyState === 4 && httpReq.status === 200) {

            var response = parseInt(httpReq.responseText);
            risultato = JSON.parse(httpReq.responseText);
            console.log("res"+response);
            console.log("ris"+risultato);

            var latitudine = risultato.results[0].geometry.location.lat;
            var longitudine = risultato.results[0].geometry.location.lng;


            console.log(latitudine+","+longitudine);
            // Ottenute latitudine e longitudine, posso passare a completare la registrazione

            var httpReq2 = new XMLHttpRequest();
            httpReq2.onreadystatechange = function () {
                var response = parseInt(httpReq2.responseText);

                if (httpReq2.readyState === 4 && httpReq2.status === 200) {

                    switch (response) {
                        case 0:
                            window.location = "index.php"; //pagina utente
                            break;
                        case - 1:
                            console.log(parseInt(httpReq.responseText)+"la risposta");
                            document.getElementById("alertErroreDialog").innerHTML = "Il <strong>codice fiscale</strong> inserito risulta già registrato.";
                            document.getElementById("alertErroreDialog").hidden = false;
                            break;
                        case - 2:
                            document.getElementById("alertErroreDialog").innerHTML = "<strong>L'indirizzo email</strong> inserito è già associato ad un account.";
                            document.getElementById("alertErroreDialog").hidden = false;
                            break;
                        case - 3:
                            document.getElementById("alertErroreDialog").innerHTML = "Errore nell'invio della mail di conferma.";
                            document.getElementById("alertErroreDialog").hidden = false;
                            break;
                        case - 4:
                            document.getElementById("alertErroreDialog").innerHTML = "Errore generico";
                            document.getElementById("alertErroreDialog").hidden = false;
                            break;

                    }
                }
            };

            httpReq2.open("POST", "utility/registrazione.php", true);
            httpReq2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            httpReq2.send("nome=" + nome + "&cognome=" + cognome + "&dataNascita=" + dataNascita + "&cf=" + cfNuovoUtente + "&mail=" + mailNuovoUtente + "&password=" + pass1 + "&via=" + via + "&citta=" + citta + "&provincia=" + provincia + "&regione=" + regione + "&telefono=" + telefono + "&latitudine=" + latitudine + "&longitudine=" + longitudine + "&tipoUtente=" + tipoUtente);

        }
    };

    url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+indirizzoEncoded+'&key='+mapsAPIKey;
    httpReq.open("POST", url, true);
    httpReq.send();


}

//AJAX UNIVERSALE PER INVIARE QUERY AL DB
function ajaxConnect(query) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", "/utility/dbquery.php", true);
    xhr.send(query);
}

function getImmobili() {

    var checkBox = document.getElementById("checkBarrieraArchitettonica");
    var nessunAccesso;
    if (checkBox.checked == true){
        nessunAccesso = true;
    } else {
        nessunAccesso = false;
    }

    if (document.getElementById("immRegione").value == 0 && nessunAccesso==true) {
        query = "SELECT * From Abitazioni WHERE AccessoDisabili=1";
        console.log("query");
    }else if(document.getElementById("immRegione").value == 0 && nessunAccesso==false){
        query = "SELECT * From Abitazioni";
    } else {
        var regioneTesto = document.getElementById('immRegione').selectedOptions[0].text;
        var provinciaTesto = document.getElementById('immProvincia').selectedOptions[0].text;

        if(provinciaTesto != 'Provincia') {
            if(nessunAccesso==true) {
                query = "SELECT * From Abitazioni WHERE Regione='" + regioneTesto + "' AND Provincia='" + provinciaTesto + "' AND AccessoDisabili=1";
            }else{
                query = "SELECT * From Abitazioni WHERE Regione='" + regioneTesto + "' AND Provincia='" + provinciaTesto + "'";
            }
        }
        else{
            if(nessunAccesso==true) {
                query = "SELECT * From Abitazioni WHERE Regione='" + regioneTesto + "' AND AccessoDisabili=1";
            }else {
                query = "SELECT * From Abitazioni WHERE Regione='" + regioneTesto + "'";
            }
        }
    }

    getImmobiliQuery(query);

    function getImmobiliQuery(query) {
        console.log("in getimmobili "+query);
        var httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function () {
            if (httpReq.readyState === 4 && httpReq.status === 200) {
                immobili = JSON.parse(httpReq.responseText);

                acc = document.getElementById("tavolaSegnalazioniBody");
                var rows = acc.getElementsByTagName("tr");

                //Cancellazione tabella dal basso verso l'alto
               for(i=rows.length-1;i>=0;i--){
                   acc.deleteRow(i);
               }

                for (i = 0; i < immobili.length; i++) {
                    console.log("id "+immobili[i].id);
                    idImmobile = immobili[i].id;
                    regione = immobili[i].regione;
                    provincia = immobili[i].provincia;
                    citta = immobili[i].citta;
                    indirizzo = immobili[i].indirizzo;
                    postiTotali = immobili[i].postiTotali;
                    postiOccupati = immobili[i].postiOccupati;

                    acc.innerHTML = acc.innerHTML +
                        "<tr>" +
                        "<td>" + idImmobile + "</td>" +
                        "<td>" + regione + "</td>" +
                        "<td>" + provincia + "</td>" +
                        "<td>" + citta + "</td>" +
                        "<td>" + indirizzo + "</td>" +
                        "<td>" + postiOccupati + "/" + postiTotali + "</td>" +
                        "</tr>";
                }
            }

        }

        httpReq.open("POST", "/utility/getImmobiliJSON.php?v=2", true);
        httpReq.setRequestHeader('Content-Type', 'application/json');
        httpReq.send(query);

    }
}



