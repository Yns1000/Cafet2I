<link href="css/accueil.css" rel="stylesheet" />


<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}
include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php"); 
// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simplify2I</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->
	     <link rel="icon" type="image/png" href="ressources/fav-iconTRANSP.png" />

	<!-- Liaisons aux fichiers css de Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" />
	<link href="css/sticky-footer.css" rel="stylesheet" />
	<link href="css/accueil.css" rel="stylesheet" />

	<!--[if lt IE 9]>
	  <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]-->

	<script src="js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	

</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

<!-- style inspiré de http://www.bootstrapzero.com/bootstrap-template/sticky-footer --> 
<a class="navbar-brand" href="index.php?view=accueil"> <img id="logo" src="ressources/logo_transparent.png" alt=" Notre logo "/> </a>

<a class="navbar-brand" href="https://ig2i.centralelille.fr/"> <img id="logo2I" src="ressources/Centrale_Lille_IG2I-removebg-preview.png" alt=" Le logo de l'école "/> </a>
<?php
if (!valider("connecte","SESSION"))
echo "<a class=\"navbar-brand\" href=\"index.php?view=login\"> <div id=logout>Login</div><img id=\"ConnectLogo\" src=\"ressources/Daco_5265627 1.png\" alt=\" Le logo de login \"/> </a>";
else
echo "<a class=\"navbar-brand\" href=\"controleur.php?action=Logout\"> <div id=logout>Logout</div> <img id=\"ConnectLogo\" src=\"ressources/Daco_5265627 1.png\" alt=\" Le logo de logout \"/> </a>";

?>
<!-- Wrap all page content here -->
<div id="wrap">
  <!-- Fixed navbar -->
  <div class=" navbar acc navbar-fixed-top">
    <div class="container">

      <div class="navbar-header">
        <button  type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
        </button>
	
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
         	<!-- <li class="active"><a href="index.php?view=accueil">Accueil</a></li> -->
		<?=mkHeadLink("Accueil","accueil",$view,"test accc")?>
		<?php
		// Si l'utilisateur n'est pas connecte, on affiche un lien de connexion 
		if (!valider("connecte","SESSION"))
			echo mkHeadLink("Se connecter","login",$view,"test"); 
			//echo "<li><a href=\"index.php?view=login\">Se connecter</a></li>";
		else {
			if (isAdmin($_SESSION["idUser"]))
			echo mkHeadLink("Administration","users",$view,"test");
			//echo mkHeadLink("Conversations","conversations",$view);
			echo mkHeadLink("Mon Compte","compte",$view,"test");
			echo mkHeadLink("Mon Panier","paiements",$view,"test");
			echo "<li class=\"active test\"> <a href=\"controleur.php?action=Logout\">Se deconnecter</a></li>";


			
		}
		?>
        </ul>
      </div><!--/.nav-collapse -->
	  
	
    </div>

  </div>
  
  <?php /* echo "	<div><section>
  <nav>
    <ul class=\"menuItems\">";
      echo "<li><a href= \"index.php?view=login\" data-item='Accueil'>Accueil</a></li>";
	  if (isAdmin($_SESSION["idUser"]))
      echo "<li><a href = \"index.php?view=users\" data-item='Administration'>Administration</a></li>";
	  if (valider("connecte","SESSION")){
	  echo "<li><a href= \"index.php?view=compte\" data-item='Mon compte'>Mon compte</a></li>";
      echo "<li><a href= \"index.php?view=paiements\" data-item='Mon panier'>Mon panier</a></li>";
	  }
      echo "<li class=\"active\"><a href=\"controleur.php?action=Logout\" data-item='Se Deconnecter'>Se Deconnecter</a></li>";
	  if (!valider("connecte","SESSION")) 
	  echo "<li class=\"active\"><a href=\"controleur.php?action=login\" data-item='Se Connecter'>Se Connecter</a></li>";
   echo" </ul>
  </nav>

</section></div>";
*/ ?>

  <!-- Begin page content -->
  <div class="container">








