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
    <script type="text/javascript" src="/utility/JS_Utilities.js?v=4"></script>


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
            <a class="navbar-brand" href="riepilogo.php">Area Utente</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav bottoniStato">
                <li role="button" class ="bottoneStato" ><a href="profilo.php">Profilo</a></li>
                <li role="button" class ="bottoneStato active"><a href="mieimmobili.php">I Miei Immobili</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php" onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container" id="containerAccordion">
    <BR><BR>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Immobile 1 - Villetta a Barletta</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <p>Posti Occupati: 3/4</p>
                    <p>Disponibile fino al: 19/09/2020</p>
                    <p>Idoneità: SI</p>
                    <button type="button" id="buttonModifica" class="btn btn-info">Modifica</button>
                    <button type="button" id="buttonElimina"  class="btn btn-danger">Elimina</button>

                </div>
            </div>
        </div>
    <p><strong>Note:</strong> Click on the linked heading text to expand or collapse accordion panels.</p>
</div>
</div>

<div class="container-fluid text-center">
    <button id="buttonAggiunta" type="button" onclick="window.location.href='/addImmobile.php'" class="btn btn-success">Aggiungi Immobile</button>
</div>



</body>
<SCRIPT>

    query = "SELECT * From Abitazioni WHERE Proprietario = '"+localStorage.codiceFiscale+"'";
    getImmobili(query);

    function popola() { //DA SPOSTARE POI NEL FILE JS UTILITIES
        for(i=0; i<5;i++) {
            acc = document.getElementById("accordion");
            acc.innerHTML = acc.innerHTML +
            "";
        }
    }

    popola();
</SCRIPT>
</html>