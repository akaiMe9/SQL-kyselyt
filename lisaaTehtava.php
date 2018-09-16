<?php
require_once 'libs/common.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/kyselytyyppi.php';

if (isset($_SESSION['kayttaja'])) {
        
    if (isset($_POST['tallenna'])) {
        
        $kuvaus = (filter_input(INPUT_POST, "kuvaus"));
        $ratkaisu = (filter_input(INPUT_POST, "ratkaisu"));
        $luontipvm = date("Y-m-d H:i:s");   
        $luoja = $_SESSION['kayttaja'];
        
        if(!empty($_POST['kyselytyypit'])){
                                  
            foreach($_POST['kyselytyypit'] as $tyyppi){
                $kyselytyyppi = $tyyppi;
            }
        }
        
        $uusitehtava = new Tehtava();
        $uusitehtava->setKuvaus($kuvaus);
        $uusitehtava->setRatkaisu($ratkaisu);
        $uusitehtava->setKyselytyyppi($kyselytyyppi);        
        $uusitehtava->setLuontipvm($luontipvm);
        $uusitehtava->setLuoja($luoja);
             
        if ($uusitehtava->onkoKelvollinen()) {
            
            $uusitehtava->lisaaTehtavaKantaan();
            
            naytaNakyma("valikko_view", array(
                $_SESSION['ilmoitus']['onni'] = "Tehtävä lisätty!",
            ));
        } else {
            
            naytaNakyma("uusiTehtavaLomake", array(
               'tehtava' => $uusitehtava,
               'kuvaus' => $kuvaus,
               'ratkaisu' => $ratkaisu,
               'kyselytyypit' => Kyselytyyppi::haeKaikkiKyselytyypit(),
               
               $_SESSION['virheet'] = $uusitehtava->getVirheet()
               ));
        }
    }
    
} else {
    naytaNakyma("login", array(
        $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään."));
}





