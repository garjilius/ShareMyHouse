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
    <script type="text/javascript" src="/utility/JS_Utilities.js?<?php echo date('l jS \of F Y h:i:s A'); ?>"></script>


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
            <a class="navbar-brand" href="riepilogo.php">ShareMyHouse</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav bottoniStato">
                <li role="button"  ><a href="riepilogo.php">Immobili</a></li>
                <li role="button" ><a href="">Cittadini</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a onclick="logout()"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container" id="containerAccordion">
    <BR><BR>
    <div class="panel-group" id="accordion">

</div>
</div>

<div class="container-fluid text-center">
    <BR><BR><BR>
</div>



</body>
<SCRIPT>

    query = "SELECT * From Utente WHERE tipoutente = 2";
    function getCittadiniQuery(query) {
        console.log("entro");
        var httpReq = new XMLHttpRequest();
        httpReq.onreadystatechange = function () {
            if (httpReq.readyState === 4 && httpReq.status === 200) {
                cittadini = JSON.parse(httpReq.responseText);

                //Genera gli accordion per gli immobili
                for(i=0; i<cittadini.length;i++) {
                    destinationSource = "#"+cittadini[i].cf;
                    destination = cittadini[i].cf;
                    panelBodyID = "panelBody"+cittadini[i].cf;
                    titoloAccordionID = "titoloAccordion"+cittadini[i].cf;

                    acc = document.getElementById("accordion");
                    acc.innerHTML = acc.innerHTML +
                    "        <div class=\"panel panel-default\">\n" +
                        "            <div class=\"panel-heading\">\n" +
                        "                <h4 class=\"panel-title\">\n" +
                        "                    <a data-toggle=\"collapse\"  id=\""+titoloAccordionID+"\" data-parent=\"#accordion\" href=\""+destinationSource+"\">Prova</a>\n" +
                        "                </h4>\n" +
                        "            </div>\n" +
                        "            <div id=\""+destination+"\" class=\"panel-collapse collapse in\">\n" +
                        "                <div class=\"panel-body\" id=\""+panelBodyID+"\">\n" +
                        "                </div>\n" +
                        "            </div>\n" +
                        "        </div>";
                }
                popolaCampi();
            }
        }

        httpReq.open("POST", "/utility/getCittadiniJSON.php?v=2", true);
        httpReq.setRequestHeader('Content-Type', 'application/json');
        httpReq.send(query);


    }

    function popolaCampi() {
        for (i = 0; i < cittadini.length; i++) {
            titolo = document.getElementById("titoloAccordion" + cittadini[i].cf);
            titolo.innerText = cittadini[i].nome;
            panelbody = document.getElementById("panelBody"+cittadini[i].cf);
            if(cittadini[i].idonea ==1) {
                idoneita = "Si";
            }
            else {
                idoneita = "No";
            }

            panelbody.innerHTML= "<p>Posti Occupati: "+cittadini[i].cf+"/"+cittadini[i].cf+"</p>" +
                "<p>Resa disponibile fino al: "+cittadini[i].cf+"</p>" +
                "<p>Idoneità Concessa: "+cittadini[i].cf;

            var btnMod = document.createElement("BUTTON");
            btnMod.className = "btn btn-info";
            btnMod.id = "buttonModifica"+cittadini[i].cf;
            btnMod.innerText ="Modifica Immobile";
            btnMod.style.margin = "5px";
            btnMod.setAttribute("idAbitazione",cittadini[i].cf);
            btnMod.onclick = function(){
                localStorage.setItem("idAbitazione",this.getAttribute("idAbitazione"));
                window.location.href='/editImmobile.php?'
            };


            var btnDel = document.createElement("BUTTON");
            btnDel.className = "btn btn-danger";
            btnDel.id = "buttonDelete"+cittadini[i].cf;
            btnDel.setAttribute("idAbitazione",cittadini[i].cf);
            btnDel.innerText ="Elimina";
            btnDel.onclick = function(){
                localStorage.setItem("idAbitazione",this.getAttribute("idAbitazione"));
                eliminaImmobile(localStorage.getItem("idAbitazione"));
            };
            panelbody.appendChild(btnDel);
            panelbody.appendChild(btnMod);

        }
    }

    getCittadiniQuery(query);
</SCRIPT>
</html>