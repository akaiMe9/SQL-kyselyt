<?php

require_once 'libs/tietokantayhteys.php';

class Kayttaja {
  
  private $id;
  private $tunnus;
  private $salasana;
  private $nimi;
  private $oikeusryhma;
  
  public function __construct($id, $tunnus, $salasana, $nimi, $oikeusryhma) {
    $this->id = $id;
    $this->tunnus = $tunnus;
    $this->salasana = $salasana;
    $this->nimi = $nimi;
    $this->oikeusryhma = $oikeusryhma;
  }
  
  public function setId($id) {
      $this->id = $id;
  }

  public function setTunnus($tunnus) {
      $this->tunnus = $tunnus;
  }

  public function setSalasana($salasana) {
      $this->salasana = $salasana;
  }

  public function setNimi($nimi) {
      $this->nimi = $nimi;
  }

  public function setOikeusryhma($oikeusryhma) {
      $this->oikeusryhma = $oikeusryhma;
  }

  public function getId() {
      return $this->id;
  }

  public function getTunnus() {
      return $this->tunnus;
  }

  public function getSalasana() {
      return $this->salasana;
  }

  public function getNimi() {
      return $this->nimi;
  }

  public function getOikeusryhma() {
      return $this->oikeusryhma;
  }  
  
    public static function etsiKayttajaTunnuksilla($tunnus, $salasana) {
        $sql = "SELECT id, tunnus, salasana, nimi, oikeusryhma from sqlkyselyt.kayttajat where tunnus = ? AND salasana = ? LIMIT 1";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute(array($tunnus, $salasana));

        $tulos = $kysely->fetchObject();
    
        if ($tulos == null) {
           return null;
        } else {
          $kayttaja = new Kayttaja(); 
          $kayttaja->setId($tulos->id);
          $kayttaja->setTunnus($tulos->tunnus);
          $kayttaja->setSalasana($tulos->salasana);
          $kayttaja->setNimi($tulos->nimi);
          $kayttaja->setOikeusryhma($tulos->oikeusryhma);
      
        }
    
        return $kayttaja;
    }
  
    public static function etsiKaikkiKayttajat() {
        $sql = "SELECT id, tunnus, salasana, nimi, oikeusryhma FROM sqlkyselyt.kayttajat";
        $kysely = getTietokantayhteys()->prepare($sql); 
        $kysely->execute();
    
        $tulokset = array();
  
        foreach($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $kayttaja = new Kayttaja();
            $kayttaja->setId($tulos->id);
            $kayttaja->setTunnus($tulos->tunnus);
            $kayttaja->setSalasana($tulos->salasana);
            $kayttaja->setNimi($tulos->nimi);
            $kayttaja->setOikeusryhma($tulos->oikeusryhma);

        $tulokset[] = $kayttaja;
    }
    return $tulokset;
    }

}

