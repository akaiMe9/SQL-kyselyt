<?php
require_once 'libs/common.php';
require_once 'libs/models/tehtavalista.php';
require_once 'libs/models/sessio.php';
require_once 'libs/models/sisaltaa.php';
require_once 'libs/models/tehtava.php';
require_once 'libs/models/yritys.php';

if (isset($_SESSION['kayttaja'])) {
    $lista = $_SESSION['lista'];
    $aloitusaika = date("Y-m-d H:i:s");
    $sessioid = $_SESSION['sessioid'];
    $yritysnro = $_SESSION['yritysnro'];
    $indeksi = $_SESSION['indeksi'];
    
    try{
        $tehtavat = Sisaltaa::haeTehtavatListalta($lista); 
        
        // tehtävien määrä listalla
        $_SESSION['tehtavienlkm'] = count($tehtavat);
                
        $tehtavanro = reset($tehtavat[$indeksi]);
        
        $_SESSION['tehtavanro'] = $tehtavanro;
        
        
        if($tehtavat != null){
            $tehtava = Tehtava::haeTehtava($tehtavanro);
            
            try{
                // luo ja tallenna uusi yritys
                $uusiyritys = new Yritys();
                $uusiyritys->setSessio($sessioid);
                $uusiyritys->setTehtava($tehtavanro);
                $uusiyritys->setAlkuaika($aloitusaika);
                $uusiyritys->setYritysnro($yritysnro);

                try{
                    $uusiyritys->tallennaUusiYritys();
                    $_SESSION['yritysnro'] = $uusiyritys->getYritysnro();
                } catch (Exception $e) {
                    echo 'Virhe yrityksen tallennuksessa: ' .$e->getMessage();
                }

                naytaNakyma("suoritaTehtava_view", array(
                    $_SESSION['tehtavat'] => $tehtavat,
                    $_SESSION['tehtava'] => $tehtava,
                    'tehtavat' => $tehtavat,
                    'tehtava' => $tehtava
                ));
            } catch (Exception $e){
                echo 'Virhe: ' .$e->getMessage();

            }
        } else {
            naytaNakyma("valitseTehtavalista", array(
                $_SESSION['ilmoitus']['eiloydy'] = "Tehtäviä ei löytynyt."
            ));
        }

    } catch(Exception $e) {
        echo 'Virhe: ' .$e->getMessage();
    }

} else {
        naytaNakyma("login", array(
           $_SESSION['ilmoitus'] = "Kirjaudu sisään." 
        ));
    }
 
  
  
  






