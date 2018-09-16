<?php

require_once 'libs/tietokantayhteys.php';

class Kyselytyyppi{
    private $id;
    private $tyyppi;
    
    public function __construct($id, $tyyppi) {
        $this->id = $id;
        $this->tyyppi = $tyyppi;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setTyyppi($tyyppi) {
        $this->tyyppi = $tyyppi;
    }

    public function getId() {
        return $this->id;
    }

    public function getTyyppi() {
        return $this->tyyppi;
    }

    public static function haeKaikkiKyselytyypit(){
        $sql = "SELECT * FROM sqlkyselyt.kyselytyypit";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
        $tulokset = array();
        
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos){
            $kyselytyyppi = new Kyselytyyppi();
            $kyselytyyppi->setId($tulos->id);
            $kyselytyyppi->setTyyppi($tulos->tyyppi);
                        
            $tulokset[] = $kyselytyyppi;   
        }
        
        return $tulokset;
  
    }
    
    
    
}

