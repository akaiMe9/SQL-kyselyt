<?php

require_once 'libs/tietokantayhteys.php';

class Tehtava {
    private $id;
    private $kyselytyyppi;
    private $kuvaus;
    private $luoja;
    private $ratkaisu;
    private $luontipvm;
    private $virheet = array();
    
    public function __construct($id, $kyselytyyppi, $kuvaus, $luoja, $ratkaisu, $luontipvm) {
        $this->id = $id;
        $this->kyselytyyppi = $kyselytyyppi;
        $this->kuvaus = $kuvaus;
        $this->luoja = $luoja;
        $this->ratkaisu = $ratkaisu;
        $this->luontipvm = $luontipvm;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setKyselytyyppi($uusityyppi) {
        $this->kyselytyyppi = $uusityyppi;
    }
    
    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
        
        if (trim($this->kuvaus) == '') {
            $this->virheet['kuvaus'] = "Kuvaus ei saa olla tyhjä.";
        } else { 
            unset($this->virheet['kuvaus']);
        }
    }

    public function setRatkaisu($ratkaisu) {
        $this->ratkaisu = $ratkaisu;
        
        if (trim($this->ratkaisu) == '') {
            $this->virheet['ratkaisu'] = "Ratkaisu ei saa olla tyhjä.";
        } else { 
            unset($this->virheet['ratkaisu']);
        }
    }

    public function setLuoja($luoja) {
        $this->luoja = $luoja;
    }
    
    public function setLuontipvm($luontipvm) {
        $this->luontipvm = $luontipvm;
    }

    public function getId() {
        return $this->id;
    }

    
    public function getKyselytyyppi() {
        return $this->kyselytyyppi;
    }

    public function getKuvaus() {
        return $this->kuvaus;
    }

    public function getRatkaisu() {
        return $this->ratkaisu;
    }

    public function getLuoja() {
        return $this->luoja;
        
    }
    
    public function getLuontipvm() {
        return $this->luontipvm;
    }

        
    public static function haeTehtava($id){
        $sql = "SELECT * FROM sqlkyselyt.tehtavat WHERE id = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute(array($id));
        
        if($ok){
            $tulos = $kysely->fetchObject();
                
            if ($tulos == null) {
                return null;
            } else {            
                $tehtava = new Tehtava();
                $tehtava->setId($tulos->id);
                $tehtava->setKyselytyyppi($tulos->kyselytyyppi);
                $tehtava->setRatkaisu($tulos->ratkaisu);
                $tehtava->setKuvaus($tulos->kuvaus);
                $tehtava->setLuoja($tulos->luoja);
                $tehtava->setLuontipvm($tulos->luontipvm);
            }
        
            return $tehtava;
            
        } else {
            throw new Exception("\nPDO::errorInfo():\n");
        }
    }
    
    
    public static function haeKaikkiTehtavat(){
        $sql = "SELECT * FROM sqlkyselyt.tehtavat";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
        $tulokset = array();
        
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos){
            $tehtava = new Tehtava();
            $tehtava->setId($tulos->id);
            $tehtava->setKyselytyyppi($tulos->kyselytyyppi);
            $tehtava->setRatkaisu($tulos->ratkaisu);
            $tehtava->setKuvaus($tulos->kuvaus);
            $tehtava->setLuoja($tulos->luoja);
            $tehtava->setLuontipvm($tulos->luontipvm);
                        
            $tulokset[] = $tehtava;   
        }
        
        return $tulokset;
  
    }
    

    public function lisaaTehtavaKantaan() {
        $sql = "INSERT INTO sqlkyselyt.tehtavat ( kuvaus, ratkaisu, luoja, luontipvm, kyselytyyppi) VALUES(?,?,?,?,?) RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getKuvaus(), $this->getRatkaisu(), $this->getLuoja(), $this->getLuontipvm(),$this->getKyselytyyppi()));
        if ($ok) {
          //Haetaan RETURNING-määreen palauttama numero.
          $this->id = $kysely->fetchColumn();
        } else {
          $this->virheet['kysely'] = "Error occurred: ".implode(":",$this->pdo->errorInfo());
        }
        
        return $ok;
    }
    
    public function poistaKannasta($nro){
        $sql = "DELETE FROM sqlkyselyt.tehtavat WHERE id = ?";
        $kysely = getTietokantayhteys() ->prepare($sql);
        
        $kysely->execute(array($nro));
        
        return $ok;
       
    }

    public function onkoKelvollinen() {
        return empty($this->virheet);
    }
    
    /* Palauttaa virhelistan */
    public function getVirheet() {
        return $this->virheet;
    }
}

