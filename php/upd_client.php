<?php
//définition de fonctions
session_start();


// initialisation des variables

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

// si le formulaire est validé alors on peut inserer un client ou modifier un client
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

	// si la demande de modification est valide
	if(!empty($_GET['upd_id'])){
		// on controle que le client est connecté sinon authentification
		if(empty($_SESSION['mdp_session'])){
			session_unset();
			header("Location: /login.php");
		}

	$upd_id=$_GET['upd_id'];
	$mdp_session=$_SESSION['mdp_session'];
		//echo $mdp_session;

		
	// sql de mise à kour du client	
    $sql_upd = "UPDATE client SET  email= :email, nom= :nom, prenom= :prenom, civilite=:civilite, adresse= :adresse,code_postal= :code_postal,  ville= :ville,  pays= :pays,  mdp= MD5(:mdp) WHERE code_client = :upd_id and mdp='".$mdp_session."'";	
			

	//echo $sql_upd;
	$stmt = $bdd->prepare($sql_upd);
	$stmt->bindParam(':upd_id',$upd_id, PDO::PARAM_STR, 10);
	$stmt->bindParam(':email',$email, PDO::PARAM_STR, 60);
	$stmt->bindParam(':nom',$nom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':prenom',$prenom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':civilite',$civilite,PDO::PARAM_STR, 12);
	$stmt->bindParam(':adresse',$adresse,PDO::PARAM_STR, 300);
	$stmt->bindParam(':code_postal',$code_postal,PDO::PARAM_STR, 5);	
	$stmt->bindParam(':ville',$ville, PDO::PARAM_STR, 50);
	$stmt->bindParam(':pays',$pays,PDO::PARAM_STR, 50);
	$stmt->bindParam(':mdp',$mdp,PDO::PARAM_STR, 50);

	$stmt->execute();
	
	
	}
	else
	{
	// sql de création du client
	 $sql_insert="INSERT INTO client (code_client, email, nom, prenom, civilite, adresse, code_postal, ville, pays, mdp) VALUES (:code_client, :email, :nom, :prenom, :civilite, :adresse, :code_postal, :ville, :pays, MD5(:mdp))";
	//echo $sql_insert;
	 
	$stmt = $bdd->prepare($sql_insert); 
	$code_client=$email;
	$stmt->bindParam(':code_client',$code_client, PDO::PARAM_STR, 60);
	$stmt->bindParam(':email',$email, PDO::PARAM_STR, 60);
	$stmt->bindParam(':nom',$nom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':prenom',$prenom, PDO::PARAM_STR, 100);
	$stmt->bindParam(':civilite',$civilite,PDO::PARAM_STR, 12);
	$stmt->bindParam(':adresse',$adresse,PDO::PARAM_STR, 300);
	$stmt->bindParam(':code_postal',$code_postal,PDO::PARAM_STR, 5);	
	$stmt->bindParam(':ville',$ville, PDO::PARAM_STR, 50);
	$stmt->bindParam(':pays',$pays,PDO::PARAM_STR, 50);
	$stmt->bindParam(':mdp',$mdp,PDO::PARAM_STR, 50);
 
     $stmt->execute();	 
	}
	
	
	header('Location: /login.php');
}

else
{
	//echo "je suis dans le select"."   et oui oui yes";
	
	 
	
	//echo "upd_id=".$_GET['upd_id'];

	if(!empty($_GET['upd_id'])){
			if(empty($_SESSION['mdp_session'])){
			session_unset();
			header("Location: /login.php");
			}
			$upd_id=$_GET['upd_id'];
			//echo "upd_id=".$upd_id;
			$mdp_session=$_SESSION['mdp_session'];
			//echo "mdp_session=".$mdp_session;
				
			$sql_sel = "select * from client Where code_client =:code_client and mdp=:mdp" ;
	
			//echo $sql_sel;
					
			$stmt = $bdd->prepare($sql_sel);
			$stmt->bindParam(':mdp',$mdp_session, PDO::PARAM_STR, 50);
			$stmt->bindParam(':code_client',$upd_id, PDO::PARAM_STR, 60);
			$stmt->execute();
	
				
			while ($donnees = $stmt->fetch())
					{
					//$cpt_valide=true;
					//echo "je suis dans le while";
					$code_client= $donnees['code_client'];
					$email= str_replace(' ', '&nbsp;',$donnees['email']);
					$nom= str_replace(' ', '&nbsp;',$donnees['nom']);
					$prenom= str_replace(' ', '&nbsp;',$donnees['prenom']);
					$civilite=$donnees['civilite'];
					$adresse=str_replace(' ', '&nbsp;',$donnees['adresse']);
					//echo "adresse :".$adresse;
					$code_postal=$donnees['code_postal'];
					$ville=str_replace(' ', '&nbsp;',$donnees['ville']);
					$pays=str_replace(' ', '&nbsp;',$donnees['pays']);
					
					}
			
			$stmt->closeCursor(); // Termine le traitement de la requête
	}
}



?>

<HTML>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style_form_client.css" rel="stylesheet" media="all" type="text/css"> 
</head>
<script type="text/javascript">
function ctrl_mail(mail)

{
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
	if (!reg.test(mail)){
		alert("Veuillez saisir une adresse email valide !");
	}
	return(reg.test(mail));
}



