<?php include "top_foot.inc.php";
include "config.inc.php";
top();
$db = mysql_connect($db_host, $db_user, $db_password);
if ($db == false) {
    die("Errore nella connessione. Verificare i parametri nel file config.inc.php");
}

mysql_select_db($db_name, $db)
or die("Errore nella selezione del database. Verificare i parametri nel file config.inc.php");
$id = $_GET['id'];
$query = "SELECT titolo,testo,data,autore,mail FROM news WHERE id='$id'";
$result = mysql_query($query, $db);
$row = mysql_fetch_array($result);

$data = date("j/n/y", $row[data]);
echo "<b>$row[titolo]</b><br><br>";
echo "$row[testo]<br><br>";
if ($row[mail] != "") {
    echo "$data, <a href=mailto:$row[mail]>$row[autore]</a><br>";
} else {
    echo "$data, $row[autore]<br>";
}

echo "<br><a href=index.php>Torna alla pagina iniziale</a><br>";
mysql_close($db);
foot();
