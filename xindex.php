<?php
include "top_foot.inc.php";
include "config.inc.php";
top();
$db = mysql_connect($db_host, $db_user, $db_password);
if ($db == false) {
    die("Errore nella connessione. Verificare i parametri nel file config.inc.php");
}

mysql_select_db($db_name, $db)
or die("Errore nella selezione del database. Verificare i parametri nel file config.inc.php");
$query = "SELECT id, nome, cognome, paese FROM immagini ORDER BY id DESC LIMIT 0,5";
$result = mysql_query($query, $db);
while ($row = mysql_fetch_array($result)) {
    echo "<a href=\"view.php?id=$row[id]\"> $row[nome] - $row[cognome] - $row[paese]</a><br>";
}
mysql_close($db);
foot();
