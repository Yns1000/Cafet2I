<link href='css/temp.css' type='text/css' rel='stylesheet' />
<?php
require 'pannier.class.php';
$pannier = new panier();
//C'est la propriété php_self qui nous l'indique : 
// Quand on vient de index : 
// [PHP_SELF] => /chatISIG/index.php 
// Quand on vient directement par le répertoire templates
// [PHP_SELF] => /chatISIG/templates/accueil.php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
// Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

?>

</br></br></br></br>
    <div class="page-header">
      <h1>Bienvenu sur le site de commande de la caféteria de l'IG2I !</h1>
    </div>

    <h3>Veuillez choisir vos articles ! </h3>

</br>










<?php
$page = null;
if(isset($_POST['tri'])){
    $page = $_POST['tri'];
}
switch($page){
    case 'page1': $stock = listerStock("", "reference DESC"); break;
    case 'page2': $stock = listerStock("","reference ASC"); break;
    case 'page3': $stock = listerStock("","prix ASC"); break;
    case 'page4': $stock = listerStock("","prix DESC"); break;
    default: 	$stock = listerStock(); break;
}
?>

    <div>
			<label for="tri">Trier</label>
			</br>
      <form name="myform" action="" method="post">
			<select class="form__field format" name="tri" id="promo" onchange="this.form.submit()">
				<option value="" selected>--- Trier ---</option>
				<option value="page1">Ajouts récents</option>
        <option value="page2">Ajouts anciens</option>
				<option value="page3">Prix croissant</option>
        <option value="page4">Prix décroissant</option>
			</select>
		</div>




    <?php
$page_filtre = null;
if(isset($_POST['filtre'])){
    $page_filtre = $_POST['filtre'];
}
switch($page_filtre){
    case 'filtre_page1': $stock = listerStock("where categorie = \"boissons\"", "reference DESC"); break;
    case 'filtre_page2': $stock = listerStock("where categorie = \"confiserie\"","reference ASC"); break;
    case 'filtre_page3': $stock = listerStock("where dispo = 1",""); break;
}
?>

    <div >
			<label for="filtre">Filtrer</label>
			</br>
      <form name="myform" action="" method="post">
			<select class="form__field format" name="filtre" id="promo" onchange="this.form.submit()">
				<option value="" selected>--- Filtre ---</option>
				<option value="filtre_page1">Boissons</option>
        <option value="filtre_page2">Confiseries</option>
        <option value="filtre_page3">Disponibles</option>
			</select>
		</div>




    <style>
    /* Cellules */

 









  </style>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<div class="tttt">

<?php


//	$stock = listerStock("","prix ASC");
//	$stock = listerStock("","prix DESC");
//  $stock = listerStock(" where categorie = \"boissons\"","prix ASC");
//  $stock = listerStock(" where categorie = \"confiserie\"","prix ASC");
//  $stock = listerStock(" where categorie = \"confiserie\"","prix DESC");
//  $stock = listerStock(" where categorie = \"boissons\"","prix DESC");





	for ($x = 0; $x <= count($stock)-1; $x++) {


        echo "<div class=\"articles\">
        <div class=\"blockPhoto\">
        <img class=\"photoprod\" src=\"" . $stock[$x]["lien_photo"] . "\" alt=\"Article mis en vente\"> </img></div>
        <div class=\"nomProd\"><h3>". $stock[$x]["nom_prod"] ."</h3><h2 class=\"prixProd\">". $stock[$x]["prix"] ." € </h2><a href=\"index.php?view=addpanier&id=". $stock[$x]["reference"] ."\" class=\"panier\">Au Panier</a></div></div>";

    }
?>
  
  </div>
















