<?php

require_once 'libs/tietokantayhteys.php';

class Yritys {
    
    private $sessio;
    private $tehtava;
    private $yritysnro;
    private $vastaus;
    private $tulos;
    private $alkuaika;
    private $loppuaika;
    private $virheet = array();

    public function __construct($sessio, $tehtava, $yritysnro, $vastaus, $tulos, $alkuaika, $loppuaika) {
        $this->sessio = $sessio;
        $this->tehtava = $tehtava;
        $this->yritysnro = $yritysnro;
        $this->vastaus = $vastaus;
        $this->tulos = $tulos;
        $this->alkuaika = $alkuaika;
        $this->loppuaika = $loppuaika;
    }
    
    public function setSessio($sessio) {
        $this->sessio = $sessio;
    }

    public function setTehtava($tehtava) {
        $this->tehtava = $tehtava;
    }

    public function setYritysnro($yritysnro) {
        $this->yritysnro = $yritysnro;
    }

    public function setVastaus($vastaus) {
        $this->vastaus = $vastaus;
        
        // tyhjä vastauskenttä
        if($this->vastaus == ''){
            $this->virheet['tyhja'] = "Vastaus ei saa olla tyhjä.";
        } else {
            unset($this->virheet['tyhja']); 
        }  
        
        // sulkujen määrän tarkastus
        $sulut1 = intval(substr_count($this->vastaus,'('));
        $sulut2 = intval(substr_count($this->vastaus,')'));
                   
        if ($sulut1 !== $sulut2){
            $this->virheet['sulut'] = "Sulkuja tulee olla parillinen määrä.";
        } else {
            unset($this->virheet['sulut']);
        }
        
        // puolipisteen tarkastus
        if (substr($this->vastaus, -1) !== ';'){
            $this->virheet['puolipiste'] = "Kyselyn täytyy päättyä puolipisteeseen.";
        } else {
            $this->vastaus = substr($vastaus, 0, -1);
            unset($this->virheet['puolipiste']);
        }
        
        
    }     
        
    public function setTulos($tulos) {
        // jos tulos oikein: 1
        // jos väärin: 2
        $this->tulos = $tulos;
    }

    public function setAlkuaika($alkuaika) {
        $this->alkuaika = $alkuaika;
    }

    public function setLoppuaika($loppuaika) {
        $this->loppuaika = $loppuaika;
    }
      
    public function getSessio() {
        return $this->sessio;
    }

    public function getTehtava() {
        return $this->tehtava;
    }

    public function getYritysnro() {
        return $this->yritysnro;
    }

    public function getVastaus() {
        return $this->vastaus;
    }

    public function getTulos() {
        return $this->tulos;
    }

    public function getAlkuaika() {
        return $this->alkuaika;
    }

    public function getLoppuaika() {
        return $this->loppuaika;
    }
     
    public function tallennaUusiYritys(){
       $sql = "INSERT INTO sqlkyselyt.yritykset (sessio, tehtava, yritysnro, alkuaika) VALUES(?,?,?,?)";
       $kysely = getTietokantayhteys()->prepare($sql);

       $ok = $kysely->execute(array($this->getSessio(), $this->getTehtava(), $this->getYritysnro(), $this->getAlkuaika()));
        
        if (!$ok) {
            throw new Exception("joku virhe kyselyssä..");
        }
        
        return $ok;
        
    }
    
    public function tallennaMuokkaukset(){
       try{
        $sql = "UPDATE sqlkyselyt.yritykset SET vastaus = ?, loppuaika = ? WHERE sessio = ? AND tehtava = ? AND yritysnro = ?";
       $kysely = getTietokantayhteys()->prepare($sql);

       $ok = $kysely->execute(array($this->getVastaus(), $this->getLoppuaika(), $this->getSessio(), $this->getTehtava(), $this->getYritysnro()));
       } catch (Exception $e) {
           echo 'Joku virhe kyselyssä' .$e->getMessage();
       }       
        return $ok;
        
    }
    
    public function tallennaTulos(){
       try{
        $sql = "UPDATE sqlkyselyt.yritykset SET tulos = ? WHERE sessio = ? AND tehtava = ? AND yritysnro = ?";
       $kysely = getTietokantayhteys()->prepare($sql);

       $ok = $kysely->execute(array($this->getTulos(), $this->getSessio(), $this->getTehtava(), $this->getYritysnro()));
       } catch (Exception $e) {
           echo 'Joku virhe kyselyssä' .$e->getMessage();
       }       
        return $ok;
        
    }
    

    public static function haeYritys($sessio, $tehtava, $yritys){
        $sql = "SELECT * FROM sqlkyselyt.yritykset WHERE sessio = ? AND tehtava = ? AND yritysnro = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sessio, $tehtava, $yritys));
        
        $tulos = $kysely->fetchObject();
        
            if ($tulos == null) {
               return null;
            } else {
              $yritys = new Yritys(); 
              $yritys->setSessio($tulos->sessio);
              $yritys->setTehtava($tulos->tehtava);
              $yritys->setYritysnro($tulos->yritysnro);
              $yritys->setVastaus($tulos->vastaus);
              $yritys->setTulos($tulos->tulos);
              $yritys->setAlkuaika($tulos->alkuaika);
              $yritys->setLoppuaika($tulos->loppuaika);
            }
        
        return $yritys;
        
    }
    
    public static function poistaYritys($sessio, $tehtava, $yritysnro){
       $sql = "DELETE FROM sqlkyselyt.yritykset WHERE sessio = ? AND tehtava = ? and yritysnro = ?";
       $kysely = getTietokantayhteys()->prepare($sql);

       $ok = $kysely->execute(array($sessio, $tehtava, $yritysnro));
        
        if (!$ok) {
            throw new Exception("joku virhe kyselyssä..");
        }
        
        return $ok;
        
    }
    
    //select
    public static function suoritaKyselySelect($vastaus){
        $sql = "$vastaus";
        $kysely = getTietokantayhteys()->prepare($sql);

        if($kysely->execute()){
            $tulokset = array();
            
            foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos){
                $tulos;
                $tulokset[] = $tulos;   
            }
        } else {
            throw new Exception("Joku virhe tuli nyt.");
        }
        
        return $tulokset;  
    }
    
    public static function suoritaKysely($vastaus){
        $sql = "$vastaus";
        $kysely = getTietokantayhteys()->prepare($sql);
        $ok = $kysely->execute();

        if(!$ok){
            throw new Exception("\nPDO::errorInfo():\n");
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

