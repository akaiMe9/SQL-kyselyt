<?php
require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/tehtavalista.php';

if (isset($_SESSION['kayttaja'])) {
        
    $_SESSION['tehtavat'] = Tehtava::haeKaikkiTehtavat();
    
    if($_SESSION['tehtavat'] != NULL){
        
        naytaNakyma("uusiTehtavalistaLomake", array(    
            'tehtavat' => $_SESSION['tehtavat'],
            'tehtavalista' => new Tehtavalista()
        ));
        
    } else {
        naytaNakyma("valikko_view", array(    
        $_SESSION['ilmoitus'] = "Ei löytynyt yhtään tehtävää" 
    ));
    }
      
} else {
    naytaNakyma("login", array(    
        $_SESSION['ilmoitus'] = "Kirjaudu sisään."
    ));
}



