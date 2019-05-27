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
                <h2>Riepilogo Immobili<BR></h2>
            </div>
        </div></div>

    <div class ="container search">
        <input type="text" name="search" id="searchbar" oninput="handleSearch('rigaImmobile')" placeholder="Search...">
    </div><BR>

        <div class="container form-group">
                <select class="form-control" id="immRegione" style="width:250px; display: inline;" onchange="filtroRegioni()">

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
            <select class="form-control" id="immProvincia" style="width:250px; display: inline; margin-left: 20px;" disabled name="provincia" onchange="getImmobili()">
                <option value="0">Provincia</option>
            </select>
            <input type="checkbox" id="checkBarrieraArchitettonica" style="margin-left: 15px; margin-right: 7px; text-align:center;" value="checkBarrieraArchitettonica" onclick="getImmobili()">Accesso disabili<br>
        </div>

    <div class="container">  
        <div class="table-responsive">
            <table id="tavolaSegnalazioni" class="tavolaSegnalazioni table-striped table-bordered table table-hover row-clickable table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th style="width: 5.0%" id="thId">ID   </th>
                        <th style="width: 15.0%" id = "thRegione">Regione</th>
                        <th style="width: 5.0%" id="thProvincia">Provincia</th>
                        <th style="width: 25.0%" id="thCitta">Citt&agrave</th>
                        <th style="width: 45.0%" id="thIndirizzo">Indirizzo</th>
                        <th style="width: 5.0%" id="thPosti">Posti</th>

                    </tr>
                </thead>
                <tbody id="tavolaSegnalazioniBody">

                </tbody>
            </table>
        </div>
    </div>

        <script type="text/javascript">
            var stringaDaPassare = 'riepilogo';
            localStorage.setItem('paginaProvenienza', stringaDaPassare);
            getImmobili();
        </script>
</body>


</html>