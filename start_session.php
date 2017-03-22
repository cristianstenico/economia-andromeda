<?php
include("config.inc.php");
if ($_POST["pass"] == $password) {
	start_session();
	header("Location:insert.php");
	exit();
} else {
	header("Location:login.php");
	exit();
}
?>