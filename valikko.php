<?php
 
    require_once 'libs/common.php';
    
        
    if (isset($_SESSION['kayttaja'])) {
            
        naytaNakyma("valikko_view");
        
    } else {
        naytaNakyma("login", array(
           $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään." 
        ));
    }
  