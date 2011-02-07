<?php

include "lib/dbconnect.php";
include "lib/sheets.php";

$cellNum = 0;

if (!isset($sheet)) {
	//Display when there's nothing else to display.  Default intro.
	$displayRow = "<br><br><center><h2>Welcome to <i>WebSheets</i>.</h2>Please select an inventory spreadsheet by clicking on the pulldown menu in the upper right hand corner.</center>";
} else {
	//Assign variables when "globals" are turned off	
	if (isset($_REQUEST['delete']))
		$delete = $_REQUEST['delete'];
	if (isset($_REQUEST['desc']))
		$desc = $_REQUEST['desc'];
	if (isset($_REQUEST['new']))
		$new = $_REQUEST['new'];
	if (isset($_REQUEST['search']))
		$search = $_REQUEST['search'];
	if (isset($_REQUEST['searchField']))
		$searchField = $_REQUEST['searchField'];
	if (isset($_REQUEST['sheet']))
		$sheet = $_REQUEST['sheet'];
	if (isset($_REQUEST['sort']))
		$sort = $_REQUEST['sort'];

	//Delete rows
	if (isset($delete)) {
		$delete_ids = @implode(",", $delete);
		
		if ($delete_ids != 0) {
			foreach($delete as $id) {
				$sql = "delete from $tablename where `id` = $id";
				mysql_query($sql, $connection) or die(mysql_error());
			}
		}

		$delete = "";
	}

	//New Record
	if (isset($new)) {
		$size = count($values);
		$insert = "values ('', 'A', ";
		while ($i < $size) {
			$insert .= "'', ";
			$i++;
		}
		$insert = substr($insert, 0, -16);
		$insert .= "now(), now())";
	
		$sql = "insert into $tablename $insert";
		$result = mysql_query($sql,$connection) or die(mysql_error());
		$sort = "id";
		$desc = "yes";
		$searchField = "entered";
		$search = date("Y-m-d");
	}

	//Column sorting	
	if (!isset($sort)) {
		$sort = "order by `id`";
		$desc = "no";
	} elseif (isset($sort) && $desc == "no") {
		$sortCol = $sort;
		$sort = "order by `$sort`";
		$desc = "yes";
		$arrow = "<img src='icons/arrow_up.gif' border='0'>";
	} elseif (isset($sort) && $desc == "yes") {
		$sortCol = $sort;
		$sort = "order by `$sort` desc";
		$desc = "no";
		$arrow = "<img src='icons/arrow_down.gif' border='0'>";
	}

	//Display
	if (isset($searchField)) {

		//Construct Search
		if ($searchField == "all") {
			$where = "where `status` != 'S'";
		} elseif ($searchField == "status" && $search == "S" || $search == "s") {
			$where = "where `status` = 'S'";
		} elseif ($searchField == "id") {
			$where = "where `id` = '$search'";
		} else {
			$searchHow = ($search == "")?"= ''":"like '%$search%'";
			$where = "where `$searchField` $searchHow";
		}
		
		//Select and display records based on variables
		$sql = "select * from $tablename $where $sort";
		$result = mysql_query($sql, $connection);
		$numRows = mysql_num_rows($result);

		if ($numRows == 0) {
			$displayRow = "<tr bgcolor='#FFFFFF'><td align='center'><br><br><b>No Records Found</b></td></tr>";
		} else {
			$count = 0;
			$cellNum = 0;
			$displayRow = "";

			while ($row = mysql_fetch_array($result)) {
				$columnDisplay = "";
				$count++;
				$numCells = 0;

				foreach ($rows as $key => $value) {
					${$key} = $row[$key];
					//${$key} = str_replace ( array("<and>", "<pound>", "<dq>", "<sq>"), array("&", "#", "\"", "<sq>"), ${$key} );
					if ($value != "blah") {
						$cellNum++;
						$numCells++;
						if ($value < 500) {
							$columnDisplay .= "<td align='center'><input type='text' name='$key' value='${$key}' size='$value' style='background-color: transparent; border: 0px; overflow: hidden;' id='$cellNum' onChange='autoSave(this.name, this.value, $id);' onKeyUp='nextRow(this, event);'></td>\n";
						} else {
							$columnDisplay .= "<td align='center'><textarea name='$key' cols='$value' style='background-color: transparent; border: 0px; overflow: hidden; height: 18px; font: 10pt arial, helvetica, sans-serif;' id='$cellNum' onChange='autoSave(this.name, this.value, $id);' onKeyUp='nextRow(this, event);' onfocus='this.style.height=\"125px\"; this.style.overflow=\"auto\";' onblur='this.style.height=\"18px\"; this.style.overflow=\"hidden\";'>${$key}</textarea></td>\n";
						}
					}
				}

				//Count the number of pictures for each record
				$i = 0;
				$numPics = 0;
		
				while ( $i < 7 ) {
					$uploadfilePics = "../resources/$id/" . $i . "t.jpg";
					if(file_exists($uploadfilePics)) {
						$numPics++;
					}
					$i++;
				}

				//Build the row	
				$displayRow .= 
				"<tr style='background-color: #ffffff;' ondblclick='highlight(this);'>
					<td><input type='checkbox' name='delete[]' value='$id'></td>
					<th> $count </th>
					<th> $id </th>
					"
					. $columnDisplay .
					"<th>$count</a></th></tr>";
			}
		}
	} else {
		//Display WebSheet name when not editing
		$displayRow = "<br><br><center><font face='verdana'><font size='4'><b>WebSheet:</b></font> <font size='4'>$sheet</font><br><font size='2'><blockquote>Hit the magnifying glass to retrieve ALL of the records or search for a specific record.</blockquote></font></font></center>";
	}
}

