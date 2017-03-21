<?php
include("config.inc.php");
$db=mysql_connect($db_host,$db_user,$db_password);
if ($db == FALSE)
die ("Errore nella connessione. Verificare i parametri nel file config.inc.php");
mysql_select_db($db_name,$db) or die ("Errore nella selezione del database. Verificare i parametri nel file config.inc.php");
$query = "CREATE TABLE economia".$anno." (id INT (5) UNSIGNED not null AUTO_INCREMENT, nome VARCHAR (35) not null , cognome VARCHAR (35) not null , paese VARCHAR (35) not null, image VARCHAR (80) not null, premio VARCHAR(30), PRIMARY KEY (id))";
if (mysql_query($query, $db))
	echo "L'installazione è stata eseguita correttamente";
else
	echo "Errore durante l'installazione";
mysql_close($db);
?>