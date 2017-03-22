<?php
include ("config.inc.php");
include ("top_foot.inc.php");

//intestazione
top();
?>

<form method="post" action="save.php" enctype="multipart/form-data">
Files:<br/>
<input type="file" name="immagini[]" multiple />
<br /><br />
Password:<br />
<input type="password" size="40" name="pass" />
<br /><br />
<input type="submit" value="Inserisci" />
</form>
<?php
// chiusura pagina
foot();
?>