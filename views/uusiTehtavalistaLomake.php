<form class="form-horizontal" action="lisaaTehtavalista.php" method="POST">
<fieldset>

<!-- Form Name -->
<h1>Uusi tehtävälista</h1>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-2 control-label" for="textarea">Tehtävälistan kuvaus</label>
  <div class="col-md-6">                     
      <textarea class="form-control" id="textarea" name="kuvaus" maxlength="50" ><?php echo $data->kuvaus; ?></textarea>
  </div>
</div>

<!-- Multiple Checkboxes -->
<div class="form-group">
  <label class="col-md-2 control-label" for="checkboxes">Valitse tehtävät</label>
  <div class="col-md-10">
    <?php foreach($data->tehtavat as $tehtava): ?>
        <div class="checkbox">
        <label for="checkboxes-1">
      <input name="tehtavat[]" id="tehtavat" value="<?php echo $tehtava->getId(); ?>" type="checkbox">
      <?php echo $tehtava->getId() . ': '. $tehtava->getKuvaus(); ?>
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





