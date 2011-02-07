<?php

include "lib/dbconnect.php";
include "lib/sheets.php";

//Assign variables when "globals" are turned off
if(isset($_REQUEST['name']))
	$name = $_REQUEST['name'];
if(isset($_REQUEST['value']))
	$value = $_REQUEST['value'];
if(isset($_REQUEST['id']))
	$id = $_REQUEST['id'];
if(isset($_REQUEST['search']))
	$search = $_REQUEST['search'];

if(isset($id) && $name != "updated" && $name != "entered") {
	$value = nl2br(htmlspecialchars($value, ENT_QUOTES));
	$value = preg_replace("/(http:\/\/)?([a-zA-Z0-9\-.]+\.[a-zA-Z0-9\-]+([\/]([a-zA-Z0-9_\/\-.?&%=+])*)*)/", '<a href="http://$2" target="_blank">http://$2</a>', $value);
	$sql = "update $tablename set `$name` = '$value', updated = now() where `id` = $id";
	$result = mysql_query($sql,$connection) or die(mysql_error());
}

?>
