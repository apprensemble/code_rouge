<HTML>


















<script language="javascript">
<!--
 function verif_supprim (ele){
     if (window.confirm('voulez-vous réellement supprimer cet élément?'))
         { window.location = ele;
        }
    }
//-->
</script>

<head>




<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
</head>



<?php
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

// Si tout va bien, on peut continuer

?>

<body>
    <table width="780" border="0" cellspacing="2" cellpadding="3" align="CENTER">

        <tr>
            <td width="780" height="50" class="ptitre"><img src="/images/dot.gif" alt=""  width="25" height="1">Gestion des Produits</td>
        </tr>
	<tr>
		<td colspan="4" width="780"><img src="/images/point780.gif" alt="" width="780" height="4"></td>
	</tr>
	<tr>
		<td colspan="4" width="780"><img src="/images/dot.gif" alt=""  height="10"></td>
	</tr>
	
    </table>
    <table width="750" border="0" cellspacing="2" cellpadding="3" align="CENTER">
        <tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Ajouter un produit" onclick="javascript : window.location='upd_utilisateur.asp';" class="bouton">
            </td>
        </tr>
        <tr>
            <td width="10%" class="LigneTitreTab" >
                <b>Code</b>
            </td>
			<td width="25%" class="LigneTitreTab" >
                <b>Nom du Produit</b>
            </td>
            <td width="25%" class="LigneTitreTab">
                <b>Prix HT</b>
            </td>
            <td align="CENTER" colspan="3" class="LigneTitreTab">
                <b>Action</b>
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
                <input type="button" value="Modifier" onclick="javascript: window.location = 'upd_utilisateur.asp?IdUser=IdUser';" class="bouton">
            </td>
            <td  width="13%" align="CENTER" class="ligneTab">
                <input type="button" value="Groupes" onclick="javascript: window.location = 'upd_utilisateurgroupes.asp?IdUser=IdUser';" class="bouton">
            </td>
            <td  width="14%" align="CENTER" class="ligneTab">
			
             <input type="button" value="Supprimer" onclick="javascript: verif_supprim ('../asp/Liste_Utilisateurs.asp?supp_id=IdUser');" class="bouton">
            
            </td>
        </tr>

	<tr>
            <td colspan="7" align="center" bgcolor="white">
                <input type="button" value="Ajouter un produit" onclick="javascript : window.location='upd_utilisateur.asp';" class="bouton">
            </td>
        </tr>
    </table>




</body>





	
	
	
	
<?php
}

$reponse->closeCursor(); // Termine le traitement de la requête

?>



</HTML>