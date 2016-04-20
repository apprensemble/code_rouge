<HTML>



<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
</head>

<?php

// initialisation des variables

$erreur=False;

$upd_id="";

$CodeProduit="";
$LibelleProduit="";
$DescCourt="";
$DescLong="";
$PrixHTProduit="";
$TvaProduit="";
$DateFinProduit="";


try
{
	// On se connecte à MySQL
$bdd = new PDO('mysql:host=localhost;dbname=gestion_site;charset=utf8', 'root', 'saremi62*');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}



if(!empty($_POST['saisie_form'])){
	
$CodeProduit=$_POST['CodeProduit'];
$LibelleProduit=$_POST['LibelleProduit'];
$DescCourt=$_POST['DescCourt'];
$DescLong=$_POST['DescLong'];
$PrixHTProduit=$_POST['PrixHTProduit'];
$TvaProduit=$_POST['TvaProduit'];
$DateFinProduit=$_POST['DateFinProduit'];	
	
	if(!empty($_GET['upd_id'])){
		$upd_id=$_GET['upd_id'];
		echo "upd_id=".$upd_id;
    $sql_upd = "Update produits SET "." Code= '".$CodeProduit."', "." Libelle= '".$LibelleProduit."' Where Code = '".$upd_id."'";	
	$bdd->exec($sql_upd);
	echo $sql_upd;
	
	echo "je suis dans la modification";
	header('Location: /admin_produits.php'); 
	}
	
}

else
{
	echo "je suis dans le select"."   et oui oui";
	
	
	
	

		if(!empty($_GET['upd_id'])){
				echo $_GET['upd_id'];
				$upd_id=$_GET['upd_id'];
				echo "upd_id=".$upd_id;
				$sql_sel = "select * from produits Where Code ='".$_GET['upd_id']."'" ;
				echo $sql_sel;
				$rep = $bdd->query($sql_sel);
			
		// On affiche chaque entrée une à une

			while ($donnees = $rep->fetch())
			{
			$CodeProduit= $donnees['Code'];;
			$LibelleProduit= $donnees['Libelle'];
			$DescCourt= $donnees['Descriptif_court'];
			$DescLong= $donnees['Descriptif_long'];
			$PrixHTProduit=$donnees['Prix_HT'];
			$TvaProduit=$donnees['TVA'];
			$DateFinProduit=$donnees['Date_Fin'];
			}
			
			$rep->closeCursor(); // Termine le traitement de la requête
		}
}



?>


<form action="formulaire.php?upd_id=<?php echo $upd_id; ?>" method="POST" name="formulaire">
<input type="hidden" name="saisie_form" value="True">
<input type="hidden" name="CodeProduit" value="<?php $CodeProduit ?>">
       
	    
	    
	    
	    
	    
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
			<td class="dmTitre" title=""><?php if ($erreur) { echo "Tous les information obligatoires suivies d'un * n'ont pas été saisies !!!";} else {echo "Toutes les informations suivies d'un * sont obligatoires";} ?></TD> 			
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