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

class cittadino {
    private $cf = "";
    private $regione = "";
    private $provincia= "";
    private $citta ="";
    private $indirizzo="";
    private $accessoDisabiliNecessario="";
    private $dataNascita="";
    private $mail="";
    private $telefono="";
    private $latitudine="";
    private $longitudine="";
    private $tipoUtente="";
    private $idImmobileAssegnato="";

    public function toArray() {
        return array(
            "cf" => $this->getCF(),
            "regione" => $this->getRegione(),
            "provincia" => $this->getProvincia(),
            "citta" => $this->getCitta(),
            "indirizzo" => $this->getIndirizzo(),
            "accessoDisabiliNecessario" => $this->getAccessoDisabiliNecessario(),
            "dataNascita" => $this->getDataNascita(),
            "mail" => $this->getMail(),
            "telefono" => $this->getTelefono(),
            "latitudine" => $this->getLatitudine(),
            "longitudine" => $this->getLongitudine(),
            "idImmobileAssegnato" => $this->getIdImmobileAssegnato(),
            "tipoUtente" => $this->getTipoUtente()
        );
    }


    public function getCF()
    {
        return $this->cf;
    }

    /**
     * @return string
     */
    public function getIdImmobileAssegnato()
    {
        return $this->idImmobileAssegnato;
    }

    /**
     * @param string $idImmobileAssegnato
     */
    public function setIdImmobileAssegnato($idImmobileAssegnato)
    {
        $this->idImmobileAssegnato = $idImmobileAssegnato;
    }


    public function setCF($cf)
    {
        $this->cf = $cf;
    }

    public function getRegione()
    {
        return $this->regione;
    }

    public function setRegione($regione)
    {
        $this->regione = $regione;
    }

    public function getAccessoDisabiliNecessario()
    {
        return $this->accessoDisabiliNecessario;
    }


    public function setAccessoDisabiliNecessario($accessoDisabiliNecessario)
    {
        $this->accessoDisabiliNecessario = $accessoDisabiliNecessario;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }


    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }


    public function getCitta()
    {
        return $this->citta;
    }

    public function setCitta($citta)
    {
        $this->citta = $citta;
    }

    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    public function setIndirizzo($indirizzo)
    {
        $this->indirizzo = $indirizzo;
    }


    public function getLatitudine()
    {
        return $this->latitudine;
    }

    public function setLatitudine($latitudine)
    {
        $this->latitudine = $latitudine;
    }

    public function getLongitudine()
    {
        return $this->longitudine;
    }

    public function setLongitudine($longitudine)
    {
        $this->longitudine = $longitudine;
    }

    public function getDataNascita()
    {
        return $this->dataNascita;
    }

    public function setDataNascita($dataNascita)
    {
        $this->dataNascita = $dataNascita;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getTipoUtente()
    {
        return $this->tipoUtente;
    }

    public function setTipoUtente($tipoUtente)
    {
        $this->tipoUtente = $tipoUtente;
    }


}

$numrighe = mysqli_num_rows($result);
$cittadini = array();
//echo $numrighe;

for ($i=0;$i<$numrighe;$i++) {

    $riga = mysqli_fetch_assoc($result);
    $cittadiniTMP = new cittadino();
    $cittadiniTMP->setCF($riga["CF"]);
    $cittadiniTMP->setRegione($riga["Regione"]);
    $cittadiniTMP->setProvincia($riga["Provincia"]);
    $cittadiniTMP->setCitta($riga["Citta"]);
    $cittadiniTMP->setIndirizzo($riga["Indirizzo"]);
    $cittadiniTMP->setAccessoDisabiliNecessario($riga["AccessoDisabiliNecessario"]);
    $cittadiniTMP->setDataNascita($riga["DataNascita"]);
    $cittadiniTMP->setMail($riga["mail"]);
    $cittadiniTMP->setTelefono($riga["telefono"]);
    $cittadiniTMP->setLatitudine($riga["Latitudine"]);
    $cittadiniTMP->setLongitudine($riga["Longitudine"]);
    $cittadiniTMP->setIdImmobileAssegnato($riga["idImmobileAssegnato"]);

    $cittadini[$i] = $cittadiniTMP->toArray();

}
//echo $utenti[0]->getNome();
$cittadiniJSON = json_encode($cittadini);
echo $cittadiniJSON;

?>