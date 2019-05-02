<?php
require_once './databaseconnection.php';

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
    $queryCheckCF = "SELECT * FROM Utente WHERE CF = '".$cf."'";
    $result = mysqli_query($db,$queryCheckCF);
    $rowcount=mysqli_num_rows($result);
    if($rowcount > 0){
        echo -1;
        exit();
    }


    // Controllo presenza email
    $queryCheckEmail = "SELECT * FROM InfoUtente WHERE mail = '".$mail."'";
    $result = mysqli_query($db,$queryCheckEmail);
    $rowcount=mysqli_num_rows($result);
    if($rowcount > 0){
        echo -2;
        exit();
    }

    $query = "INSERT INTO `InfoUtente`(`CF`, `Regione`, `Provincia`, `Citta`, `Indirizzo`, `AccessoDisabiliNecessario`, `DataNascita`, `mail`, `telefono`, `latitudine`, `longitudine`)
                            VALUES ('".$cf."', '".$regione."', '".$provincia."','".$citta."','".$via."', '0','".$dataNascita."', '".$mail."', '0000', 'latitudine', 'longitudine')";


    $query1 = "INSERT INTO `Utente`(`CF`, `Nome`, `Cognome`, `password`, `tipoutente`) VALUES ('".$cf."', '".$nome."', '".$cognome."', '".$password."', '0')";

    $error = 0;

    $result = mysqli_query($db,$query);
    if($result)
    {
        $error = 0;

    }
    else{
        echo 4;
        exit();
    }


    $result1 = mysqli_query($db,$query1);
    if($result1)
    {
        $error = 0;

    }
    else{
        echo 4;
        exit();
    }

    echo $error;
}
?>
