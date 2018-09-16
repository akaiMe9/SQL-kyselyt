<form class="form-horizontal" action = "tarkasta.php" method = "POST">
<fieldset>
    
<!-- Form Name -->
<p class="bg-primary lead">Tehtävä <?php echo $_SESSION['tehtavanro']; ?></p>
<div class="col-md-10">
<p> Alla näet tietokannan kuvauksen. Kirjoita taulujen nimet muodossa data.taulu, esim. data.kurssit.
</p>

<p class="bg-warning lead">Tehtävä: <?php echo $data->tehtava->getKuvaus(); ?></p>



<img src="img/data.jpg" alt="tietokantakaavio"> 
<br>
<br>

<p class="bg-danger lead">Yritys: <?php echo $_SESSION['yritysnro']; ?>/3</p>
<br>
<p>Vastaus:</p>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-0 control-label" for="textarea"></label>
  <div class="col-md-8">                     
      <textarea class="form-control" id="textarea" name="vastaus" rows="5" maxlength="200"></textarea>
  </div>
</div>
<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-0 control-label" for="button1id"></label>
  <div class="col-md-4">
    <button id="button1id" name="tarkasta" class="btn btn-success">Tarkasta vastaus</button>
    
  </div>
</div>
</div>

</fieldset>
</form>

   

