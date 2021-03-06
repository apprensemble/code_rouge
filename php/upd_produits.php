<?php
//définition de fonctions




function upload (){

$dossier = 'images/uploaded/';
$fichier = basename($_FILES['PhotoProduit']['name']);
$taille_maxi = 1000000;
$taille = filesize($_FILES['PhotoProduit']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
$extension = strrchr($_FILES['PhotoProduit']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $UploadReussi = False; //'Vous devez uploader un fichier de type png, gif, jpg, jpeg'
	 echo 'Vous devez uploader un fichier de type png, gif, jpg, jpeg';
}
if($taille>$taille_maxi)
{
     $UploadReussi = False; //'Le fichier est trop gros...'
	 echo 'Le fichier est trop gros...';
}
if(!isset($UploadReussi)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '_', $fichier);
     if(move_uploaded_file($_FILES['PhotoProduit']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
		 $UploadReussi = True; //Upload effectué avec succès';
          echo 'Upload effectué avec succès';
		  
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
		  $UploadReussi = False; //'Echec de l\'upload !'
		  echo 'Echec de l\'upload !';
     }
}
else
{
     echo $UploadReussi;
}	
	
return $UploadReussi;
	
}





// initialisation des variables

//$dossierPhy="C:\Autres Programmes\wamp\www\images\uploaded\";

$erreur=False;

$upd_id="";

$CodeProduit="";
$LibelleProduit="";
$DescCourt="";
$DescLong="";
$PrixHTProduit="";
$TvaProduit="20.6";
$DateFinProduit="2030-12-31 00:00:00";
$CommentProduit="";
$PhotoProduit="";

include 'connect_bd.php'; // connexion à la base de données MySQL


if(!empty($_POST['saisie_form']) and upload ()){
	
$CodeProduit=$_POST['CodeProduit'];
$LibelleProduit=$_POST['LibelleProduit'];
$DescCourt=$_POST['DescCourt'];
$DescLong=$_POST['DescLong'];
$PrixHTProduit=$_POST['PrixHTProduit'];
$TvaProduit=$_POST['TvaProduit'];
$DateFinProduit=$_POST['DateFinProduit'];	
$CommentProduit=$_POST['CommentProduit'];	
$PhotoProduit= basename($_FILES['PhotoProduit']['name']);
	
	if(!empty($_GET['upd_id'])){
		$upd_id=$_GET['upd_id'];
		
		
    $sql_upd = "Update produit SET code_prod= :CodeProduit, lib_prod= :LibelleProduit, desc_court= :DescCourt, desc_long= :DescLong, prix_HT=:PrixHTProduit, TVA= :TvaProduit,dt_fin= :DateFinProduit,  commentaires= :CommentProduit, photo= '".$PhotoProduit."' Where code_prod = :upd_id";	
			
    //$sql_upd = "Update produits SET Code= :CodeProduit, Libelle= :LibelleProduit, Descriptif_court= :DescCourt, Descriptif_long= :DescLong, Prix_HT=:PrixHTProduit, TVA= :TvaProduit,Date_fin= :DateFinProduit,  Commentaires= :CommentProduit, Photo= :PhotoProduit Where Code = :upd_id";	

	//echo $sql_upd;
	$stmt = $bdd->prepare($sql_upd);
	$stmt->bindParam(':upd_id',$upd_id, PDO::PARAM_STR, 10);
	$stmt->bindParam(':CodeProduit',$CodeProduit, PDO::PARAM_STR, 10);
	$stmt->bindParam(':LibelleProduit',$LibelleProduit, PDO::PARAM_STR, 50);
	$stmt->bindParam(':DescCourt',$DescCourt, PDO::PARAM_STR, 100);
	$stmt->bindParam(':DescLong',$DescLong, PDO::PARAM_STR, 12);
	$stmt->bindParam(':PrixHTProduit',$PrixHTProduit,PDO::PARAM_STR);
	$stmt->bindParam(':TvaProduit',$TvaProduit,PDO::PARAM_STR);
	$stmt->bindParam(':DateFinProduit',$DateFinProduit,PDO::PARAM_STR);	
	$stmt->bindParam(':CommentProduit',$CommentProduit, PDO::PARAM_STR, 3000);
//	$stmt->bindParam(':PhotoProduit',$PhotoProduit,PDO::PARAM_STR);
	

	$stmt->execute();
	
	
	}
	else
	{
	//$sql_insert="INSERT INTO produits (Code, Libelle, Descriptif_court, Descriptif_long, Prix_HT, TVA, Date_fin, Commentaires) VALUES ('".$CodeProduit."', '".$LibelleProduit."', '".$DescCourt."', '".$DescLong."', '".$PrixHTProduit."', '".$TvaProduit."', '".$DateFinProduit."', '".$CommentProduit."')";

	 $sql_insert="INSERT INTO produit (code_prod, lib_prod, desc_court, desc_long, prix_HT, TVA, dt_fin, commentaires, photo) VALUES (:CodeProduit, :LibelleProduit, :DescCourt, :DescLong, :PrixHTProduit, :TvaProduit, :DateFinProduit, :CommentProduit, :PhotoProduit)";
	 //echo $sql_insert;
	$stmt = $bdd->prepare($sql_insert);
	$stmt->bindParam(':CodeProduit',$CodeProduit, PDO::PARAM_STR, 10);
	$stmt->bindParam(':LibelleProduit',$LibelleProduit, PDO::PARAM_STR, 50);
	$stmt->bindParam(':DescCourt',$DescCourt, PDO::PARAM_STR, 100);
	$stmt->bindParam(':DescLong',$DescLong, PDO::PARAM_STR, 12);
	$stmt->bindParam(':PrixHTProduit',$PrixHTProduit,PDO::PARAM_STR);
	$stmt->bindParam(':TvaProduit',$TvaProduit,PDO::PARAM_STR);
	$stmt->bindParam(':DateFinProduit',$DateFinProduit,PDO::PARAM_STR);	
	$stmt->bindParam(':CommentProduit',$CommentProduit, PDO::PARAM_STR, 3000);
	$stmt->bindParam(':PhotoProduit',$PhotoProduit,PDO::PARAM_STR);
	 
     $stmt->execute();	 
	}
	
	
	header('Location: /admin_produits.php');
}

else
{
	//echo "je suis dans le select"."   et oui oui yes";
	
	 
	
	

		if(!empty($_GET['upd_id'])){
				//echo $_GET['upd_id'];
				$upd_id=$_GET['upd_id'];
				//echo "upd_id=".$upd_id;
				$sql_sel = "select * from produit Where code_prod ='".$_GET['upd_id']."'" ;
				//echo $sql_sel;
				$rep = $bdd->query($sql_sel);
			
		// On affiche chaque entrée une à une

			while ($donnees = $rep->fetch())
			{
			$CodeProduit= $donnees['code_prod'];;
			$LibelleProduit= $donnees['lib_prod'];
			$DescCourt= $donnees['desc_court'];
			$DescLong= $donnees['desc_long'];
			$PrixHTProduit=$donnees['prix_HT'];
			$TvaProduit=$donnees['TVA'];
			$DateFinProduit=$donnees['dt_fin'];
			$CommentProduit=$donnees['commentaires'];
			$PhotoProduit=$donnees['photo'];			
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
<form action="upd_produits.php?upd_id=<?php echo $upd_id; ?>" method="POST" name="formulaire" enctype="multipart/form-data">
<input type="hidden" name="saisie_form" value="True">
<input type="hidden" name="CodeProduit" value="<?php $CodeProduit ?>">
       
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
			<td width="30%" class="FormTitre">&nbsp;Code Produit* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="CodeProduit" size="50" maxlength="50" value="<?php echo $CodeProduit ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Libellé produit* :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="LibelleProduit" size="50" maxlength="50" value="<?php echo $LibelleProduit ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Descriptif court:</td>
			<td width="70%" class="FormContenu">
				<textarea name="DescCourt" rows="2" cols="50"><?php echo $DescCourt ?></textarea>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Descriptif long:</td>
			<td width="70%" class="FormContenu">
				<textarea name="DescLong" rows="5" cols="50"><?php echo $DescLong ?></textarea>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		
				<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Prix Produit :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="PrixHTProduit" size="50" maxlength="50" value="<?php echo $PrixHTProduit ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;TVA produit :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="TvaProduit" size="50" maxlength="50" value="<?php echo $TvaProduit ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Date Fin produit :</td>
			<td width="70%" class="FormContenu">
				<input type="Text" name="DateFinProduit" size="50" maxlength="50" value="<?php echo $DateFinProduit ?>">
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Commentaires :</td>
			<td width="70%" class="FormContenu">
					<textarea name="CommentProduit" rows="5" cols="50"><?php echo $PhotoProduit.$CommentProduit ?></textarea>

			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>

		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="30%" class="FormTitre">&nbsp;Photo produit à Charger :</td>
			<td width="70%" class="FormContenu">
				<input type="file" name="PhotoProduit" >
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
					<input type="Submit" value="<?php If ($CodeProduit <> ""){echo "Modifier";} else {echo "Enregistrer";} ?>" class="bouton">
				</td>			
			</tr>
		
			</table>	
	</td>
</table>



	
</HTML>	