<?php
require_once './databaseconnection.php';
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');

    $xmlCF = file_get_contents('php://input');
    //echo $xmlCF;
    $cf = simplexml_load_string($xmlCF);
    $cf = $cf->query[0]->cf;;
    //echo $cf;

    $query = "SELECT * FROM Abitazioni WHERE PROPRIETARIO = '" . $cf . "'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

   // echo $query;
    echo '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?>';

    echo '<dati>';
    while ($riga = mysqli_fetch_assoc($result)) {

       echo '<Immobile>';

        echo '<id>' . $riga["IDAbitazione"] . '</id>';
        echo '<nome>' . $riga["NomeAbitazione"] . '</nome>';
        echo '<proprietario>' . $riga["Proprietario"] . '</proprietario>';
        echo '<idonea>' . $riga["Idonea"] . '</idonea>';
        echo '<accessoDisabili>' . $riga["AccessoDisabili"] . '</accessoDisabili>';
        echo '<regione>' . $riga["Regione"] . '</regione>';
        echo '<provincia>' . $riga["Provincia"] . '</provincia>';
        echo '<citta>' . $riga["Citta"] . '</citta>';
        echo '<indirizzo>' . $riga["Indirizzo"] . '</indirizzo>';
        echo '<latitudine>' . $riga["Latitudine"] . '</latitudine>';
        echo '<longitudine>' . $riga["longitudine"] . '</longitudine>';

        echo '</Immobile>';

    }
    echo '</dati>';

?>
