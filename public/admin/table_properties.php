<?

include "lib/dbconnect.php";


// Creates column selection drop-down menu
$columns = "<option value=''>Select Column</option>";

if (isset($sheet) && $sheet != "") {
	$sql = "describe $sheet";
	$result = mysql_query($sql, $connection);
	
	while ($row = mysql_fetch_array($result)) {
		$field = $row['Field'];
		if ($field != "index" && $field != "status" && $field != "entered" && $field != "updated") {
			$columns .= "<option value='$field'>$field</option>";
		}
	}
}

// Add New Column to Table
if (isset($addColumn) && $addColumn == 1) {
	if (isset($datatype) && isset($size)) {
		if($datatype == "char") {
			$datatype = "char($size)";
		} elseif ($datatype == "int") {
			$datatype = "int($size)";
		} elseif ($datatype == "text") {
			$datatype = "text";
		} elseif ($datatype == "varchar") {
			$datatype = "varchar($size)";
		}
	} else {
			$datatype = "";
	}

	if (isset($after) && $after != "") {
		$after = "after $after";
	} else {

		$after = "after `status`";
	}

	$sql = "alter table $sheet add $newColumn $datatype $after";
	$result = mysql_query($sql,$connection) or die(mysql_error());

	echo "
		<script language='javascript'>
			parent.frames['navFrame'].location.href='inv_edit_nav.php?sheet=$sheet';
			parent.frames['editFrame'].location.href='inv_edit.php?sheet=$sheet';
		</script>
	";
}

// Deletes column from table
if (isset($deleteColumn) && $deleteColumn == 1) {
	$sql = "alter table $sheet drop $deleteThis";
	$result = mysql_query($sql,$connection) or die(mysql_error());

	echo "
		<script language='javascript'>
			parent.frames['navFrame'].location.href='inv_edit_nav.php?sheet=$sheet';
			parent.frames['editFrame'].location.href='inv_edit.php?sheet=$sheet';
		</script>
	";
}

// Creates new table
if (isset($newTable) && $newTable == 1) {
	$sql = "create table $tablename (`index` int(10) not null auto_increment, primary key (`index`), `status` char(1), `entered` datetime, `updated` datetime)";
	$result = mysql_query($sql,$connection) or die(mysql_error());
	
	echo "
		<script language='javascript'>
			parent.frames['navFrame'].location.href='inv_edit_nav.php?sheet=$tablename';
			parent.frames['editFrame'].location.href='inv_edit.php?sheet=$tablename';
		</script>
	";
}

// Delete Table
if (isset($deleteTable) && $deleteTable == 1) {
	$sql = "drop table $deleteTableName";
	$result = mysql_query($sql,$connection) or die(mysql_error());

	$sql = "delete from sheets where sheet = '$deleteTableName'";
	$result = mysql_query($sql,$connection) or die(mysql_error());

	echo "
		<script language='javascript'>
			parent.frames['navFrame'].location.href='inv_edit_nav.php';
			parent.frames['editFrame'].location.href='inv_edit.php';
		</script>
	";
}

// Edit Column
if (isset($editColumn) && $editColumn == 1) {
	if (isset($datatype) && $size != "") {
		if($datatype == "char") {
			$datatype = "char($size)";
		} elseif ($datatype == "int") {
			$datatype = "int($size)";
		} elseif ($datatype == "text") {
			$datatype = "text";
		} elseif ($datatype == "varchar") {
			$datatype = "varchar($size)";
		}
	} else {
		$sql = "describe $sheet";
		$result = mysql_query($sql, $connection);
		
		while ($row = mysql_fetch_array($result)) {
			$field = $row['Field'];
			$type = $row['Type'];
	
			if ($field == $editCol) {
				$datatype = $type;
			}
	
		}
	}

	if ($newName == "") {
		$newName = $editCol;
	}

	$sql = "alter table $sheet change $editCol $newName $datatype";
	$result = mysql_query($sql,$connection) or die(mysql_error());

	echo "
		<script language='javascript'>
			parent.frames['navFrame'].location.href='inv_edit_nav.php?sheet=$sheet';
			parent.frames['editFrame'].location.href='inv_edit.php?sheet=$sheet';
		</script>
	";
}

?>


