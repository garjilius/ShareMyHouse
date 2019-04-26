<?php
require_once './databaseconnection.php';
header('Content-type: application/json');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');

    $query = file_get_contents('php://input');
    //echo $cf." ";

    //$query = "SELECT * FROM Abitazioni WHERE Proprietario = '" . $cf . "'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

class immobile {
    private $id = "";
    private $nome = "";
    private $proprietario= "";
    private $idonea ="";
    private $accessoDisabili="";
    private $regione="";
    private $provincia="";
    private $citta="";
    private $indirizzo="";
    private $latitudine="";
    private $longitudine="";
    private $disponibilita="";



    public function toArray() {
        return array(
            "id" => $this->getId(),
            "nome" => $this->getNome(),
            "proprietario" => $this->getProprietario(),
            "idonea" => $this->getIdonea(),
            "indirizzo" => $this->getIndirizzo(),
            "accessoDisabili" => $this->getAccessoDisabili(),
            "citta" => $this->getCitta(),
            "provincia" => $this->getProvincia(),
            "regione" => $this->getRegione(),
            "latitudine" => $this->getLatitudine(),
            "longitudine" => $this->getLongitudine(),
            "disponibilita" => $this->getDisponibilita()
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

    /**
     * @return string
     */
    public function getProprietario()
    {
        return $this->proprietario;
    }

    /**
     * @param string $proprietario
     */
    public function setProprietario($proprietario)
    {
        $this->proprietario = $proprietario;
    }

    /**
     * @return string
     */
    public function getIdonea()
    {
        return $this->idonea;
    }

    /**
     * @param string $idonea
     */
    public function setIdonea($idonea)
    {
        $this->idonea = $idonea;
    }

    /**
     * @return string
     */
    public function getAccessoDisabili()
    {
        return $this->accessoDisabili;
    }

    /**
     * @param string $accessoDisabili
     */
    public function setAccessoDisabili($accessoDisabili)
    {
        $this->accessoDisabili = $accessoDisabili;
    }

    /**
     * @return string
     */
    public function getRegione()
    {
        return $this->regione;
    }

    /**
     * @param string $regione
     */
    public function setRegione($regione)
    {
        $this->regione = $regione;
    }

    /**
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * @param string $provincia
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    /**
     * @return string
     */
    public function getCitta()
    {
        return $this->citta;
    }

    /**
     * @param string $citta
     */
    public function setCitta($citta)
    {
        $this->citta = $citta;
    }

    /**
     * @return string
     */
    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    /**
     * @param string $indirizzo
     */
    public function setIndirizzo($indirizzo)
    {
        $this->indirizzo = $indirizzo;
    }

    /**
     * @return string
     */
    public function getLatitudine()
    {
        return $this->latitudine;
    }

    /**
     * @param string $latitudine
     */
    public function setLatitudine($latitudine)
    {
        $this->latitudine = $latitudine;
    }

    /**
     * @return string
     */
    public function getLongitudine()
    {
        return $this->longitudine;
    }

    /**
     * @param string $longitudine
     */
    public function setLongitudine($longitudine)
    {
        $this->longitudine = $longitudine;
    }

    /**
     * @return string
     */
    public function getDisponibilita()
    {
        return $this->disponibilita;
    }

    /**
     * @param string $disponibilita
     */
    public function setDisponibilita($disponibilita)
    {
        $this->disponibilita = $disponibilita;
    }



}

$numrighe = mysqli_num_rows($result);
$immobili = array();
//echo $numrighe;

for ($i=0;$i<$numrighe;$i++) {

    $riga = mysqli_fetch_assoc($result);
    $immobileTMP = new immobile();
    $immobileTMP->setId($riga["IDAbitazione"]);
    $immobileTMP->setCitta($riga["Citta"]);
    $immobileTMP->setProvincia($riga["Provincia"]);
    $immobileTMP->setRegione($riga["Regione"]);
    $immobileTMP->setIndirizzo($riga["Indirizzo"]);
    $immobileTMP->setAccessoDisabili($riga["AccessoDisabili"]);
    $immobileTMP->setNome($riga["NomeAbitazione"]);
    $immobileTMP->setProprietario($riga["Proprietario"]);
    $immobileTMP->setIdonea($riga["Idonea"]);
    $immobileTMP->setLatitudine($riga["Latitudine"]);
    $immobileTMP->setLongitudine($riga["Longitudine"]);
    $immobileTMP->setDisponibilita($riga["scadenzaDisponibilita"]);

    $immobili[$i] = $immobileTMP->toArray();

}
//echo $utenti[0]->getNome();
$immobiliJSON = json_encode($immobili);
echo $immobiliJSON;

?>