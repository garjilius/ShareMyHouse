<!DOCTYPE html>
<html lang="it">
    <head>
        <title>ShareMyHouse</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-Equiv="Cache-Control" Content="no-cache">
        <meta http-Equiv="Pragma" Content="no-cache">
        <meta http-Equiv="Expires" Content="0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/CSS/extra.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
        <link href="apple-touch-icon.png" rel="apple-touch-icon" />
        <link href="apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
        <link href="apple-touch-icon-167x167.png" rel="apple-touch-icon" sizes="167x167" />
        <link href="apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <?php
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.
        ?>

    </head>
    <body>

        <?php /*include './utility/databaseconnection.php' */ ?>

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="riepilogo.php">CittadinAPP</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav bottoniStato">
                        <li role="button" class ="bottoneStato" daMostrare = "tutte" onclick=show(this)><a href="#">Tutte</a></li>
                        <li role="button" class ="bottoneStato active" daMostrare = "positive"onclick=show(this)><a href="#">Positive</a></li>
                        <li role="button" class ="bottoneStato" daMostrare = "negative" onclick=show(this)><a href="#">Negative</a></li>
                        <li role="button" class ="bottoneStato" daMostrare = "daVerificare" onclick=show(this)><a href="#">Da Verificare</a></li>
                        <li role="button" class ="bottoneStato" daMostrare = "verificaRichiesta" onclick=show(this)><a href="#">Verifiche richieste</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        
        <div class="container-fluid text-center">    
            <div class="container">
                <h2>Riepilogo<BR></h2>
                <button id ="buttonStatistiche" onclick="window.location.href = 'statistiche.php'" type="button" class="btn btn-primary btn-lg">Visualizza Statistiche</button>
            </div>
        </div></div>
        

    <div class="container form-group">
        <label for="sel1">Filtra per *criterio x*</label>
        <select class="form-control" id="filtroAllerta" onchange="comboAllerta(this)">
            <option value = "default">Tutti</option>
            <option value = "1">Attenzione</option>
            <option value = "2">Preallarme</option>
            <option value = "3">Allarme</option>
            <option value = "0">Senza Categoria </option>
        </select>
    </div>


    <div class ="container search">
        <input type="text" name="search" id="searchbar" oninput="handleSearch()" placeholder="Search...">
    </div><BR>

    <div class="container">  
        <div class="table-responsive">
            <table id="tavolaSegnalazioni" class="tavolaSegnalazioni table-bordered table table-hover row-clickable table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 5.0%"  onclick = orderBy("id") id="thId">ID   </th>
                        <th style="width: 30.0%" onclick = orderBy("luogo") id = "thIndirizzo">Indirizzo</th>
                        <th style="width: 30.0%" onclick = orderBy("descrizione") id="thDescrizione">Descrizione</th>
                        <th style="width: 7.0%" onclick = orderBy("attendibilita") id="thAttendibilita">Attendibilit&aacute</th>
                        <th style="width: 5.0%" onclick = orderBy("stato") id="thStato">Stato</th>
                        <th style="width: 13.0%" onclick = orderBy("cfOperatore") id="thOperatore">Operatore</th>
                        <th style="width: 10.0%" onclick = orderBy("dataChiusura") id="thChiusura">Chiusura</th>

                    </tr>
                </thead>
                <tbody id="tavolaSegnalazioniBody">

                </tbody>
            </table>
        </div>
    </div>

   <!-- <div class="container legenda">
        <h5>LEGENDA</h5>
        <h6 class=bg-info>Blu: Livello non disponibile </h6>
        <h6 class=bg-success>Verde: Livello di attenzione</h6>
        <h6 class=bg-warning>Giallo: Livello di preallarme</h6>
        <h6 class=bg-danger>Rosso: Livello di allarme</h6>
    </div> -->

</body>

