<?php
include('config.inc.php');
$db = mysql_connect($db_host, $db_user, $db_password);
if ($db == FALSE)
	die ("Errore nella connessione. Verificare i parametri nel file config.inc.php");
mysql_select_db($db_name, $db)
or die ("Errore nella selezione del database. Verificare i parametri nel file config.inc.php");

$dati="economia".$anno;

if(isset($_GET['pag'])) {
	$pag=$_GET['pag'];
	$pag2=$pag+20;
	$query="SELECT id, nome, cognome, paese,image FROM $dati ORDER BY id LIMIT $pag,$pag2";	
} else {
	$query = "SELECT id, nome, cognome, paese,image FROM $dati ORDER BY id LIMIT 0,20";
}

$result = mysql_query($query, $db);
echo "<table width=\"243\" border=\"0\" cellspacing=\"3\" class=\"tabella\">";
for($i=0;$i<5;$i++){
	echo "<tr>\n";
	for($j=0;$j<4;$j++){
		$row = mysql_fetch_array($result);
		if($row==FALSE)
			echo "<td width=\"55\" height=\"55\" class=\"immaginina\"><div align=\"center\"></div></td>\n";
		elseif (isset($pag))
			echo "<td width=\"55\" height=\"55\" class=\"immaginina\"><div align=\"center\"><a href=\"index.php?id=$row[id]&pag=$pag&dat=$dat\"><img src=\"thumb/$anno/$row[image]\"></a></div></td>\n";
		else
			echo "<td width=\"55\" height=\"55\" class=\"immaginina\"><div align=\"center\"><a href=\"index.php?id=$row[id]&dat=$dat\"><img src=\"thumb/$anno/$row[image]\"></a></div></td>\n";
	}
	echo "</tr>\n";
}
echo "</table>";
mysql_close($db);
?>