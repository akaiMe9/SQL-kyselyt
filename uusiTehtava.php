<?php
require_once 'libs/common.php';
require_once 'libs/models/kyselytyyppi.php';
require_once 'libs/models/tehtava.php';

if (isset($_SESSION['kayttaja'])) {
         
    naytaNakyma("uusiTehtavaLomake", array(
        $kyselytyypit = Kyselytyyppi::haeKaikkiKyselytyypit(),
        'kyselytyypit' => $kyselytyypit,
        $_SESSION['kyselytyypit'] = $kyselytyypit,
        'tehtava' => new Tehtava()
        ));
    
} else {
    naytaNakyma("login", array(    
        $_SESSION['ilmoitus'] = "Kirjaudu sisään."
    ));
}