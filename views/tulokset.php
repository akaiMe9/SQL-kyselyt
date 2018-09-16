<form class="form-horizontal" action="tulokset.php" method="POST">
<fieldset>

<!-- Form Name -->
<p class="bg-primary lead">Tulokset</p> 
<br>
<p class="bg-success lead">Yritys <?php echo $_SESSION['yritysnro']; ?>/3</p>

<?php if ($data->tulos === "väärin!"): ?>
<div class="bg-danger text-white">
    <h3>Vastauksesi on <?php echo $data->tulos; ?></h3>
</div>
<?php endif; ?>

<?php if ($data->tulos === "oikein!"): ?>
<div class="bg-success text-white">
    <h3>Vastauksesi on <?php echo $data->tulos; ?></h3>
</div>
<?php endif; ?>

<h4><b>Kyselysi tulos:</b></h4>
<p><?php echo $_SESSION['error']; ?></p>
<?php if ($_SESSION['kyselytyyppi'] === 1): ?>
    <?php tulostaTaulukkoSimple($data->tulokset); ?>
    
        <?php if ($data->tulos === "väärin!"): ?>
        <br>
        <h4><b>Tuloksen pitäisi näyttää tältä:</b></h4>
            <?php tulostaTaulukkoSimple($data->oikeatulos); ?>
        <br>
        <?php endif; ?>
        
<?php endif; ?>

 <?php if($data->tulos === "väärin!" and $_SESSION['yritysnro'] == 3) : ?>
<h4><b>Oikea ratkaisu olisi ollut:</b></h4>
<?php echo $data->ratkaisu; ?>
<?php endif; ?>

<br>
<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-0 control-label" for="button1id"></label>
  <div class="col-md-4">
    <?php if($data->tulos === "väärin!" and $_SESSION['yritysnro'] < 3) : ?>
      <button id="button1id" class="btn btn-success" name="uusiyritys"><span class="glyphicon glyphicon-circle-arrow-left pull-left"></span>Yritä uudelleen</button>
    
    <?php endif; ?>
    
     <?php if($data->tulos === "oikein!" or $_SESSION['yritysnro'] == 3): ?>
    <button id="button2id" name="seuraava" class="btn btn-primary"><span class="glyphicon glyphicon-circle-arrow-right pull-left"></span>Seuraava tehtävä</button>
    <?php endif; ?>
    
  </div>
</div>
<?php unset($_SESSION['error']); ?>
</fieldset>
</form>



