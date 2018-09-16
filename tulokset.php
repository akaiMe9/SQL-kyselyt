<?php 
require_once 'libs/common.php';

if (isset($_SESSION['kayttaja'])) {

    // uusi yritys
    if(isset($_POST['uusiyritys'])){
        $_SESSION['yritysnro']++;
        header('Location: uusiYritys.php');

    }

    // seuraava tehtävä
    if(isset($_POST['seuraava'])){
        $_SESSION['indeksi']++;

        // jos listalla vielä tehtäviä jäljellä
        if ($_SESSION['indeksi'] < $_SESSION['tehtavienlkm']){
            $_SESSION['yritysnro'] = 1;

            header('Location: uusiYritys.php');  
        } else {
            header('Location: lopputulokset.php');  
        }

    }

    
} else {
    naytaNakyma("login", array(
        $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään."));
}




