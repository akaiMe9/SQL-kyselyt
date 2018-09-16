<?php
require_once 'libs/common.php';
require_once 'libs/models/sessio.php';

if (isset($_SESSION['kayttaja'])) {
    $kayttaja = $_SESSION['kayttaja'];
   
    if(isset($_POST['aloita'])){
        
        $lista = ($_POST['tehtavalista']);
        $aloitusaika = date("Y-m-d H:i:s"); 
        $_SESSION['alkuaika'] = $aloitusaika;
        $_SESSION['lista'] = $lista;
        $_SESSION['yritysnro'] = 1;
        $_SESSION['indeksi'] = 0;
        
        try{
            $uusisessio = new Sessio();
            $uusisessio->setLista($lista);
            $uusisessio->setKayttaja($kayttaja);
            $uusisessio->setAloitusaika($aloitusaika);   
            $uusisessio->uusiSessio();
            
            $_SESSION['sessioid'] = $uusisessio->getId();
            $sessioid = $_SESSION['sessioid'];
            
        } catch (Exception $e) {
             echo 'Virhe: Session luonti epäonnistui: ' .$e->getMessage();
        }
        
        header('Location: uusiYritys.php');   
        

} else {
        naytaNakyma("login", array(
           $_SESSION['ilmoitus'] = "Kirjaudu sisään." 
        ));
    }
 
  
  
}




