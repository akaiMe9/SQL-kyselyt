<?php
  require_once 'libs/common.php';
  require_once 'libs/models/tehtava.php';
  require_once 'libs/models/yritys.php';
  require_once 'libs/models/sessio.php';
   
  if (isset($_SESSION['kayttaja'])) {
      
    $sessioid = $_SESSION['sessioid'];
    $yritysnro = $_SESSION['yritysnro'];
    $tehtavanro = $_SESSION['tehtavanro'];
    $tehtava = Tehtava::haeTehtava($tehtavanro);
    $kyselytyyppi = $tehtava->getKyselytyyppi();
    $oikearatkaisu = $tehtava->getRatkaisu();
    $ratkaisu = substr($oikearatkaisu, 0, -1);
    
    $_SESSION['kyselytyyppi'] = $kyselytyyppi;
        
    
    if(isset($_POST['tarkasta'])){
        
        // hae muokattava yritys
        $yritysnro = $_SESSION['yritysnro'];
        
        try{
            $yritys = Yritys::haeYritys($sessioid, $tehtavanro, $yritysnro);
        } catch (Exception $e) {
            echo 'Virhe: ' .$e->getMessage();
        }
        
        //ota vastaan käyttäjän vastaus     
        $vastaus = trim(filter_input(INPUT_POST, "vastaus"));
        $yritys->setVastaus($vastaus);
        
        // testaa vastauksen kelvollisuus
        if($yritys->onkoKelvollinen()){
            
            $loppuaika = date("Y-m-d H:i:s");
            $yritys->setLoppuaika($loppuaika);
            
            // tallenna vastaus ja loppuaika yritykselle
            try{
                $yritys->tallennaMuokkaukset();
            } catch (Exception $e) {
                echo 'Virhe: Muutosten tallennus epäonnistui: ' .$e->getMessage();
            }  
        } else {
            $_SESSION['virheet'] = $yritys->getVirheet();
                        
            naytaNakyma("suoritaTehtava_view", array(
                $_SESSION['tehtavat'] => $tehtavat,
                $_SESSION['tehtava'] => $tehtava,
                'tehtavat' => $tehtavat,
                'tehtava' => $tehtava,
                
            ));
        }  
        
        //hae muokattu vastaus (puolipiste poistettu)
        $uusivastaus = $yritys->getVastaus();
        
        
        //suorita kysely vastauksella
        if ($kyselytyyppi === 1) { //jos tehtävän tyyppi on select
            
            // testataan, että kyselyn ensimmäinen sana on select
            $testivastaus = strtolower(strtok($uusivastaus, " "));
                        
            if($testivastaus === "select"){
                try{
                    $tulokset = Yritys::suoritaKyselySelect($uusivastaus);
                } catch (Exception $e) { // syntaksivirheet
                    $yritys->setTulos(2);
                    $yritys->tallennaTulos();
                    $tulos = "väärin!";

                    $virheilmoitus = $e->getMessage();
                    $_SESSION['error'] = "Kyselyn suoritus epäonnistui! Virhe: $virheilmoitus";
                } 
            } else {
                $_SESSION['virheet']['kyselytyyppi'] = "Vinkki: vastauksen tulee alkaa sanalla select";
                
                naytaNakyma("suoritaTehtava_view", array(
                    $_SESSION['tehtavat'] => $tehtavat,
                    $_SESSION['tehtava'] => $tehtava,
                    'tehtavat' => $tehtavat,
                    'tehtava' => $tehtava
                ));
                
            }
        } else {
            try{
                //Yritys::suoritaKysely($uusivastaus); 
                
                $uusivastaustiivis = str_replace(' ', '', $uusivastaus);
                $ratkaisutiivis = str_replace(' ', '', $ratkaisu);
                
                // jos vastaus sama kuin oikea ratkaisu
                if(strtolower($uusivastaustiivis) == strtolower($ratkaisutiivis)){
                    
                    try{
                        Yritys::suoritaKysely($uusivastaus);
                        
                        $yritys->setTulos(1);
                        $yritys->tallennaTulos();
                        $tulos = "oikein!"; 
                        
                    } catch (Exception $ex) {
                        $virheilmoitus = $e->getMessage();
                        $_SESSION['error'] = "Kyselyn suoritus epäonnistui! Virhe: $virheilmoitus";
                        
                        $yritys->setTulos(2);
                        $yritys->tallennaTulos();
                        $tulos = "väärin!";
                    }
                              
                } else {
                    $yritys->setTulos(2);
                    $yritys->tallennaTulos();
                    $tulos = "väärin!"; 
                    
                    // Jos viimeinenkin yritys epäonnistui, suoritetaan oikea ratkaisu
                    if($_SESSION['yritysnro'] == 3){
                        Yritys::suoritaKysely($ratkaisu);
                    }
                }
                
            } catch (Exception $e) {
                $yritys->setTulos(2);
                $yritys->tallennaTulos();
                $tulos = "väärin!"; 
                
                $virheilmoitus = $e->getMessage();
                $_SESSION['error'] = "Kyselyn suoritus epäonnistui! Virhe: $virheilmoitus";
            }
            
            naytaNakyma("tulokset", array(
                'tulos' => $tulos,
                'tulokset' => $tulokset,
                'oikeatulos' =>$oikeatulos,
                'ratkaisu' => $oikearatkaisu
            ));
           
        }
        
        //hae tehtävän oikea ratkaisu
        if ($kyselytyyppi === 1) { //jos tehtävän tyyppi on select
            try{
                $oikeatulos = Yritys::suoritaKyselySelect($ratkaisu);
                
            } catch (Exception $e){
                echo 'Oikean ratkaisun haku epännistui' .$e.getMessage;
                
            }
        }
            
        //vertaa vastausta oikeaan ratkaisuun
        if ($kyselytyyppi === 1){
            if($tulokset == $oikeatulos){
                try{
                    $yritys->setTulos(1);
                    $yritys->tallennaTulos();
                    
                    $tulos = "oikein!";

                } catch (Exception $e){
                    echo 'Virhe: Tuloksen tallentaminen epäonnistui: ' .$e->getMessage();
                }
            } else {
                try{
                    $yritys->setTulos(2);
                    $yritys->tallennaTulos();
                    
                    $tulos = "väärin!";
                } catch (Exception $e){
                    echo 'Virhe: Tuloksen tallentaminen epäonnistui: ' .$e->getMessage();
                }
            }
        
            naytaNakyma("tulokset", array(
                'tulos' => $tulos,
                'tulokset' => $tulokset,
                'oikeatulos' =>$oikeatulos,
                'ratkaisu' => $oikearatkaisu
            ));
        } 
    }

} else {
    naytaNakyma("login", array(
       $_SESSION['ilmoitus']['login'] = "Kirjaudu sisään." 
    ));
      
}
  
