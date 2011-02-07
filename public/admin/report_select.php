<?

include "lib/sheets.php";

$rep_what = "";
$rep_where = "";
$rep_sort = "<option></option>";
$tab = "&nbsp;&nbsp;";
$size = count($colNames);

//Construct What Column
foreach ($colNames as $key => $value) {
	if ($key == "status" || $key == "entered" || $key == "updated") {
		$rep_what .= "<option value='$key'>$value</option>";
	} else {
		$rep_what .= "<option value='$key' selected>$value</option>";
	}
}

//Construct Where Column
foreach ($colNames as $key => $value) {
	$whereOptions = "
		<select name='select-$key'>
			<option value='='>=</option>
			<option value='!='>!=</option>
			<option value='like'>LIKE</option>
			<option value='>'>></option>
			<option value='>='>>=</option>
			<option value='<'><</option>
			<option value='<='><=</option>
		</select>
	";

	if ($key == "status") {
		$rep_where .= "
			<tr>
				<td><input type='checkbox' name='rep_where_array[]' value='$key' checked></td>
				<td>$value $tab</td>
				<td>$whereOptions</td>
				<td><input type='text' name='text-$key' value='A'></td>
			</tr>
	
		";
	} else {
		$rep_where .= "
			<tr>
				<td><input type='checkbox' name='rep_where_array[]' value='$key'></td>
				<td>$value $tab</td>
				<td>$whereOptions</td>
				<td><input type='text' name='text-$key'></td>
			</tr>
	
		";
	}
}

//Construct Sort Column
foreach ($colNames as $key => $value) {
	$rep_sort .= "<option value='$key'>$value</option>";
}

?>

<html>
<head>
	<link href="styles/inv_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<table align="center">
	<tr>
		<td align="center"><h2>Create Report</h2></td>
	</tr>
</table>
<br>
<table cellspacing="1" cellpadding="3" border="0" bgcolor="black" align="center">
<form method="post" action="report_display.php">
<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
	<tr>
		<th bgcolor='#F0F0F0'>WHAT</th>
		<th bgcolor='#F0F0F0'>WHERE</th>
		<th bgcolor='#F0F0F0'>ORDER BY</th>
	</tr>
	<tr>
		<td bgcolor="white" align="center" valign="top">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<select multiple='multiple' size='<? echo $size; ?>' name='rep_what_array[]' class="inputReport">
							<? echo $rep_what; ?>
						</select>
					</td>
				</tr>
			</table>
		</td>

		<td bgcolor="white" align="center" valign="top">
			<table cellspacing="0" cellpadding="0">
				<? echo $rep_where; ?>
			</table>
		</td>

		<td bgcolor="white" align="center" valign="top">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<select name="orderBy01">
							<? echo $rep_sort; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<select name="orderBy02">
							<? echo $rep_sort; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<select name="orderBy03">
							<? echo $rep_sort; ?>
						</select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3" bgcolor="white" align="center"><input type="submit" value="Generate Report"></td>
	</tr>
</form>
</body>
</html>
<script type="text/html">