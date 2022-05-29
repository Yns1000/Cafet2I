<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&family=Sora:wght@300&display=swap" rel="stylesheet">
<script src="js/tempuser.js"></script>
<link href='css/temp.css' type='text/css' rel='stylesheet' />
<link href="css/accueil.css" rel="stylesheet" />


</br></br></br></br></br></br></br></br>
</br></br></br></br>
</br></br></br></br>





<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php");
require 'pannier.class.php';
// définit mkTable



// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "users.php") {
    header("Location:../index.php?view=users");
    die("");
}

$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";

$total = $_SESSION['panierConfirm']['total'];
$date = $_SESSION['panierConfirm']['date_panier'];
$ID_User = $_SESSION['panierConfirm']['Id_User'];
$NextId = NextID('commandes', 'id_commande');
// Interface de gestion des utilisateurs 
// Cette interface ne doit pas etre offerte aux utilisateurs non connectés


$ids = array_keys($_SESSION['panier']);
if (empty($ids)) {
  $produit = array();
} else {
  $produit = listerPanier('select * from produits where reference IN (' . implode(',', $ids) . ')');
}


if ($msg = valider("msg") && $total != 0) {
    $msg = '<h2 style="color:green;">Félicitation votre paiement est validé !</h2>';
    echo $msg;
    MkCommande($NextId, $ID_User, $total, $date);

    
    if (!empty($ids)) {
        for ($x = 0; $x <= count($produit) - 1; $x++) {
          if (!empty($_SESSION['panier'][$produit[$x]->reference])) {
            AddCom($NextId, $ID_User, $produit[$x]->reference,$_SESSION['panier'][$produit[$x]->reference], $produit[$x]->prix); //Faire appairaitre idProduit, combien et price avec boucle

          }
        }
    }
    

    unset($_SESSION['panier']);
    echo '<a href=\'index.php?view=accueil\'>-> Retournez à l\'accueil</strong></a>';
    //header('Location:'.$urlBase);

}


if ($msg2 = valider("msg2") && $total != 0) {
    $msg2 = '<h2 style="color:red;">Malheureusement votre paiement n\'a pas été validé !</h2>';
    echo $msg2;
    MkCommande($NextId, $ID_User, $total, $date, '0', '0');


//FIXME DOIT ON STOCKER LES PANIERS NON VALIDES ???   
if (!empty($ids)) {
    for ($x = 0; $x <= count($produit) - 1; $x++) {
      if (!empty($_SESSION['panier'][$produit[$x]->reference])) {
        AddCom($NextId, $ID_User, $produit[$x]->reference,$_SESSION['panier'][$produit[$x]->reference], $produit[$x]->prix); //Faire appairaitre idProduit, combien et price avec boucle

      }
    }
}

    echo '<p style=\'font-size : 22px; color: black\'> - Essayez d\'utiliser une autre carte.</br> - Verifiez que vous avez les fonds suffisants.</br> - Vous pouvez aussi contacter votre banque ou le service client de Simplify2I au 0766039074 (service non surtaxé). </p>';
    echo '<a style=\'font-size : 18px; color:black\' href=\'index.php?view=accueil\'>-> Retournez à l\'accueil</strong></a>';
    //header('Location:'.$urlBase);

}


?>