<SCRIPT>

    function show(oggettoCliccato) { //QUESTA FUNZIONE MOSTRA SOLO ALCUNE DELLE SEGNALAZIONI
        stato = oggettoCliccato.getAttribute("daMostrare");
        resetNavBar(oggettoCliccato);
        console.log("Stato Cliccato: " + stato);
        switch (stato) {
            case "tutte":
                sessionStorage.removeItem("statoRichiesto");
                query = "SELECT * FROM Segnalazione JOIN Indirizzo on id = idSegnalazione ORDER BY id";
                break;
            case "positive":
                sessionStorage.setItem("statoRichiesto", 1)
                break;
            case "negative":
                sessionStorage.setItem("statoRichiesto", 2)
                break;
            case "daVerificare":
                sessionStorage.setItem("statoRichiesto", 0)
                break;
            case "verificaRichiesta":
                sessionStorage.setItem("statoRichiesto", 3)
                break;
        }
        createTable(getRightQuery());
    }

    //ResetBottoniNavBar
    function resetNavBar(bottoneAttivo) {
        bottoni = document.getElementsByClassName("bottoneStato");
        for (i = 0; i < bottoni.length; i++) {
            bottoni[i].classList.remove("active");
        }
        bottoneAttivo.classList.add("active");
    }

    //Gestione combobox
    function comboAllerta(combo) {
        valore = combo.options[combo.selectedIndex].value;

        switch (valore) {
            case "default":
                sessionStorage.removeItem("allertaRichiesta");
                query = "SELECT * FROM Segnalazione JOIN Indirizzo on id = idSegnalazione ORDER BY id";
                break;
            case "0":
                sessionStorage.setItem("allertaRichiesta", 0)
                break;
            case "1":
                sessionStorage.setItem("allertaRichiesta", 1)
                break;
            case "2":
                sessionStorage.setItem("allertaRichiesta", 2)
                break;
            case "3":
                sessionStorage.setItem("allertaRichiesta", 3)
                break;
        }
        createTable(getRightQuery());
    }


    function getRightQuery() {
        if (sessionStorage.getItem("statoRichiesto") === null && sessionStorage.getItem("allertaRichiesta") === null)
            query = "SELECT * FROM Segnalazione JOIN Indirizzo on id = idSegnalazione";
        else if (!(sessionStorage.getItem("statoRichiesto") === null) && sessionStorage.getItem("allertaRichiesta") === null)
            query = "SELECT * FROM Segnalazione JOIN Indirizzo on id = idSegnalazione WHERE stato = " + sessionStorage.getItem("statoRichiesto");
        else if (!(sessionStorage.getItem("allertaRichiesta") === null) && sessionStorage.getItem("statoRichiesto") === null)
            query = "SELECT * FROM Segnalazione JOIN Indirizzo on id = idSegnalazione WHERE livello = " + sessionStorage.getItem("allertaRichiesta");
        else
            query = "SELECT * FROM Segnalazione JOIN Indirizzo on id = idSegnalazione WHERE stato = " + sessionStorage.getItem("statoRichiesto") + " AND livello = " + sessionStorage.getItem("allertaRichiesta");

        if (!(sessionStorage.getItem("orderBy") === null)) { //SE C'E' UN CRITERIO DI ORDINE  
            query = query + " ORDER BY " + sessionStorage.getItem("orderBy") + ", id";
        } else {
            query = query + " ORDER BY id";
        }
        console.log(query);
        return query;
    }

    function orderBy(dato) {
        toSet = "DESC";
        if (!(sessionStorage.getItem("order" + dato) === null)) {
            if (sessionStorage.getItem("order" + dato).includes("ASC")) {
                toSet = "DESC";
            }
            if (sessionStorage.getItem("order" + dato).includes("DESC")) {
                toSet = "ASC";
            }
        }

        sessionStorage.setItem("order" + dato, toSet);
        sessionStorage.setItem("orderBy", dato + " " + sessionStorage.getItem("order" + dato));
        createTable(getRightQuery());
    }

    //GESTISCO LA BARRA DI RICERCA. CANCELLO RIGHE SENZA IL VALORE CERCATO
    function handleSearch() {
        var ricerca = document.getElementById("searchbar").value;
        righe = document.getElementsByClassName("rigaSegnalazione");
        for (i = 0; i < righe.length; i++) {
            testoRiga = righe[i].innerText.toLowerCase();
            testoRicerca = ricerca.toLowerCase();
            if (testoRiga.includes(testoRicerca)) {
                righe[i].style.display = "";
            } else {
                righe[i].style.display = "none";
            }
        }
    }

    //AJAX Per creare tabella
    function createTable(query) {
        corpo = document.getElementById("tavolaSegnalazioniBody");
        corpo.innerHTML = "";
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "getSegnalazioni.php?query=" + query, true);
        xhr.send("");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                xmlDoc = xhr.responseXML.documentElement;
                var segnalazioni = xmlDoc.getElementsByTagName("Segnalazione");
                var tavolaSegnalazioni = document.getElementById("tavolaSegnalazioniBody");
                var extra = xmlDoc.getElementsByTagName("Extra");
                for (s = 0; s < segnalazioni.length; s++) {

                    var row = tavolaSegnalazioni.insertRow(s);
                    statoColore = parseInt(extra[s].childNodes[1].firstChild.nodeValue);
                    if (statoColore === 0) {
                        row.classList.add("bg-info");
                    }
                    if (statoColore === 1) {
                        row.classList.add("bg-success");
                    }
                    if (statoColore === 2) {
                        row.classList.add("bg-warning");
                    }
                    if (statoColore === 3) {
                        row.classList.add("bg-danger");
                    }
                    row.classList.add("rigaSegnalazione");
                    row.setAttribute("idSegnalazione", segnalazioni[s].childNodes[0].firstChild.nodeValue);
                    for (i = 0; i < segnalazioni[s].childNodes.length; i++) {
                        if (segnalazioni[s].childNodes[i].firstChild === null) {
                            nodo = " ";
                        } else {
                            nodo = segnalazioni[s].childNodes[i].firstChild.nodeValue;
                        }

                        cell = row.insertCell(i);
                        cell.innerHTML = nodo;
                        if (i === 0) { //ID
                            id = nodo;
                            cell.innerHTML = "<H3>" + nodo + "</H3>";
                        }
                        if (i === 3) { //ATTENDIBILITA
                            if (parseInt(nodo) === -1)
                                cell.innerHTML = "UTENTE IN PROVA";
                        }

                        if (i === 4) { // STATO SEGNALAZIONE
                            stato = parseInt(nodo);
                            switch (stato) {
                                case 0:
                                    cell.innerHTML = "<img height='40' width='40' src='unverified.png'>";
                                    break;
                                case 1:
                                    cell.innerHTML = "<img height='40' width='40' src='true.png'>";
                                    break;
                                case 2:
                                    cell.innerHTML = "<img height='40' width='40' src='false.png'>";
                                    break;
                                case 3:
                                    cell.innerHTML = "<img height='40' width='40' src='waiting.png'>";
                                    break;
                                case 4:
                                    cell.innerHTML = "<img height='40' width='40' src='closed.png'>";
                                    break;
                            }
                        }
                    }
                    row.onclick = function () { //CLICCABILE
                        id = this.getAttribute("idSegnalazione");
                        window.location = "segnalazione.php?id=" + id;
                    };
                }
            }
        };
    }

    sessionStorage.setItem("statoRichiesto", 1);
    createTable(getRightQuery());

    //VERIFICA LOGIN
    function logout() {
        localStorage.removeItem("codiceFiscale");
        window.location = "https://cittadinapp.altervista.org/index.php";
    }

    /*

    $(document).ready(function () {
        //NASCONDE IL BOTTONE STATISTICHE SE NON E' UN DECISORE
        if ((localStorage.getItem("tipoUtente") != 2)) {
            document.getElementById("buttonStatistiche").style.display = "none";
        }
        if (!localStorage.codiceFiscale) {
            while (document.firstChild) {
                document.removeChild(document.firstChild);
            }
            window.location = "errorPage.php";
        }
    }); */
    //Da Riattivare quando funzionerà la logica di login


</SCRIPT>
</html>