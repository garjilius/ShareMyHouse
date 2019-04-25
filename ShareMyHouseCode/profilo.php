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
    <script type="text/javascript" src="/utility/JS_Utilities.js?n=o1poi0o"></script>




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
            <a class="navbar-brand" href="riepilogo.php">Area Utente</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav bottoniStato">
                <li role="button" class ="bottoneStato active" ><a href="profilo.php">Profilo</a></li>
                <li role="button" class ="bottoneStato" ><a href="mieimmobili.php">I Miei Immobili</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php" onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
   <h2 id = "titoloNomeUtente">Benvenuto, Nome Utente</h2>
    <h3>Le Tue Informazioni</h3><BR><BR>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h4><i class="fa fa-user"> Utente</i></h4>
            <h5><input disabled id="userName" type="text" name="NomeCognome" value="Mario Rossi"></h5><BR>
            <h4><i class="fa fa-id-card"> CODICE FISCALE</i></h4>
            <h5><input disabled id="cfUser" type="text" name="CF" value="CODICEFISCALEEEEE"></h5><BR>

        </div>
        <div class="col-md-4">
            <h4><i class="fa fa-calendar">Data Di Nascita</i></h4>
            <h5><input disabled id="dataNascitaUser" type="text" name="dataNascita" value="22/22/22"></h5><BR>
            <h4><i class="fa fa-map-pin"> Indirizzo</i></h4>
            <h5><input disabled id="addressUser" type="text" class="infoutenteModificabile" name="Indirizzo" value="Via Via Via 5"></h5><BR>

        </div>
        <div class="col-md-4">
            <h4><i class="fa fa-phone"> Telefono</i></h4>
            <h5><input disabled id="telUtente" type="text" class="infoutenteModificabile" name="TelUtente" value="0123456789"></h5><BR>
            <h4><i class="fa fa-envelope-o"> eMail</i></h4>
            <h5 ><input disabled id="emailUser" type="text" class="infoutenteModificabile" name="mail" value="posta@elettronica.com"></h5><BR>
        </div>
    </div>
</div>
    <button id="buttonModifica" type="button" onclick="modificaInfoUtente()" class="btn btn-primary">Modifica</button>
</div>

<script>
getDatiUtente(localStorage.codiceFiscale);
</script>
</body>
</html>