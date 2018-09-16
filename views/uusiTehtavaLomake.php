<form class="form-horizontal" action="lisaaTehtava.php" method="POST">
<fieldset>

<!-- Form Name -->
<h1>Uusi tehtävä</h1> 


<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="textarea">Tehtävän kuvaus</label>
  <div class="col-md-4">                     
      <textarea class="form-control" id="textarea" name="kuvaus" maxlength="200" ><?php echo $data->kuvaus; ?></textarea>
  </div>
</div>

<div class="form-group">
    <label class="col-md-2 control-label" for="img">Tietokantakaavio</label>
    <div class="col-md-4"> 
<img src="img/data.jpg" alt="tietokantakaavio"> 
</div>
<br>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="textarea" >Ratkaisu</label>
  <div class="col-md-4">                     
      <textarea class="form-control" rows="5" id="textarea" name="ratkaisu" maxlength="200"><?php echo $data->ratkaisu; ?></textarea>
  </div>
</div>

<!-- Multiple Radios -->
<div class="form-group">
  <label class="col-md-2 control-label" for="radios">Kyselytyyppi</label>
  <div class="col-md-2">
     <?php foreach($data->kyselytyypit as $tyyppi): ?> 
  <div class="radio">
    <label for="radios-0">
      <input id="radios-0" name="kyselytyypit[]" value="<?php echo $tyyppi->getId(); ?>" checked="checked" type="radio">
      <?php echo strtoupper($tyyppi->getTyyppi()); ?>
    </label>
	</div>
    <?php endforeach; ?>
  </div>
</div>




<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-2 control-label" for="button1id"></label>
  <div class="col-md-2">
      <button id="tallenna" name="tallenna" class="btn btn-success btn-block"><span class="glyphicon glyphicon-floppy-disk pull-left"></span>Tallenna</button>
    
    
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-2 control-label" for="button1id"></label>
  <div class="col-md-2">
      <a href="valikko.php" name="valikko" class="btn btn-info btn-block"><span class="glyphicon glyphicon-th-list pull-left"></span>Palaa valikkoon</a>
  </div>
</div>




</fieldset>
</form>