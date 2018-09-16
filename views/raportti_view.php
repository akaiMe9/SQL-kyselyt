<h1>Raportti</h1>
<H4><?php echo $data->otsikko; ?></H4>

<?php tulostaTaulukko($data->tulokset); ?>





<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-0 control-label" for="button1id"></label>
  <div class="col-md-2">
      <a href="raportit_valikko.php" name="valikko" class="btn btn-danger btn-block"><span class="glyphicon glyphicon-th-list pull-left"></span>Palaa raporttivalikkoon</a>
    
    
  </div>
</div>


   