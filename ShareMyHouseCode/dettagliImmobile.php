<!DOCTYPE html>
<html lang="it">
    <head>
        <title>ShareMyHouse</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-Equiv="Cache-Control" Content="no-cache">
        <meta http-Equiv="Pragma" Content="no-cache">
        <meta http-Equiv="Expires" Content="0">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/CSS/extra.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
        <link href="/images/SHARE_MY_HOUSE.png" rel="apple-touch-icon" />
        <link href="/images/SHARE_MY_HOUSE_180x180.png" rel="apple-touch-icon" sizes="152x152" />
        <link href="/images/SHARE_MY_HOUSE_167x167.png" rel="apple-touch-icon" sizes="167x167" />
        <link href="/images/SHARE_MY_HOUSE_180x180.png" rel="apple-touch-icon" sizes="180x180" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="/utility/checklogin.js"></script>
        <script type="text/javascript" src="/utility/JS_Utilities.js"></script>
        <script type="text/javascript" src="/utility/apikey.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>

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
                <h2>Dettagli Immobile<BR></h2>
                <h3 id="titoloNome"></h3>
            </div>
        </div></div>

        <div class="container-fluid text-center">
        <BR><BR>
        <div class="container">
            <div class="row">
                <div class="col-md-4"><BR>
                    <fieldset>
                        <legend>Informazioni</legend><BR><BR>
                        <h4 id="campoIndirizzo">Paese finto - Indirizzo finto </h4>
                        <h4 id="campoDisponibilita">Disponibile fino al XX/XX/XXXX </h4>
                        <h4 id="campoPosti">Posti disponibili: X/N </h4>
                        <h4 id="campoDisabili">Accesso Disabili: SI </h4>
                    </fieldset>

                </div>
                <div class="col-md-4"><BR>
                    <fieldset>
                        <legend>Mappa</legend>
                        <div class="Flexible-container">
                        <div id="googleMap" style="position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>
                    </div>
                    </fieldset>
                    <br><br><br><br>

                </div>
                <div class="col-md-4"><BR>
                    <fieldset>
                        <legend>Pannello di Controllo</legend><BR><BR>
                        <button id="buttonProprietario" type="button" onclick="mostraModaleProprietario(immobili[0].proprietario)" class="btn btn-info">Informazioni Proprietario</button><BR><BR>
                        <button id="buttonOccupanti" type="button" onclick="window.location.href='gestisciOccupanti.php'" class="btn btn-warning">Gestisci Occupanti</button><BR>
                        <h5>Idoneità concessa <input id="immIdoneo" onclick="gestisciIdoneita()" type="checkbox" value=""></h5><BR>
                        <BR><BR><BR>
                    </fieldset>

                </div>
            </div>
        </div></div>

        <div class="modal fade" id="modaleUserInfo" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Informazioni Proprietario</h4>
                    </div>
                    <div class="modal-body" id="bodyModaleUserInfo">

                        <h4 class="fa fa-user"> Nome </h4>
                        <h6 id="modalNome">PLACEHOLDER</h6>

                        <h4 class="fa fa-user"> Cognome </h4>
                        <h6 id="modalCognome">PLACEHOLDER</h6>

                        <h4 class="fa fa-id-card"> Codice Fiscale</h4>
                         <h6 id="modalCF">PLACEHOLDER</h6>

                        <h4 class="fa fa-calendar"> Data Di Nascita</h4>
                        <h6 id="modalNascita">PlaceHolder</h6>

                        <h4 class="fa fa-envelope-o"> Mail</h4>
                        <h6 id="modalMail">PLACEHOLDER</h6>

                        <h4 class="fa fa-phone"> Telefono</h4>
                        <h6 id="modalTelefono">PLACEHOLDER</h6>

                        <h4 class="fa fa-map-pin"> Indirizzo</h4>
                        <h6 id="modalIndirizzo">PLACEHOLDER</h6>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

</body>

