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
        <script type="text/javascript" src="/utility/getDistance.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
        <script type="text/javascript" src="/utility/JS_Utilities.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>

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
                        <li role="button" class="active" ><a href="riepilogo.php">Immobili</a></li>
                        <li role="button" ><a href="cittadini.php">Cittadini</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        
        <div class="container-fluid text-center">    
            <div class="container">
                <h2 id="intestazionePagina">Riepilogo Immobili<BR></h2>
            </div>
        </div></div>

    <div class ="container search text-center">
        <input type="text" name="search" id="searchbar" oninput="handleSearch()" placeholder="Search...">
    </div><BR>

        <div class="container text-center">
            <h5>KM Massimi dalla residenza: <input id="rangeKm" type="number" min="1" placeholder="km" value="" oninput="getImmobiliCittadino()"></h5>
            <h5>Stessa Provincia <input id="sameProvincia" type="checkbox" onclick="getImmobiliCittadino()" value=""></h5>
            <h5>Stessa Regione <input id="sameRegione" type="checkbox" value="" onclick="getImmobiliCittadino()"></h5>
        </div>

    <div class="container">  
        <div class="table-responsive">
            <table id="tavolaSegnalazioni" class="tavolaSegnalazioni table-striped table-bordered table table-hover row-clickable table-responsive">
                <thead class="thead-dark">
                    <tr id="righeTabella">
                        <th style="width: 5.0%" id="thId">ID   </th>
                        <th style="width: 15.0%" id = "thRegione">Regione</th>
                        <th style="width: 5.0%" id="thProvincia">Provincia</th>
                        <th style="width: 25.0%" id="thCitta">Citt&agrave</th>
                        <th style="width: 45.0%" id="thIndirizzo">Indirizzo</th>
                        <th style="width: 5.0%" id="thPosti">Posti</th>
                        <th style="width: 5.0%" id="thPosti">Azione</th>

                    </tr>
                </thead>
                <tbody id="tavolaSegnalazioniBody">

                </tbody>
            </table>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Conferma operazione</h4>
                    </div>
                    <div class="modal-body">
                        <p>Sei sicuro di voler assegnare l'occupante?</p>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Annulla</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="mostraModale()">Assegna occupante</button>
                    </div>
                </div>
    </div>

        <script type="text/javascript">

            cf =<?=$_GET['cf']?>;
            document.getElementById("intestazionePagina").innerText ="Cerca migliore immobile per:  "+cf ;
            //Carico i dati dell'utente e formo la tabella
            getUtente(cf);

            function cercaImmobileAssegnato() {
                var httpReq = new XMLHttpRequest();

                var idImmobile = parseInt(document.getElementById("idImmobileRiga").textContent);

                var query = "SELECT idImmobileAssegnato From InfoUtente WHERE CF='" + cf + "'";

                console.log("id querty  " + query);

                cercaImmobileAssegnato(query);

                function cercaImmobileAssegnato(query) {
                    httpReq.onreadystatechange = function () {
                        if (httpReq.readyState === 4 && httpReq.status === 200) {
                            if (httpReq.responseText !== false) {

                                cittadini = JSON.parse(httpReq.responseText);
                                idImmobileAssegnato = parseInt((cittadini[0].idImmobileAssegnato));

                                if(idImmobileAssegnato==0){
                                    queryAggiornamento = "UPDATE InfoUtente SET idImmobileAssegnato="+idImmobile+" WHERE CF='" + cf + "'";
                                    aggiornaNumeroPosti(queryAggiornamento);

                                }else{
                                    console.log("già assegnato");
                                }
                            }
                        }
                    }

                    httpReq.open("POST", "/utility/getCittadiniJSON.php?v=2", true);
                    httpReq.setRequestHeader('Content-Type', 'application/json');
                    httpReq.send(query);

                }

            }

            function mostraModale() {
                var httpReq = new XMLHttpRequest();

               // var x = document.getElementById("tavolaSegnalazioni").querySelector("#thId").value;

                var x = document.getElementById("aggiungiOccupante").parentElement.parentElement;
                var idImmobile = parseInt(document.getElementById("idImmobileRiga").textContent);

                var query = "SELECT Abitazioni.postiOccupati,Abitazioni.postiTotali, InfoUtente.idImmobileAssegnato From Abitazioni INNER JOIN InfoUtente WHERE IDAbitazione="+idImmobile;

                mostraModale(query);

                function mostraModale(query) {
                    httpReq.onreadystatechange = function () {
                        if (httpReq.readyState === 4 && httpReq.status === 200) {
                            if (httpReq.responseText !== false) {
                                immobili = JSON.parse(httpReq.responseText);

                                    postiTotali = parseInt(immobili[0].postiTotali);
                                    postiOccupati = parseInt(immobili[0].postiOccupati);

                                cercaImmobileAssegnato();

                                if (postiOccupati < postiTotali) {

                                        postiOccupati = postiOccupati + 1;
                                        queryAggiornamento = "UPDATE Abitazioni INNER JOIN InfoUtente ON Abitazioni.IDAbitazione=InfoUtente.idImmobileAssegnato SET Abitazioni.postiOccupati=" + postiOccupati + " WHERE Abitazioni.IDAbitazione =" + idImmobile+ "";
                                        aggiornaNumeroPosti(queryAggiornamento);

                                }else if(postiOccupati >= postiTotali){
                                    window.alert("Questa abitazione ha tutti i posti occupati!");

                                }
                                else {
                                    console.log("non posso aggionare ancora");
                                }
                            }


                        }
                    }
                }

                httpReq.open("POST", "/utility/getImmobiliJSON.php?v=2", true);
                httpReq.setRequestHeader('Content-Type', 'application/json');
                httpReq.send(query);

            }


        </script>
</body>


</html>