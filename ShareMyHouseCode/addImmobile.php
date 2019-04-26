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

<div class="container-fluid text-center">
    <h2>Aggiunta Immobile</h2><BR><BR>
    <div class="container">
        <div class="row">
            <div class="col-md-4"><BR>
                <h4><i class="fa fa-id-card-o"> Alias Immobile</i></h4>
                <h5><input id="immAlias" type="text" value=""></h5><BR>
                <h4><i class="fa fa-wheelchair"> Accesso Disabili</i></h4>
                <h5><input id="immDisabili" type="checkbox" value=""></h5><BR>

            </div>
            <div class="col-md-4">
                <h4><i class="fa fa-map-pin"> Regione</i></h4>
                <select id="immRegione" name="regione" class="form-control" style="width:60%; margin:auto">
                    <?php
                    require_once './utility/databaseconnection.php';

                    $query = "SELECT nome FROM Regione";
                    $result = mysqli_query($db,$query);
                    $numRighe = mysqli_num_rows($result);

                    echo '<option value="">--------------------</option>';
                    for ($i = 0; $i < $numRighe; $i++) {
                        $regioni = mysqli_fetch_row($result);
                        $tmp = $regioni[0];
                        echo '<option value="' . $tmp . '">' . $tmp . '</option>';
                    }
                    ?>
                </select><BR>
                <h4><i class="fa fa-map-pin"> Provincia</i></h4>
                <select id="immProvincia" name="provincia" class="form-control" style="width:60%; margin:auto">
                    <?php
                    $query = "SELECT sigla FROM province";
                    $result = mysqli_query($db,$query);
                    $numRighe = mysqli_num_rows($result);

                    echo '<option value="">--------------------</option>';
                    for ($i = 0; $i < $numRighe; $i++) {
                        $province = mysqli_fetch_row($result);
                        $tmp = $province[0];
                        echo '<option value="' . $tmp . '">' . $tmp . '</option>';
                    }
                    ?>
                </select><BR>

            </div>
            <div class="col-md-4"><BR>
                <h4><i class="fa fa-map-pin"> Città</i></h4>
                <h5><input id="immCitta" type="text" value=""></h5><BR>
                <h4><i class="fa fa-map-pin"> Indirizzo</i></h4>
                <h5 ><input id="immIndirizzo" type="text" value=""></h5><BR>
            </div>
        </div>
    </div>
    <button id="buttonAccetta" type="button" onclick="salvaImmobile()" class="btn btn-primary">Fine</button>

</div>
<BR><BR><BR>
</body>

</html>