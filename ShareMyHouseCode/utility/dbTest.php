<?php
	$username = "";
	$host = "";
    $database = "my_sharemyhouse";
    $password = "";
    $myip = $_SERVER["REMOTE_ADDR"];

    $db = mysqli_connect($host, $username,$password, $database) or die("Errore durante la connessione al database");

    $query = "SELECT * FROM Utente JOIN InfoUtente ON Utente.CF = InfoUtente.CF WHERE Utente.CF = '" . $cf . "'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

?>
