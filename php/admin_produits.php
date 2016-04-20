<HTML>

<script language="javascript">
<!--
 function verif_supprim (ele){
     if (window.confirm('voulez-vous vraiment supprimer ce produit?'))
         { window.location = ele;
        }
    }
//-->
</script>

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
</head>



<?php
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

// Si tout va bien, on peut continuer
	if(!empty($_GET['supp_id'])){
		//echo $_GET['supp_id'];

        $sql_del = "Delete from produits Where Code ='".$_GET['supp_id']."'" ;
        $bdd->exec($sql_del);
		//echo $sql_del;


    }

?>

<body>

<table width="750" border="0" cellspacing="2" cellpadding="3" align="CENTER">
        <tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Ajouter un produit" onclick="javascript : window.location='upd_utilisateur.asp';" class="bouton">
            </td>
        </tr>
        <tr>
            <td width="15%" class="LigneTitreTab" >
                <b>Code</b>
            </td>
			<td width="35%" class="LigneTitreTab" >
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
$reponse = $bdd->query('select * from produits');

// On affiche chaque entrée une à une




while ($donnees = $reponse->fetch())
{
?>



        <tr>
            <td class="ligneTab">
                <b><?php  echo $donnees['Code']; ?></b>
            </td>
			<td class="ligneTab">
                <b><?php  echo $donnees['Libelle']; ?></b>
            <td class="ligneTab">
                <b><?php  echo $donnees['Prix_HT']; ?></b>
            </td>
            <td  width="13%" align="CENTER" class="ligneTab">
                <input type="button" value="Détail" onclick="javascript: parent.bas.location.href = 'aff_produits.php?aff_id=<?php  echo $donnees['Code']; ?>';" class="bouton">
            </td>
            <td  width="13%" align="CENTER" class="ligneTab">
                <input type="button" value="Modifier" onclick="javascript: parent.bas.location.href= 'upd_produits.php?upd_id=<?php  echo $donnees['Code']; ?>';" class="bouton">
            </td>
            <td  width="14%" align="CENTER" class="ligneTab">
			
             <input type="button" value="Supprimer" onclick="javascript: verif_supprim ('/admin_produits.php?supp_id=<?php  echo $donnees['Code']; ?>');" class="bouton">
            
            </td>
        </tr>

<?php	}  ?>

		
		<tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Ajouter un produit" onclick="javascript : window.location='upd_produits.php';" class="bouton">
            </td>
        </tr>
</table>




</body>





	
	
	
	
<?php

$reponse->closeCursor(); // Termine le traitement de la requête

?>



</HTML>
