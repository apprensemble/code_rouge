<?php
//définition de fonctions






// initialisation des variables

//$dossierPhy="C:\Autres Programmes\wamp\www\images\uploaded\";

$erreur=False;

$upd_id="";

$code_client= "";
$email= "";
$nom= "";
$prenom= "";
$civilite="";
$adresse="";
$code_postal="";
$ville="";
$pays="";			
$mdp="";

include 'connect_bd.php'; // connexion à la base de données MySQL


if(!empty($_POST['saisie_form'])){

$code_client= $_POST['code_client'];
$email= $_POST['email'];
$nom= $_POST['nom'];
$prenom= $_POST['prenom'];
$civilite=$_POST['civilite'];
$adresse=$_POST['adresse'];
$code_postal=$_POST['code_postal'];
$ville=$_POST['ville'];
$pays=$_POST['pays'];			
$mdp=$_POST['mdp'];

	
	if(!empty($_GET['upd_id'])){
		$upd_id=$_GET['upd_id'];
		
		
    $sql_upd = "UPDATE client SET code_client= :code_client, email= :email, nom= :nom, prenom= :prenom, civilite=:civilite, adresse= :adresse,code_postal= :code_postal,  ville= :ville,  pays= :pays,  mdp= :mdp WHERE code_prod = :upd_id";	
			

	//echo $sql_upd;
	$stmt = $bdd->prepare($sql_upd);
	$stmt->bindParam(':upd_id',$upd_id, PDO::PARAM_STR, 10);
	$stmt->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
	$stmt->bindParam(':email',$email, PDO::PARAM_STR, 60);
	$stmt->bindParam(':nom',$nom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':prenom',$prenom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':civilite',$civilite,PDO::PARAM_STR, 1);
	$stmt->bindParam(':adresse',$adresse,PDO::PARAM_STR, 300);
	$stmt->bindParam(':code_postal',$code_postal,PDO::PARAM_STR, 5);	
	$stmt->bindParam(':ville',$ville, PDO::PARAM_STR, 50);
	$stmt->bindParam(':pays',$pays,PDO::PARAM_STR, 50);
	$stmt->bindParam(':mdp',$mdp,PDO::PARAM_STR, 50);

	$stmt->execute();
	
	
	}
	else
	{

	 $sql_insert="INSERT INTO client (code_client, email, nom, prenom, civilite, adresse, code_postal, ville, pays, mdp) VALUES (:code_client, :email, :nom, :prenom, :civilite, :adresse, :code_postal, :ville, :pays, :mdp)";
	 //echo $sql_insert;
	$stmt->bindParam(':upd_id',$upd_id, PDO::PARAM_STR, 10);
	$stmt->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
	$stmt->bindParam(':email',$email, PDO::PARAM_STR, 60);
	$stmt->bindParam(':nom',$nom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':prenom',$prenom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':civilite',$civilite,PDO::PARAM_STR, 1);
	$stmt->bindParam(':adresse',$adresse,PDO::PARAM_STR, 300);
	$stmt->bindParam(':code_postal',$code_postal,PDO::PARAM_STR, 5);	
	$stmt->bindParam(':ville',$ville, PDO::PARAM_STR, 50);
	$stmt->bindParam(':pays',$pays,PDO::PARAM_STR, 50);
	$stmt->bindParam(':mdp',$mdp,PDO::PARAM_STR, 50);
 
     $stmt->execute();	 
	}
	
	
	header('Location: /admin_clients.php');
}

else
{
	//echo "je suis dans le select"."   et oui oui yes";
	
	 
	
	

		if(!empty($_GET['upd_id'])){
				//echo $_GET['upd_id'];
				$upd_id=$_GET['upd_id'];
				//echo "upd_id=".$upd_id;
				$sql_sel = "select * from client Where code_client ='".$_GET['upd_id']."'" ;
				//echo $sql_sel;
				$rep = $bdd->query($sql_sel);
			
		// On affiche chaque entrée une à une

			while ($donnees = $rep->fetch())
			{
			$code_client= $donnees['code_client'];
			$email= $donnees['email'];
			$nom= $donnees['nom'];
			$prenom= $donnees['prenom'];
			$civilite=$donnees['civilite'];
			$adresse=$donnees['adresse'];
			$code_postal=$donnees['code_postal'];
			$ville=$donnees['ville'];
			$pays=$donnees['pays'];			
			$mdp=$donnees['mdp'];
			}
			
			$rep->closeCursor(); // Termine le traitement de la requête
		}
}



