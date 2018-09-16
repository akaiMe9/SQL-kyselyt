<?php

require_once 'libs/tietokantayhteys.php';

class Sisaltaa {
    private $lista;
    private $tehtava;
    
    public function __construct($lista, $tehtava) {
        $this->lista = $lista;
        $this->tehtava = $tehtava;
    }
    
    public function setLista($lista) {
        $this->lista = $lista;
    }

    public function setTehtava($tehtava) {
        $this->tehtava = $tehtava;
    }

    public function getLista() {
        return $this->lista;
    }

    public function getTehtava() {
        return $this->tehtava;
    }

    public function tallennaTehtavalistalle(){
        $sql = "INSERT INTO sqlkyselyt.sisaltaa (lista, tehtava) VALUES (?, ?)";
        $kysely = getTietokantayhteys()->prepare($sql);

        $ok = $kysely->execute(array($this->getLista(), $this->getTehtava()));
                
        return $ok; 
    }
       
    public static function haeTehtavatListalta($lista){
        $sql = "SELECT tehtava FROM sqlkyselyt.sisaltaa WHERE lista = ?";
        $kysely = getTietokantayhteys()->prepare($sql);
        
        if($kysely->execute(array($lista))){
            
            $tulokset = array();
        
            foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos){
                $tulos->tehtava;
            
                $tulokset[] = $tulos;   
            }
            
            return $tulokset;
        } else {
            throw new Exception;
        }
  
    }
}



