<form class="form-inline" action ="login.php" method ="POST">
<div class="form-group">
    
<p class="bg-primary lead">SQL-kyselyohjelma</p>

<div class="container">
    
<h3>Kirjaudu</h3>
<br>
<label for="kayttajatunnus">Käyttäjätunnus</label>
<input type="text" class="form-control" name="kayttajatunnus" value="<?php echo $data->kayttaja; ?>">


<label for="salasana">Salasana</label>
<input type="password" class="form-control" name="salasana">


<button type="submit" class="btn btn-success" name="kirjaudu">Kirjaudu</button>
</div>
</div>
</form>




