<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
$code_client= "";			
$mdp="";
	

  Function Msg($num) {
	  
	  
	switch ($num) {
    case 1:
        $Msg = "Utilisateur ou mot de passe invalide !";
        break;
    case 2:
         $Msg = "Utilisateur invalide !";
        break;
    case 3:
         $Msg = "Mot de passe invalide !";
        break;
    default:
         $Msg = "Erreur inconnue";
	} 
  }  
	

	$_SESSION['timeout']  = 360;

  $message = 0;
  $cpt_valide=false;
if(!empty($_POST['saisie_form'])){
	
	include 'connect_bd.php'; // connexion à la base de données MySQL

	$code_client= @$_POST['code_client'];			
	$mdp=@$_POST['mdp'];
	
	
	$sql_sel = "select * from client Where code_client =:code_client and mdp=MD5(:mdp)" ;
	
	//echo $sql_sel;
					
	$stmt = $bdd->prepare($sql_sel);
	$stmt->bindParam(':mdp',$mdp, PDO::PARAM_STR, 50);
	$stmt->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
	$stmt->execute();
	
				
	while ($donnees = $stmt->fetch())
			{
			$cpt_valide=true;
				echo "je suis dans le while";
			$code_client= $donnees['code_client'];
			$email= $donnees['email'];
			$nom= $donnees['nom'];
			$prenom= $donnees['prenom'];
			$civilite=$donnees['civilite'];
			$mdp=$donnees['mdp'];
			}
			
	$stmt->closeCursor(); // Termine le traitement de la requête

	if ($cpt_valide){
	//echo $code_client;	
	$_SESSION['code_client'] = $code_client;
	$_SESSION['email'] = $email;
	$_SESSION['nom'] = $nom;
	$_SESSION['prenom'] = $prenom;
	$_SESSION['civilite'] = $civilite;
	$_SESSION['mdp_session'] = $mdp;
	$message=5;
	//routage 
	$url="Location: /achat_produits.php?code_client=".$code_client;
	header($url);
	
	}
} else {
	$code_client="";
	$message=1;}
?>


	

<HTML>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style_form_client.css" rel="stylesheet" media="all" type="text/css"> 
</head>


	    

<div align="center">
    <h1>Site VP Chti</h1>
 
   
	
	
<form action="login.php" method="POST" name="formulaire" id="client">
<input type="Hidden" name="saisie_form" value="True">

      <fieldset>
        <legend>Authentification</legend>

        <ol>
          <li>
            <label for="code_client">Compte client</label>
            <input id="code_client" name="code_client" type="text" placeholder="Email" value="<?php echo $code_client ?>"  required>
          </li>
		   <li>
            <label for="mdp">Mot de passe</label>
            <input id="mdp" name="mdp" type="password" placeholder=""  >
          </li>
        </ol>
      </fieldset>

     
		
     

      <fieldset>
        <button  type=submit value="">Valider</button>
      </fieldset>
	  
    </form>
	 <a class="url" href="upd_client.php">Pas encore Membre, inscrivez-vous maintenant !</a>
 </div>





</HTML>	