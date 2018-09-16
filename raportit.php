<?php
require_once 'libs/common.php';
require_once 'libs/models/raportit.php';

if (isset($_SESSION['kayttaja'])) {
    
    if(isset($_POST['r1'])){
    
        try{
            $tulokset = Raportit::onnistuneet_lkm();
            $otsikko = "Onnistuneiden määrä";
        } catch (Exception $e){
            echo 'Virhe: raporttia ei löytynyt ' .$e.getMessage();
        }
    
    }
    
    if(isset($_POST['r2'])){
        
        try{
            $tulokset = Raportit::lista_suoritusajat();
            $otsikko = "Listojen suoritusajat (sekuntia)";
                       
        } catch (Exception $e){
        echo 'Virhe: raporttia ei löytynyt ' .$e.getMessage();
        }
    
    }
   
    naytaNakyma("raportti_view", array(
        'tulokset' => $tulokset,
        'otsikko' => $otsikko
    ));
    
    
} else {
        naytaNakyma("login", array(
           $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään." 
        ));
      

}

  



