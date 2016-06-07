<?php
//définition de fonctions
session_start();

$Dossier = '/images/uploaded/';
$mdp_session=$_SESSION['mdp_session'];
$code_client=$_SESSION['code_client'];
//$total_panier=0;


if(empty($_SESSION['mdp_session'])){
	header("Location: /login.php");
	session_unset();
}


include 'connect_bd.php'; // connexion à la base de données MySQL

		// calcul du prix total panier
		function calcul_prix_panier_ttc($bd,$client){
		$sql_select_total_panier="select code_client,sum(prix_HT*qte*(1+TVA/100)) as total_panier from produits_panier Where code_client ='".$client."' group by code_client" ;
		//echo ("je suis dans la fonction calcul total panier");
		
		$rep = $bd->query($sql_select_total_panier);
		$total_panier=0;			
		while ($donnees = $rep->fetch())
				{
				$total_panier=round($donnees['total_panier'],2);
				//echo ("total panier = ".$total_panier);
				}
				
		$rep->closeCursor();
		return $total_panier;
		}
		
//SQL de mise à jour du panier avec le prix total panier
		function maj_panier($bd,$client,$montant){
		$sql_upd_panier= "UPDATE panier SET  montant_total_ttc= :montant_total_ttc WHERE code_client = :code_client";	

		//echo $client."-------".$montant;
		$upd_panier = $bd->prepare($sql_upd_panier);
		$upd_panier->bindParam(':code_client',$client, PDO::PARAM_STR, 60);
		$upd_panier->bindParam(':montant_total_ttc',$montant);
		$upd_panier->execute();		
		}
				


// Suppression d'un produit du panier
	if(!empty($_GET['supp_id'])){
		//echo "produit à supprimer".$_GET['supp_id'];

        $sql_del = "Delete from produits_panier Where code_prod ='".$_GET['supp_id']."' and code_client='".$code_client."'" ;
        $bdd->exec($sql_del);
		//echo $sql_del;
		$total_panier=calcul_prix_panier_ttc($bdd,$code_client);
		maj_panier($bdd,$code_client,$total_panier);

    }

	
?>



<HTML>

<script language="javascript">
<!--
 function verif_supprim (ele){
     if (window.confirm('voulez-vous vraiment supprimer ce produit?'))
         { window.location = ele;
        }
    }

</script>


<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" media="all" type="text/css"> 

<script language="javascript">
function ouverture() 
{
window.open("vp.htm", "ouverture", "toolbar=no, status=yes, scrollbars=yes, resizable=no, width=200, height=200");
}

</script>




</head>

<body>

<div align="center">
<h1>Mon Panier</h1>
</div>


<table width="850" border="0" cellspacing="2" cellpadding="3" align="CENTER">
        <tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Continuer mes achats" onclick="javascript : window.location='achat_produits.php';" class="bouton4">
            </td>
        </tr>
        <tr>
            <td width="25%" class="LigneTitreTab" >
                <b>photo</b>
            </td>
			<td width="50%" class="LigneTitreTab" >
                <b>Nom du Produit</b>
            </td>
            <td width="5%" class="LigneTitreTab">
                <b>Prix HT</b>
            </td>
			 <td width="5%" class="LigneTitreTab">
                <b>TVA</b>
            </td>
			 <td width="3%" class="LigneTitreTab">
                <b>Qté</b>
            </td>
			 <td width="7%" class="LigneTitreTab">
                <b>Total TTC</b>
            </td>
           
            <td width="5%" align="CENTER" colspan="3" class="LigneTitreTab">
			<img class="displayed" src="/images/icon_poubelle_vide.png"  height="35" width="35">
                
            </td>
        </tr>







<?php
$sql_sel_panier_client="select pp.code_client,pp.code_prod,pp.prix_HT,pp.TVA,pp.qte,p.lib_prod,p.desc_court,p.desc_long,p.photo from produits_panier pp inner join produit p on (pp.code_prod=p.code_prod) where pp.code_client='".$code_client."'";
$reponse = $bdd->query($sql_sel_panier_client);

// On affiche chaque entrée une à une




while ($donnees = $reponse->fetch())
{
?>



        <tr>
            <td class="ligneTab1">
                <img class="displayed" src="<?php echo $Dossier.$donnees['photo']; ?>"  height="80" width="80">
            </td>
			<td class="ligneTab">
				<h2><b><?php  echo $donnees['code_prod']; ?></b></h2>
                <ul>
				<li><b><?php  echo $donnees['lib_prod']; ?></b></li>
				</ul>
			</td>	
            <td class="ligneTab1">
                <?php  echo ($donnees['prix_HT'])."€"; ?>
            </td>
			<td class="ligneTab1">
                <?php  echo round($donnees['TVA'],2); ?>
            </td>
			<td class="ligneTab1">
                <?php  echo ($donnees['qte']); ?>
            </td>
			
			          
			<td  width="7%" class="ligneTab1">
                <?php  echo round($donnees['prix_HT']*$donnees['qte']*(1+$donnees['TVA']/100),2)."€"; ?>
            </td>
			
			 <td  width="14%" align="CENTER" class="ligneTab1">
             <input type="button" value="Supprimer" onclick="javascript: verif_supprim ('/aff_panier.php?supp_id=<?php  echo $donnees['code_prod']; ?>');" class="bouton">
            </td>
            
           
            
            
        </tr>

<?php	}  ?>


		

		
		<tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Continuer mes achats" onclick="javascript : window.location='achat_produits.php';" class="bouton4">
            </td>
        </tr>
</table>


<table width="850" border="0" cellspacing="2" cellpadding="3" align="CENTER">

		<tr>
            <td width="76%" class="LignePiedTab" >
                <b>Total TCC de vos achats :</b>
            </td>
			<td width="24%" class="LignePiedTab" >
                <b><?php echo calcul_prix_panier_ttc($bdd,$code_client)." €"; ?></b>
            </td>
        </tr>
		
			
		<tr>
            <td colspan="7" align="right" bgcolor="white">
                <input type="button" value="Valider ma Commande" onclick="javascript : window.location='<?php if (calcul_prix_panier_ttc($bdd,$code_client)>0){echo ("form_paiement.php");} else {echo ("aff_panier.php");} ?>';" class="bouton3">
            </td>
        </tr>
</table>





<script language="javascript">
function infos(text) { 
document.getElementById('info').style.visibility="visible";
document.getElementById('info').innerHTML=text;
}
</script>



<!-- Balise à insérer à l'endroit ou le cadre doit apparaitre -->
<div id="info" style="visibility:hidden">ceci est mon info</div> 
<!-- Lien d'identification contenant la fonction JS 'infos' -->
<!--<a href="#" onclick="javascript:infos('tu es un blaireau');">Identification</a>-->
	
	
	
	
<?php

$reponse->closeCursor(); // Termine le traitement de la requête

?>



</HTML>