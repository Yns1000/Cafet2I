</br></br></br></br>
<link href='css/temp.css' type='text/css' rel='stylesheet' />
<script src="js/tempuser.js"></script>
<link href="css/accueil.css" rel="stylesheet" />



<style>

</style>





<div class="page-header">
  <h1>Mon panier</h1>
</div>


<?php
if (!valider("connecte", "SESSION")) {
  $_REQUEST["msg"] = "Il faut vous connecter !!";
  include("templates/login.php");
} else {
  include_once("libs/modele.php");
  include_once("libs/maLibUtils.php"); // tprint
  include_once("libs/maLibForms.php");
  require 'pannier.class.php';
  $panier  = new panier();




  $ids = array_keys($_SESSION['panier']);
  if (empty($ids)) {
    $produit = array();
  } else {
    $produit = listerPanier('select * from produits where reference IN (' . implode(',', $ids) . ')');
  }


  $total = 0;
  if (isset($_GET['det'])) {
    $panier->del($_GET['det']);
  }
  echo "<div class=\"container2\">
  <ul class=\"Commandes\">
    <li class=\"titres\">
      <div class=\"colone \" style=\"padding-right : 76px;\"></div>
      <div class=\"colone gen\">Réference</div>
      <div class=\"colone gen\">Nom du produit</div>
      <div class=\"colone gen\">Prix</div>
      <div class=\"colone gen\">Quantité</div>
	  <div class=\"colone gen\">Catégorie</div>
	  <div class=\"colone gen\">Action</div>
     
    </li>";

  $chosen = 0;
  $couleur = 1;
  if (!empty($ids)) {
    for ($x = 0; $x <= count($produit) - 1; $x++) {
      if (!empty($_SESSION['panier'][$produit[$x]->reference])) {
        if ($couleur == 1 && $chosen == 0) {
          echo "<li style=\"color : #fff; background-color : #333333;\" class=\"table-row\">
  <div class=\"blockPhoto imge\"><img class=\"photoprod2\" src=\"";
          echo $produit[$x]->lien_photo;
          echo "\" alt=\"Article mis en vente\"> </img></div>
  <div class=\"colone gen\" data-label=\"Numéro commande\" style=\" padding-top:25px;\">" . $produit[$x]->reference . "</div>
  <div class=\"colone gen\" data-label=\"Prenom\" style=\" padding-top:25px;\">" . $produit[$x]->nom_prod . "</div>
  <div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">" . $produit[$x]->prix . "€</div>
  <div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">";
          if (!empty($_SESSION['panier'][$produit[$x]->reference])) echo $_SESSION['panier'][$produit[$x]->reference];
          echo "</div>
  <div class=\"colone gen\" data-label=\"Promo\" style=\" padding-top:25px;\">"  . $produit[$x]->categorie . "</div>
  <a style=\"text-decoration:none;\" href=\"index.php?view=paiements&det=" . $produit[$x]->reference . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-top:15px; padding-left:13px\"> <div class=\"button-60\">Supprimer articles</div></a>
</div></li>";
          $couleur = 0;
          $chosen = 1;
        }
        if ($couleur == 0 && $chosen == 0) {
          echo "<li style=\"color : #333333; background-color : #fff;\" class=\"table-row\">
  <div class=\"blockPhoto imge\"><img class=\"photoprod2\" src=\"" . $produit[$x]->lien_photo . "\" alt=\"Article mis en vente\"> </img></div>
  <div class=\"colone gen\" data-label=\"Numéro commande\" style=\" padding-top:25px;\">" . $produit[$x]->reference . "</div>
  <div class=\"colone gen\" data-label=\"Prenom\" style=\" padding-top:25px;\">" . $produit[$x]->nom_prod . "</div>
  <div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">" . $produit[$x]->prix . "€</div>
  <div class=\"colone gen\" data-label=\"Nom\" style=\" padding-top:25px;\">";
          if (!empty($_SESSION['panier'][$produit[$x]->reference])) echo $_SESSION['panier'][$produit[$x]->reference];
          echo "</div>
  <div class=\"colone gen\" data-label=\"Promo\" style=\" padding-top:25px;\">"  . $produit[$x]->categorie . "</div>
<a style=\"text-decoration:none;\" href=\"index.php?view=paiements&det=" . $produit[$x]->reference . "\"><div class=\"colone \" data-label=\"Nom du produit\" style=\"right : 0px; padding-top:15px; padding-left:13px\"> <div class=\"button-60\">Supprimer articles</div></a>
</div></li>";
          $couleur = 1;
          $chosen = 1;
        }
        $chosen = 0;
        if (!empty($_SESSION['panier'][$produit[$x]->reference]))
          $total += $produit[$x]->prix * $_SESSION['panier'][$produit[$x]->reference];
      }
    }
  }
  echo "</ul><div class=\"button-50 droite\"> Total : $total €</div>";

  // tprint($_SESSION['panier']); TODO RETURN PANIER POUR ENREGISTRER LES PRODUITS SUR DBD
  //tprint($produit);
  //tprint(json_encode($produit));


  //C'est la propriété php_self qui nous l'indique : 
  // Quand on vient de index : 
  // [PHP_SELF] => /chatISIG/index.php 
  // Quand on vient directement par le répertoire templates
  // [PHP_SELF] => /chatISIG/templates/accueil.php

  // Si la page est appelée directement par son adresse, on redirige en passant pas la page index
  // Pas de soucis de bufferisation, puisque c'est dans le cas où on appelle directement la page sans son contexte

  /*
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php?view=accueil");
	die("");
} */

  // définit mkTable

?>




  <div id="yih">


    <!-- PANIER -->





    <?php
    mkForm('controleur.php');

    //Infos du panier
    $NextId = NextID('commandes', 'id_commande'); // Le prochain ID du panier
    echo '</br>';
    $ID_User =  $_SESSION['idUser'];
    echo '</br>';
    $total;
    echo '</br>';
    $date = date('Y-m-d');
    echo '</br>';
    if (empty($_SESSION['panier']['ID_Panier'])) {
      $_SESSION['panierConfirm']['total'] = $total;
      $_SESSION['panierConfirm']['date_panier'] = $date;
      $_SESSION['panierConfirm']['Id_User'] = $ID_User;
      $_SESSION['panierConfirm']['ID_Panier'] = $NextId;
    }




    //tprint($_SESSION); TEST
    ?>



    <div id="paypal-button-container"></div>

    <script src="https://www.paypal.com/sdk/js?client-id=Ae_4Ntm-HUjAR3cV-G6nSwf8xPpD7U7P5MaVRjBoeH8pb-n0xJP-hOAUZJakbt6goQ7jFUV6QfiXecWf&currency=EUR"></script>
    <script>
      var total = '<?php echo $total; ?>';
      var IdUser = '<?php echo $ID_User; ?>';
      var NexID = '<?php echo $NextId; ?>';
      var date = '<?php echo $date; ?>';
      var valid = 0;
      paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: total // TODO REMPLACER PAR TOTAL DES ARTICLES 
              }
            }]
          });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {


          return actions.order.capture().then(function(orderData) {

            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            // valid = 1;
            //FIXME TEST TRANSAC alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
            actions.redirect('http://localhost/Cafet2I/index.php?view=validOrder&msg=Paiement+valide');

          });

        },
        onCancel: function(data, actions) {
          actions.redirect('http://localhost/Cafet2I/index.php?view=validOrder&msg2=Paiement+non+valide');

        }
      }).render('#paypal-button-container');

      /* if (valid == 1){
       }*/
    </script>
  </div>
<?php
  /*
	mkForm("controleur.php"); 
	mkInput("password","passe","",["id"=>"textChangerPassword","label"=>"Nouveau mot de passe : "]); 
	mkInput("submit","action","Changer Password");
	endForm(); 

    */
}

?>