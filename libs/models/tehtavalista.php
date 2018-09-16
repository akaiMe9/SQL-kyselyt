<?php

require_once 'libs/tietokantayhteys.php';

class Tehtavalista {
    private $id;
    private $kuvaus;
    private $luontipvm;
    private $luoja;
    private $tehtavien_lkm;
    private $virheet = array();
    
    public function __construct($id, $kuvaus, $luontipvm, $luoja, $tehtavien_lkm) {
        $this->id = $id;
        $this->kuvaus = $kuvaus;
        $this->luontipvm = $luontipvm;
        $this->luoja = $luoja;
        $this->luoja = $tehtavien_lkm;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setKuvaus($kuvaus) {
        $this->kuvaus = $kuvaus;
        
         if (trim($this->kuvaus) == '') {
            $this->virheet['kuvaus'] = "Kuvaus ei saa olla tyhjä.";
        } else { 
            unset($this->virheet['kuvaus']);
        }
    }
    
    public function setLuontipvm($luontipvm) {
        $this->luontipvm = $luontipvm;
    }

    public function setLuoja($luoja) {
        $this->luoja = $luoja;
    }
    
    public function setTehtavien_lkm($tehtavien_lkm) {
        $this->tehtavien_lkm = $tehtavien_lkm;
    }

        
    public function getId() {
        return $this->id;
    }

    public function getKuvaus() {
        return $this->kuvaus;
        
    }

    public function getLuontipvm() {
        return $this->luontipvm;
    }

    public function getLuoja() {
        return $this->luoja;
    }
    
    public function getTehtavien_lkm() {
        return $this->tehtavien_lkm;
    }
 
    public static function haeTehtavalista($id){
        $sql = "SELECT * from sqlkyselyt.tehtavalistat WHERE id = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
         
        $tulos = $kysely->execute(array($this->$id));
        
        if ($tulos == null) {
           return null;
        } else {
          $tehtavalista = new Tehtavalista(); 
          $tehtavalista->setId($tulos->id);
          $tehtavalista->setKuvaus($tulos->kuvaus);
          $tehtavalista->setLuontiPvm($tulos->luontipvm);
          $tehtavalista->setLuoja($tulos->luoja);
          $tehtavalista->setTehtavien_lkm($tulos->tehtavien_lkm);
        }
    
        return $tehtavalista;
    }
    
    public static function haeKaikkiTehtavalistat(){
        $sql = "SELECT * FROM sqlkyselyt.tehtavalistat";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
         
        $tulokset = array();
  
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tehtavalista = new Tehtavalista();
            $tehtavalista->setId($tulos->id);
            $tehtavalista->setKuvaus($tulos->kuvaus);
            $tehtavalista->setLuontipvm($tulos->luontipvm);
            $tehtavalista->setLuoja($tulos->luoja);
            $tehtavalista->setTehtavien_lkm($tulos->tehtavien_lkm);
            
        $tulokset[] = $tehtavalista;
        
        }
    
        return $tulokset;
    }
    
    public function lisaaTehtavalista() {
        $sql = "INSERT INTO sqlkyselyt.tehtavalistat (kuvaus, luoja, luontipvm, tehtavien_lkm) VALUES(?,?,?,?)RETURNING id";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getKuvaus(), $this->getLuoja(), $this->getLuontipvm(), $this->getTehtavien_lkm()));
    
        if ($ok) {
            $this->id = $kysely->fetchColumn();
            $_SESSION['ilmoitus'] = pg_last_notice($kysely);
        } else {
            $this->virheet['kuvaus'] = pg_last_error($kysely);
        }

        return $ok;
    }
    
      public function tallennaTehtavien_lkm(){
       
      try{
        $sql = "UPDATE sqlkyselyt.tehtavalistat SET tehtavien_lkm = ? WHERE id = ?";
        $kysely = getTietokantayhteys()->prepare($sql);

       $ok = $kysely->execute(array($this->getTehtavien_lkm(), $this->getId()));
       } catch (Exception $e) {
           echo 'Joku virhe kyselyssä' .$e->getMessage();
       }       
        return $ok;
        
    }
    
    public function suoritaTapahtumat($query){
              
      try{
        $kysely = getTietokantayhteys()->prepare($query);

       $ok = $kysely->execute(array($query));
       } catch (Exception $e) {
           echo 'Joku virhe kyselyssä' .$e->getMessage();
       }       
        return $ok;
    }
    
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    public function getVirheet() {
        return $this->virheet;
    }
}


