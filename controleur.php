<?php
session_start();

	include_once "libs/maLibUtils.php";	
	include_once "libs/modele.php"; 
	include_once "libs/maLibSecurisation.php"; 
	// cf. injection de dépendances 


	$qs = "";
	$dataQS = array(); 
	
	// voir les entetes HTTP venant du client : 
	// tprint($_SERVER);
	// die("");

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				if ($login = valider("login"))
				if ($passe = valider("passe"))
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (verifUser($login,$passe)) {
						// tout s'est bien passé, doit-on se souvenir de la personne ? 
						if (valider("remember")) {
							setcookie("login",$login , time()+60*60*24*30);
							setcookie("passe",$password, time()+60*60*24*30);
							setcookie("remember",true, time()+60*60*24*30);
						} else {
							setcookie("login","", time()-3600);
							setcookie("passe","", time()-3600);
							setcookie("remember",false, time()-3600);
						}
					}
				}

				// On redirigera vers la page index automatiquement
			break;
				
			case 'Inscription' : //TODO
				// On verifie la presence des champs login et passe
				if ($prenom = valider("prenom"))
				if ($nom = valider("nom"))
				if ($promo = valider("promos"))
				if ($login = valider("login2"))
				if ($tel = valider("tel"))
				if ($passe = valider("passe2"))
				if ($passe2 = valider("confpasse2"))
				if (strcmp($passe,$passe2)==0)
				{
					// On verifie l'utilisateur, 
					// et on crée des variables de session si tout est OK
					// Cf. maLibSecurisation
					if (!verifUser($login,$passe)) {
						// tout s'est bien passé, doit-on se souvenir de la personne ? 
						mkUser($login,$passe,$promo,$nom,$prenom,$tel);

						$qs = "?view=login&msg=" .urlencode("Votre compte a été crée avec succés, veuillez vous connecter."); 
					}
				}
				if (strcmp($passe,$passe2)!==0)
				$qs = "?view=login&msg=" .urlencode("Les mots de passe saisis ne concordent pas."); 
				if ($prenom = !valider("prenom"))
				$qs = "?view=login&msg=" .urlencode("Veuillez inserrer un prenom."); 




				// On redirigera vers la page index automatiquement
			break;

			case 'Logout' :
			case 'logout' :
				// traitement métier
				session_destroy(); // 1) traitement 
				// 2) choisir la vue suivante 
				$qs = "?view=login";
			break;
			
			case 'Promouvoir' : 				
				// Produire un code générique capable de traiter des QS
				// ?idUser=3
				// ET aussi ?idUSer[]=3
				// => tester la nature de la variable idUser 
				if ($idUser = valider("idUser"))
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						promouvoirAdmin($nextIdUser); 
					}
				}  
				else {
					promouvoirAdmin($idUser); 
				}
				
				// 2) choisir la vue suivante en lui passant les paramètres nécessaires 
				$qs = "?view=users&lastIdUser=$idUser"; 
			break;
			
			case 'Changer couleur' :
			case 'changer Couleur' :
			case 'Changer Couleur' :
			case 'changer couleur' :				 
				if ($idUser = valider("idUser"))
				if ($color = valider("color")) 
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idUser)) {
					// NB : le client a envoyé une chaine de requete structurée 
					// avec des crochets pour les clés 'idUser[]'
					// => $_GET["idUser"] est maintenant un tableau 
					foreach($idUser as $nextIdUser) {
						changerCouleur($nextIdUser,$color); 
					}
				}  
				else {
					changerCouleur($idUser,$color);  
				}

				$qs = "?view=users&lastIdUser=$idUser";
			break; 
			

			
			case 'Retrograder' : 				
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT 
				if ($idUser = valider("idUser"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						retrograderUser($nextIdUser); 
					}
				} else {
					retrograderUser($idUser); 
				}
				
				// 2) choisir la vue suivante en lui passant les paramètres nécessaires 
				$qs = "?view=users&lastIdUser=$idUser"; 
			break;	
			

			case 'Autoriser' : 				
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($idUser = valider("idUser"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						autoriserUtilisateur($nextIdUser); 
					}
				} else {
					autoriserUtilisateur($idUser); 
				}
				
				// 2) choisir la vue suivante en lui passant les paramètres nécessaires 
				$qs = "?view=users&lastIdUser=$idUser"; 
			break;

			case 'Valider la commande' : 				
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($idCom = valider("idCom"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idCom)) {
					foreach($idCom as $nextIdCom) {
						StatutCommande($nextIdCom, 1); 
					}
				} else {
					StatutCommande($idCom,1); 
				}
				
				// 2) choisir la vue suivante en lui passant les paramètres nécessaires 
				$qs = "?view=users&lastIdCom=$idUser"; 
			break;

			case 'Valider livraison' : 				
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($idCom = valider("idCom"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idCom)) {
					foreach($idCom as $nextIdCom) {
						StatutLivraison($nextIdCom, 1); 
					}
				} else {
					StatutLivraison($idCom,1); 
				}
				
				// 2) choisir la vue suivante en lui passant les paramètres nécessaires 
				$qs = "?view=users&lastIdCom=$idUser"; 
			break;

			case 'Interdire' :  
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($idUser = valider("idUser"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idUser)) {
					foreach($idUser as $nextIdUser) {
						interdireUtilisateur($nextIdUser); 
					}
				} else {
					interdireUtilisateur($idUser); 
				}
				
				$qs = "?view=users&lastIdUser=$idUser"; 
				
			break; 

			case 'Annuler la commande' : 				
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($idCom = valider("idCom"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idCom)) {
					foreach($idCom as $nextIdCom) {
						StatutCommande($nextIdCom, 0); 
						StatutLivraison($nextIdCom,0); 

					}
				} else {
					StatutCommande($idCom,0); 
					StatutLivraison($idCom,0); 

				}
				
				// 2) choisir la vue suivante en lui passant les paramètres nécessaires 
				$qs = "?view=users&lastIdCom=$idUser"; 
			break;

			case 'Disponible' :  
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($idProd = valider("idProd"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idProd)) {
					foreach($idProd as $nextIdProd) {
						dispo($nextIdProd,1); 
					}
				} else {
					dispo($idProd, 1); 
				}
				
				$qs = "?view=users&lastProd=$idProd";
				
			break; 
			case 'Indisponible' :  
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($idProd = valider("idProd"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) 
				if (is_array($idProd)) {
					foreach($idProd as $nextIdProd) {
						dispo($nextIdProd,0); 
					}
				} else {
					dispo($idProd, 0); 
				}
				
				$qs = "?view=users&lastProd=$idProd"; 
				
			break; 
			
						
			case 'Supprimer' :
			// ON doit gérer la suppression d'un utilisateur ou d'une conversation 
			if ($entite = valider("entite")) {
				switch($entite) {
					case "users" : 
						if ($idUser = valider("idUser"))  
						if (valider("connecte","SESSION"))
						if (isAdmin($_SESSION["idUser"]))
						if (is_array($idUser)) {
							foreach($idUser as $nextIdUser) {
								supprimerUser($nextIdUser); 
							}
						} else {
							supprimerUser($idUser) ; 
						}
						$qs = "?view=users";
					
					break;
					
					case "conversations" : 
						if ($idConv = valider("idConv"))  
						if (valider("connecte","SESSION"))
						if (isAdmin($_SESSION["idUser"])){
							supprimerConversation($idConv) ;
						}
						$qs = "?view=conversations";
				}	
			}		
			break; 

			case 'Supprimer le produit' :
				// ON doit gérer la suppression d'un produit 
					
							if ($idProd = valider("idProd"))  
							if (valider("connecte","SESSION"))
							if (isAdmin($_SESSION["idUser"]))
							if (is_array($idProd)) {
								foreach($idProd as $nextIdProd) {
									supprimerProd($nextIdProd); 
								}
							} else {
								supprimerProd($idProd) ; 
							}
							$qs = "?view=users";
						
				break; 

				case 'Supprimer la commande' :
					// ON doit gérer la suppression d'un produit 
						
								if ($idCom = valider("idCom"))  
								if (valider("connecte","SESSION"))
								if (isAdmin($_SESSION["idUser"]))
								if (is_array($idCom)) {
									foreach($idCom as $nextIdCom) {
										supprimerCommande($nextIdCom); 
									}
								} else {
									supprimerCommande($idCom) ; 
								}
								$qs = "?view=users";
							
					break; 
			
			case 'Changer Password' : 
				$qs = "?view=compte";
				if ($passe = valider("passe"))
				if (valider("connecte","SESSION")) {
					changerPasse($_SESSION["idUser"],$passe);
					session_destroy();
					$qs = "?view=login&msg=" .urlencode("Mot de passe modifié, il faut vous reconnecter"); 
				}
				
				 
			
			break; 

			case 'Changer Pseudo' : 
				$qs = "?view=compte";
				if ($pseudo = valider("pseudo"))
				if (valider("connecte","SESSION")) {
					changerPseudo($_SESSION["idUser"],$pseudo);
					session_destroy();
					$qs = "?view=login&msg=" .urlencode("Pseudo modifié, il faut vous reconnecter"); 
				}
				
			
			break;

			case 'Accepter modifications': ///////////////////////TODO
				$qs = "?view=compte";
				if (($pseudo = valider("pseudo")) || ($passe = valider("passe")))
					$pseudo = valider("pseudo");
				$passe = valider("passe");
				if (valider("connecte", "SESSION")) {
					changerInfo($_SESSION["idUser"], $pseudo, $passe);
					session_destroy();
					$qs = "?view=login&msg=" . urlencode("Modifications sauvegardées, il faut vous reconnecter");
	
					//TODO	changerInfo($_SESSION["idUser"], $pseudo, $passe);
	
	
				}
				break;
	
			case 'Choix promo':
				// 1) réaliser l'opération demandée 
				// NEVER TRUST USER INPUT   
				if ($promo = valider("promos"))
					if (valider("connecte", "SESSION"))
					ChangePromo($_SESSION["idUser"], $promo);
				// 2) choisir la vue suivante en lui passant les paramètres nécessaires 
				$qs = "?view=compte";
	
	
				break;

			case 'Creer Utilisateur' : 
				$lastIdUser	= 0; 			
				if ($pseudo = valider("pseudo"))
				if ($passe = valider("passe"))  
				if ($tel = valider("tel"))  
				if ($prenom = valider("prenom"))
				if ($nom = valider("nom"))
				if ($promo = valider("promos"))
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"])) {
					if(valider("admin")){
					$admin=1;
					$lastIdUser = mkUser($pseudo, $passe,$promo,$nom,$prenom,$tel,$admin); 
					}
					else
					$lastIdUser = mkUser($pseudo, $passe,$promo,$nom,$prenom,$tel); 

				}
				
				$qs = "?view=users&lastIdUser=$lastIdUser"; 
			break;	
			
			case 'Ajouter Produit' : 
				$fileSize = $_FILES['upload']['size'];
				$file = $_FILES['upload']['name'];
				$tmp = $_FILES['upload']['tmp_name'];
				$dest = $_SERVER['DOCUMENT_ROOT']."/ressources/Produits/".$file;

				//echo $file;
				//tprint($_FILES);
				//die;
				$lastIdProd	= 0; 			
				if ($nomProd = valider("nomProd"))
				if ($Prix = valider("Prix"))  
				if ($Quantite = valider("Quantite"))
				if (valider("connecte","SESSION"))
				if($fileSize < 1000000)
				if (isAdmin($_SESSION["idUser"]))
				if ($categ = valider("prodlist"))
				if ($dispo = valider("dispo")) {
				if($fileSize < 1000000)
				$lastIdProd = mkProd($nomProd, $Prix,$Quantite,$dispo, "ressources/Produits/".$file, $categ); 
				}
				else{
					if($fileSize < 1000000)
				$lastIdProd = mkProd($nomProd, $Prix,$Quantite,0, "ressources/Produits/".$file, $categ); 
				}


					
				if($_FILES['upload']['error'] > 0){
				echo "Une erreur est survenue lors du transfert."; 
				}
					


				if($fileSize > 1000000){
					$qs = "?view=users&msg=" .urlencode("Le fichier est trop gros !"); 
					break;
				}	


				$resultat = move_uploaded_file($tmp, "ressources/Produits/".$file);

				

				if($resultat){
					$qs = "?view=users&msg2=" .urlencode("Transfert validé"); 
					break;

				}
				


				$qs = "?view=users&lastProd=$resultat"; 
			break;	





			case 'Ajouter stock' : 
				$lastIdProd	= 0; 			
				if ($idProd = valider("idProd"))
				if ($nb = valider("combien"))  
				if (valider("connecte","SESSION"))
				if (isAdmin($_SESSION["idUser"]))
				{	
					$tmp = combienStockInd($idProd);	
					$nb = $nb + $tmp;	
				$lastIdProd = AddStock($idProd, $nb);
				}
				
				
				$qs = "?view=users&lastProd=$lastIdProd"; 
			break;	

			// Gestion des conversations 
			
			case 'Activer' :
			if ($idConv = valider("idConv"))  
			if (valider("connecte","SESSION"))
			if (isAdmin($_SESSION["idUser"]))
			{
				reactiverConversation($idConv);
			}
			// On veut envoyer l'identifiant de la conversation manipulée à la vue 
			// pour que cette conversation soit automatiquement sélectionnée 
			// dans le menu déroulant
			// Sol 1 : on renvoie l'id sous forme de QS dans l'URL de redirection
			// Sol 2 : on pourrait sauvegarder l'identifiant 
			// dans une variable de session créée dans le controleur 
			// et relue dans la vue conversation
			// Ce n'est pas une bonne pratique : on sauvegarde dans les variables 
			// de session des données pérennes 
			$qs = "?view=conversations&idConv=$idConv";
			break; 
			
			case 'Archiver' :
			if ($idConv = valider("idConv"))  
			if (valider("connecte","SESSION"))
			if (isAdmin($_SESSION["idUser"])){
				archiverConversation($idConv);
			}  
			$qs = "?view=conversations&idConv=$idConv";
			break; 

			
			case 'Ajouter Conversation' :  
			$idConv = false;
			if ($theme = valider("theme"))  
			if (valider("connecte","SESSION"))
			if (isAdmin($_SESSION["idUser"])){
					$idConv = creerConversation($theme) ;
			}
			$qs = "?view=conversations&idConv=$idConv";
			break; 
			
			case 'Poster' : 		
			
			// Données reçues : contenu=... & idConv...
			// Un message ne peut être posté que par un utilisateur NON blacklisté 
			// ET dans une conversation active 	 
			if ($idConv = valider("idConv")) 
			if ($contenu = valider("contenu"))
			if (valider("connecte","SESSION"))
			if (! valider("isBlacklisted","SESSION")) {
				$dataConv = getConversation($idConv);
				if (count($dataConv) > 0)
				if ($dataConv["active"]) {
					enregistrerMessage($idConv, valider("idUser","SESSION"), $contenu);
				}
			}
			$qs = "?view=chat&idConv=$idConv";
			break;


		}

	}

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments
	
	if ($qs == "") {
		// On renvoie vers la page précédente en se servant de HTTP_REFERER
		// attention : il peut y avoir des champs en + de view...
		$qs = parse_url($_SERVER["HTTP_REFERER"]. "&cle=val", PHP_URL_QUERY);
		$tabQS = explode('&', $qs);
		array_map('parseDataQS', $tabQS);
		$qs = "?view=" . $dataQS["view"];
	}

	header("Location:" . $urlBase . $qs);

	// On écrit seulement après cette entête
	ob_end_flush();


	function parseDataQS($qs) {
		global $dataQS; 
		$t = explode('=',$qs);
		$dataQS[$t[0]]=$t[1]; 
	}
	
?>