<html>
<head>
	<title></title>
	<link href="styles/inv_style.css" rel="stylesheet" type="text/css">
</head>
<body>

<table align="center" cellpadding="4">
	<tr>
		<td colspan="5" align="center"><h2>Properties for "<? echo $sheet; ?>"</h2></td>
	</tr>
	<tr>
		<td valign="top" colspan="3">
			<table align="center">
				<form action="table_properties.php">
				<input type="hidden" name="addColumn" value="1">
				<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
				<tr>
		
					<td colspan="5"><h3><u>Add Column</u></h3></td>
				</tr>
				<tr>
					<td><b>Insert After:</b></td>
					<td><b>Name:</b></td>
					<td><b>Type:</b></td>
					<td><b>Size:</b></td>
				</tr>
				<tr>
					<td>
						<select name="after" class="inputText">
							<? echo $columns; ?>
						</select>
					</td>
	
					<td><input type="text" name="newColumn" class="inputText"></td>
					<td>
						<select name="datatype" class="inputText">
							<option value="varchar">Letters and Numbers</option>
							<option value="char">Just Letters</option>
							<option value="int">Just Numbers</option>
							<option value="text">Paragraphs</option>
						</select>
					</td>
					<td><input type="text" name="size" size="3" class="inputText"></td>
					<td><input type="image" src="icons/nav-new.gif" value="Add Sheet" class="inputImageButton"></td>
				</tr>
				</form>
			</table>
		</td>
</tr>
<tr>
		<td valign="top" colspan="3">
			<table align="center">
				<form action="table_properties.php">
				<input type="hidden" name="editColumn" value="1">
				<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
				<tr>
		
					<td colspan="5"><h3><u>Edit Column</u></h3></td>
				</tr>
				<tr>
					<td><b>Edit Which:</b></td>
					<td><b>New Name:</b></td>
					<td><b>Type:</b></td>
					<td><b>Size:</b></td>

				</tr>
				<tr>
		
					<td>
						<select name="editCol" class="inputText">
							<? echo $columns; ?>
						</select>
					</td>
					<td><input type="text" name="newName" class="inputText"></td>
					<td>
						<select name="datatype" class="inputText">
							<option value="varchar">Letters and Numbers</option>
							<option value="char">Just Letters</option>
							<option value="int">Just Numbers</option>
							<option value="text">Paragraphs</option>
						</select>
					</td>
					<td><input type="text" name="size" size="3" class="inputText"></td>
					<td><input type="image" src="icons/nav-new.gif" value="Edit Column" class="inputImageButton"></td>
				</tr>
				</form>
			</table>
		</td>
</tr>
<tr>
		<td valign="top">
			<table align="center">
				<form action="table_properties.php">
				<input type="hidden" name="deleteColumn" value="1">
				<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
				<tr>
					<th colspan="2"><h3><u>Delete Column</u></h3></th>
				</tr>
				<tr>
					<td>
						<select name="deleteThis" class="inputText">
							<? echo $columns; ?>
						</select>
					</td>
					<td><input type="image" src="icons/nav-delete.gif" value="Delete Column" onclick="javascript:return confirm('Are you sure you want to delete this?');" class="inputImageButton"></td>
				</tr>
				</form>
			</table>
		</td>
		<td valign="top">
			<table align="center">
				<form action="table_properties.php">
				<input type="hidden" name="newTable" value="1">
				<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
				<tr>
					<th colspan="2"><h3><u>Create Sheet</u></h3></th>
				</tr>
				<tr>
					<td><input type="text" name="tablename" class="inputText"></td>
					<td><input type="image" src="icons/nav-new.gif" value="Add Sheet" class="inputImageButton"></td>
				</tr>
				</form>
			</table>
		</td>
		<td valign="top">
			<table align="center">
				<form action="table_properties.php">
				<input type="hidden" name="deleteTable" value="1">
				<input type="hidden" name="deleteTableName" value="<? echo $sheet; ?>">
				<tr>
					<th><h3><u>Delete Sheet</u></h3></th>
				</tr>
				<tr>
					<td align="center"><input type="image" src="icons/nav-delete.gif" value="Delete Sheet" onclick="javascript:return confirm('Are you sure you want to delete this?');" class="inputImageButton"></td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
<script type="text/html">