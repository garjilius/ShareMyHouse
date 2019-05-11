<?php
require_once './databaseconnection.php';
header('Content-type: application/json');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');

    $cf = file_get_contents('php://input');

    $query = "SELECT * FROM Utente JOIN InfoUtente ON Utente.CF = InfoUtente.CF WHERE Utente.CF = '" . $cf . "'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));

    class utente {
        private $cf = "";
        private $nome = "";
        private $cognome= "";
        private $tipoUtente ="";
        private $dataNascita="";
        private $mail="";
        private $telefono="";
        private $regione="";
        private $provincia="";
        private $citta="";
        private $indirizzo="";
        private $necessDisabili="";
        private $latitudine="";
        private $longitudine="";

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



        public function getCf()
        {
            return $this->cf;
        }

        public function setCf($cf)
        {
            $this->cf = $cf;
        }

        public function getNome()
        {
            return $this->nome;
        }

        public function setNome($nome)
        {
            $this->nome = $nome;
        }

        public function getCognome()
        {
            return $this->cognome;
        }

        public function setCognome($cognome)
        {
            $this->cognome = $cognome;
        }

        public function getTipoUtente()
        {
            return $this->tipoUtente;
        }

        public function setTipoUtente($tipoUtente)
        {
            $this->tipoUtente = $tipoUtente;
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

        public function getRegione()
        {
            return $this->regione;
        }

        public function setRegione($regione)
        {
            $this->regione = $regione;
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

        public function getNecessDisabili()
        {
            return $this->necessDisabili;
        }


        public function setNecessDisabili($necessDisabili)
        {
            $this->necessDisabili = $necessDisabili;
        }


        public function toArray() {
            return array(
                "cf" => $this->getCf(),
                "nome" => $this->getNome(),
                "cognome" => $this->getCognome(),
                "telefono" => $this->getTelefono(),
                "indirizzo" => $this->getIndirizzo(),
                "mail" => $this->getMail(),
                "tipoUtente" => $this->getTipoUtente(),
                "necessDisabili" => $this->getNecessDisabili(),
                "dataNascita" => $this->getDataNascita(),
                "citta" => $this->getCitta(),
                "provincia" => $this->getProvincia(),
                "regione" => $this->getRegione(),
                "latitudine" => $this->getLatitudine(),
                "longitudine" => $this->getLongitudine()
            );
        }
    }

    $numrighe = mysqli_num_rows($result);
    $utenti = array();
    //echo $numrighe;

for ($i=0;$i<$numrighe;$i++) {

    $riga = mysqli_fetch_assoc($result);
    $utenteTMP = new utente();
    $utenteTMP->setCf($riga["CF"]);
    $utenteTMP->setCitta($riga["Citta"]);
    $utenteTMP->setProvincia($riga["Provincia"]);
    $utenteTMP->setRegione($riga["Regione"]);
    $utenteTMP->setIndirizzo($riga["Indirizzo"]);
    $utenteTMP->setTelefono($riga["telefono"]);
    $utenteTMP->setMail($riga["mail"]);
    $utenteTMP->setDataNascita($riga["DataNascita"]);
    $utenteTMP->setNecessDisabili($riga["AccessoDisabiliNecessario"]);
    $utenteTMP->setNome($riga["Nome"]);
    $utenteTMP->setCognome($riga["Cognome"]);
    $utenteTMP->setTipoUtente($riga["tipoUtente"]);
    $utenteTMP->setLatitudine($riga["latitudine"]);
    $utenteTMP->setLongitudine($riga["longitudine"]);

    $utenti[$i] = $utenteTMP->toArray();

}
    $utentiJSON = json_encode($utenti);
    echo $utentiJSON;

?>
