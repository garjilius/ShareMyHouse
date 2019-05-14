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
    <script type="text/javascript" src="/utility/checklogin.js"></script>
    <script type="text/javascript" src="/utility/apikey.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>
    <script type="text/javascript" src="/utility/JS_Utilities.js?v?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>


    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

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
            <a class="navbar-brand" href="">ShareMyHouse</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav bottoniStato">
                <li role="button" class ="bottoneStato" ><a href="riepilogo.php">Immobili</a></li>
                <li role="button" class ="bottoneStato active"><a href="cittadini.php">Cittadini</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php" onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <h2>Aggiunta Cittadino</h2><BR><BR>
    <div class="container">
        <div class="row">
            <div class="col-md-4"><BR>
                <h4>Codice fiscale</h4>
                <h5><input id="codiceFiscaleCittadino" type="text" value=""></h5><BR>
                <h4><i class="fa fa-wheelchair"> Accesso Disabili</i></h4>
                <h5><input id="disabilitaCittadino" type="checkbox" value=""></h5><BR>

            </div>
            <div class="col-md-4">
                <h4><i class="fa fa-map-pin"> Regione</i></h4>
                <select id="immRegione" onchange="filtroRegioni()" name="regione" class="form-control" style="width:60%; margin:auto">


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


                </select><BR>
                <h4><i class="fa fa-map-pin"> Provincia</i></h4>
                <select id="immProvincia" disabled name="provincia" class="form-control" style="width:60%; margin:auto"> </select><BR>


                <h4>Mail</h4>
                <h5><input id="mailCittadino" type="" placeholder="" value=""></h5><BR>
                <h4>Telefono</h4>
                <h5><input id="telefonoCittadino" min="9" max="9" value=""></h5><BR>

            </div>
            <div class="col-md-4"><BR>
                <h4><i class="fa fa-map-pin"> Città</i></h4>
                <h5><input id="cittaCittadino" type="text" value=""></h5><BR>
                <h4><i class="fa fa-map-pin"> Indirizzo</i></h4>
                <h5 ><input id="indirizzoCittadino" type="text" value=""></h5><BR>

                <h4><i class="fa fa-map-pin"> Data di Nascita</i></h4>
                <h5 ><input id="dataNascitaCittadino" type="text" value=""></h5><BR>
                <h4><i class="fa fa-map-pin"> Nome</i></h4>
                <h5 ><input id="nomeCittadino" type="text" value=""></h5><BR>
                <h4><i class="fa fa-map-pin"> Cognome</i></h4>
                <h5 ><input id="cognomeCittadino" type="text" value=""></h5><BR>
            </div>
        </div>
    </div>
    <button id="buttonAccetta" type="button" class="btn btn-danger" onclick="window.location.href='cittadini.php'">Annulla</button>
    <button id="buttonAccetta" type="button" onclick="salvaCittadino()" class="btn btn-success">Aggiungi e torna alla lista</button>

</div>
<BR><BR><BR>
</body>

</html>