<?php 
require_once 'libs/tietokantayhteys.php';

class Sessio {
    
    private $id;
    private $lista;
    private $kayttaja;
    private $aloitusaika; 
    private $lopetusaika;
    private $suoritusaika;
    private $virheet = array();
    
    public function __construct($id, $lista, $kayttaja, $aloitusaika, $lopetusaika, $suoritusaika) {
        $this->id = $nro;
        $this->lista = $lista;
        $this->kayttaja = $kayttaja;
        $this->aloitusaika = $aloitusaika;
        $this->lopetusaika = $lopetusaika;
        $this->suoritusaika = $suoritusaika;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLista($lista) {
        $this->lista = $lista;
    }

    public function setKayttaja($kayttaja) {
        $this->kayttaja = $kayttaja;
    }

    public function setAloitusaika($aloitusaika) {
        $this->aloitusaika = $aloitusaika;
    }

    public function setLopetusaika($lopetusaika) {
        $this->lopetusaika = $lopetusaika;
    }
    
    public function setSuoritusaika($suoritusaika) {
        $this->suoritusaika = $suoritusaika;
    }

    
    public function getId() {
        return $this->id;
    }

    public function getLista() {
        return $this->lista;
    }

    public function getKayttaja() {
        return $this->kayttaja;
    }

    public function getAloitusaika() {
        return $this->aloitusaika;
    }

    public function getLopetusaika() {
        return $this->lopetusaika;
    }
    
    public function getSuoritusaika() {
        return $this->suoritusaika;
    }

    
    public function uusiSessio(){
       $sql = "INSERT INTO sqlkyselyt.sessiot (lista, kayttaja, aloitusaika) VALUES(?,?,?) RETURNING id";
       $kysely = getTietokantayhteys()->prepare($sql);

       $ok = $kysely->execute(array($this->getLista(), $this->getKayttaja(), $this->getAloitusaika()));
        
        if ($ok) {
            $this->id = $kysely->fetchColumn();
        } else {
            throw new Exception(pg_last_error($kysely));
        }
        
        return $ok;
        
    }
    
    public static function poistaSessio($sessioid){
       $sql = "DELETE FROM sqlkyselyt.sessiot WHERE id = ?";
       $kysely = getTietokantayhteys()->prepare($sql);

       $ok = $kysely->execute(array($sessioid));
        
        if (!$ok) {
            throw new Exception("joku virhe kyselyssä..");
        }
        
        return $ok;
        
    }
    
    //R1    
//    public static function haeSessiot(){
//        $sql = "SELECT kayttaja, COUNT(*) as onnistuneet from sqlkyselyt.sessiot WHERE tulos = 1";
//        $kysely = getTietokantayhteys()->prepare($sql);
//        $kysely->execute(array($kayttaja));
//        
//        $tulos = $kysely->fetchObject();
//                
//        if ($tulos == null) {
//            return null;
//        } else {            
//            
//        }
//        
//        return $sessio;
//    }
    
    //R2
    public static function haeSessio($sessioid){
        $sql = "SELECT * FROM sqlkyselyt.sessiot WHERE id = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($sessioid));
        
        $tulos = $kysely->fetchObject();
                
        if ($tulos == null) {
            return null;
        } else {      
            $sessio = new Sessio();
            $sessio->setId($tulos->id);
            $sessio->setLista($tulos->lista);
            $sessio->setKayttaja($tulos->kayttaja);
            $sessio->setAloitusaika($tulos->aloitusaika);
            $sessio->setLopetusaika($tulos->lopetusaika);
            $sessio->setSuoritusaika($tulos->suoritusaika);
        }
        
        return $sessio;
    }
    
    //lopetusajan ja suoritusajan tallennus
    public function tallennaLopetusaika(){
       try{
           $sql = "UPDATE sqlkyselyt.sessiot SET lopetusaika = ?, suoritusaika = ? WHERE id = ?";
           $kysely = getTietokantayhteys()->prepare($sql);

           $ok = $kysely->execute(array($this->getLopetusaika(), $this->getSuoritusaika(), $this->getId()));
       } catch (Exception $e) {
           echo 'Joku virhe kyselyssä' .$e->getMessage();
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
    
    
    
    public function onkoKelvollinen() {
        return empty($this->virheet);
    }

    public function getVirheet() {
        return $this->virheet;
    }

    
}  
