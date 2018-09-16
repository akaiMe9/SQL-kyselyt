<!DOCTYPE HTML>
<html>
    <head>
<meta charset="UTF-8"> 
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-theme.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
<title> SQL-kyselyohjelma</title>
    </head>

<body>
    <?php if (!empty($_SESSION['ilmoitus'])): ?>
        <div class="alert alert-success">
    <?php    foreach ($_SESSION['ilmoitus'] as $ilmoitus) {
        echo $ilmoitus;
    }
    ?>
   
    </div>
    <?php
        unset($_SESSION['ilmoitus']); 
        endif;
    ?>
    
        <br> 
    <?php if (!empty($_SESSION['virheet'])): ?>
        <div class="alert alert-danger">
        <?php    foreach ($_SESSION['virheet'] as $virhe) {
            echo $virhe;
        }
        ?>
   
    </div>
    <?php
        unset($_SESSION['virheet']); 
        endif;
    ?>
    
    
  <?php 
    require 'views/'.$sivu.'.php'; 
    ?>
    
    <br> 
    
    
    
        
        
        
</body>
</html>



