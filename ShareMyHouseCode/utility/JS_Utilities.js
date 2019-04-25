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
        //httpReq.responseType = "document";
        httpReq.send(cf);

}

function getImmobili(cf) {
    var httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (httpReq.readyState === 4 && httpReq.status === 200) {
            xmlDoc = httpReq.responseXML;
        }
    }

    httpReq.open("POST", "/utility/getImmobili.php?v=1", true);
    httpReq.setRequestHeader('Content-Type', 'application/json');
    console.log("GetImmobiliCF "+cf);
    httpReq.send(cf);

}

//AJAX UNIVERSALE PER INVIARE QUERY AL DB
function ajaxConnect(query) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", "/utility/dbquery.php", true);
    xhr.send(query);
}

