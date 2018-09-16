<?php
require_once 'libs/common.php';
require_once 'libs/models/kayttaja.php';

if (isset($_POST['kirjaudu'])){
    
    if (empty($_POST['kayttajatunnus'])) {
        naytaNakyma("login", array(
            $_SESSION['virheet']['kayttajatunnus'] = "Et antanut käyttäjätunnusta." 
        ));
    }

    $kayttaja = filter_input(INPUT_POST, "kayttajatunnus");

    if (empty($_POST['salasana'])) {
        naytaNakyma("login", array(
            'kayttaja' => $kayttaja,
            $_SESSION['virheet']['salasana'] = "Et antanut salasanaa."
        ));
    }

    $salasana = filter_input(INPUT_POST, "salasana");

    $kirjautunutKayttaja = Kayttaja::etsiKayttajaTunnuksilla($kayttaja, $salasana);

    if ($kirjautunutKayttaja != null) {
        $_SESSION['kayttaja'] = $kirjautunutKayttaja->getId();

        header('Location: valikko.php');    

    } else {
        naytaNakyma("login", array(
            'kayttaja' => $kayttaja,
            $_SESSION['virheet']['vaarat'] = "Antamasi tunnus tai salasana on väärä.", 
        ));
    }

} else {
    naytaNakyma("login");
}


