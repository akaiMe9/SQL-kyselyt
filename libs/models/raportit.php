<?php
require_once 'libs/tietokantayhteys.php';

class Raportit{
    
    //R1: Raportti, joka näyttää yksittäisen session tiedot
    public static function onnistuneet_lkm() {
        $sql = "SELECT * FROM sqlkyselyt.onnistuneet_lkm";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
        $tulokset = array();
        
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos){
            $tulos->sessio;
            $tulos->kayttaja;
            $tulos->onnistuneet_lkm;
                                    
            $tulokset[] = $tulos;   
        }
        
        return $tulokset;
    }
    
    //R2: Raportti, joka näyttää yksittäisen tehtävälistan sessioiden yhteenvetotietoja
    public static function lista_suoritusajat() {
        $sql = "SELECT * FROM sqlkyselyt.lista_suoritusajat";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();
        
        $tulokset = array();
        
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos){
            $tulos->lista;
            $tulos->min;
            $tulos->max;
            $tulos->keskiarvo;
                                    
            $tulokset[] = $tulos;   
        }
        
        return $tulokset;
    }
  
}


