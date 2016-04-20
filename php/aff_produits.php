<HTML>



<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
</head>

<?php

// initialisation des variables

$Dossier = '/images/uploaded/';

$erreur=False;

$aff_id="";

$CodeProduit="";
$LibelleProduit="";
$DescCourt="";
$DescLong="";
$PrixHTProduit="";
$TvaProduit="";
$DateDebProduit="";
$DateFinProduit="";
$CommentProduit="";
$PhotoProduit="";


try
{
	// On se connecte à MySQL
$bdd = new PDO('mysql:host=10.7.0.1;dbname=gestion_site;charset=utf8', 'root', 'mysqlRoot.');

}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}


if(!empty($_GET['aff_id'])){
	

	$sql_sel = "select * from produits Where Code ='".$_GET['aff_id']."'" ;
				//echo $sql_sel;
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
			$DateDebProduit=$donnees['Date_debut'];
			$DateFinProduit=$donnees['Date_fin'];
			$CommentProduit=$donnees['Commentaires'];
			$PhotoProduit=$donnees['Photo'];
			}
			
			$rep->closeCursor(); // Termine le traitement de la requête
		
}



?>


<form action="admin_produits.php" method="POST" name="formulaire">
	    
	    	    
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
			<td><img src="/images/dot.gif" alt="" width="10" height="1"></td> 			
			<td width="100%" class="dmTitre" title="" >     Fiche Produit</TD> 			
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td> 				
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="60"></td>                 
		</tr>
	</table>	


		
		
	<table class="dmFond2" width="650" border="0" cellspacing="0" cellpadding="0">		
	

		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Code Produit* :</td>
			<td width="80%" class="FormContenu">
				<?php echo $CodeProduit ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Libellé produit* :</td>
			<td width="80%" class="FormContenu">
				<?php echo $LibelleProduit ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Descriptif court:</td>
			<td width="80%" class="FormContenu">
				<?php echo $DescCourt ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Descriptif long:</td>
			<td width="80%" class="FormContenu">
				<?php echo $DescLong ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		
				<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Prix Produit :</td>
			<td width="80%" class="FormContenu">
				<?php echo $PrixHTProduit ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>
		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;TVA produit :</td>
			<td width="80%" class="FormContenu">
				<?php echo $TvaProduit ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>


		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Date Début produit :</td>
			<td width="80%" class="FormContenu">
				<?php echo $DateDebProduit ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>

		
		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Date Fin produit :</td>
			<td width="80%" class="FormContenu">
				<?php echo $DateFinProduit ?>
			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>

		<tr class="dmFond2"> 
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="15"></td>
			<td><img src="/images/dot.gif" alt="" width="5" height="1"></td>		
			<td width="20%" class="FormTitre">&nbsp;Commentaires :</td>
			<td width="80%" class="FormContenu">
				<?php echo $CommentProduit ?>

			</td>
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td>
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="1"></td>
		</tr>

		
		
		
		
	</table>

	
		<table class="dmFond2" width="650" border="0" cellspacing="0" cellpadding="0">		
	
			
		<tr class="dmFond2">
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="20"></td>
			<td><img src="/images/dot.gif" alt="" width="10" height="30"></td> 
			<td width="50%" class="dmTitre" title="" ><img src="<?php echo $Dossier.$PhotoProduit ?>" alt="" width="200" height="200"></td> 
			<td width="50%" class="dmTitre" title="" ><?php echo $PhotoProduit ?></TD> 			
			<td><img src="/images/dot.gif" alt="" width="1" height="1"></td> 				
			<td class="dmContour2"><img src="/images/dot.gif" alt="" width="1" height="60"></td>                 
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
				<td width="20%" class="FormTitre"></td>
				<td width="80%"  align="RIGHT" class="FormContenu">
					<input type="Submit" value="Retour" class="bouton">
				</td>			
			</tr>
		
			</table>	
	</td>
</table>



	
</HTML>	
