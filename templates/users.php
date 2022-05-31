<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Sora:wght@300&display=swap" rel="stylesheet">
<script src="js/tempuser.js"></script>
<link href='css/temp.css' type='text/css' rel='stylesheet' />
<link href="css/accueil.css" rel="stylesheet" />


</br></br></br></br>




<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

if ($msg = valider("msg")) {
	$msg = '<h2 style="color:red;">' . $msg  . "</h2>";
}

if ($msg2 = valider("msg2")) {
	$msg2 = '<h2 style="color:green;">' . $msg2  . "</h2>";
}

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "users.php") {
	header("Location:../index.php?view=users");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php");
// définit mkTable

// Interface de gestion des utilisateurs 
// Cette interface ne doit pas etre offerte aux utilisateurs non connectés

if (!valider("connecte", "SESSION")) {
	// header("Location:?view=login&msg=" . urlencode("Il faut vous connecter !!")); 
	// déclenche une erreur headers already sent 
	// car les entetes HTTP de réponse ont déjà envoyées
	// car la page header envoie un résultat HTML au client 
	// ET que le serveur ne bufferise pas 

	// On choisit de charger la vue de login 
	$_REQUEST["msg"] = "Il faut vous connecter !!";
	include("templates/login.php");
} else {

	// la partie administration ne doit pas etre offerte aux utilisateurs connectés qui ne sont pas administrateurs

	// Côté serveur, les opérations d'administration ne doivent pas etre déclenchées si l'utilisateur n'est pas administrateur  
?>

	<?php
	// la partie administration ne doit pas etre offerte aux utilisateurs connectés qui ne sont pas administrateurs

	//if (valider("isAdmin","SESSION")) {
	if (isAdmin($_SESSION["idUser"])) {
	?>

		<div class="page-header">
			<h1>Administration du site</h1>
		</div>

		<p class="lead">

		<h2>Utilisateurs de la base </h2>
		<p>Veuillez consultez les utilisateurs présents dans le site web et ceux qui sont bannis jusqu'à changement. </p>

		<button type="submit"  value="" class="button-50" style="width : auto; margin:auto; display:block;  background-color:#6495ed ; " onclick="affConex('autoriz','non_autoriz','bouttonOuvr')">Utilisateurs autorisées</button>
	</br>
		<button type="submit"  value="" class="button-50"  style="width : auto; margin:auto; display:block;  background-color:#6495ed ;"onclick="affConex('non_autoriz','autoriz', 'bouttonOuvr');">Utilisateurs non autorisées</button>
	</br>
		<button type="submit" id="bouttonOuvr" value="" class="button-50"  style="width : auto; margin:auto; display:none; background-color : #ce2029" onclick="NoUser('non_autoriz','autoriz','bouttonOuvr');">Minimisez le tableau</button>




		<?php
				echo "<div id=\"autoriz\" style=\"display:none\"><hr />";

		echo "<h3 style=\"text-align : center;\">Liste des utilisateurs autorisés de la base :</h3>";
		$users = listerUtilisateurs("nbl");

		// tprint($users);	// préférer un appel à 
		//mkTable($users, array("id", "pseudo", "admin", "nom", "prenom", "NumeroTEL"));
		


		echo "<div class=\"container2\">
		<ul class=\"Commandes\">
		  <li class=\"titres\">
			<div class=\"colone gen\">Id</div>
			<div class=\"colone gen\">Pseudo</div>
			<div class=\"colone gen\">Admin</div>
			<div class=\"colone gen\">Nom</div>
			<div class=\"colone gen\">Prenom</div>
			<div class=\"colone gen\">Numero</div>
		  </li>";

		  $chosen = 0;
		  $couleur = 1;
		for ($x = 0; $x <= count($users) - 1; $x++) {
			if ($couleur == 1 && $chosen == 0) {
	echo "<li style=\"color : #fff; background-color : #333333 ;\" class=\"table-row\">
		  <div class=\"colone gen\" data-label=\"Id\">" . $users[$x]["id"] . "</div>
		  <div class=\"colone gen\" data-label=\"Pseudo\">" . $users[$x]["pseudo"] . "</div>
		  <div class=\"colone gen\" data-label=\"Admin\">" . $users[$x]["admin"] . "</div>
		  <div class=\"colone gen\" data-label=\"Nom\">"  . $users[$x]["nom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Prenom\">"  . $users[$x]["prenom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Numero\">"  . $users[$x]["NumeroTEL"] . "</div>
		</li>";
		$couleur = 0;
		$chosen = 1;
			}
			if ($couleur == 0 && $chosen == 0) {
				echo "<li style=\"color : #333333; background-color : #fff;\" class=\"table-row\">
		  <div class=\"colone gen\" data-label=\"Id\">" . $users[$x]["id"] . "</div>
		  <div class=\"colone gen\" data-label=\"Pseudo\">" . $users[$x]["pseudo"] . "</div>
		  <div class=\"colone gen\" data-label=\"Admin\">" . $users[$x]["admin"] . "</div>
		  <div class=\"colone gen\" data-label=\"Nom\">"  . $users[$x]["nom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Prenom\">"  . $users[$x]["prenom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Numero\">"  . $users[$x]["NumeroTEL"] . "</div>
		</li>";
		$couleur = 1;
		$chosen = 1;
			}
			$chosen = 0;

		}

		echo "</ul></div></div>";
		echo "<div id=\"non_autoriz\" style=\"display:none\"><hr />";

		echo "<h3 style=\"text-align : center;\">Liste des utilisateurs non autorisés de la base :</h3>";
		$users = listerUtilisateurs("bl");
		//tprint($users);	// préférer un appel à mkTable($users);
		//mkTable($users, array("id", "pseudo", "admin", "nom", "prenom", "NumeroTEL"));
		
		echo "<div class=\"container2\">
		<ul class=\"Commandes\">
		  <li class=\"titres\">
			<div class=\"colone gen\">Id</div>
			<div class=\"colone gen\">Pseudo</div>
			<div class=\"colone gen\">Admin</div>
			<div class=\"colone gen\">Nom</div>
			<div class=\"colone gen\">Prenom</div>
			<div class=\"colone gen\">Numero</div>
		  </li>";

		  $chosen = 0;
		  $couleur = 1;

		for ($x = 0; $x <= count($users) - 1; $x++) {
			if ($couleur == 1 && $chosen == 0) {
	echo "<li style=\"color : #fff; background-color :  #333333;\" class=\"table-row\">
		  <div class=\"colone gen\" data-label=\"Id\">" . $users[$x]["id"] . "</div>
		  <div class=\"colone gen\" data-label=\"Pseudo\">" . $users[$x]["pseudo"] . "</div>
		  <div class=\"colone gen\" data-label=\"Admin\">" . $users[$x]["admin"] . "</div>
		  <div class=\"colone gen\" data-label=\"Nom\">"  . $users[$x]["nom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Prenom\">"  . $users[$x]["prenom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Numero\">"  . $users[$x]["NumeroTEL"] . "</div>
		</li>";
		$couleur = 0;
		$chosen = 1;
			}
			if ($couleur == 0 && $chosen == 0) {
				echo "<li style=\"color :  #333333; background-color : #fff;\" class=\"table-row\">
		  <div class=\"colone gen\" data-label=\"Id\">" . $users[$x]["id"] . "</div>
		  <div class=\"colone gen\" data-label=\"Pseudo\">" . $users[$x]["pseudo"] . "</div>
		  <div class=\"colone gen\" data-label=\"Admin\">" . $users[$x]["admin"] . "</div>
		  <div class=\"colone gen\" data-label=\"Nom\">"  . $users[$x]["nom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Prenom\">"  . $users[$x]["prenom"] . "</div>
		  <div class=\"colone gen\" data-label=\"Numero\">"  . $users[$x]["NumeroTEL"] . "</div>
		</li>";
		$couleur = 1;
		$chosen = 1;
			}
			$chosen = 0;

		}
		
		?>
		</div></div></ul><hr />



	<h2>Liste des commandes</h2>

	<p>Dans cette partie, vous pouvez gerer les commandes et consultez leurs détails.</p>


	<?php
	$stock = listerCommande();
	//mkTable($stock, array("id_commande", "nom", "prenom", "promo", "montant", "valide", "livraison"));
	//echo "<strong><p style=\"color : red;\"> Si valide = 1 : la commande est validée </br> Si valide = 0 : la commande est annulée </br> Si livaison = 1 : la commande est prête à être cherchée </br> Si livaison = 0 : la commande n'est pas prête à être cherchée </p></strong>";

	// TODO
	//$stock=listestocks("tout");
	//tprint($stock);
	?>
	<!-- HTML !-->
	<input id="button1" onclick="affListe('list', 'button1', 'button2')" class="button-40" type="button"  style="background-color:#6495ed ;" value="Afficher liste de commandes">
	<input id="button2" onclick="affListe('list', 'button1', 'button2')" class="button-40" type="button"  style="background-color:#ce2029 ;" value="Fermer liste de commandes">



	<!-- <input onclick="affListe()" class="favorite styled" type="button" value="Afficher les commandes"> -->
	<?php

	echo "<div class=\"container2\" id=\"list\">";
	/*for ($x = 0; $x <= count($stock) - 1; $x++) {
		//$num =intval(mkLigne($stock[$x]));  
		//$nom = mkLigne($stock[$x]);  
		if (($stock[$x]["valide"] == 1) && ($stock[$x]["livraison"] == 0)) //1       
			echo '</br>
  <div  style="border : solid #51484f 3px; font-family: \'Lato\', sans-serif; color : #fff; font-size : 18px; text-align : center ; background-color : #006400; padding : 10px">En attente de livraison </br>Numéro de commande &nbsp&nbsp&nbsp : &nbsp&nbsp&nbsp ' . $stock[$x]["id_commande"] . '</br>Prenom : ' . $stock[$x]["prenom"] . ' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Nom :  ' . $stock[$x]["nom"] . ' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Promo : ' . $stock[$x]["promo"] . '</br>Produit : ' . $stock[$x]["nom_prod"] . '
  </div>';
		if ($stock[$x]["valide"] == 0) //1       
			echo '</br>
  <div style="border : solid #51484f 3px; font-family: \'Lato\', sans-serif; color : #fff; font-size : 18px; text-align : center ; background-color : #b22222; padding : 10px">Commande annulée </br>Numéro de commande &nbsp&nbsp&nbsp : &nbsp&nbsp&nbsp ' . $stock[$x]["id_commande"] . '</br>Prenom : ' . $stock[$x]["prenom"] . ' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Nom :  ' . $stock[$x]["nom"] . ' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Promo : ' . $stock[$x]["promo"] . '</br>Produit : ' . $stock[$x]["nom_prod"] . '
  </div>';
		if (($stock[$x]["valide"] == 1) && ($stock[$x]["livraison"] == 1)) //1       
			echo '</br>
  <div style="border : solid #51484f 3px; font-family: \'Lato\', sans-serif; color : #fff; font-size : 18px; text-align : center ; background-color : #26619c; padding : 10px">Livré ! </br> Numéro de commande &nbsp&nbsp&nbsp : &nbsp&nbsp&nbsp ' . $stock[$x]["id_commande"] . '</br>Prenom : ' . $stock[$x]["prenom"] . ' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Nom :  ' . $stock[$x]["nom"] . ' &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Promo : ' . $stock[$x]["promo"] . '</br>Produit : ' . $stock[$x]["nom_prod"] . '
  </div>';
	}
	echo "</div>"; */

	echo "<hr />";

	echo "<div class=\"container2\">
  <ul class=\"Commandes\">
    <li class=\"titres\">
      <div class=\"colone gen\">Numéro commande</div>
      <div class=\"colone gen\">Prenom</div>
      <div class=\"colone gen\">Nom</div>
	  <div class=\"colone gen\">Promo</div>
	  <div class=\"colone gen\">Montant (€)</div>
      <div class=\"colone gen\">Statut du paiment</div>
	  <div style=\"right : 0px; padding-left:35px; margin:0;\" class=\"colone gen\">Voir détail</div>

    </li>";

	for ($x = 0; $x <= count($stock) - 1; $x++) {

		if (($stock[$x]["valide"] == 1) && ($stock[$x]["livraison"] == 1))
			echo "<li style=\"color : #fff; background-color : #26619c;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numéro commande\">" . $stock[$x]["id_commande"] . "</div>
      <div class=\"colone gen\" data-label=\"Prenom\">" . $stock[$x]["prenom"] . "</div>
      <div class=\"colone gen\" data-label=\"Nom\">" . $stock[$x]["nom"] . "</div>
      <div class=\"colone gen\" data-label=\"Promo\">"  . $stock[$x]["promo"] . "</div>
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut commande\">Ancienne commande finalisée</div>
	  <a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-left:15px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838; color:#fff; margin:0;\">Voir plus d'info</div></a>
    </li>";

		if (($stock[$x]["valide"] == 1) && ($stock[$x]["livraison"] == 0))
			echo "<li style=\"color : #fff; background-color : #2e8b57;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numéro commande\">" . $stock[$x]["id_commande"] . "</div>
      <div class=\"colone gen\" data-label=\"Prenom\">" . $stock[$x]["prenom"] . "</div>
      <div class=\"colone gen\" data-label=\"Nom\">" . $stock[$x]["nom"] . "</div>
      <div class=\"colone gen\" data-label=\"Promo\">"  . $stock[$x]["promo"] . "</div>
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut commande\">Commande en attente de livraison</div>
	  <a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-left:15px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838; color:#fff; margin:0;\">Voir plus d'info</div></a>
    </li>";

		if (($stock[$x]["valide"] == 0) && ($stock[$x]["livraison"] == 0))
			echo "<li style=\"color : #fff; background-color : #b22222;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numéro commande\">" . $stock[$x]["id_commande"] . "</div>
      <div class=\"colone gen\" data-label=\"Prenom\">" . $stock[$x]["prenom"] . "</div>
      <div class=\"colone gen\" data-label=\"Nom\">" . $stock[$x]["nom"] . "</div>
      <div class=\"colone gen\" data-label=\"Promo\">"  . $stock[$x]["promo"] . "</div>
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut du paiment\">Commande annulée</div>
	  <a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-left:15px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838; color:#fff; margin:0;\">Voir plus d'info</div></a>
    </li>";

		if (($stock[$x]["valide"] == 0) && ($stock[$x]["livraison"] == 1))
			echo "<li style=\"color : #fff; background-color : #b22222;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numero Commande\">" . $stock[$x]["id_commande"] . "</div>
      <div class=\"colone gen\" data-label=\"Prenom\">" . $stock[$x]["prenom"] . "</div>
      <div class=\"colone gen\" data-label=\"Nom\">" . $stock[$x]["nom"] . "</div>
      <div class=\"colone gen\" data-label=\"Promo\">"  . $stock[$x]["promo"] . "</div>
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut commande\">Commande annulée</div>
	  <a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-left:15px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838; color:#fff; margin:0;\">Voir plus d'info</div></a>
	  </li>";
	}

	echo "  </ul>
	</div></div>";
	?>
<hr />
	<h2>Gestion des commandes</h2>
	<?php
	mkForm("controleur.php"); //FIXME A SIMPLIFIER
	mkInput("hidden", "entite", "produit");

	$commande = listerCommande(); // produits par parcoursRs(recordset mysql)
	$lastCom = valider("lastIdCom");
	mkSelect("idCom", $commande, "id_commande", "prenom", $lastCom, "montant");

	/*	$produit = listerStock(); // produits par parcoursRs(recordset mysql)
			$lastProd = valider("lastProd");
			mkSelect("idProd",$produit,"reference","reference",$lastProd,"nom_prod"); */

	mkInput("submit", "action", "Valider la commande", "", "button-40");
	mkInput("submit", "action", "Annuler la commande", "", "button-40");
	mkInput("submit", "action", "Valider livraison", "", "button-40");
	echo "<p style=\"color:red;\"> <strong>*Pour qu'une commande soit archivée et que le stock soit modifié vous devez valider la commande puis valider la livraison</br>*En validant la livraison, le stock sera modifié en fonction des articles commandés.</strong></p>";

	echo ("</br>");
	echo ("</br>");
	mkInput("submit", "action", "Supprimer la commande", "", "button-40","background-color : #cc0000;");
	//	mkInput("submit","action","Retrograder");
	//	mkInput("submit","action","Promouvoir");

	/*			
			$colors = array(); 
			$colors[] = array("nom"=>"rouge", "code"=>"red");
			$colors[] = array("nom"=>"orange", "code"=>"orange");
			$colors[] = array("nom"=>"gris", "code"=>"grey");
			$colors[] = array("nom"=>"bleu", "code"=>"blue");							
			// tprint($colors);					 
			mkSelect("color",$colors,"code","nom");
*/

	//	mkInput("color","color","");
	//mkInput("submit","action","Changer Couleur");		
	endForm();

	?>

<hr />

		<h2>Gestion des utilisateurs</h2>


		<?php
		mkForm("controleur.php");
		mkInput("hidden", "entite", "users");

		$users = listerUtilisateurs(); // produits par parcoursRs(recordset mysql)
		$lastIdUser = valider("lastIdUser");
		mkSelect("idUser", $users, "id", "pseudo", $lastIdUser, "blacklist");
		mkInput("submit", "action", "Interdire", "", "button-40");
		mkInput("submit", "action", "Autoriser", "", "button-40");
		mkInput("submit", "action", "Supprimer", "", "button-40","background-color : #cc0000;");
		mkInput("submit", "action", "Retrograder", "", "button-40");
		mkInput("submit", "action", "Promouvoir", "", "button-40");

		/*			
			$colors = array(); 
			$colors[] = array("nom"=>"rouge", "code"=>"red");
			$colors[] = array("nom"=>"orange", "code"=>"orange");
			$colors[] = array("nom"=>"gris", "code"=>"grey");
			$colors[] = array("nom"=>"bleu", "code"=>"blue");							
			// tprint($colors);					 
			mkSelect("color",$colors,"code","nom");
*/


		endForm();
		echo "</br> <div class=\"\">";

		mkForm("controleur.php");
		echo "<strong>Nouvel Utilisateur :</strong></br></br>";
		echo " Nom </br>";
		mkInput("text", "nom", "", ["id" => "textNom"], "form__field format");
		echo "</br>";
		echo "</br>";
		echo " Prenom </br>";
		mkInput("text", "prenom", "", ["id" => "textPrenom"], "form__field format");
		echo "</br>";
		echo "</br>";
		echo " Pseudo </br>";
		mkInput("text", "pseudo", "", ["id" => "textPseudo"], "form__field format");
		echo "</br>";
		echo "</br>";
		echo " Mot de passe </br>";
		mkInput("password", "passe", "", ["id" => "textPasse"], "form__field format format");
		echo "</br>";
		echo "</br>";

		?>

		<strong>Numéro de telephone : </br></strong><input type="tel" class="form__field format" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" name="tel" value="">
		</br>
		</br>
		<div>
			<label for="promo">Sa promo :</label>
			</br>
			<select class="form__field format" name="promos" id="promo">
				<option value="" selected>--- Choisissez sa Promo ---</option>
				<option value="LE1">LE1</option>
				<option value="LE2">LE2</option>
				<option value="LE3">LE3</option>
				<option value="LE4">LE4</option>
				<option value="LE5">LE5</option>
			</select>
		</div>

		<?php
		echo "</br>";

		echo "<strong>Rendre administrateur : </strong>";
		echo "</br>";
		echo "<label>
		<input type=\"radio\" name=\"admin\" value=\"admin\">
		Oui
	  </label>
	  <label>
		<input type=\"radio\" name=\"admin\" value=\"0\">
		Non
	  </label>";
		echo "</br>";
		mkInput("submit", "action", "Creer Utilisateur", "", "button-40");
		endForm();
		?>
		</div>
		<hr />


		<h2>Liste des stocks</h2>

		<button id="btnStockOuvr" type="submit"  value="" class="button-50" style="width : auto; background-color:#6495ed ; display:block; " onclick="affConex('stockui','btnStockOuvr','btnStockFerm')">Afficher stock</button>
		<button id="btnStockFerm" type="submit"  value="" class="button-50" style="width : auto;  background-color:#6495ed ; display:none; " onclick="NoUser('btnStockFerm','stockui','btnStockFerm', 'btnStockOuvr')">Minimiser stock</button>


		<?php
		
		echo "<div id=\"stockui\" style=\"display:none;\"><h3 style=\"text-align : center;\"><strong>Liste des produits et leurs stocks :</strong></h3></br>";
		$stock = listerStock();
		//mkTable($stock, array("reference", "nom_prod", "prix", "quantite", "dispo"));
		//echo "<strong><p style=\"color : red;\"> Si dispo = 1 : le produit est disponible </br> Si dispo = 0 : le produit n'est pas disponible </p></strong>";

		echo " <div class=\"container2\">
		<ul class=\"Commandes\">
		  <li class=\"titres\">
			<div class=\"colone gen\">Reference</div>
			<div class=\"colone gen\">Nom du Produit</div>
			<div class=\"colone gen\">Prix</div>
			<div class=\"colone gen\">Quantité</div>
			<div class=\"colone gen\">Disponibilité</div>
		  </li>";

		  $chosen = 0;
		  $couleur = 1;
		for ($x = 0; $x <= count($stock) - 1; $x++) {
			if ($couleur == 1 && $chosen == 0) {
		echo "<li style=\"color : #fff; background-color : #333333 ;\" class=\"table-row\">
		  <div class=\"colone gen\" data-label=\"Reference\">" . $stock[$x]["reference"] . "</div>
		  <div class=\"colone gen\" data-label=\"Nom du Produit\">" . $stock[$x]["nom_prod"] . "</div>
		  <div class=\"colone gen\" data-label=\"Prix\">" . $stock[$x]["prix"] . "</div>
		  <div class=\"colone gen\" data-label=\"Quantite\">"  . $stock[$x]["quantite"] . "</div>";
		  if ($stock[$x]["dispo"] == 1) 
		  echo"<div class=\"colone gen\" data-label=\"Disponibilité\">Disponible</div>";
		  else
		  echo"<div class=\"colone gen\" data-label=\"Disponibilité\">Indisponible</div></li>";
		$couleur = 0;
		$chosen = 1;
			}
			if ($couleur == 0 && $chosen == 0) {
				echo "<li style=\"color : #333333; background-color : #fff;\" class=\"table-row\">
				<div class=\"colone gen\" data-label=\"Reference\">" . $stock[$x]["reference"] . "</div>
				<div class=\"colone gen\" data-label=\"Nom du Produit\">" . $stock[$x]["nom_prod"] . "</div>
				<div class=\"colone gen\" data-label=\"Prix\">" . $stock[$x]["prix"] . "</div>
				<div class=\"colone gen\" data-label=\"Quantite\">"  . $stock[$x]["quantite"] . "</div>";
				if ($stock[$x]["dispo"] == 1) 
				echo"<div class=\"colone gen\" data-label=\"Disponibilité\">Disponible</div>";
				else
				echo"<div class=\"colone gen\" data-label=\"Disponibilité\">Indisponible</div></li>";
		$couleur = 1;
		$chosen = 1;
			}
			$chosen = 0;

		}

		echo "</ul></div></div>";
		
		?>
		<hr />


		<h2>Gestion des stocks</h2>
		<?php
		mkForm("controleur.php");
		mkInput("hidden", "entite", "produit");

		$produit = listerStock(); // produits par parcoursRs(recordset mysql)
		$lastProd = valider("lastProd");
		mkSelect("idProd", $produit, "reference", "reference", $lastProd, "nom_prod");
		echo "<div class=\"form-group\">
	  <label for=\"pwd\">Combien : </label></br> <input type=\"number\" class=\"form__field format\" min=\"0\" oninput=\"this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null\" name=\"combien\" value=\"\"></div>";
		mkInput("submit", "action", "Ajouter stock", "", "button-40");


		echo "</br><hr />";
		mkInput("submit", "action", "Disponible", "", "button-40");
		mkInput("submit", "action", "Indisponible", "", "button-40");
		echo ("</br></br>");
		mkInput("submit", "action", "Supprimer le produit","", "button-40","background-color : #cc0000;");
		//	mkInput("submit","action","Retrograder");
		//	mkInput("submit","action","Promouvoir");

		/*			
			$colors = array(); 
			$colors[] = array("nom"=>"rouge", "code"=>"red");
			$colors[] = array("nom"=>"orange", "code"=>"orange");
			$colors[] = array("nom"=>"gris", "code"=>"grey");
			$colors[] = array("nom"=>"bleu", "code"=>"blue");							
			// tprint($colors);					 
			mkSelect("color",$colors,"code","nom");
*/

		//	mkInput("color","color","");
		//mkInput("submit","action","Changer Couleur");

		endForm();
		echo "<hr />";
		mkForm("controleur.php");
		echo "<h2><strong>Nouveau Produit :</strong></h2></br>";
		echo "Nom du produit: </br>";
		mkInput("text", "nomProd", "", ["id" => "textNom"], "form__field format");
		echo "</br>";
		echo "</br>";
		echo "Prix : </br>";
		echo "<input class=\"form__field format\" name=\"Prix\" value=\"\" type=\"number\" step=\"any\" min=0>";
		echo "</br>";
		echo "</br>";
		echo "Stock :</br>";
		echo "<div class=\"form-group\">
		<label for=\"pwd\"></label> <input type=\"number\" class=\"form__field format\" min=\"0\" oninput=\"this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null\" name=\"Quantite\" value=\"\"></div>";
		
		echo "Illustration :</br>";
		echo "<div class=\"form-group bloc\">
		<label for=\"pwd\"></label><input class=\"button-40\" name=\"upload\" value=\"\" type=\"file\" accept=\"image/png, image/jpeg, image/jpg\"></div>";

//style=\"width : 500px; height : 200px; padding-left : 150px; padding-top : 90px

		?>

		<div>
			<label for="prodlist">Catégorie :</label>
			</br>
			<select class="button-40" name="prodlist" id="prodlist">
				<option value="" selected>---Selectionnez une catégorie ---</option>
				<option value="boissons">boissons</option>
				<option value="confiserie">confiserie</option>
				<option value="gateaux">gateaux</option>
				<option value="sandwich">sandwich</option>

				<!-- AJOUTER SI BESOIN -->

			</select>
		</div>

		<div>
			<label for="dispo">Disponible :</label>
			</br>
			<select class="button-40" name="dispo" id="dispo">
				<option value="" selected>--- Situation du produit ---</option>
				<option value="1">Disponible</option>
				<option value="0">Indisponible</option>
			</select>
		</div>

		<?php
		echo "</br>";
		mkInput("submit", "action", "Ajouter Produit", "", "button-40");
		endForm();

		if ($msg) echo $msg;

		if ($msg2) echo $msg2;


		
		
		?>

	<?php
	}}	// fin si user est admin 
	?>

	</p>

	
