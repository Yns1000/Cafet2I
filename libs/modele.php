<?php

/*
Dans ce fichier, on définit diverses fonctions permettant de récupérer des données utiles pour notre TP d'identification. Deux parties sont à compléter, en suivant les indications données dans le support de TP
*/


/********* PARTIE 1 : prise en main de la base de données *********/


// inclure ici la librairie faciliant les requêtes SQL
include_once("maLibSQL.pdo.php");

function listerPanier($sql, $data = array())
{
	global $BDD_host;
	global $BDD_base;
 	global $BDD_user;
 	global $BDD_password;

	$dbh = new PDO("mysql:host=$BDD_host;dbname=$BDD_base", $BDD_user, $BDD_password);
	$req = $dbh->prepare($sql);
	$req->execute($data);
	


	return $req->fetchAll(PDO::FETCH_OBJ);

}


function listerUtilisateurs($classe = "both")
{
	// NB : la présence du symbole '=' indique la valeur par défaut du paramètre s'il n'est pas fourni
	// Cette fonction liste les utilisateurs de la base de données 
	// et renvoie un tableau d'enregistrements. 
	// Chaque enregistrement est un tableau associatif contenant les champs 
	// id,pseudo,blacklist,connecte,couleur

	// Lorsque la variable $classe vaut "both", elle renvoie tous les utilisateurs
	// Lorsqu'elle vaut "bl", elle ne renvoie que les utilisateurs blacklistés
	// Lorsqu'elle vaut "nbl", elle ne renvoie que les utilisateurs non blacklistés

	$SQL = "select * from users";
	if ($classe == "bl")
		$SQL .= " where blacklist=1";
	if ($classe == "nbl")
		$SQL .= " where blacklist=0";
	
	// echo $SQL;
	return parcoursRs(SQLSelect($SQL));

}

function listerStock($categ="", $mode="")
{

	//Trier par categorie / Trier par prix nom,prix...

	$SQL = "select * from produits ";

	if(!empty($categ))
	$SQL .= $categ;

	if(!empty($mode))
	$SQL .= " order by ".$mode;


	return parcoursRs(SQLSelect($SQL));

}

function listerCommande()
{
	$SQL = "SELECT users.id, users.nom, users.prenom, users.promo, commandes.id_commande,commandes.montant,commandes.valide,commandes.livraison
	FROM `users`
	JOIN commandes
	ON users.id = commandes.id_client";

	return parcoursRs(SQLSelect($SQL));

}

function dispo($idProd, $disp)
{
	// cette fonction affecte le int "dispo" à 1(oui) ou 0(non)
	$SQL = "UPDATE produits";

	if($disp == "1")
	$SQL .= " SET dispo=1";
	else if($disp == "0")
	$SQL .= " SET dispo=0";

	$SQL .=" WHERE reference='$idProd'";
	
	SQLUpdate($SQL);
}

function combienStockInd($idProd)
{
	//On recupere le stock ancien pour l'aditionner
	$SQL = "SELECT quantite
	FROM `produits`
	WHERE reference='$idProd'";
	$stock = parcoursRs(SQLSelect($SQL));
	return	$stock[0]["quantite"];

}
function AddStock($idProd, $nb)
{
	// cette fonction ajout du stock
	$SQL = "UPDATE produits";

	$SQL .= " SET quantite=$nb";

	$SQL .=" WHERE reference='$idProd'";
	
	SQLUpdate($SQL);
}

function MkCommande($idCom,$idClient, $montant ,$date,$valide=1, $livraison=0){

$SQL= "INSERT INTO commandes(id_commande, id_client, montant,valide,livraison,date_commande) VALUES('$idCom','$idClient', '$montant','$valide','$livraison','$date')"; 
	return SQLInsert($SQL); 
}





function AddCom($idPanier, $idClient, $idProduit, $combien, $price){

	$SQL= "INSERT INTO panier(id_panier, id_client, id_produit,quantite,prix) VALUES('$idPanier','$idClient', '$idProduit', '$combien','$price')"; 
		return SQLInsert($SQL); 
	}

function valideCommande($idCommande, $statut)
{
	// cette fonction change le statut de validation de la commande  
	if($statut==1)
	$SQL = "UPDATE commandes SET valide=1 WHERE id_commande='$idCommande'";
	else if($statut==0)
	$SQL = "UPDATE commandes SET valide=0 WHERE id_commande='$idCommande'";
	
	SQLUpdate($SQL);
}


function StatutCommande($idCommande, $statut)
{
	// cette fonction change le statut de validation de la commande  
	if($statut==1)
	$SQL = "UPDATE commandes SET valide=1 WHERE id_commande='$idCommande'";
	else if($statut==0)
	$SQL = "UPDATE commandes SET valide=0 WHERE id_commande='$idCommande'";
	
	SQLUpdate($SQL);
}

