<?php
include "config.inc.php";
if ($_POST["pass"] == $password) {
	session_start();
	$_SESSION['access'] = true;
	header("Location:insert.php");
	exit();
} else {
    header("Location:login.php");
    exit();
}
