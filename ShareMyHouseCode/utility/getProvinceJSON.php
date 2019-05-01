<?php
require_once './databaseconnection.php';
header('Content-type: application/json');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');

    $query = file_get_contents('php://input');
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

class provincia {
    private $id = "";
    private $idRegione = "";
    private $sigla= "";
    private $nome ="";


    public function toArray() {
        return array(
            "id" => $this->getId(),
            "nomeProvincia" => $this->getNome(),
            "idRegione" => $this->getIdRegione(),
            "siglaProvincia" => $this->getSigla(),

        );
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIdRegione()
    {
        return $this->idRegione;
    }

    /**
     * @param string $idRegione
     */
    public function setIdRegione($idRegione)
    {
        $this->idRegione = $idRegione;
    }

    /**
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * @param string $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }






}

$numrighe = mysqli_num_rows($result);
$province = array();
//echo $numrighe;

for ($i=0;$i<$numrighe;$i++) {

    $riga = mysqli_fetch_assoc($result);
    $provinciaTMP = new provincia();
    $provinciaTMP->setId($riga["id"]);
    $provinciaTMP->setNome($riga["nome"]);
    $provinciaTMP->setIdRegione($riga["id_regione"]);
    $provinciaTMP->setSigla($riga["sigla"]);


    $province[$i] = $provinciaTMP->toArray();

}
//echo $utenti[0]->getNome();
$provinceJSON = json_encode($province);
echo $provinceJSON;

?>