?>

<HTML>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
</head>
<form action="upd_client.php?upd_id=<?php echo $upd_id; ?>" method="POST" name="formulaire" enctype="multipart/form-data">
<input type="hidden" name="saisie_form" value="True">
<input type="hidden" name="code_client" value="<?php $code_client ?>">
       
<input type="hidden" name="MAX_FILE_SIZE" value="1000000">    
	    
	    
	    
	    
<table  width="675" border="0" cellspacing="0" cellpadding="0" align="center">
	
<td width="675" align="center">


	<table class="dmContour2" width="650" border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td class="dmContour2"><img src="/images/dot.gif" alt="" width="650" height="1"></td>
		</tr>
	</table>




	<table class="dmFond2" width="650" border="0" cellspacing="0" cellpadding="0">

		
				<tr class="dmFond2">
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="20"></td> 					
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td> 					
			<td width="100%" class="dmTitre" title=""><?php if ($erreur) { echo "Tous les information obligatoires suivies d'un * n'ont pas été saisies !!!";} else {echo "Toutes les informations suivies d'un * sont obligatoires";} ?></TD> 			
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td> 					
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>                 
		</tr>

		<tr class="dmFond2">
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="20"></td> 					
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td> 					
			<td class="dmTitre" title=""></TD> 					
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td> 					
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>                 
		</tr>
		
		<tr></tr>
		
	</table>	
		
	<table class="dmFond2" width="650" border="0" cellspacing="0" cellpadding="0">		
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Email* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="email" size="50" maxlength="50" value="<?php echo $email ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Nom* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="nom" size="50" maxlength="50" value="<?php echo $nom ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;prenom* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="nom" size="50" maxlength="50" value="<?php echo $nom ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		
		

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Civilité:</td>
			<td width="70%" class="FormContenu">
			
				<SELECT name="civilite" size="1">
					<OPTION>Monsieur
					<OPTION>Madame
					<OPTION>Mademoiselle
				</SELECT>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Adresse*:</td>
			<td width="70%" class="FormContenu">
				<textarea name="adresse" rows="5" cols="50"><?php echo $adresse ?></textarea>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		
				<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Code Postal* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="code_postal" size="50" maxlength="50" value="<?php echo $code_postal ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Ville* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="ville" size="50" maxlength="50" value="<?php echo $ville ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Pays* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="pays" size="50" maxlength="50" value="<?php echo $pays ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Mot de passe* :</td>
			<td width="70%" class="FormContenu">
				<input type="password" name="pwd" size="50" maxlength="50" value="<?php echo $pwd ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		

		

		
		
		
		
		
	</table>

	
		
	<table class="dmContour2" width="650" border="0" cellspacing="0" cellpadding="0" >
		<tr>
		<td class="dmContour2"><img src="/images/dot.gif" alt="" width="650" height="1"></td>
		</tr>
	</table>

	    
</td>
</table>
	    

	    




<table  width="675" border="0" cellspacing="0" cellpadding="0" align="center">
	
	<td width="675" align="center">

			<table class="dmFond3" width="650" border="0" cellspacing="0" cellpadding="0">
		
			<tr>
			<td><img src="/images/dot.gif" alt="" width="650" height="20"></td>
			</tr>
			
			<tr class="dmFond3">
				<td width="30%" class="FormTitre"></td>
				<td width="70%"  align="RIGHT" class="FormContenu">
					<input type="Submit" value="<?php If ($code_client <> ""){echo "Modifier";} else {echo "Enregistrer";} ?>" class="bouton">
				</td>			
			</tr>
		
			</table>	
	</td>
</table>



	
</HTML>	