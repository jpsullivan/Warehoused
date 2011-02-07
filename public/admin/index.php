<?php

if (isset($_REQUEST['password']))
	$password = $_REQUEST['password'];

if(isset($password)) {
	if($password == "hogans" || $password == "HOGANS") {
		header("Location: http://www.hogansinfo.com/admin/main.php");
	}
}
?>

<html>
<head>
	<title>WebSheets</title>
	<link href="styles/inv_style.css" rel="stylesheet" type="text/css">
</head>
<body style="margin: 0">

<br><br><br><br><br><br><br><br>
<center><font size="8" family="arial, helvetica, sans-serif"><i><b>WebSheets</b></i></font></center>
<table width="100%" height="100" bgcolor="#D4D0C8">
	<tr>
		<td>
			<table align="center">
				<form action="index.php" method="post">
				<tr>
					<td><b>Password</b></td>
					<td>
						<input type="password" name="password" size="10" class="inputText">
						<input type="submit" name="login" value="Login" class="inputButton">
					</td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>

</body>
</html>
<script type="text/html">