function StatutLivraison($idCommande, $statut)
{
	// cette fonction change le statut de validation de la commande  
	

	
	if($statut==1)
	$SQL = "UPDATE commandes SET livraison=1 WHERE id_commande='$idCommande'";
	else if($statut==0)
	$SQL = "UPDATE commandes SET livraison=0 WHERE id_commande='$idCommande'";
	
	SQLUpdate($SQL);
}

function interdireUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à vrai
	$SQL = "UPDATE users SET blacklist=1 WHERE id='$idUser'";
	// les apostrophes font partie de la sécurité !! 
	// Il faut utiliser addslashes lors de la récupération 
	// des données depuis les formulaires

	SQLUpdate($SQL);
}

function autoriserUtilisateur($idUser)
{
	// cette fonction affecte le booléen "blacklist" à faux 
	$SQL = "UPDATE users SET blacklist=0 WHERE id='$idUser'";
	SQLUpdate($SQL);
}

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id FROM users WHERE pseudo='$login' AND passe='$passe'";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}


function isAdmin($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT admin FROM users WHERE id='$idUser'";
	return SQLGetChamp($SQL); 
}

function isBlacklisted($idUser)
{
	// vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT blacklist FROM users WHERE id='$idUser'";
	return SQLGetChamp($SQL); 
}

/********* PARTIE 2 *********/

function mkUser($pseudo, $passe,$promo="",$nom="",$prenom="", $tel="" ,$admin=0) //FIXME PAGE ADMIN 
{
	// Cette fonction crée un nouvel utilisateur et renvoie l'identifiant de l'utilisateur créé
	$SQL= "INSERT INTO users(pseudo, passe,admin,promo,nom,prenom,NumeroTEL) VALUES('$pseudo', '$passe','$admin','$promo','$nom','$prenom','$tel')"; 
	return SQLInsert($SQL); 
}

function mkProd($nomprod, $prix,$quantite,$dispo ,$file,$categ="") //FIXME PAGE ADMIN 
{
	// Cette fonction crée un nouveau produit et renvoie l'identifiant du produit créé
	$SQL= "INSERT INTO produits(nom_prod, prix,quantite,dispo,categorie, lien_photo) VALUES('$nomprod', '$prix','$quantite','$dispo', '$categ','$file')"; 
	return SQLInsert($SQL); 
}



function connecterUtilisateur($idUser)
{
	// cette fonction affecte le booléen "connecte" à vrai pour l'utilisateur concerné 
}

function deconnecterUtilisateur($idUser)
{
	// cette fonction affecte le booléen "connecte" à faux pour l'utilisateur concerné 
}

function changerCouleur($idUser,$couleur="black")
{
	// cette fonction modifie la valeur du champ 'couleur' de l'utilisateur concerné
	$SQL = "UPDATE users SET couleur='$couleur' WHERE id='$idUser'";
	return SQLUpdate($SQL);
}


function changerPasse($idUser,$passe)
{
	// cette fonction modifie la valeur du champ 'couleur' de l'utilisateur concerné
	$SQL = "UPDATE users SET passe='$passe' WHERE id='$idUser'";
	return SQLUpdate($SQL);
}

function changerPseudo($idUser,$pseudo)
{
	// cette fonction modifie le pseudo d'un utilisateur
	$SQL = "UPDATE users SET pseudo='$pseudo' WHERE id='$idUser'";
	return SQLUpdate($SQL);
}

function changerInfo($idUser,$pseudo, $passe)
{
	// cette fonction modifie le pseudo d'un utilisateur
	if(!empty($pseudo)){
	$SQL = "UPDATE users SET pseudo='$pseudo' WHERE id='$idUser'";
	SQLUpdate($SQL);
	}
	if(!empty($passe)){
	// cette fonction modifie la valeur du champ 'mot de passe' de l'utilisateur concerné
	$SQL = "UPDATE users SET passe='$passe' WHERE id='$idUser'";
	SQLUpdate($SQL);
	}
	return 0;
}

function ChangePromo($idUser, $promo)
{
	// cette fonction change la promotion de l'élève
	$SQL = "UPDATE users SET promo='$promo' WHERE id='$idUser'";
	return SQLUpdate($SQL);
}

function promouvoirAdmin($idUser)
{
	// cette fonction fait de l'utilisateur un administrateur
	$SQL = "UPDATE users SET admin=1 WHERE id='$idUser'";
	return SQLUpdate($SQL);
}

function retrograderUser($idUser)
{
	// cette fonction fait de l'utilisateur un simple mortel
	$SQL = "UPDATE users SET admin=0 WHERE id='$idUser'";
	return SQLUpdate($SQL);
}

function supprimerUser($idUser)
{
	// cette fonction fait de l'utilisateur un simple mortel
	$SQL = "DELETE FROM users WHERE id='$idUser'";
	echo $SQL; 
	return SQLDelete($SQL);
}

