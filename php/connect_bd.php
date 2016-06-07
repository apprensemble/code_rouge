

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

?>