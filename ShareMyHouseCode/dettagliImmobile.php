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
                <h2>Dettagli Immobile<BR></h2>
            </div>
        </div></div>

        <div class="container-fluid text-center">
        <BR><BR>
        <div class="container">
            <div class="row">
                <div class="col-md-4"><BR>
                    <fieldset>
                        <legend>Informazioni</legend><BR><BR>
                        <p id="campoIndirizzo">Paese finto - Indirizzo finto</p>
                        <p id="campoDisponibilita">Disponibile fino al XX/XX/XXXX</p>
                        <p id="campoPosti">Posti disponibili: X/N</p>
                        <p id="campoDisabili">Accesso Disabili: SI</p>
                    </fieldset>

                </div>
                <div class="col-md-4"><BR>
                    <fieldset>
                        <legend>Mappa</legend>
                        <div class="Flexible-container">
                        <div id="googleMap" style="position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);"></div>
                    </div>
                    </fieldset>

                </div>
                <div class="col-md-4"><BR>
                    <fieldset>
                        <legend>Pannello di Controllo</legend><BR><BR>
                        <button id="buttonProprietario" type="button" onclick="" class="btn btn-info">Informazioni Proprietario</button><BR><BR>
                        <button id="buttonOccupanti" type="button" onclick="" class="btn btn-warning">Gestisci Occupanti</button>

                    </fieldset>

                </div>
            </div>
        </div></div>

</body>


</html>