function supprimerCommande($idCom)
{
	// cette fonction fait de l'utilisateur un simple mortel
	$SQL = "DELETE FROM panier WHERE id_panier='$idCom';
	DELETE FROM commandes WHERE id_commande='$idCom'";
	echo $SQL; 
	return SQLDelete($SQL);
}

function supprimerProd($idProd)
{
	// cette fonction supprime un produit
	$SQL = "DELETE FROM produits WHERE reference='$idProd'";
	echo $SQL; 
	return SQLDelete($SQL);
}


/********* PARTIE 3 *********/

function listerUtilisateursConnectes()
{
	// Liste les utilisteurs connectes
}

function listerConversations($mode="tout") {
	// Liste toutes les conversations ($mode="tout")
	// OU uniquement celles actives  ($mode="actives"), ou inactives  ($mode="inactives")
	$SQL = "SELECT * FROM conversations "; 
	if ($mode=="actives") $SQL .= " WHERE active=1";
	if ($mode=="inactives") $SQL .= " WHERE active=0"; 
	
	return parcoursRs(SQLSelect($SQL));
}

function archiverConversation($idConversation) {
	// rend une conversation inactive
	$SQL="UPDATE conversations SET active=0 WHERE id='$idConversation'"; 
	SQLUpdate($SQL); 
}

function creerConversation($theme) {
	// crée une nouvelle conversation et renvoie son identifiant
	$SQL="INSERT INTO conversations(theme) VALUES ('$theme')"; 
	return SQLInsert($SQL); 
}

function reactiverConversation($idConversation) {	
	// rend une conversation active
	$SQL="UPDATE conversations SET active=1 WHERE id='$idConversation'";
	SQLUpdate($SQL); 

}

function supprimerConversation($idConv) {
	// supprime une conversation et ses messages

	// NB : on aurait pu aussi demander à mysql de supprimer automatiquement
	// les messages lorsqu'une conversation est supprimée, 
	// en déclarant idConversation comme clé étrangère vers le champ id de la table 
	// des conversations et en définissant un trigger
	
	// merdique : il est préférable d'appliquer des contraintes d'intégrité référentielle
	// depuis le moteur de base de données 
	$SQL="DELETE FROM message WHERE idConversation='$idConv'"; 
	SQLDelete($SQL);
	
	$SQL="DELETE FROM conversations WHERE id='$idConv'"; 
	SQLDelete($SQL);
	
	 
}


function enregistrerMessage($idConversation, $idAuteur, $contenu)
{
	// On se prémunit des failles de type "injection JS"
	// aussi appelées failles XSS 
	// Cross-Site Scripting 
	
	// Enregistre un message dans la base en encodant les caractères spéciaux HTML : 
	// <, > et & pour interdire les messages HTML
	
	$contenu = htmlspecialchars($contenu); 
	
	$SQL = "INSERT INTO message(idConversation, idAuteur, contenu) "; 
	$SQL .= " VALUES('$idConversation', '$idAuteur', '$contenu')";
	return SQLInsert($SQL);
}

function listerMessages($idConv,$format="asso") {
	// Liste les messages de cette conversation, au format JSON ou tableau associatif
	// Champs à extraire : contenu, auteur, couleur 
	// en ne renvoyant pas les utilisateurs blacklistés
	
	$SQL = "SELECT m.id as idMessage, u.id as idAuteur, m.contenu, u.pseudo as auteur, u.couleur "; 
	$SQL .= " FROM message m INNER JOIN users u ON m.idAuteur = u.id "; 
	$SQL .= " WHERE m.idConversation='$idConv' AND u.blacklist=0 "; 
	$SQL .= " ORDER BY m.id ASC"; 
	
	if ($format == "asso") 
		return parcoursRs(SQLSelect($SQL));
	else 
		return json_encode(parcoursRs(SQLSelect($SQL)));

}

function listerMessagesFromIndex($idConv,$index)
{
	// Liste les messages de cette conversation, 
	// dont l'id est superieur à l'identifiant passé
	// Champs à extraire : contenu, auteur, couleur 
	// en ne renvoyant pas les utilisateurs blacklistés

}

function getConversation($idConv)
{	
	// Récupère les données de la conversation (theme, active)
	$SQL = "SELECT * FROM conversations WHERE id='$idConv'"; 
	$dataConvs = parcoursRs(SQLSelect($SQL));
	if (count($dataConvs)>0) return $dataConvs[0];
	else return array();
}


// fonction pour reccuperer prochain id du panier + 1

function NextID ($table, $colone){

$SQL = "SELECT MAX($colone) as newCol FROM $table ";

$newSQL = parcoursRs(SQLSelect($SQL));

	return $newSQL[0]['newCol']+1;
}

