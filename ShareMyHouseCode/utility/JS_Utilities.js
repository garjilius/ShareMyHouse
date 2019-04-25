function logout() {
    localStorage.removeItem("codiceFiscale");
    window.location = "index.php";
}

function modificaInfoUtente() {
    let infoUtente = document.getElementsByClassName("infoutente");
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
        return;
    }
}

function getDatiUtente(cf) {
    var httpReq = new XMLHttpRequest();
    httpReq.onreadystatechange = function () {
        if (httpReq.readyState === 4 && httpReq.status === 200) {
            let xmlDoc = httpReq.responseXML;
            //console.log(xmlDoc.getElementsByTagName("Nome"));
        }
    }

        httpReq.open("POST", "/utility/getDatiUtente.php?v=o010o2", true);
        httpReq.setRequestHeader('Content-Type', 'text/xml');
        cfToSend = "<xml><query><cf>"+cf+"</cf></query></xml>"
        console.log(cfToSend);
        httpReq.send(cfToSend);

}

