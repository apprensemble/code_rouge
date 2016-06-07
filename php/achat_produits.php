<?php
//définition de fonctions
session_start();
$Dossier = '/images/uploaded/';

if(empty($_SESSION['mdp_session'])){
	session_unset();
	header("Location: /login.php");
}

$mdp_session=$_SESSION['mdp_session'];
//echo $mdp_session;

$code_client= "";
$email= "";
$nom= "";
$prenom= "";
$code_client= $_SESSION['code_client'];

include 'connect_bd.php'; // connexion à la base de données MySQL
		

$panier_valide=false;
if(!empty($_POST['saisie_form'])){
	
	//include 'connect_bd.php'; // connexion à la base de données MySQL

	$code_client= $_SESSION['code_client'];
	//echo "code client : ".$code_client;
	$email= $_SESSION['email'];
	$nom= $_SESSION['nom'];
	$prenom= $_SESSION['prenom'];
	$code_prod=$_POST['code_prod'];
	//echo "code prod : ".$code_prod;
	$prix_HT=$_POST['prix_HT'];
	//echo "prix HT:".$prix_HT;
	$TVA=$_POST['TVA'];
	//echo "TVA: ".$TVA;
	$qte=$_POST['quantite'];
	//echo "qte:".$qte;


	// on vérifie si un panier existe pour le client
	 $sql_sel = "select * from panier Where code_client ='".$code_client."'" ;
		//echo $sql_sel;
		$rep = $bdd->query($sql_sel);				
		while ($donnees = $rep->fetch())
				{
				$panier_valide=true;
				//echo "je suis dans le while";
				}
				
		$rep->closeCursor(); // Termine le traitement de la requête
		
		//preparation des SQL d'alimentation
		// alimentation table produits_panier
		$sql_insert_prod_panier="INSERT INTO produits_panier (code_client, code_prod, prix_HT, qte, TVA) VALUES (:code_client, :code_prod, :prix_HT, :qte, :TVA)";
				 
		$alim_prod_panier = $bdd->prepare($sql_insert_prod_panier); 
				
		$alim_prod_panier->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
		$alim_prod_panier->bindParam(':code_prod',$code_prod, PDO::PARAM_STR, 10);
		$alim_prod_panier->bindParam(':prix_HT',$prix_HT);
		$alim_prod_panier->bindParam(':qte',$qte);
		$alim_prod_panier->bindParam(':TVA',$TVA);
		//echo $sql_insert_prod_panier;
		
		// alimentation table panier :création d'un panier client
		$sql_insert_panier="INSERT INTO panier (code_client) VALUES (:code_client)";
				 
		$alim_panier = $bdd->prepare($sql_insert_panier); 	
		$alim_panier->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
		
		// calcul du prix total panier
		function calcul_prix_panier_ttc($bd,$client){
		$sql_select_total_panier="select code_client,sum(prix_HT*qte*(1+TVA/100)) as total_panier from produits_panier Where code_client ='".$client."' group by code_client" ;
		//echo ("je suis dans la fonction calcul total panier");
		
		$rep = $bd->query($sql_select_total_panier);
		$total_panier=0;
		$nb_prod=0;
		while ($donnees = $rep->fetch())
				{
				$total_panier=$donnees['total_panier'];	
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
			

		if ($panier_valide){
			//on ajoute le produit aux produits du panier
			$alim_prod_panier->execute();
			$total_panier=calcul_prix_panier_ttc($bdd,$code_client);
			maj_panier($bdd,$code_client,$total_panier);
			//echo "<script>alert('le produit a été ajouté au panier')</script>";
		} else {
			//création du panier
			$alim_panier->execute();
			//on ajoute le produit aux produits du panier
			$alim_prod_panier->execute();
			$total_panier=calcul_prix_panier_ttc($bdd,$code_client);
			//echo "<script>alert('le produit a été ajouté au panier')</script>";
		}
}	
	
	
// on détermine le nombre de produits dans le panier pour les afficher dans les boutons afficher panier
$sql_select_nbprod="select code_client,count(distinct code_prod) as nb_prod from produits_panier Where code_client ='".$code_client."' group by code_client" ;	
$rep = $bdd->query($sql_select_nbprod);
$nb_prod=0;
while ($donnees = $rep->fetch())
	{
		$nb_prod=$donnees['nb_prod'];
	}				
$rep->closeCursor();
	
?>



<HTML>

<script language="javascript">
<!--
 function verif_supprim (ele){
     if (window.confirm('voulez-vous vraiment supprimer ce produit?'))
         { window.location = ele;}
    }
//-->
</script>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
</head>

<body>
<table width="850" align="center">
<tr>
<td width="150"></td>
<td width="450" align="center"><h1>Les produits disponibles</h1></td>
<td width="150"  class="entete1" ><a class="entete1" href="/upd_client.php?upd_id=<?php echo $code_client ?>">Mon profil</a></td>
</tr>
</table>


<table width="850" border="0" cellspacing="2" cellpadding="3" align="CENTER">
        <tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Afficher le panier<?php echo (" -> (".$nb_prod.")"); ?>" onclick="javascript : window.location='aff_panier.php';" class="bouton4">
            </td>
        </tr>
        <tr>
            <td width="35%" class="LigneTitreTab" >
                <b>photo</b>
            </td>
			<td width="55%" class="LigneTitreTab" >
                <b>Nom du Produit</b>
            </td>
            <td width="10%" class="LigneTitreTab">
                <b>Prix HT</b>
            </td>
            <td align="CENTER" colspan="3" class="LigneTitreTab">
                <b>Actions</b>
            </td>
        </tr>







<?php
$reponse = $bdd->query('select * from produit');

// On affiche chaque entrée une à une

while ($donnees = $reponse->fetch())
{
?>



        <tr>
            <td class="ligneTab">
                <img  class="displayed" src="<?php echo $Dossier.$donnees['photo']; ?>"  height="200" width="200">
            </td>
			<td class="ligneTab">
				<h2><b><?php  echo $donnees['code_prod']; ?></b></h2>
                <ul>
				<li><b><?php  echo $donnees['lib_prod']; ?></b></li>
				<li><b><?php  echo $donnees['desc_court']; ?></b></li>
				<li><b><?php  echo $donnees['desc_long']; ?></b></li>
				</ul>
			</td>	
            <td class="ligneTab">
                <h2><b><?php  echo ($donnees['prix_HT'])."€"; ?></b></h2>
            </td>
            <td  width="13%" align="CENTER" class="ligneTab2">
				<form action="achat_produits.php" method="POST" name="<?php echo ("form_".$donnees['code_prod']) ?>">
				<input type="hidden" name="saisie_form" value="True">
				<input type="hidden" name="code_prod" value="<?php echo $donnees['code_prod'] ?>">
				<input type="hidden" name="prix_HT" value="<?php echo $donnees['prix_HT'] ?>">
				<input type="hidden" name="TVA" value="<?php echo $donnees['TVA'] ?>">
					<table>
						<tr>
							<td class="Txtpetit">Quantité:</td>
						
							<td>
							<SELECT name="quantite" size="1">
								<OPTION>1
								<OPTION>2
								<OPTION>3
								<OPTION>4
								<OPTION>5
								<OPTION>6
							</SELECT>
							</td>
						</tr>
						
						<tr>
							<input type="Submit" value="Ajouter au panier" class="bouton">
						</tr>
					</table>
				</form>
			</td>
            
            
        </tr>

<?php	}  ?>

		
		<tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Afficher le panier<?php echo (" -> (".$nb_prod.")"); ?>" onclick="javascript : window.location='aff_panier.php';" class="bouton4">
            </td>
        </tr>
</table>




</body>





	
	
	
	
<?php

$reponse->closeCursor(); // Termine le traitement de la requête

?>



</HTML>