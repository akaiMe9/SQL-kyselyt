<?php

function getTietokantayhteys() {
  
  static $yhteys = null; 
  $tunnus = "km424941";
  $salasana= "Kantt4r3lliSQL";
  
  if ($yhteys == null) { 
    $yhteys = new PDO("pgsql:host=dbstud2.sis.uta.fi;port=5432;dbname=$tunnus", $tunnus, $salasana);
    $yhteys->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }

  return $yhteys;
}

