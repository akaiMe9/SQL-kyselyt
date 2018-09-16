<form class="form-horizontal" action = "lopputulokset.php" method = "POST">
<fieldset>
    
<!-- Form Name -->
<p class="bg-primary lead">Kaikki tehtävät suoritettu!</p>

<p class="bg-danger lead">Yhteenveto</p>
<br>
<p>Suoritusaika: <?php echo $_SESSION['suoritusaika']; ?> </p>

<div class="form-group">
  <label class="col-md-2 control-label" for="singlebutton"></label>
  <div class="col-md-2">
    <a href="valikko.php" name="valikko" class="btn btn-info btn-block"><span class="glyphicon glyphicon-th-list pull-left"></span>Palaa valikkoon</a>
  </div>
</div>



</fieldset>
</form>


