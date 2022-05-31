<?php

include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php"); 
require 'pannier.class.php';


if ($msg = valider("msg")) {
	$msg = '<h2 style="color:red;">' . $msg  . "</h2>";
}

if ($msg2 = valider("msg2")) {
	$msg2 = '<h2 style="color:green;">' . $msg2  . "</h2>";
}

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


$panier  = new panier();

if(isset($_GET['id'])){
    echo "</br></br></br></br></br></br></br></br></br></br>";

    $produit = listerPanier('select * from produits where dispo = 1 and reference =:id', array('id' => $_GET['id']) );
    if(empty($produit))
    die("<h1>Ce produit n'est pas disponible et n'a donc pas été ajouté au panier !</h1>");

    $panier->add($produit[0]->reference);
    die("Le produit a bien été ajouté à votre panier <a  style=\"font-size : 18px; color:#334277\" href=\"javascript:history.back()\"> retourner sur le catalogue</a> ou <a  style=\"font-size : 18px; color:#334277\" href=\"index.php?view=paiements\"> allez dans votre panier</strong></a> ");

}else{
    die("<h1>Votre panier est vide !</h1>");
}


}
?>
