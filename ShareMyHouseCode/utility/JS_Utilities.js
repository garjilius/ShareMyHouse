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
            xmlDoc = httpReq.responseXML;
            //Benvenuto
            document.getElementById("titoloNomeUtente").innerText = "Benvenuto, "+ xmlDoc.getElementsByTagName("nome")[0].firstChild.nodeValue+" "+xmlDoc.getElementsByTagName("cognome")[0].firstChild.nodeValue;

            document.getElementById("cfUser").value = xmlDoc.getElementsByTagName("cf")[0].firstChild.nodeValue;
            document.getElementById("userName").value = xmlDoc.getElementsByTagName("nome")[0].firstChild.nodeValue+" "+xmlDoc.getElementsByTagName("cognome")[0].firstChild.nodeValue;
            document.getElementById("dataNascitaUser").value = xmlDoc.getElementsByTagName("dataNascita")[0].firstChild.nodeValue;
            document.getElementById("addressUser").value = xmlDoc.getElementsByTagName("Indirizzo")[0].firstChild.nodeValue;
            document.getElementById("telUtente").value = xmlDoc.getElementsByTagName("tel")[0].firstChild.nodeValue;
            document.getElementById("emailUser").value = xmlDoc.getElementsByTagName("mail")[0].firstChild.nodeValue;
        }
    }

        httpReq.open("POST", "/utility/getDatiUtente.php?v=o0o10o2", true);
        //httpReq.open("POST", "/utility/test.xml", true);
        httpReq.setRequestHeader('Content-Type', 'text/xml');
        httpReq.responseType = "document";
        cfToSend = "<xml><query><cf>"+cf+"</cf></query></xml>"
        //console.log(cfToSend);
        httpReq.send(cfToSend);

}

//AJAX UNIVERSALE PER INVIARE QUERY AL DB
function ajaxConnect(query) {
    xhr = new XMLHttpRequest();
    xhr.open("POST", "/utility/dbquery.php", true);
    xhr.send(query);
}

