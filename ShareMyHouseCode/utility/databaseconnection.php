<?php
	$username = "";
	$host = "";
    $database = "my_emanuelegargiulo";
    $password = "";
    $myip = $_SERVER["REMOTE_ADDR"];

    $db = mysqli_connect($host, $username,$password, $database) or die("Errore durante la connessione al database");

    /*
if (mysqli_ping($db)) {
   echo "Connection is ok!";
}
else  {
    echo "Error: ". mysqli_error($db);
} */
?>
