<?php
require_once './databaseconnection.php';

if (isset($_POST['cf']) && isset($_POST['password'])) {
    
    $cf = $_POST['cf'];
    $password = $_POST['password'];

    $query = "SELECT * FROM Utente WHERE CF = '" . $cf . "'";
    $result = mysqli_query($db,$query);
    $risposta = mysqli_fetch_assoc($result);

    if (strcmp($password, $risposta['password']) == 0) {
        
        $tipo = $risposta["tipoutente"];
      /*  if ($tipo == 0) {
            echo 0;
        } else if ($tipo == 1) {
            echo 1;
        } else if ($tipo == 2) {
            echo 2;
        } */ 
        if($tipo >=0 && $tipo <=2)
            echo $tipo;
    } else {
        echo -1;
    }
}
?>