?>

<html>
<head>
	<title>Inventory Edit Frame</title>
	<link href="styles/inv_style.css" rel="stylesheet" type="text/css">
	<script defer>
		function autoSave(n, v, i) {
			var location = "inv_edit_update.php?name=" + n + "&value=" + v + "&id=" + i + "&sheet=<? if (isset($sheet)) { echo $sheet; } ?>";
			parent.frames['updateFrame'].location.href=location;
		}
		function nextRow(t, event) {
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			var id = t.id;
			var totalCells = <?php echo $cellNum; ?>;
			var numCells = <?php echo $numCells; ?>;

			if (keyCode == 13 || keyCode == 40) {
				var newPosition = parseInt(id) + numCells;
				if (newPosition < totalCells) {
					id = parseInt(id) + numCells;
				} else {
					id = 1;
				}
				document.getElementById(id).focus();
			} else if  (keyCode == 38) {
				var newPosition = parseInt(id) - numCells;
				if (newPosition > 0) {
					id = parseInt(id) - numCells;
				} else {
					id = 1;
				}
				document.getElementById(id).focus();
			} 
		}
		function highlight(x) {
			if (x.style.backgroundColor == '#ffffff' || x.style.backgroundColor == 'rgb(255, 255, 255)') { 
				x.style.backgroundColor = '#ffff00';
			} else if (x.style.backgroundColor == 'ffff00' || x.style.backgroundColor == 'rgb(255, 255, 0)') { 
				x.style.backgroundColor = '#ffffff';
			} else { 
				x.style.backgroundColor = '#ffffff';
			}	
		}
		//#f0f0f0
	</script>
</head>

<body leftmargin="0" topmargin="0">
<table bgcolor="#000000" cellspacing="0" cellpadding="0" align="center">
<?php if (isset($numRows) && $numRows > 0) { ?>
	<tr>
		<td>
			<table cellspacing="1">
			<tr>
				<th bgcolor="#F0F0F0">&nbsp;</th>
				<th bgcolor="#F0F0F0"> # </th>
				<th bgcolor="#F0F0F0"> ID </th>
				
			<?php	
				if (isset($search)) {
					$sortSearch = "&search=$search&searchField=$searchField";
				} else {
					$sortSearch = "";
				}
			
				foreach ($colNames as $key => $value) {
					if (isset($sortCol) && $sortCol == $key) { 
						echo "<th bgcolor='#F0F0F0' nowrap><a href=\"inv_edit.php?sheet=$sheet&sort=$key&desc=$desc$sortSearch\"> $value $arrow </a></th>";
					} else {
						echo "<th bgcolor='#F0F0F0' nowrap><a href=\"inv_edit.php?sheet=$sheet&sort=$key&desc=$desc$sortSearch\"> $value </a></th>";
					}
			
				}
			?>
			<th bgcolor="#F0F0F0"> # </th>
			</tr>
			<form action="inv_edit.php" method="post" name="editForm">
				<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
				<? echo "$displayRow"; ?>
			</form>
			</table>
		</td>
	</tr>
<?php } else { echo "$displayRow"; } ?>
</table>
</body>
</html>
<script type="text/html">