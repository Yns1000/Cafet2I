<link href='css/temp.css' type='text/css' rel='stylesheet' />
<script src="js/tempuser.js"></script>
<link href="css/accueil.css" rel="stylesheet" />

<style>

#mdp{
	display: none;
}

#commande{
	display: none;
}

#pseudo{
	display: none;
}

</style>
<script>
	function affinfo(a,b,c) {

    if (a.style.display === "none") {
        a.style.display = "block";
        b.style.display = "none";
        c.style.display = "none";
    }
	else {
        a.style.display = "block";
        b.style.display = "none";
        c.style.display = "none";

    }
    }
</script>

</br></br></br></br>

<?php

//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php") {
	header("Location:../index.php?view=accueil");
	die("");
}


include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php");
// définit mkTable
if (!valider("connecte","SESSION")) {
	// header("Location:?view=login&msg=" . urlencode("Il faut vous connecter !!")); 
	// déclenche une erreur headers already sent 
	// car les entetes HTTP de réponse ont déjà envoyées
	// car la page header envoie un résultat HTML au client 
	// ET que le serveur ne bufferise pas 
	
	// On choisit de charger la vue de login 
	$_REQUEST["msg"] = "Il faut vous connecter !!"; 
	include("templates/login.php");
} else {
?>



<div class="page-header">
	<h1>Mon Compte</h1>
</div>

<p class="lead">


	<?php
	//TODO changer pseudo


	mkForm("controleur.php");
	echo "</br> </br> </br> </br><ul><li class=\"active\"> <a onclick=\"affinfo(mdp,pseudo,commande);\"  href=\"#\">Modifier votre mot de passe</a></li></ul>";
	echo "<ul><li class=\"active\"> <a onclick=\"affinfo(pseudo,commande,mdp);\" href=\"#\">Modifier votre pseudo</a></li></ul>";
	echo "<ul><li class=\"active\"> <a onclick=\"affinfo(commande,mdp,pseudo);\" href=\"#\">Voir mon historique de commande</a></li></ul>";

	echo "<div id=\"mdp\">";
	
	mkInput("password", "passe", "", ["id" => "textChangerPassword", "label" => "Ancien mot de passe : "],"form__field");
	echo "</br>";
	mkInput("password", "passe", "", ["id" => "textChangerPassword", "label" => "Nouveau mot de passe : "],"form__field");
	mkInput("submit", "action", "Accepter modifications","","button-40");
	echo "</div>";

	echo "<div id=\"pseudo\">";
	mkInput("pseudo", "pseudo", "", ["id" => "textChangerPseudo", "label" => "Nouveau pseudo : "],"form__field");
	mkInput("submit", "action", "Accepter modifications","","button-40");
	echo "</div>";

$Utilisateur = $_SESSION["idUser"];

	$SQL = "SELECT users.id, users.nom, users.prenom, users.promo, commandes.id_commande,commandes.montant,commandes.valide,commandes.livraison
	FROM `users`
	JOIN commandes
	ON users.id = commandes.id_client
	WHERE users.id = $Utilisateur";

	$stock = parcoursRs(SQLSelect($SQL));


	echo "<div id=\"commande\">
  <ul class=\"Commandes\">
    <li class=\"titres\">
      <div class=\"colone gen\">Numéro commande</div>
	  <div class=\"colone gen\">Montant (€)</div>
      <div class=\"colone gen\">Statut du paiment</div>
	  <div class=\"colone gen\">Détail</div>

    </li>";

	for ($x = 0; $x <= count($stock) - 1; $x++) {

		if (($stock[$x]["valide"] == 1) && ($stock[$x]["livraison"] == 1))
			echo "<li style=\"color : #fff; background-color : #26619c;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numéro commande\">" . $stock[$x]["id_commande"] . "</div>
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut commande\">Ancienne commande finalisée</div>
	  <a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-right:65px; padding-left:55px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838;  margin:0;\">Voir plus d'info</div></a>
	  </div></li>";

		if (($stock[$x]["valide"] == 1) && ($stock[$x]["livraison"] == 0))
			echo "<li style=\"color : #fff; background-color : #2e8b57;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numéro commande\">" . $stock[$x]["id_commande"] . "</div>
     
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut commande\">Commande en attente de livraison</div>
	  <a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-right:65px; padding-left:55px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838; color:#fff; margin:0;\">Voir plus d'info</div></a>
	  </div></li>";

		if (($stock[$x]["valide"] == 0) && ($stock[$x]["livraison"] == 0))
			echo "<li style=\"color : #fff; background-color : #b22222;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numéro commande\">" . $stock[$x]["id_commande"] . "</div>
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut du paiment\">Commande annulée</div>
	  
	<a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-right:65px; padding-left:55px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838; color:#fff; margin:0;\">Voir plus d'info</div></a>
	</div></li>";

		if (($stock[$x]["valide"] == 0) && ($stock[$x]["livraison"] == 1))
			echo "<li style=\"color : #fff; background-color : #b22222;\" class=\"table-row\">
      <div class=\"colone gen\" data-label=\"Numero Commande\">" . $stock[$x]["id_commande"] . "</div>
     
	  <div class=\"colone gen\" data-label=\"Montant\">"  . $stock[$x]["montant"] . "</div>
	  <div class=\"colone gen\" data-label=\"Statut commande\">Commande annulée</div>
	  <a href=\"index.php?view=facture&idCom=" . $stock[$x]["id_commande"] . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-right:65px; padding-left:55px; margin:0;\" > <div class=\"button-60\" style=\"background-color : #383838; color:#fff; margin:0;\">Voir plus d'info</div></a>
	  </div></li>";
	}

	echo "  </ul>
	</div>";
	echo "</div>";
	

	echo "</br>";
	echo "</br>";
	echo "</br>";

	endForm();

	$Promo = array(
		0 => 'LE1',
		1 => 'LE2',
		2 => 'LE3',
		3 => 'LE4',
		4 => 'LE5'
	);





	?>
	<?php
			mkForm("controleur.php");
	?>
    

</p>

<?php
} // Fin si user non connecté
?>

<!--<div>
        <label for="promo">Votre promo :</label>
        <select name="promos" id="promo">
            <option value="" selected>--- Choisissez votre Promo ---</option>
            <option value="LE1">LE1</option>
            <option value="LE2">LE2</option>
            <option value="LE3">LE3</option>
			<option value="LE4">LE4</option>
            <option value="LE5">LE5</option>
        </select>
    </div>
    <div>
		<?php
			/*mkInput("submit", "action", "Changer promo");
		
		?>
    </div>
	<?php
			endForm();*/
	?>