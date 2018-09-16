<?php
require_once 'libs/common.php';
require_once 'libs/models/sessio.php';
require_once 'libs/models/yritys.php';


if (isset($_SESSION['kayttaja'])) {
    $sessioid = $_SESSION['sessioid'];
    $aloitusaika = $_SESSION['alkuaika'];
    $lopetusaika = date("Y-m-d H:i:s");
    $_SESSION['lopetusaika'] = $lopetusaika;
    
    
    try{
        $sessio = Sessio::haeSessio($sessioid);
            
    } catch (Exception $e) {
        echo 'jotain meni mönkään' .$e.getMessage();
    }
    
    // suoritusajan näyttäminen
    $datetime1 = date_create($aloitusaika);
    $datetime2 = date_create($lopetusaika);
    $suoritusaika_nayta = date_diff($datetime1, $datetime2);
    
    // suoritusaika sekuntteina
    $alku  = strtotime($aloitusaika);
    $loppu = strtotime($lopetusaika);
    $suoritusaika = $loppu - $alku;

    $sessio->setSuoritusaika($suoritusaika);
    $sessio->setLopetusaika($lopetusaika); 
    
    try{
        $sessio->tallennaLopetusaika();
    } catch (Exception $e) {
        echo 'Virhe: ' .$e->getMessage();
    }
       
    $_SESSION['suoritusaika'] = $suoritusaika_nayta->format('%h tuntia %i minuuttia %s sekuntia' );
       
    naytaNakyma("lopputulokset_view", array());
    

} else {
    naytaNakyma("login", array(
       $_SESSION['ilmoitus'] = "Kirjaudu sisään." 
    ));
}