<script>

    var immobili ="";

    function caricaDati() {
        id =  <?=$_GET['idImmobile']?>;
        query = "Select * FROM Abitazioni WHERE IDAbitazione ="+id;
        var httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function () {
            if (httpReq.readyState === 4 && httpReq.status === 200) {
                immobili = JSON.parse(httpReq.responseText);

                document.getElementById("titoloNome").innerText = id+": "+immobili[0].nome;
                document.getElementById("campoIndirizzo").innerText = immobili[0].indirizzo + " - "+immobili[0].citta + " ("+immobili[0].provincia+")";
                document.getElementById("campoDisponibilita").innerText = "Disponibile fino al "+immobili[0].disponibilita;
                document.getElementById("campoPosti").innerText = "Posti disponibili: "+ (immobili[0].postiTotali-immobili[0].postiOccupati)+ "/" +immobili[0].postiTotali;

                accDis = immobili[0].accessoDisabili;
                if(accDis ==1) {
                    document.getElementById("campoDisabili").innerText = "Accesso Disabili: SI";
                }
                else {
                    document.getElementById("campoDisabili").innerText = "Accesso Disabili: NO";
                }

                if(immobili[0].idonea ==1) {
                    document.getElementById("immIdoneo").checked = true;
                }
                else {
                    document.getElementById("immIdoneo").checked = false;
                }


                //CREAZIONE MAPPA
                var latitudine = parseFloat(immobili[0].latitudine);
                var longitudine = parseFloat(immobili[0].longitudine);
                var coordinate = {lat: latitudine, lng: longitudine};
                var mapProp = {
                    center: coordinate,
                    zoom: 17,
                    tilt:0,
                    mapTypeId: google.maps.MapTypeId.HYBRID
                };
                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                var marker = new google.maps.Marker({
                    position: coordinate,
                    title: immobili[0].nome,
                    map: map
                });
                marker.setMap(map);
            }
        }

        httpReq.open("POST", "/utility/getImmobiliJSON.php?v=2", true);
        httpReq.setRequestHeader('Content-Type', 'application/json');
        httpReq.send(query);

    }

    function mostraModaleProprietario(cf) {
        var httpReq = new XMLHttpRequest();

        var modalNome = document.getElementById("modalNome");
        var modalCognome = document.getElementById("modalCognome");
        var modalNascita = document.getElementById("modalNascita");
        var modalIndirizzo = document.getElementById("modalIndirizzo");
        var modalMail = document.getElementById("modalMail");
        var modalTelefono = document.getElementById("modalTelefono");
        var modalCF = document.getElementById("modalCF");

        httpReq.onreadystatechange = function () {
            if (httpReq.readyState === 4 && httpReq.status === 200) {
                if(httpReq.responseText!==false) {
                    utenti = JSON.parse(httpReq.responseText);

                    modalNome.innerHTML = utenti[0].nome;
                    modalCognome.innerHTML = utenti[0].cognome;
                    modalCF.innerHTML = utenti[0].cf;
                    modalNascita.innerHTML =  utenti[0].dataNascita;
                    modalIndirizzo.innerHTML =  utenti[0].indirizzo + " - " + utenti[0].citta;
                    modalMail.innerHTML = utenti[0].mail;
                    modalTelefono.innerHTML = utenti[0].telefono;


                    $("#modaleUserInfo").modal("show");

                }
            }
        }

        httpReq.open("POST", "/utility/getDatiUtenteJSON.php?v=9o0o10o2", true);
        httpReq.setRequestHeader('Content-Type', 'application/json');
        httpReq.send(cf);

    }

    function gestisciIdoneita() {
        id =  <?=$_GET['idImmobile']?>;
        var checkIdoneo = document.getElementById("immIdoneo");
        if (checkIdoneo.checked) {
            query = "UPDATE Abitazioni SET Idonea =1 WHERE IDAbitazione = "+id;
        }
        else {
            query = "UPDATE Abitazioni SET Idonea =0 WHERE IDAbitazione = "+id;
        }
        ajaxConnect(query);
    }



</script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDi6OYQpSp_dEjtGzJ3hkeZXBw-wlMBUk0&callback=caricaDati"></script>


</html>