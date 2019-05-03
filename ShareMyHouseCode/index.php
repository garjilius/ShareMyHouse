<!DOCTYPE html>
<html lang="en">

    <head>
        <title>ShareMyHouse</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-Equiv="Cache-Control" Content="no-cache">
        <meta http-Equiv="Pragma" Content="no-cache">
        <meta http-Equiv="Expires" Content="0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link href="/images/SHARE_MY_HOUSE.png" rel="apple-touch-icon" />
        <link href="/images/SHARE_MY_HOUSE_180x180.png" rel="apple-touch-icon" sizes="152x152" />
        <link href="/images/SHARE_MY_HOUSE_167x167.png" rel="apple-touch-icon" sizes="167x167" />
        <link href="/images/SHARE_MY_HOUSE_180x180.png" rel="apple-touch-icon" sizes="180x180" />
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript" src="/utility/JS_Utilities.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
        <script type="text/javascript" src="/utility/getDistance.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
       <!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="/utility/apikey.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
        <script type="text/javascript">



            if (localStorage.getItem("cittadinApp")) {
                window.location = "formSegnalazioneUtente.php";
            }

            //CANCELLO SESSIONSTORAGE AL CARICAMENTO PAGINA
            $(document).ready(function () {
                if (sessionStorage.codiceFiscale) {
                    sessionStorage.removeItem("codiceFiscale");
                }
            });

            window.login = function() {

                var cf = document.getElementById("cf").value;
                var password = document.getElementById("password").value;
                if (cf.length == 0) {
                    document.getElementById("alertErrore").innerHTML = "Inserire un <strong>codice fiscale</strong>.";
                    document.getElementById("alertErrore").hidden = false;
                    return;
                } else if (password.length == 0) {
                    document.getElementById("alertErrore").innerHTML = "Inserire una <strong>password</strong>.";
                    document.getElementById("alertErrore").hidden = false;
                    return;

                } else {

                    var httpReq = new XMLHttpRequest();
                    httpReq.onreadystatechange = function () {


                        if (httpReq.readyState == 4 && httpReq.status == 200) {
                            console.log(parseInt(httpReq.responseText)+"");
                            localStorage.setItem("codiceFiscale", cf);

                            switch (parseInt(httpReq.responseText)) {
                                case 0:
                                    localStorage.setItem("tipoUtente", 0);
                                    window.location = "mieimmobili.php"; //pagina utente
                                    break;
                                case 1:
                                    localStorage.setItem("tipoUtente", 1);
                                    window.location = "riepilogo.php"; //pagina operatore
                                    break;
                                case 2:
                                    localStorage.setItem("tipoUtente", 2);
                                    //window.location = "riepilogo.php"; //Rimuovere? Non ci saranno più di due tipologie di utenti
                                    break;
                                case - 1:
                                    document.getElementById("alertErrore").innerHTML = "Codice fiscale <strong>NON PRESENTE</strong> nel database.";
                                    document.getElementById("alertErrore").hidden = false;
                                    break;
                                case - 2:
                                    document.getElementById("alertErrore").innerHTML = "<strong>Password inserita errata</strong>.";
                                    document.getElementById("alertErrore").hidden = false;
                                    break;
                            }
                        }
                    };

                    httpReq.open("POST", "/utility/login.php", true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send("cf=" + cf + "&password=" + password);
                }
            };

            function inviaMail() {

                document.getElementById("alertErroreRecuperoMail").hidden = true;

                var mail = document.getElementById("mail").value;

                if (!validazione_email(mail)) {
                    document.getElementById("alertErroreRecuperoMail").innerHTML = "Indirizzo mail <strong>non valido</strong>.";
                    document.getElementById("alertErroreRecuperoMail").hidden = false;
                    return;
                }


                var httpReq = new XMLHttpRequest();
                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {
                        console.log(httpReq.responseText);
                        var response = parseInt(httpReq.responseText);
                        switch (response) {
                            case - 1:
                                document.getElementById("alertErroreRecuperoMail").innerHTML = "<strong>Indirizzo email</strong> non associato ad un account.";
                                document.getElementById("alertErroreRecuperoMail").hidden = false;
                                break;
                            case - 2:
                                document.getElementById("alertErroreRecuperoMail").innerHTML = "Errore invio mail.";
                                document.getElementById("alertErroreRecuperoMail").hidden = false;
                                break;
                            case 1:
                                alert("Riceverai una mail con la password.");
                                $('#recuperoPassword').modal('hide');
                                break;

                        }
                    }
                };
                httpReq.open("POST", "operazioniUtente.php", true);
                httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                httpReq.send("emailRecupero=" + mail);
            }

            function nuovoUtente() {

                document.getElementById("alertErroreDialog").hidden = true;

                var nome = document.getElementById("nome").value;
                var cognome = document.getElementById("cognome").value;
                var dataNascita = document.getElementById("dataNascita").value;
                var cfNuovoUtente = document.getElementById("cfNuovo").value;
                var mailNuovoUtente = document.getElementById("mailNuovo").value;
                var pass1 = document.getElementById("pass1").value;
                var pass2 = document.getElementById("pass2").value;
                var via = document.getElementById("via").value;
                var citta = document.getElementById("citta").value;
                var provincia = document.getElementById("provincia").value;
                var regione = document.getElementById("regione").value;
                var telefono = document.getElementById("telefono").value;

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

                } else if (pass1.length == 0 || pass2.length == 0) {
                    document.getElementById("alertErroreDialog").innerHTML = "Verificare i campi <strong>password</strong>.";
                    document.getElementById("alertErroreDialog").hidden = false;
                    return;

                } else if (pass1 !== pass2) {
                    document.getElementById("alertErroreDialog").innerHTML = "Le due password <strong>non corrispondono</strong>.";
                    document.getElementById("alertErroreDialog").hidden = false;
                    return;

                } else if (!validazione_data(dataNascita)) {
                    document.getElementById("alertErroreDialog").innerHTML = "Formato data <strong>non valido</strong>.";
                    document.getElementById("alertErroreDialog").hidden = false;
                    return;

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
                        httpReq2.send("nome=" + nome + "&cognome=" + cognome + "&dataNascita=" + dataNascita + "&cf=" + cfNuovoUtente + "&mail=" + mailNuovoUtente + "&password=" + pass1 + "&via=" + via + "&citta=" + citta + "&provincia=" + provincia + "&regione=" + regione + "&telefono=" + telefono + "&latitudine=" + latitudine + "&longitudine=" + longitudine);

                    }
                };

                url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+indirizzoEncoded+'&key='+mapsAPIKey;
                httpReq.open("POST", url, true);
                httpReq.send();


            }

            function validazione_email(email) {
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (!reg.test(email))
                    return false;
                else
                    return true;
            }

            function validazione_data(data) {
                var espressione = /^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}/;
                if (!espressione.test(data))
                    return false;
                else
                    return true;
            }

        </script>


        <?php
        //header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        //header("Pragma: no-cache"); // HTTP 1.0.
        //header("Expires: 0 "); // Proxies.
        ?>

    </head>

    <body>

        <!-- NAVIGATION BAR -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">ShareMyHouse</a>
                </div>
            </div>
        </nav>

        <div class="space" style="height: 30px" ></div>

        <!-- CONTAINER FORM -->
        <div class="container">

            <form action="">

                <div class="form-group">
                    <label for="cf"><h3>Codice Fiscale</h3></label>
                    <input type="text" class="form-control" id="cf" name="cf">
                </div>

                <div class="form-group">
                    <label for="password"><h3>Password</h3></label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6 col-sm-8 col-lg-10">

                        </div>
                        <div class="col-xs-6 col-sm-4 col-lg-2">
                            <button type="button" id="buttonInvia" onclick="login()" class="btn btn-default" style="position: absolute; right: 10px;" >Login</button>
                        </div>
                    </div>
                </div>

                <div class="space" style="height: 30px" ></div>

                <div class="alert alert-danger" id="alertErrore" hidden="true">

                </div>

                <div class="space" style="height: 60px" ></div>

                <div class="form-group">
                    <a style="text-decoration: underline; cursor: pointer" data-toggle="modal" data-target="#primoAccesso">Primo accesso</a>
                    <a style="text-decoration: underline; float: right; cursor: pointer" data-toggle="modal" data-target="#recuperoPassword" >Password dimenticata?</a> 
                </div>
            </form>
        </div>

        <!-- MODALE RECUPERO PASSWORD -->
        <div class="modal fade" id="recuperoPassword" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Recupero password</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="mail">Inserire indirizzo email</label>
                            <input type="mail" class="form-control" id="mail" name="mail">
                        </div>

                        <div class="alert alert-danger" id="alertErroreRecuperoMail" hidden="true">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="nuovoUtente()" class="btn btn-default">Invia</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODALE ISCRIZIONE -->
        <div class="modal fade" id="primoAccesso" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Registrazione utente</h4>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group">
                                <label for="cfNuovo">Codice fiscale</label>
                                <input type="text" class="form-control" id="cfNuovo" name="cfNuovo">
                            </div>
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome">
                            </div>
                            <div class="form-group">
                                <label for="cognome">Cognome</label>
                                <input type="text" class="form-control" id="cognome" name="cognome">
                            </div>
                            <div class="form-group">
                                <label for="dataNascita">Data di nascita</label>
                                <input type="date" class="form-control" id="dataNascita" name="dataNascita" placeholder="FORMATO: YYYY-MM-DD">
                            </div>
                            <div class="form-group">
                                <label for="via">Via e numero Civico</label>
                                <input type="text" class="form-control" id="via">
                            </div>
                            <div class="form-group">
                                <label for="citta">Citt&agrave;</label>
                                <input type="text" class="form-control" id="citta">
                            </div>


                            <div class="form-group">
                                <label>Regione - Provincia</label>
                                <div class="row">
                                    <div class="col-xs-8 col-sm-8 col-lg-8">
                                        <select id="regione" name="regione" onchange="filtroRegioni()" class="form-control">

                                            <?php
                                            require_once './utility/databaseconnection.php';

                                            $query = "SELECT * FROM Regione";
                                            $result = mysqli_query($db,$query);
                                            $numRighe = mysqli_num_rows($result);

                                            echo '<option value="0">--------------------</option>';
                                            for ($i = 0; $i < $numRighe; $i++) {
                                                $regioni = mysqli_fetch_row($result);
                                                $tmp = $regioni[1];
                                                $num = $regioni[0];
                                                echo '<option value="' . $num . '">' . $tmp . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-lg-4">

                                        <select id="provincia" disabled name="provincia" class="form-control">

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="telegono">Telefono</label>
                                <input type="number" class="form-control" id="telefono" maxlength="10">

                            </div>


                            <div class="form-group">
                                <label for="mailNuovo">Email</label>
                                <input type="email" class="form-control" id="mailNuovo" name="mailNuovo">
                            </div>
                            <div class="form-group">
                                <label for="pass1">Password</label>
                                <input type="password" class="form-control" id="pass1" name="pass1">
                            </div>
                            <div class="form-group">
                                <label for="pass1">Ripetere password</label>
                                <input type="password" class="form-control" id="pass2" name="pass2">
                            </div>
                        </form>

                        <div class="alert alert-danger" id="alertErroreDialog" hidden="true">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="bottoneInvio" type="button" onclick="nuovoUtente()" class="btn btn-default">Invia</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="space" style="height: 30px" ></div>

    </body>
</html>



