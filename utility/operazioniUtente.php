<?php

header("Content-Type: application/json; charset=UTF-8");
require_once './databaseconnection.php';

// SALVATAGGIO TEMPORANEO NUOVO UTENTE
if (isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['dataNascita']) && isset($_POST['cf']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['via']) && isset($_POST['citta']) && isset($_POST['provincia']) && isset($_POST['regione']) && isset($_POST['cap'])) {

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $dataNascita = $_POST['dataNascita'];
    $cf = $_POST['cf'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $via = $_POST['via'];
    $citta = $_POST['citta'];
    $provincia = $_POST['provincia'];
    $regione = $_POST['regione'];
    $cap = $_POST['cap'];

    // Controllo presenza codice fiscale 
    $queryCheckCF = "SELECT * FROM Utente WHERE CF = '%s'";
    $queryCheckCF = sprintf($queryCheckCF, $cf);

    // Controllo presenza email
    $queryCheckEmail = "SELECT * FROM Utente WHERE email = '%s'";
    $queryCheckEmail = sprintf($queryCheckEmail, $mail);

    $codiceCausale = "";
    for ($i; $i < 5; $i++) {
        $codiceCausale .= rand(1, 1000);
    }

    $query = "INSERT INTO CacheTemporanea VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')";
    $query = sprintf($query, $nome, $cognome, $dataNascita, $cf, $mail, $password, $via, $citta, $provincia, $regione, $cap, $codiceCausale);

    if (mysqli_num_rows(mysqli_query($db,$queryCheckCF)) > 0) {

        echo -1;
    } else if (mysqli_num_rows(mysqli_query($db,$queryCheckEmail)) > 0) {

        echo -2;
    } else if (mysqli_query($db,$query)) {

        $oggetto = "Conferma indirizzo mail CittadinAPP";
        $link = "https://www.cittadinapp.altervista.org/confermaRegistrazione.php?codice=" . $codiceCausale;

        $messaggio = '<html><head>
        <title>Conferma indirizzo mail CittadinAPP</title>
        </head>
        <body>
            <h3>MESSAGGIO GENERATO AUTOMATICAMENTE! NON RISPONDERE!</h3>
            <p>Per confermare la mail e completare la registrazione, clicca qui:</p>
            <p><a href="' . $link . '"><button type="button">Conferma registrazione</button></a></p>
        </body>
        </html>';

        $intestazioni = "From: CittadinAPP\r\n";

        /* Per inviare email in formato HTML, si deve impostare l'intestazione Content-type. */
        $intestazioni .= "MIME-Version: 1.0\r\n";
        $intestazioni .= "Content-type: text/html; charset=iso-8859-1\r\n";

        $esito = mail($mail, $oggetto, $messaggio, $intestazioni);

        if ($esito) {
            echo 1;
        } else {
            echo -3;
        }
    } else {
        echo -4;
    }
}

// INVIO EMAIL DI RECUPERO PASSWORD
if (isset($_POST['emailRecupero'])) {

    $emailRecupero = $_POST['emailRecupero'];

    $query = "SELECT password FROM Utente WHERE email = '%s'";
    $query = sprintf($query, $emailRecupero);
    $result = mysqli_query($db,$query);

    if (mysqli_num_rows($result) == 0) {

        echo -1;
    } else {

        $info = mysqli_fetch_assoc($result);
        $password = $info['password'];

        $oggetto = "Recupero password CittadinAPP";

        $messaggio = '<html><head>
          <title>Recupero password CittadinAPP</title>
          </head>
          <body>
          <h3>MESSAGGIO GENERATO AUTOMATICAMENTE! NON RISPONDERE!</h3>
          <p>Password per accedere a CittadinAPP: ' . $password . '</p>
          </body>
          </html>';

        $intestazioni = "From: CittadinAPP\r\n";
        // Per inviare email in formato HTML, si deve impostare l'intestazione Content-type.
        $intestazioni .= "MIME-Version: 1.0\r\n";
        $intestazioni .= "Content-type: text/html; charset=iso-8859-1\r\n";

        $esito = mail($emailRecupero, $oggetto, $messaggio, $intestazioni);

        if ($esito) {
            echo 1;
        } else {
            echo -2;
        }
    }
}

// LOGIN
if (isset($_POST['cfLogin']) && isset($_POST['passwordLogin'])) {

    $cf = $_POST['cfLogin'];
    $password = $_POST['passwordLogin'];

    $query = "SELECT * FROM Utente WHERE CF = '" . $cf . "'";
    $result = mysql_query($query);

    if (mysqli_num_rows($result) > 0) {

        $riga = mysqli_fetch_assoc($result);

        if (strcmp($password, $riga['password']) == 0) {

            $tipo = $riga["tipoUtente"];
            /* if ($tipo == 0) {
              echo 0;
              } else if ($tipo == 1) {
              echo 1;
              } */
            if ($tipo >= 0 && $tipo <= 2)
                echo $tipo;
        } else {
            echo -2;
        }
    } else {
        echo -1;
    }
}


// AGGIUNGI SEGNALAZIONI
if (isset($_POST['jsonS']) && isset($_POST['jsonI'])) {

    $segnalazione = json_decode($_POST['jsonS']);

    $cf = $segnalazione->cf;
    $coordinate = $segnalazione->coordinate;
    $luogo = $segnalazione->luogo;
    $descrizione = $segnalazione->descrizione;
    $livello = $segnalazione->livello;
    $immagine = $segnalazione->immagine;

    $query = "SELECT attendibilita FROM Utente WHERE CF = '%s'";
    $query = sprintf($query, $cf);
    $result = mysqli_query($db,$query);
    $riga = mysqli_fetch_row($result);
    $attendibilita = $riga[0];

    $queryS = "INSERT INTO Segnalazione(descrizione, luogo, coordinate,"
            . " attendibilita, CF, livello, immagine, dataOra) VALUES ('%s','%s','%s','%s','%s','%s','%s', NOW())";
    $queryS = sprintf($queryS, $descrizione, $luogo, $coordinate, $attendibilita, $cf, $livello, $immagine);
    $resultS = mysqli_query($db,$queryS);

    $indirizzo = json_decode($_POST['jsonI']);

    $streetNumber = $indirizzo->streetNumber;
    $route = $indirizzo->route;
    $locality = $indirizzo->locality;
    $areaLevel3 = $indirizzo->areaLevel3;
    $areaLevel2 = $indirizzo->areaLevel2;
    $areaLevel1 = $indirizzo->areaLevel1;
    $country = $indirizzo->country;
    $postalCode = $indirizzo->postalCode;
    $lat = $indirizzo->lat;
    $lng = $indirizzo->lng;
    $area = $indirizzo->area;

    $queryMaxId = "SELECT max(id) FROM Segnalazione";
    $resultMaxQuery = mysqli_query($db,$queryMaxId);
    $maxId = mysqli_fetch_row($resultMaxQuery)[0];

    $queryI = "INSERT INTO Indirizzo VALUES('%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')";
    $queryI = sprintf($queryI, $maxId, $streetNumber, $route, $locality, $areaLevel3, $areaLevel2, $areaLevel1, $country, $postalCode, $lat, $lng, $area);
    $resultI = mysqli_query($db,$queryI);

    if($resultS && $resultI) {
    	echo true;
    } else {
    	echo false;
    }
}

// SCARICA COORDINATE AREA DI UNA SEGNALAZIONE
if (isset($_GET['idSegnalazione']) && isset($_GET['area'])) {

    $id = $_GET['idSegnalazione'];

    $query = "SELECT area FROM Indirizzo WHERE idSegnalazione = '" . $id . "'";
    $result = mysqli_query($db,$query);

    if (mysqli_num_rows($result) > 0) {

        $res = mysqli_fetch_row($result);
        echo $res[0];
    }
}

class Segnalazione {

    private $id;
    private $descrizione;
    private $dataOra;
    private $CF;
    private $luogo;
    private $lat;
    private $lng;
    private $livello;
    private $stato;
    private $immagine;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getDescrizione() {
        return $this->descrizione;
    }

    function getDataOra() {
        return $this->dataOra;
    }

    function getCF() {
        return $this->CF;
    }

    function getLuogo() {
        return $this->luogo;
    }

    function setDescrizione($descrizione) {
        $this->descrizione = $descrizione;
    }

    function setDataOra($dataOra) {
        $this->dataOra = $dataOra;
    }

    function setCF($CF) {
        $this->CF = $CF;
    }

    function setLuogo($luogo) {
        $this->luogo = $luogo;
    }

    function getLat() {
        return $this->lat;
    }

    function getLng() {
        return $this->lng;
    }

    function setLat($lat) {
        $this->lat = $lat;
    }

    function setLng($lng) {
        $this->lng = $lng;
    }

    function getLivello() {
        return $this->livello;
    }

    function setLivello($livello) {
        $this->livello = $livello;
    }

    function getStato() {
        return $this->stato;
    }

    function setStato($stato) {
        $this->stato = $stato;
    }

    function getImmagine() {
        return $this->immagine;
    }

    function setImmagine($immagine) {
        $this->immagine = $immagine;
    }

    function toJSON() {
        return array(
            "id" => $this->id,
            "descrizione" => $this->descrizione,
            "dataOra" => $this->dataOra,
            "CF" => $this->CF,
            "luogo" => $this->luogo,
            "lat" => $this->lat,
            "lng" => $this->lng,
            "livello" => $this->livello,
            "stato" => $this->stato,
            "immagine" => $this->immagine
        );
    }

}

function getArraySegnalazioni($result) {

    $numRighe = mysqli_num_rows($result);
    $segnalazioni = array();

    for ($i = 0; $i < $numRighe; $i++) {

        $res = mysqli_fetch_assoc($result);
        $tmp = new Segnalazione();
        $tmp->setId($res['id']);
        $tmp->setDescrizione($res['descrizione']);
        $tmp->setDataOra($res['dataOra']);
        $tmp->setCF($res['CF']);
        $tmp->setLuogo($res['luogo']);
        $tmp->setLat($res['lat']);
        $tmp->setLng($res['lng']);
        $tmp->setLivello($res['livello']);
        $tmp->setStato($res['stato']);
        $tmp->setImmagine($res['immagine']);
        $segnalazioni[$i] = $tmp->toJSON();
    }

    return $segnalazioni;
}

// SCARICA SEGNALAZIONI IN PROVINCIA
if (isset($_GET['provincia'])) {

    $provincia = $_GET['provincia'];

    $queryProvincia = "SELECT Segnalazione.descrizione, Segnalazione.dataOra, Segnalazione.CF, 
        Segnalazione.luogo, Indirizzo.lat, Indirizzo.lng, Segnalazione.livello, Segnalazione.stato FROM Segnalazione 
        JOIN Indirizzo ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.provincia = '%s' 
        AND Segnalazione.stato = 1 AND Segnalazione.cfOperatore IS NOT NULL";
    $queryProvincia = sprintf($queryProvincia, $provincia);
    $result = mysqli_query($db,$queryProvincia);
    $segnalazioni = getArraySegnalazioni($result);

    echo json_encode($segnalazioni);
}

// SCARICA SEGNALAZIONI UTENTE
if (isset($_GET['cf']) && isset($_GET['elenco'])) {

    $cf = $_GET['cf'];

    $query = "SELECT * FROM Segnalazione WHERE CF = '%s'";
    $query = sprintf($query, $cf);
    $result = mysqli_query($db,$query);
    $segnalazioni = getArraySegnalazioni($result);

    echo json_encode($segnalazioni);
}

// SCARICA SEGNALAZIONI IN CITTA
if (isset($_GET['citta'])) {

    $citta = $_GET['citta'];

    $queryCitta = "SELECT Segnalazione.descrizione, Segnalazione.dataOra, Segnalazione.CF, 
        Segnalazione.luogo, Indirizzo.lat, Indirizzo.lng, Segnalazione.livello, Segnalazione.stato FROM Segnalazione 
        JOIN Indirizzo ON Segnalazione.id = Indirizzo.idSegnalazione AND Indirizzo.citta2 = '%s' 
        AND Segnalazione.stato = 1 AND Segnalazione.cfOperatore IS NOT NULL";
    $queryCitta = sprintf($queryCitta, $citta);
    $result = mysqli_query($db,$queryCitta);
    $segnalazioni = getArraySegnalazioni($result);

    echo json_encode($segnalazioni);
}
