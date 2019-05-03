switch (response) {

    case 0:
        window.location = "index.php"; //pagina utente
        break;
    case 1:
        alert("Riceverai una mail per completare la procedura di registrazione.");
        $('#primoAccesso').modal('hide');
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