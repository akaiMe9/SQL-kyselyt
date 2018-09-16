<?php
require_once 'libs/common.php';
require_once 'libs/models/tehtavalista.php';

if (isset($_SESSION['kayttaja'])) {
    $tehtavalistat = Tehtavalista::haeKaikkiTehtavalistat();
    
    if ($tehtavalistat != null){
        naytaNakyma("valitseTehtavalista", array(
            'tehtavalistat' => $tehtavalistat,
            $_SESSION['tehtavalistat'] = $tehtavalistat
        ));
    } else {
        naytaNakyma("valikko", array(
            $_SESSION['ilmoitus']['tyhja'] = "Yhtään tehtävälistaa ei löytynyt."
        ));
    }

} else {
    naytaNakyma("login", array(
        $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään."
    ));
}
