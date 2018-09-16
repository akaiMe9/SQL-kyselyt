<?php
require_once 'libs/common.php';

if (isset($_SESSION['kayttaja'])) {
    
    naytaNakyma("raporttivalikko_view", array());
   
} else {
        naytaNakyma("login", array(
           $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään." 
        ));
      

}


