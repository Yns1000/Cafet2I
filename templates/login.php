</br></br></br></br>
<link href='css/temp.css' type='text/css' rel='stylesheet' />
<script src="js/tempuser.js"></script>

<style>



</style>
<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=login");
	die("");
}
if (valider("connecte","SESSION"))
{
  header("Location:index.php?view=accueil");
	die("");
}

// Chargement eventuel des données en cookies
$login = valider("login", "COOKIE");
$passe = valider("passe", "COOKIE"); 
$passe2 = valider("passe2", "COOKIE"); 
$confpasse2 = valider("confpasse2", "COOKIE"); 
$login2 = valider("login2", "COOKIE"); 
$nom = valider("nom", "COOKIE"); 
$prenom = valider("prenom", "COOKIE"); 
$tel = valider("tel", "COOKIE"); 


if ($checked = valider("remember", "COOKIE")) $checked = "checked"; 



// Si un message est présent dans la chaine de requete, on l'affiche 
if ($msg = valider("msg")) {
	$msg = '<h2 style="color:red;">' . $msg  . "</h2>";
}

?>
<div id="choixBout">
<button type="submit"  value="" class="button-50" onclick="affConex('connexion','inscription');">Connexion</button>
<button type="submit"  value="" class="button-50" onclick="affConex('inscription','connexion');">Inscription</button>
</div>

<div class="formu">

<div id="connexion" style="display: block;">
<div class="page-header">
	<h1>Connexion</h1>
</div>

<div class="lead">

	<?php if ($msg) echo $msg; ?>

 <form role="form" action="controleur.php">
  <div class="form-group">
    <label for="email">Login</label>
    <input type="text" class="form-control form__field" id="email" name="login" value="<?php echo $login;?>" >
  </div>
  <div class="form-group">
    <label for="pwd">Mot de passe</label>
    <input type="password" class="form-control form__field" id="pwd" name="passe" value="<?php echo $passe;?>">
  </div>
  <div class="checkbox">
    <label><input type="checkbox" name="remember" <?php echo $checked;?> >Se souvenir de moi</label>
  </div>
  <button type="submit" name="action" value="Connexion" class="button-40 log">Connexion</button>
</form>



</div>
</div>

<div id="inscription" style="display: none;">
<div class="page-header">
	<h1>S'inscrire</h1>
</div>

<div class="lead">


 <form role="form" action="controleur.php">

 <div class="form-group">
    <label for="email">Nom</label>
    <input type="text" class="form-control form__field" id="email" name="nom" value="<?php echo $nom;?>" >
  </div>
  
  <div class="form-group">
    <label for="email">Prenom</label>
    <input type="text" class="form-control form__field" id="email" name="prenom" value="<?php echo $prenom;?>" >
  </div>

  <div>
        <label for="promo">Votre promo :</label>
        </br>
        <select name="promos" id="promo" class="form__field">
            <option value="" selected>--- Choisissez votre Promo ---</option>
            <option value="LE1">LE1</option>
            <option value="LE2">LE2</option>
            <option value="LE3">LE3</option>
		      	<option value="LE4">LE4</option>
            <option value="LE5">LE5</option>
        </select>
    </div>

</br>

  <div class="form-group">
    <label for="email">Login</label>
    <input type="text" class="form-control form__field" id="email" name="login2" value="<?php echo $login2;?>" >
  </div>
  <div class="form-group">
    <label for="pwd">Mot de passe</label>
    <input type="password" class="form-control form__field" id="pwd" name="passe2" value="<?php echo $passe2;?>">
  </div>
  <div class="form-group">
    <label for="pwd">Confirmation de mot de passe</label>
    <input type="password" class="form-control form__field" id="pwd" name="confpasse2" value="<?php echo $confpasse2;?>">
  </div>
  <div class="form-group">
    <label for="pwd">Numéro de telephone : </label>
</br>
   <input class="form__field" type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" name="tel" value="<?php echo $tel;?>">
  </div>
  <!-- 
  <div class="checkbox">
    <label><input type="checkbox" name="remember" <?php echo $checked;?> >Se souvenir de moi</label>
  </div> -->

  <button type="submit" name="action" value="Inscription" class="log button-40">Inscription</button>
</form>

</div>
</div>
</div>



