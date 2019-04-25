<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate"); header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$str_query = file_get_contents('php://input');

require_once './databaseconnection.php';
$response = mysqli_query($db,$str_query) or die (mysqli_error($db));
echo $response;
?>

