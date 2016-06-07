<?php
//définition de fonctions
session_start();



if(empty($_SESSION['mdp_session'])){
	session_unset();
	header("Location: /login.php");
}

$mdp_session=$_SESSION['mdp_session'];
//echo "mdp_session:".$mdp_session;
$code_client=$_SESSION['code_client'];
//echo "code_client:".$code_client;




// init variable paiement effectué à false
$paiement_CB_OK=false;

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
		
		
		
	// récupération des informations du client	
		
	$sql_sel = "select * from client Where code_client =:code_client and mdp=:mdp" ;
	
	//echo $sql_sel;
					
	$stmt = $bdd->prepare($sql_sel);
	$stmt->bindParam(':mdp',$mdp_session, PDO::PARAM_STR, 50);
	$stmt->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
	$stmt->execute();
	
				
	while ($donnees = $stmt->fetch())
			{
			$cpt_valide=true;
			//echo "je suis dans le while";
			$code_client= $donnees['code_client'];
			$email= $donnees['email'];
			$nom= $donnees['nom'];
			$prenom= $donnees['prenom'];
			$np=str_replace(' ', '&nbsp;',$donnees['prenom']."  ".$donnees['nom']);
			$civilite=$donnees['civilite'];
			$adresse=str_replace(' ', '&nbsp;',$donnees['adresse']);
			$code_postal=$donnees['code_postal'];
			$ville=$donnees['ville'];
			$cv=str_replace(' ', '&nbsp;',$donnees['code_postal']." (".$donnees['ville'].")");
			$pays=$donnees['pays'];
			
			}
			
	$stmt->closeCursor(); // Termine le traitement de la requête
	
	
	// enregistrement du total panier
	$total_panier=calcul_prix_panier_ttc($bdd,$code_client);
	
	
	if(!empty($_POST['saisie_form'])){
	// sauvegarde du total panier dans une variable de session
	$_SESSION['total_panier'] = $total_panier;
	echo
	
	// on récupère des info CB et on considère que le paiement s'est effectué correctement
	$num_cb=$_POST['num_cb'];
	$code_secu_cb=$_POST['code_secu_cb'];
	$nom_porteur_cb=$_POST['nom_porteur_cb'];
	
	//on positionne la variable indiquant que le paiement CB a été effectué et on positionne une variable de session
	$reglement_cb_ok=true;
	$_SESSION['reglement_cb_ok'] = $reglement_cb_ok;
	
	$url="Location: /valid_commande.php";
	header($url);
	
	
}
	
?>





<!DOCTYPE html>

<html  lang="fr">


	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Validation commande</title>
		<link href="style_form_paiement.css" rel="stylesheet" media="all" type="text/css"> 
	</head>
	
<script type="text/javascript">

function verif_formulaire()
{
	
 if(document.paiement.montant_total.value == "0")  {
   alert("Vous devez avoir au moins un produit dans votre commande");
   return false;
  }
}
</script>

  <body>
  <div align="center">
    <h1>Validation de ma commande</h1>
  
    <form id=paiement name=paiement align="center" action="form_paiement.php" method="POST"  onsubmit="return verif_formulaire()">
	<input type="hidden" name="saisie_form" value="True">
	<input type="hidden" name="montant_total" value="<?php echo($total_panier); ?>">
      <fieldset>
        <legend>Votre identité</legend>

        <ol>
          <li>
            <label for=nom>Nom</label>
            <input disabled id=nom name=nom type=text placeholder=<?php echo($np); ?>  >
          </li>
          <li>
            <label for=email>Email</label>
            <input disabled id=email name=email type=email placeholder=<?php echo($email); ?> required>
          </li>
        </ol>
      </fieldset>

      <fieldset>
        <legend>Adresse de livraison</legend>
          <ol>
            <li>
              <label for=adresse>Adresse</label>
              <textarea  disabled id=adresse name=adresse rows=3 placeholder=<?php echo($adresse); ?> required></textarea>
            </li>
            <li>
              <label for=codepostal>Code postal</label>
              <input  disabled id=codepostal name=codepostal type=text placeholder=<?php echo($cv); ?> required>
            </li>
              <li>
              <label for=pays>Pays</label>
              <input  disabled id=pays name=pays type=text placeholder=<?php echo($pays); ?> required>
            </li>
          </ol>
        </fieldset>
		
		<fieldset>
        <legend>Montant total Commande</legend>

        <ol>
          <li>
            <label for=total>Montant à régler</label>
            <input disabled id=total name=total type=text placeholder=<?php echo($total_panier."€"); ?>  >
          </li>
        </ol>
      </fieldset>

		
      <fieldset>
        <legend>informations CB</legend>
        <ol>
          <li>
            <fieldset>
              <legend>Type de carte bancaire</legend>
              <ol>
                <li>
                  <input id=visa name=type_de_carte type=radio>
                  <label for=visa>VISA</label>
                </li>
                <li>
                  <input id=mastercard name=type_de_carte type=radio>
                  <label for=mastercard>Mastercard</label>
                </li>
              </ol>
            </fieldset>
          </li>
          <li>
            <label for=num_cb>N° de carte</label>
            <input id=num_cb name=num_cb type=number required autofocus>
          </li>
          <li>
            <label for=code_secu_cb>Code sécurité</label>
            <input id=code_secu_cb name=code_secu_cb type=number required>
          </li>
          <li>
            <label for=nom_porteur_cb>Nom du porteur</label>
            <input id=nom_porteur_cb name=nom_porteur_cb type=text placeholder="Même nom que sur la carte" required>
          </li>
        </ol>
      </fieldset>

      <fieldset>
        <button  type=submit>J'achète !</button>
      </fieldset>
    </form
  </div>
  </body>
</html>
