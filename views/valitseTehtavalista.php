<form class="form-horizontal" action="uusiSessio.php" method="POST">
<fieldset>

<!-- Form Name -->
<h1>Valitse tehtävälista</h1>

<!-- Multiple Radios -->
<div class="form-group">
  <label class="col-md-2 control-label" for="radios">Tehtävälista:</label>
  <div class="col-md-10">
      <?php foreach($data->tehtavalistat as $tehtavalista): ?>
  <div class="radio">
    <label for="radios-0">
      <input name="tehtavalista" id="tehtavalista" value="<?php echo $tehtavalista->getId(); ?>" checked="checked" type="radio">
      <?php echo $tehtavalista->getId() . ': '. $tehtavalista->getKuvaus(); ?>
    </label>
	</div>
      <?php endforeach; ?>
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-2 control-label" for="button1id"></label>
  <div class="col-md-4">
      <button id="aloita" name="aloita" class="btn btn-success btn-block"><span class="glyphicon glyphicon-play pull-left"></span>Aloita!</button>
    
  </div>
</div>


<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-2 control-label" for="button1id"></label>
  <div class="col-md-4">
      <a href="valikko.php" name="valikko" class="btn btn-info btn-block"><span class="glyphicon glyphicon-th-list pull-left"></span>Palaa valikkoon</a>
  </div>
</div>

</fieldset>
</form>


