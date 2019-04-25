<?php
require_once './databaseconnection.php';
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');

    $cf = file_get_contents('php://input');


    $query = "SELECT * FROM Utente JOIN InfoUtente ON Utente.CF = InfoUtente.CF WHERE Utente.CF = '" . $cf . "'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

   // echo $query;
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

    echo '<dati>';
    while ($riga = mysqli_fetch_assoc($result)) {

       echo '<Utente>';

        echo '<cf>' . $riga["CF"] . '</cf>';
        echo '<nome>' . $riga["Nome"] . '</nome>';
        echo '<cognome>' . $riga["Cognome"] . '</cognome>';
        echo '<dataNascita>' . $riga["DataNascita"] . '</dataNascita>';
        echo '<mail>' . $riga["mail"] . '</mail>';
        echo '<tel>' . $riga["telefono"] . '</tel>';
        echo '<tipoUtente>' . $riga["tipoutente"] . '</tipoUtente>';
        echo '<Regione>' . $riga["Regione"] . '</Regione>';
        echo '<Provincia>' . $riga["Provincia"] . '</Provincia>';
        echo '<Citta>' . $riga["Citta"] . '</Citta>';
        echo '<Indirizzo>' . $riga["Indirizzo"] . '</Indirizzo>';
        echo '<AccDisNec>' . $riga["AccessoDisabiliNecessario"] . '</AccDisNec>';

        echo '</Utente>';

    }
    echo '</dati>';

?>
