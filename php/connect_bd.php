

<?php
try
{
	// On se connecte à MySQL
	
$bdd = new PDO('mysql:host=mariadb;dbname=gestion_site;charset=utf8', 'root', 'mysqlRoot.');
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

?>
