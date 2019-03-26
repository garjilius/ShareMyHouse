<!DOCTYPE html>
<html lang="en">

    <head>
        <title>CittadinAPP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-Equiv="Cache-Control" Content="no-cache">
        <meta http-Equiv="Pragma" Content="no-cache">
        <meta http-Equiv="Expires" Content="0">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link href="apple-touch-icon.png" rel="apple-touch-icon" />
        <link href="apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152" />
        <link href="apple-touch-icon-167x167.png" rel="apple-touch-icon" sizes="167x167" />
        <link href="apple-touch-icon-180x180.png" rel="apple-touch-icon" sizes="180x180" />



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
        </script>

        <?php
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.
        ?>

    </head>

    <body>

        <!-- NAVIGATION BAR -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">CittadinAPP</a>
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
                        <button type="button" onclick="inviaMail()" class="btn btn-default">Invia</button>
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
                                        <select id="regione" name="regione" class="form-control">
                                            <?php
                                            require_once './databaseconnection.php';

                                            $query = "SELECT nome FROM Regione";
                                            $result = mysql_query($query);
                                            $numRighe = mysql_num_rows($result);

                                            echo '<option value="default">--------------------</option>';
                                            for ($i = 0; $i < $numRighe; $i++) {
                                                $regioni = mysql_fetch_row($result);
                                                $tmp = $regioni[0];
                                                echo '<option value="' . $tmp . '">' . $tmp . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-lg-4">

                                        <select id="provincia" name="provincia" class="form-control">
                                            <?php
                                            $query = "SELECT sigla FROM province";
                                            $result = mysql_query($query);
                                            $numRighe = mysql_num_rows($result);

                                            echo '<option value="default">--------------------</option>';
                                            for ($i = 0; $i < $numRighe; $i++) {
                                                $province = mysql_fetch_row($result);
                                                $tmp = $province[0];
                                                echo '<option value="' . $tmp . '">' . $tmp . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cap">CAP</label>
                                <input type="number" class="form-control" id="cap" maxlength="5">

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
                        <button type="button" onclick="nuovoUtente()" class="btn btn-default">Invia</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="space" style="height: 30px" ></div>

        <script type="text/javascript">
 
            function login() {

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
                            switch (parseInt(httpReq.responseText)) {
                                case 0:
                                    localStorage.setItem("cittadinApp", cf);
                                    window.location = "formSegnalazioneUtente.php";
                                    break;
                                case 1:
                                    localStorage.setItem("codiceFiscale", cf);
                                    localStorage.setItem("tipoUtente", 1);
                                    window.location = "riepilogo.php";
                                    break;
                                case 2:
                                    localStorage.setItem("codiceFiscale", cf);
                                    localStorage.setItem("tipoUtente", 2);
                                    window.location = "riepilogo.php";
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

                    httpReq.open("POST", "operazioniUtente.php", true);
                    httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    httpReq.send("cfLogin=" + cf + "&passwordLogin=" + password);
                }
            }

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
                var cap = document.getElementById("cap").value;

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

                } else if (cap.length == 0 || cap.length != 5) {
                    document.getElementById("alertErroreDialog").innerHTML = "Controllare il <strong>CAP</strong>.";
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

                var httpReq = new XMLHttpRequest();
                httpReq.onreadystatechange = function () {

                    if (httpReq.readyState == 4 && httpReq.status == 200) {

                        var response = parseInt(httpReq.responseText);

                        switch (response) {
                            case 1:
                                alert("Riceverai una mail per completare la procedura di registrazione.");
                                $('#primoAccesso').modal('hide');
                                break;
                            case - 1:
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



                httpReq.open("POST", "operazioniUtente.php", true);
                httpReq.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                httpReq.send("nome=" + nome + "&cognome=" + cognome +
                        "&dataNascita=" + dataNascita + "&cf=" + cfNuovoUtente +
                        "&mail=" + mailNuovoUtente + "&password=" + pass1 + "&via=" + via +
                        "&citta=" + citta + "&provincia=" + provincia + "&regione=" + regione + "&cap=" + cap);

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
    </body>
</html>



