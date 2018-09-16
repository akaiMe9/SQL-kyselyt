<?php
    session_start();
 
    function naytaNakyma($sivu, $data = array()) {
        $data = (object)$data;
        require_once 'views/template.php';
        exit();
    }
    
    function lopeta(){
        session_destroy();
        unset($_SESSION['kayttaja']);
        naytaNakyma("login", array(
            $_SESSION['ilmoitus']['login'] = "Uloskirjautuminen onnistui."
            ));
    }
    
    function tulostaTaulukko($taulukko){
        $eka = array_values($taulukko)[0]; 
        $otsikot = array();
        
        foreach ($eka as $key => $value) {
            $otsikot[] = $key;
        }
        
        echo '<table class="table table-striped">';
        echo '<thead class="thead-inverse">';
        echo '<tr></thead><tbody>';
        foreach($otsikot as $key => $value){
            echo '<th>'. $value .'</th>';
        }
        
        echo '</tr>';

        foreach($taulukko as $rivi){
            echo '<tr>';    
            
            foreach ($rivi as $key => $value){
                echo '<td>' .$value .'</td>';
            }
            echo '</tr>';
        }
        
        echo '</tbody></table>'; 
    }
    
    function tulostaTaulukkoSimple($taulukko){
        $eka = array_values($taulukko)[0]; 
        $otsikot = array();
        
        foreach ($eka as $key => $value) {
            $otsikot[] = $key;
        }
        
        echo '<table>';
        echo '<thead class="thead-inverse">';
        echo '<tr></thead><tbody>';
        foreach($otsikot as $key => $value){
            echo '<th>'. $value .'</th>';
        }
        
        echo '</tr>';

        foreach($taulukko as $rivi){
            echo '<tr>';    
            
            foreach ($rivi as $key => $value){
                echo '<td>' .$value .'</td>';
            }
            echo '</tr>';
        }
        
        echo '</tbody></table>'; 
    }
    
    
  
  
  
  


