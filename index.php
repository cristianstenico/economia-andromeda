<html>
<head>
<title>Festival dell'Economia 2018</title>
<meta charset="UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/lightbox.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-2.2.4.js"></script>
<script type="text/javascript">
jQuery(window).load(() => {
    $('.img_content').css({
        'padding-top' : ($('.immagine').height() - $('.img_content').height()) / 2
    })
})
let caricaTabella = str => {
	$("#tabella").fadeTo(200, 0.01, () => {
		if (str === 0) {
			$.ajax({
				type: 'GET',
				url: 'getTab.php',
				success: response => {
					$('#tabella').html(response).fadeTo(200, 1)
				}
			})
		} else {
			$.ajax({
				type: 'GET',
				url: 'getTab.php',
				data: `pag=${str}`,
				success: response => {
					$('#tabella').html(response).fadeTo(200, 1)
				}
			})
		}
		$('.pagine').removeClass('active')
		$(`#pag${(str/20+1)}`).addClass('active')
	})
}
</script>
</head>
<body>
<?php
include 'config.inc.php';
$dat = '1';
$dati = "economia" . $anno;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

if (isset($_GET['nome'])) {
    $nome = $_GET['nome'];
}

if (isset($_GET['cognome'])) {
    $cognome = $_GET['cognome'];
}

if (isset($_GET['paese'])) {
    $paese = $_GET['paese'];
}

if (isset($_GET['immagine'])) {
    $immagine = $_GET['immagine'];
}

if (isset($_GET['pag'])) {
    $pag = $_GET['pag'];
}

if (isset($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
    $id = $pagina + 1;
}
$db = mysql_connect($db_host, $db_user, $db_password);
if ($db == false) {
    die("Errore nella connessione. Verificare i parametri nel file config.inc.php");
}

mysql_select_db($db_name, $db)
or die("Errore nella selezione del database. Verificare i parametri nel file config.inc.php");
if (!isset($pag)) {
    $pag = 0;
}

$pag2 = $pag + 20;
$query = "SELECT id, nome, cognome, paese,image FROM $dati ORDER BY -premio DESC, id LIMIT $pag,$pag2";

if (!isset($id)) {
    $id = 1;
}

if (isset($id)) {
    $query3 = "SELECT nome, cognome, paese,image, premio FROM $dati WHERE id=\"$id\" ";
    $result3 = mysql_query($query3, $db);
    $row3 = mysql_fetch_array($result3);
}
$result = mysql_query($query, $db);
$query2 = "SELECT COUNT(*) FROM $dati count";
$numrighe = mysql_query($query2, $db);
mysql_close($db);
?>
<div id="container">
	<div id="header">
		<a href="http://www.festivaleconomia.it" target="_blank"><img id="link-festival" src="img/scoiattolo.png"/></a>
		<!--<div id="link-wrapper"><a id="link-sito" class="arancione" href="http://www.studioandromeda.net">NOI DELL'ANDROMEDA</a></div>-->
	</div>

	<div id="body">
		<div id="left">
			<!--<div id="tema">
				<p><span class="arancione">Tema ></span> I confini della libertà economica</p>
			</div>-->

			<div id="content">
			<?php
if (isset($pagina)) {
    include 'pagine/' . $pagina . '.html';
} else {
    ?>
	  			<div class="immagine" align="center">
					<div class="img_content">
					<?php
echo "<a href=\"upload_img/$anno/$row3[image]\" data-lightbox=\"image$id\" data-title=\"$row3[nome] $row3[cognome] - $row3[paese]\"><img src=\"normal/$anno/$row3[image]\"></a>";
    ?>
					</div>
				</div>
				<div class="autore">
            		<?php
echo "$row3[nome] $row3[cognome] - $row3[paese]";
    if ($row3[premio] != null) {
        echo "<div id=\"premio\">$row3[premio]</div>";
    }

    ?>
				</div>
				<?php }
?>
			</div>
		</div>

		<div id="right">
			<ul>
				<li class="menuelement"><a class="arancione" href="index.php?pagina=come">COME PARTECIPARE</a></li>
				<li class="menuelement"><a class="arancione" href="index.php?dat=1">GALLERY</a></li>
				<li class="menuelement"><a class="arancione" href="index.php?pagina=contatti">CONTATTI</a></li>
			</ul>
			<div id="listimmagini">
				<?php
$row2 = mysql_fetch_array($numrighe);

for ($a = 0; $a < $row2[0] / 20; $a++) {
    $b = $a + 1;
    $c = $a * 20;
    $class = "";
    if (isset($pag) && ($pag / 20 + 1) == $b) {
        $class = "active";
    }
    echo "<a class=\"pagine $class\" id=\"pag$b\" href=# onclick=\"caricaTabella($c)\">  $b  |</a>";
}
?>
			</div>
			<div id="tabella">
      		<?php
echo "<table width=\"243\" border=\"0\" cellspacing=\"3\" class=\"tabella\">";
for ($i = 0; $i < 5; $i++) {
    echo "<tr>\n";
    for ($j = 0; $j < 4; $j++) {
        $row = mysql_fetch_array($result);
        if ($row == false) {
            echo "<td width=\"55\" height=\"55\" class=\"immaginina\"><div align=\"center\"></div></td>\n";
        } elseif (isset($pag)) {
            echo "<td width=\"55\" height=\"55\" class=\"immaginina\"><div align=\"center\"><a href=\"index.php?id=$row[id]&pag=$pag&dat=$dat\"><img src=\"thumb/$anno/$row[image]\"></a></div></td>\n";
        } else {
            echo "<td width=\"55\" height=\"55\" class=\"immaginina\"><div align=\"center\"><a href=\"index.php?id=$row[id]&dat=$dat\"><img src=\"thumb/$anno/$row[image]\"></a></div></td>\n";
        }

    }
    echo "</tr>\n";
}
echo "</table>";
?>
      		</div>

		</div>
	</div>
</div>
<script type="text/javascript" src="js/lightbox.js"></script>
<script>
    lightbox.option({
      'resizeDuration': 500,
	  'fadeDuration' : 300,
      'wrapAround': true
    })
</script>
</body>
</html>
