<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();



function tuer_session(){
		 // Si vous voulez détruire complètement la session, effacez également
		// le cookie de session.
		// Note : cela détruira la session et pas seulement les données de session !
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}

		// Finalement, on détruit la session.
		session_destroy();
}


function quitter(){
	tuer_session();
	header("Location: /login.php");
}



if(empty($_SESSION['mdp_session'])){
	echo "La variable mot de passe est nulle";
	session_unset();
	//header("Location: /login.php");

}

$mdp_session=$_SESSION['mdp_session'];
//echo $mdp_session;
$code_client=$_SESSION['code_client'];
//echo $code_client;
$montant_total=$_SESSION['total_panier'];
//echo "total_panier=".$montant_total;
$cde_valide=false;
$reglement_cb_ok=false;
$reglement_cb_ok=$_SESSION['reglement_cb_ok'];
//echo "reglement_cb_ok=".$reglement_cb_ok;


include 'connect_bd.php'; // connexion à la base de données MySQL


$today = date("Y-m-d H:i:s"); 

//$reglement_cb_ok=false;

if ($reglement_cb_ok){
	
	try

		{

			//on tente d'exécuter les requêtes suivantes dans une transactions
			
			//on lance la transaction
			$bdd->beginTransaction();


			// alimentation table commande
			$sql_insert_cde="INSERT INTO commande (code_client, dt_cde) VALUES (:code_client,:dt_cde)";
						 
			$alim_cde = $bdd->prepare($sql_insert_cde); 
						
			$alim_cde->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
			$alim_cde->bindParam(':dt_cde',$today);
			$alim_cde->execute();	
				

			// controle que la commande a bien été créée
			
			$sql_sel = "select * from commande Where code_client =:code_client and dt_cde=:dt_cde" ;
			
			//echo $sql_sel;				
			$stmt = $bdd->prepare($sql_sel);
			$stmt->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
			$stmt->bindParam(':dt_cde',$today);
			$stmt->execute();
						
			while ($donnees = $stmt->fetch())
					{
					$cde_valide=true;
					//echo "je suis dans le while";
					$num_cde= $donnees['num_cde'];
					//echo " num cde=".$num_cde;
					$dt_cde= $donnees['dt_cde'];
					//echo " dt cde=".$dt_cde;
					}
					
			$stmt->closeCursor(); // Termine le traitement de la requête
			
			
			// si la commande est valide  on fait différentes taches
			
			if ($cde_valide){
				//on alimente la table des produits commandés à partir du panier
				$sql_insert_prod_cde="INSERT INTO produits_commande (num_cde, code_prod, prix_HT, qte_cde, TVA) SELECT :num_cde, pp.code_prod,pp.prix_HT,pp.qte, pp.TVA from produits_panier pp  where pp.code_client=:code_client";
						 
				$alim_prod_cde = $bdd->prepare($sql_insert_prod_cde); 
						
				$alim_prod_cde->bindParam(':num_cde',$num_cde, PDO::PARAM_INT);
				$alim_prod_cde->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
				$alim_prod_cde->execute();
				
				// on supprime les produits du panier
				$sql_del_prod_panier="delete from produits_panier where code_client=:code_client";
				$del_prod_panier = $bdd->prepare($sql_del_prod_panier); 		
				$del_prod_panier->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
				$del_prod_panier->execute();
				
				// on supprime le panier
				$sql_del_panier="delete from panier where code_client=:code_client";
				$del_panier = $bdd->prepare($sql_del_panier); 		
				$del_panier->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
				$del_panier->execute();
				
				// on créé une nouvelle facture à l'état non Réglée
				$sql_insert_cde="INSERT INTO facture (num_cde, dt_facture, montant_total, reglement_OK) VALUES (:num_cde,:dt_facture,:montant_total,1)";				 
				$alim_cde = $bdd->prepare($sql_insert_cde); 
						
				$alim_cde->bindParam(':num_cde',$num_cde, PDO::PARAM_INT);
				$alim_cde->bindParam(':dt_facture',$today);
				$alim_cde->bindParam(':montant_total',$montant_total);
				$alim_cde->execute();

					
				// on récupère d'abord le numéro de facture qui a été créé afin de créer une ligne de réglement
				$sql_sel = "select * from facture Where num_cde =:num_cde and dt_facture=:dt_facture" ;
			
				//echo $sql_sel;				
				$stmt = $bdd->prepare($sql_sel);
				$stmt->bindParam(':num_cde',$num_cde, PDO::PARAM_INT);
				$stmt->bindParam(':dt_facture',$today);
				$stmt->execute();
						
				while ($donnees = $stmt->fetch())
					{
					$facture_valide=true;
					$num_facture= $donnees['num_facture'];
					//echo " num facture=".$num_facture;
					}
				$stmt->closeCursor(); // Termine le traitement de la requête
				
				// on créé une ligne de réglement
				$sql_insert_reg="INSERT INTO reglement (num_facture, dt_reglement, mode_reglement) VALUES (:num_facture,:dt_reglement,'CB')";		 
				$alim_reg = $bdd->prepare($sql_insert_reg); 			
				$alim_reg->bindParam(':num_facture',$num_facture, PDO::PARAM_INT);
				$alim_reg->bindParam(':dt_reglement',$today);
				$alim_reg->execute();	
				$_SESSION['num_cde']=$num_cde;
				$_SESSION['num_facture']=$num_facture;
				
				
				// on met à jour le stock de produits
				$sql_upd_stock="UPDATE produit p,produits_commande pc SET p.stock_qte=p.stock_qte - pc.qte_cde where p.code_prod=pc.code_prod and pc.num_cde=:num_cde";
				$upd_stock = $bdd->prepare($sql_upd_stock); 		
				$upd_stock->bindParam(':num_cde',$num_cde, PDO::PARAM_STR, 60);
				$upd_stock->execute();
				
				
				
				$message="Merci pour votre Commande";
				
				
				
				
			}
			

			//si jusque là tout se passe bien on valide la transaction
			$bdd->commit();
		   
		}

	catch(Exception $e) //en cas d'erreur

		{

			//on annule la transation

			$pdo->rollback();


			//on affiche un message d'erreur ainsi que les erreurs

			echo 'Tout ne s\'est pas bien passé, voir les erreurs ci-dessous<br />';

			echo 'Erreur : '.$e->getMessage().'<br />';

			echo 'N° : '.$e->getCode();


			//on arrête l'exécution s'il y a du code après

			exit();

		}
			
	
	
	
	
}	else {$message="La transaction a échouée";}
	
	
?>


	

<HTML>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style_form_client.css" rel="stylesheet" media="all" type="text/css"> 
</head>


	    

<div align="center">
    <h1><?php echo($message); ?></h1>
 
   
	
	
<form action="login.php" method="POST" name="formulaire" id=client>
<input type="Hidden" name="saisie_form" value="True">

      <fieldset>
        <legend> Commande Validée</legend>

        <ol>
          <li>
            <label for=num_cde>N° Commande</label>
            <input id=num_cde name=num_cde type=text placeholder="" value="<?php echo $num_cde ?>"  required>
          </li>
		   
        </ol>
      </fieldset>

     
		<table>
		<tr>
			<td>
				  <fieldset>
					<button  type=submit value="">Quitter</button>
				  </fieldset>
			</td>
			<td>
				  <fieldset>
					<button  type=button value="" OnClick="window.location.href='aff_facture.php'">Facture</button>
				  </fieldset>
			</td>
	  </tr>
    </form>
 </div>





</HTML>	