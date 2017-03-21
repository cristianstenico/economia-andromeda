<?php
include("top_foot.inc.php");
include("config.inc.php");
top();
?>
<p>
<?php
$db = mysql_connect($db_host, $db_user, $db_password);
if ($db == FALSE)
    die ("Errore nella connessione. Verificare i parametri nel file config.inc.php");
 mysql_select_db($db_name, $db)
    or die ("Errore nella selezione del database. Verificare i parametri nel file config.inc.php");
$pass=$_REQUEST['pass'];
if ($pass != $password)
	die("Password errata!");
if (isset($_FILES['immagini'])) {
	$immagine = $_FILES['immagini'];
	$fileCount = count($immagine["name"]);

	for ($i = 0; $i < $fileCount; $i++)
	{
		if(@is_array(getimagesize($immagine["tmp_name"][$i])))
		{
			if (!move_uploaded_file($immagine["tmp_name"][$i], 'upload_img/'.$anno.'/'.$immagine["name"][$i])) {
				?>
				<span style="color:red">Errore nell'upload del file: <?= $immagine["name"][$i] ?></span><br/>
				<?php
			}
			else
			{
				$img_name = $immagine["name"][$i];
				if(preg_match("/(.+)_(.+)-(.+)-([0-9]+)/", $img_name, $output_array))
				{
					$nome_autore =  ucwords(str_replace("_", " ", $output_array[1]));
					$cognome_autore = ucwords(str_replace("_", " ",$output_array[2]));
					$paese = ucwords(str_replace("_", " ",$output_array[3]));
				
					$query = "INSERT INTO economia$anno (nome, cognome, paese, image) VALUES ('$nome_autore', '$cognome_autore', '$paese', '$img_name')";
					if (mysql_query($query, $db)){
						//resize thumb
						$destdir="thumb/".$anno."/";
						$src="upload_img/".$anno."/".$immagine["name"][$i];
						list($width, $height, $type, $attr) = getimagesize($src);
						$img = imagecreatefromjpeg($src);
						$lowest = min(54 / $width, 54 / $height);

						$smallwidth = floor($lowest*$width);
						$smallheight = floor($lowest*$height);
						$tmp=imagecreatetruecolor($smallwidth,$smallheight);
						imagecopyresized($tmp, $img, 0, 0, 0, 0, $smallwidth, $smallheight, $width, $height);
						imagejpeg($tmp,$destdir.$immagine["name"][$i], 100);

						//resize normal
						$destdir="normal/".$anno."/";
						$src="upload_img/".$anno."/".$immagine["name"][$i];
						list($width, $height, $type, $attr) = getimagesize($src);
						$img = imagecreatefromjpeg($src);
						$lowest = min(383 / $width, 388 / $height);

						$smallwidth = floor($lowest*$width);
						$smallheight = floor($lowest*$height);
						$tmp=imagecreatetruecolor($smallwidth,$smallheight);
						imagecopyresized($tmp, $img, 0, 0, 0, 0, $smallwidth, $smallheight, $width, $height);
						imagejpeg($tmp,$destdir.$immagine["name"][$i], 100);
					?>
						File caricato: <?= $immagine["name"][$i] ?><br/>
					<?php
					}
					else{
					?>
						<span style="color:red">Errore nel caricare il file: <?= $immagine["name"][$i] ?></span><br/>
					<?php
					}
				}
				else
				{
				?>	
					<span style="color:red">Errore nel file: <?= $immagine["name"][$i] ?></span><br/>
				<?php
				}
			}
		}
		else
		{
		?>
			<span style="color:red">Errore nel file: <?= $immagine["name"][$i] ?></span><br/>
		<?php
		}
    }	
}
mysql_close($db);
?>
</p>
<?php
	foot();
?>