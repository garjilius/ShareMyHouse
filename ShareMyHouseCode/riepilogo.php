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
        <link href="/images/SHARE_MY_HOUSE.png" rel="apple-touch-icon" />
        <link href="/images/SHARE_MY_HOUSE_180x180.png" rel="apple-touch-icon" sizes="152x152" />
        <link href="/images/SHARE_MY_HOUSE_167x167.png" rel="apple-touch-icon" sizes="167x167" />
        <link href="/images/SHARE_MY_HOUSE_180x180.png" rel="apple-touch-icon" sizes="180x180" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="/utility/checklogin.js"></script>
        <script type="text/javascript" src="/utility/JS_Utilities.js"></script>






        <?php
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.
        ?>

    </head>
    <body>

        <?php include './utility/databaseconnection.php'  ?>

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="riepilogo.php">ShareMyHouse</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav bottoniStato">
                        <li role="button" class ="bottoneStato active" daMostrare = "tutte" onclick=show(this)><a href="#">Immobili</a></li>
                        <li role="button" class ="bottoneStato" daMostrare = "positive"onclick=show(this)><a href="#">Cittadini</a></li>
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
            </div>
        </div></div>

    <div class ="container search">
        <input type="text" name="search" id="searchbar" oninput="handleSearch()" placeholder="Search...">
    </div><BR>

        <div class="container form-group">
            <select class="form-control" id="immRegione" style="width:250px;" onchange="filtroRegioni()">

                <?php
                require './utility/databaseconnection.php';
                    $query = "SELECT * FROM Regione";
                    $result = mysqli_query($db, $query);
                    $numRighe = mysqli_num_rows($result);

                    echo '<option value="0">Regione</option>';

                    for ($i = 0; $i < $numRighe; $i++) {
                        $regioni = mysqli_fetch_row($result);
                        $tmp = $regioni[1];
                        $num = $regioni[0];
                        echo '<option value="' . $num . '">' . $tmp . '</option>';
                    }


                ?>
            </select>
            <select class="form-control" id="immProvincia" style="width:250px;" disabled name="provincia" onchange="getImmobili()">
                <option value="0">Provincia</option>
            </select>
            <input type="checkbox" name="barrieraArchitettionica" value="barrieraArchitettionica">Nessuna barriera architettonica<br>
        </div>

    <div class="container">  
        <div class="table-responsive">
            <table id="tavolaSegnalazioni" class="tavolaSegnalazioni table-bordered table table-hover row-clickable table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 5.0%"  onclick = orderBy("id") id="thId">ID   </th>
                        <th style="width: 15.0%" onclick = orderBy("luogo") id = "thRegione">Regione</th>
                        <th style="width: 5.0%" onclick = orderBy("descrizione") id="thProvincia">Provincia</th>
                        <th style="width: 25.0%" onclick = orderBy("attendibilita") id="thCitta">Citt&agrave</th>
                        <th style="width: 45.0%" onclick = orderBy("stato") id="thIndirizzo">Indirizzo</th>
                        <th style="width: 5.0%" onclick = orderBy("cfOperatore") id="thPosti">Posti</th>

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
        <script type="text/javascript">
            getImmobili();
        </script>
</body>

<!--<SCRIPT>

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




</SCRIPT>-->
</html>