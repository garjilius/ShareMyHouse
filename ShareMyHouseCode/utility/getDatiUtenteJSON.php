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

        /**
         * @return mixed
         */
        public function getCf()
        {
            return $this->cf;
        }

        /**
         * @param mixed $cf
         */
        public function setCf($cf)
        {
            $this->cf = $cf;
        }

        /**
         * @return mixed
         */
        public function getNome()
        {
            return $this->nome;
        }

        /**
         * @param mixed $nome
         */
        public function setNome($nome)
        {
            $this->nome = $nome;
        }

        /**
         * @return mixed
         */
        public function getCognome()
        {
            return $this->cognome;
        }

        /**
         * @param mixed $cognome
         */
        public function setCognome($cognome)
        {
            $this->cognome = $cognome;
        }

        /**
         * @return mixed
         */
        public function getTipoUtente()
        {
            return $this->tipoUtente;
        }

        /**
         * @param mixed $tipoUtente
         */
        public function setTipoUtente($tipoUtente)
        {
            $this->tipoUtente = $tipoUtente;
        }

        /**
         * @return mixed
         */
        public function getDataNascita()
        {
            return $this->dataNascita;
        }

        /**
         * @param mixed $dataNascita
         */
        public function setDataNascita($dataNascita)
        {
            $this->dataNascita = $dataNascita;
        }

        /**
         * @return mixed
         */
        public function getMail()
        {
            return $this->mail;
        }

        /**
         * @param mixed $mail
         */
        public function setMail($mail)
        {
            $this->mail = $mail;
        }

        /**
         * @return mixed
         */
        public function getTelefono()
        {
            return $this->telefono;
        }

        /**
         * @param mixed $telefono
         */
        public function setTelefono($telefono)
        {
            $this->telefono = $telefono;
        }

        /**
         * @return mixed
         */
        public function getRegione()
        {
            return $this->regione;
        }

        /**
         * @param mixed $regione
         */
        public function setRegione($regione)
        {
            $this->regione = $regione;
        }

        /**
         * @return mixed
         */
        public function getProvincia()
        {
            return $this->provincia;
        }

        /**
         * @param mixed $provincia
         */
        public function setProvincia($provincia)
        {
            $this->provincia = $provincia;
        }

        /**
         * @return mixed
         */
        public function getCitta()
        {
            return $this->citta;
        }

        /**
         * @param mixed $citta
         */
        public function setCitta($citta)
        {
            $this->citta = $citta;
        }

        /**
         * @return mixed
         */
        public function getIndirizzo()
        {
            return $this->indirizzo;
        }

        /**
         * @param mixed $indirizzo
         */
        public function setIndirizzo($indirizzo)
        {
            $this->indirizzo = $indirizzo;
        }

        /**
         * @return mixed
         */
        public function getNecessDisabili()
        {
            return $this->necessDisabili;
        }

        /**
         * @param mixed $necessDisabili
         */
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
                "regione" => $this->getRegione()
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



    $utenti[$i] = $utenteTMP->toArray();

}
    //echo $utenti[0]->getNome();
    $utentiJSON = json_encode($utenti);
    echo $utentiJSON;

?>
