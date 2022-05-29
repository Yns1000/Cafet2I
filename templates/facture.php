</br></br></br></br>
<link href='css/temp.css' type='text/css' rel='stylesheet' />
<script src="js/tempuser.js"></script>
<link href="css/accueil.css" rel="stylesheet" />



<style>

</style>





"


<?php
if (!valider("connecte", "SESSION")) {
    $_REQUEST["msg"] = "Il faut vous connecter !!";
    include("templates/login.php");
} else {
    include_once("libs/modele.php");
    include_once("libs/maLibUtils.php"); // tprint
    include_once("libs/maLibForms.php");

    if (isset($_GET['idCom'])) {
        $commande  = $_GET['idCom'];
        $Utilisateur = $_SESSION["idUser"];

        $SQL = "SELECT commandes.id_commande, commandes.id_client, commandes.valide, commandes.date_commande, commandes.montant ,produits.nom_prod, produits.prix, panier.quantite, produits.lien_photo
    FROM commandes
    JOIN panier
    ON commandes.id_commande = panier.id_panier
    JOIN produits 
    ON panier.id_produit = produits.reference
    WHERE panier.id_panier = '$commande' AND commandes.id_client = '$Utilisateur'";

        $produit = parcoursRs(SQLSelect($SQL));

        echo "<div class=\"page-header\">
        <h1>Détail de la commande n° ". $produit[0]['id_commande']." réalisé à cette date : ". $produit[0]['date_commande']."</h1>
    </div></hr>";

    $total = $produit[0]['montant'];

if( $produit[0]['valide'] == 0){
    echo "<h2><strong>Commande annulée</strong></h2>";
}
else{
    echo "<h2><strong>Commande validée</strong></h2>";
}


        echo "<div class=\"container2\">
    <ul class=\"Commandes\">
      <li class=\"titres\">
        <div class=\"colone \" style=\"padding-right : 76px;\"></div>
        <div class=\"colone gen\">Nom du produit</div>
        <div class=\"colone gen\">Prix</div>
        <div class=\"colone gen\">Quantité</div>
     
       
      </li>";

      $chosen = 0;
      $couleur = 1;
        for ($x = 0; $x <= count($produit) - 1; $x++) {
			if ($couleur == 1 && $chosen == 0) {
                echo "<li style=\"color : #fff; background-color : #333333 ;\" class=\"table-row\">
    <div class=\"blockPhoto imge\"><img class=\"photoprod2\" src=\"";
                echo $produit[$x]['lien_photo'];
                echo "\" alt=\"Article mis en vente\"> </img></div>
    <div class=\"colone gen\" data-label=\"Prenom\" style=\" padding-top:25px;\">" . $produit[$x]['nom_prod'] . "</div>
    <div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">" . $produit[$x]['prix'] . "</div>
    <div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">" . $produit[$x]['quantite'] . "</div>
    </li>";
                $couleur = 0;
                $chosen = 1;
            }
            if ($couleur == 0 && $chosen == 0) {
                echo "<li style=\"color : #333333; background-color : #fff;\" class=\"table-row\">
    <div class=\"blockPhoto imge\"><img class=\"photoprod2\" src=\"" . $produit[$x]['lien_photo'] . "\" alt=\"Article mis en vente\"> </img></div>
<div class=\"colone gen\" data-label=\"Prenom\" style=\" padding-top:25px;\">" . $produit[$x]['nom_prod'] . "</div>
<div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">" . $produit[$x]['prix'] . "</div>
<div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">" . $produit[$x]['quantite'] . "</div>
</li>";
                $couleur = 1;
                $chosen = 1;
            }
            $chosen = 0;
        }








       
        echo "  </ul><div class=\"button-50 droite\"> Total : $total €</div>
	</div>";
        echo "</div>";
    }
}
