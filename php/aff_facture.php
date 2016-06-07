<?php
//définition de fonctions
session_start();

$Dossier = '/images/uploaded/';
$mdp_session=$_SESSION['mdp_session'];
$code_client=$_SESSION['code_client'];


if(empty($_SESSION['mdp_session'])){
	header("Location: /login.php");
	session_unset();
}

//$num_cde=1;
//$num_facture=1;

$num_facture=$_SESSION['num_facture'];

include 'connect_bd.php'; // connexion à la base de données MySQL

	
	
?>



<HTML lang="fr">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style_facture.css" rel="stylesheet" media="all" type="text/css"> 




</head>

<body>

<div width="80%" align=left padding: 20px>
<h1>Site VP Chti</h1>
</div>

<div width="80%" align=center padding: 20px>



<?php

// date et heure complete 
function dateFR( $time) { 	
	setlocale(LC_TIME, 'fr_FR', 'fr_FR@euro', 'fr', 'FR', 'fra_fra', 'fra'); 	
	return strftime('%A %d %B %Y &agrave; %Hh %Mmin %Ss', strtotime($time)); } 

// format racourcis (pas d'heure) 
function dateFR_S( $time) { 	
	setlocale(LC_TIME, 'fr_FR', 'fr_FR@euro', 'fr', 'FR', 'fra_fra', 'fra');
	return strftime('%A %d %B %Y ', strtotime($time)); } 


	$sql_sel = "select c.code_client, c.nom, c.prenom,c.civilite, c.adresse, c.code_postal, c.ville, c.pays, fac.num_cde, fac.num_facture,fac.dt_facture,fac.montant_total from client c inner join commande cde on (c.code_client=cde.code_client) inner join facture fac on (cde.num_cde=fac.num_cde)  Where fac.num_facture =".$num_facture ;
	$reponse = $bdd->query($sql_sel);
				
	while ($donnees = $reponse->fetch())
			{
			$code_client= $donnees['code_client'];
			$nom= str_replace(' ', '&nbsp;',$donnees['nom']);
			$prenom= str_replace(' ', '&nbsp;',$donnees['prenom']);
			$civilite=$donnees['civilite'];
			$adresse=str_replace(' ', '&nbsp;',$donnees['adresse']);
			$code_postal=$donnees['code_postal'];
			$ville=str_replace(' ', '&nbsp;',$donnees['ville']);
			$pays=str_replace(' ', '&nbsp;',$donnees['pays']);
			$num_cde=$donnees['num_cde'];
			$num_facture=$donnees['num_facture'];
			$montant_total=$donnees['montant_total'];
			
			$dt_facture=dateFR_S($donnees['dt_facture']);
			}
			
	$reponse->closeCursor(); // Termine le traitement de la requête
		
?>



<div width="80%" align="left">
<form id=client>
<fieldset><legend><?php echo ("Facture N° ".$num_facture. "  du ".$dt_facture);?></legend></fieldset>
<h3><?php echo ($civilite. "  ".$nom."  ".$prenom);?></h3>
<h3><?php echo ($adresse);?></h3>
<h3><?php echo ($code_postal."  ".$ville);?></h3>
</form>
</div>

<table  align="CENTER">

       
        <tr>
            <th>
                <b>code produit</b>
            </th>
			<th>
                <b>Nom du Produit</b>
            </th>
            <th>
                <b>Prix HT</b>
            </th>
			 <th>
                <b>TVA</b>
            </th>
			 <th>
                <b>Qté</b>
            </th>
			 <th>
                <b>Total TTC</b>
            </th>
           
        </tr>







<?php
$sql_sel_cde_client="select pc.num_cde,pc.code_prod,pc.prix_HT,pc.TVA,pc.qte_cde,p.lib_prod,p.desc_court,p.desc_long,p.photo from produits_commande pc inner join produit p on (pc.code_prod=p.code_prod) where pc.num_cde=".$num_cde;
$reponse = $bdd->query($sql_sel_cde_client);

// On affiche chaque entrée une à une
//echo $sql_sel_cde_client;



while ($donnees = $reponse->fetch())
{
?>



        <tr>
            <td>
                <?php  echo $donnees['code_prod']; ?>
            </td>
			<td>
				<?php  echo $donnees['lib_prod']; ?>
			</td>	
            <td>
                <?php  echo ($donnees['prix_HT'])."€"; ?>
            </td>
			<td>
                <?php  echo round($donnees['TVA'],2); ?>
            </td>
			<td>
                <?php  echo ($donnees['qte_cde']); ?>
            </td>
			
			          
			<td>
                <?php  echo round($donnees['prix_HT']*$donnees['qte_cde']*(1+$donnees['TVA']/100),2)."€"; ?>
            </td>
			
            
            
        </tr>

<?php	}  ?>

	
<?php

$reponse->closeCursor(); // Termine le traitement de la requête

?>
</table>


<?php

$sql_select_total_cde="select num_cde,sum(prix_HT*qte_cde) as total_HT, sum(prix_HT*qte_cde*(1+TVA/100)) as total_TTC,sum(prix_HT*qte_cde*(TVA/100)) as total_TVA  from produits_commande Where num_cde=".$num_cde." group by num_cde" ;
//echo $sql_select_total_cde;
		
$rep = $bdd->query($sql_select_total_cde);
				
		while ($donnees = $rep->fetch())
				{
				$total_HT=round($donnees['total_HT'],2);
				$total_TTC=round($donnees['total_TTC'],2);
				$total_TVA=round($donnees['total_TVA'],2);
				
				}
				
		$rep->closeCursor();
?>		
		
		
<div width="80%" align="right">
	<form id=total>
		<fieldset><legend><?php echo ("Total");?></legend></fieldset>
			<h3><?php echo ("Total TTC :      ".$total_TTC."€") ?></h3>
			<h3><?php echo ("Total HT :       ".$total_HT."€") ?></h3>
			<h3><?php echo ("Total TVA :      ".$total_TVA."€") ?></h3>
	</form>
</div>

</div>

</HTML>