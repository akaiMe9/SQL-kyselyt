<?php
require_once 'libs/common.php';
require_once 'libs/models/tehtavalista.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/sisaltaa.php';

if (isset($_SESSION['kayttaja'])) {
        
    $tehtavat = Tehtava::haeKaikkiTehtavat();
     
    $kuvaus = (filter_input(INPUT_POST, "kuvaus"));
    $luontipvm = date("Y-m-d H:i:s");   
    $luoja = $_SESSION['kayttaja'];
    
    if (isset($_POST['tallenna'])) {
        
        $uusitehtavalista = new Tehtavalista();
        $uusitehtavalista->setKuvaus($kuvaus);
        $uusitehtavalista->setLuontipvm($luontipvm);
        $uusitehtavalista->setLuoja($luoja);
             
        if ($uusitehtavalista->onkoKelvollinen()) {
            
            $query = $uusitehtavalista->lisaaTehtavalista();
            
            if(!empty($_POST['tehtavat'])){ // yhtään tehtävää ei valittu
                
                foreach($_POST['tehtavat'] as $tehtava){
                    $uusisisaltaa = new Sisaltaa();
                    $uusisisaltaa->setLista($uusitehtavalista->getId());
                    $uusisisaltaa->setTehtava($tehtava);
                    
                    $query .= $uusisisaltaa->tallennaTehtavalistalle();
                }
                
                $uusitehtavalista->setTehtavien_lkm(count($_POST['tehtavat']));
      
            } else {
            
                naytaNakyma("uusiTehtavalistaLomake", array(
                    $_SESSION['virheet']['tehtava'] = "Valitse vähintään yksi tehtävä.",
                    'kuvaus' => $kuvaus,
                    'tehtavat' => $tehtavat
                ));
            }
            
            $uusitehtavalista->setId($uusitehtavalista->getId());
            
            $query .= $uusitehtavalista->tallennaTehtavien_lkm();
            
            naytaNakyma("valikko_view", array(
                $_SESSION['ilmoitus']['ok'] = "Tehtävälista lisätty.",
                'tehtavat' => $tehtavat
            ));
            
        } else {
            naytaNakyma("uusiTehtavalistaLomake", array(
                $_SESSION['virheet'] = $uusitehtavalista->getVirheet(),
                'tehtavat' => $tehtavat
               ));
        }
        
        Tehtavalista::suoritaTapahtumat($query);
        
        
        
    } else {
        naytaNakyma("login", array(
            $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään."
        ));
        
    }
}