function verif_formulaire()
{
	var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
	if (!reg.test(document.formulaire.email.value)){
		alert("Veuillez saisir une adresse email valide !");
		return (false);
	}
	

 if(document.formulaire.nom.value == "")  {
   alert("Veuillez saisir votre nom!");
   document.formulaire.nom.focus();
   return false;
  }
 if(document.formulaire.prenom.value == "") {
   alert("Veuillez saisir votre prénom!");
   document.formulaire.prenom.focus();
   return false;
  }
   if(document.formulaire.adresse.value == "") {
   alert("Veuillez votre adresse complète de résidence!");
   document.formulaire.adresse.focus();
   return false;
  }
 
  if(document.formulaire.ville.value == "") {
   alert("Veuillez saisir votre ville de résidence!");
   document.formulaire.ville.focus();
   return false;
  }
   if(document.formulaire.pays.value == "") {
   alert("Veuillez entrer votre pays de résidence!");
   document.formulaire.ville.focus();
   return false;
  }
  if(document.formulaire.code_postal.value == "") {
   alert("Veuillez entrer un code postal sur 5 chiffres!");
   document.formulaire.code_postal.focus();
   return false;
  }
  
  if(document.formulaire.mdp.value.length < 6) {
   alert("Veuillez entrer un mot de passe contenant 6 caractères minimum!");
   document.formulaire.mdp.focus();
   return false;
  }
  
  if(document.formulaire.mdp.value != document.formulaire.mdpconfirme.value) {
   alert("Vous n'avez pas confirmer correctement votre mot de passe");
   document.formulaire.mdpconfirme.focus();
   return false;
  }
  
 
 
 if(document.formulaire.code_postal.value.length != 5) {
   alert("Le code postal doit être composé de 5 chiffres !");
   document.formulaire.code_postal.focus();
   return false;
  }
  
 var chkZ = 1;
 
 for(i=0;i<document.formulaire.code_postal.value.length;++i){
	 if(document.formulaire.code_postal.value.charAt(i) < "0"
   || document.formulaire.code_postal.value.charAt(i) > "9")
     chkZ = -1;
	} 
   
 if(chkZ == -1) {
   alert("Le code postal n'est pas valide !");
   document.formulaire.code_postal.focus();
   return false;
  }
  
}

</script>

	    
	    

<div align="center">
    <h1><?php If ($code_client <> ""){echo "Modification";} else {echo "Création";} ?> de votre compte client</h1>
 
   
	
	
<form action="upd_client.php?upd_id=<?php echo $upd_id; ?>" method="POST" id=client name="formulaire" enctype="multipart/form-data" onsubmit="return verif_formulaire()" align=center>
<input type="hidden" name="saisie_form" value="True">
<input type="hidden" name="code_client" value="<?php $code_client ?>">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000">    

      <fieldset>
        <legend>Votre identité</legend>

        <ol>
          <li>
            <label for=nom>Nom</label>
            <input id=nom name=nom type=text placeholder="" value="<?php echo $nom ?>"  required>
          </li>
		  <li>
            <label for=nom>Prénom</label>
            <input  id=prenom name=prenom type="Prénom"  placeholder="" value="<?php echo $prenom ?>"  required>
          </li>
          <li>
            <label for=email>Email</label>
            <input  id=email name=email type=email placeholder="" value="<?php echo $email ?>" required>
          </li>
		  <li>
            <label for=civilité>Civilité</label>
				<SELECT name="civilite" size="1">
					<OPTION>Monsieur
					<OPTION>Madame
					<OPTION>Mademoiselle
				</SELECT>
          </li>
        </ol>
      </fieldset>

      <fieldset>
        <legend>Adresse personnelle</legend>
          <ol>
            <li>
              <label for=adresse>Adresse</label>
              <textarea  id=adresse name=adresse rows=3 placeholder="" ><?php echo $adresse ?></textarea>
            </li>
            <li>
              <label for=codepostal>Code postal</label>
              <input   id=code_postal name=code_postal type=text placeholder="" value="<?php echo $code_postal ?>" required>
            </li>
			<li>
              <label for=ville>Ville</label>
              <input   id=ville name=ville type=text placeholder="" value="<?php echo $ville ?>" required>
            </li>
              <li>
              <label for=pays>Pays</label>
              <input  id=pays name=pays type=text placeholder="" value="<?php echo $pays ?>" required>
            </li>
          </ol>
        </fieldset>
		
		<fieldset>
        <legend>Choisir un Mot de passe</legend>

        <ol>
          <li>
            <label for=mdp>Mot de passe</label>
            <input id=mdp name=mdp type=password placeholder="Saisir un mdp avec 6 caractères min"  >
          </li>
		  <li>
            <label for=mdpconfirme>Confirmation Mdp</label>
            <input  id=mdpconfirme name=mdpconfirme type=password placeholder="Confirmer le mdp"  >
          </li>
        </ol>
      </fieldset>

		
     

      <fieldset>
        <button  type=submit value="<?php If ($code_client <> ""){echo "Modifier";} else {echo "Enregistrer";} ?>">Valider</button>
      </fieldset>
    </form>
 </div>





</HTML>	