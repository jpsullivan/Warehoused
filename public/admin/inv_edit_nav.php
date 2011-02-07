<?php

include "lib/dbconnect.php";
include "lib/sheets.php";

if (!isset($sheet)) {
	$sheet = "";
}

?>

<html>
<head>
	<title>Inventory Edit Navigation</title>
	<link href="styles/inv_style.css" rel="stylesheet" type="text/css">

	<script>
		function newRecord() {
			var location = "inv_edit.php?sheet=<? echo $sheet; ?>&new";
			parent.frames['editFrame'].location.href=location;
		}
		function deleteRecord() {
			parent.editFrame.document.editForm.submit();
		}
		function framePrint(whichFrame) {
			parent[whichFrame].focus();
			parent[whichFrame].print();
		}
		function displayReport() {
			var location = "report_select.php?sheet=<? echo $sheet; ?>";
			parent.frames['editFrame'].location.href=location;
		}
		function properties() {
			var location = "table_properties.php?sheet=<? echo $sheet; ?>";
			parent.frames['editFrame'].location.href=location;
		}
		function help() {
			var location = "help/help.php";
			parent.frames['editFrame'].location.href=location;
		}
	</script>
</head>
<body style="margin: 0" bgcolor="#D4D0C8">
<table align="center">
	<?php if ($sheet == "") { ?>
	<tr>
		<td><? include "lib/searchFieldSelect.php"; ?></td>
		<td><input class="inputText" type="text" name="search" size="20" value="" disabled></td>
		<td><input type="image" src="icons/nav-search_disabled.gif" name="searchRecords" alt="Search" title="Search" class="inputImageButton" disabled></td>
		<td><img src="icons/nav-new_disabled.gif" name="newTruck" alt="New" title="New" class="inputImageButton"></td>
		<td><img src="icons/nav-delete_disabled.gif" name="deleteTruck" alt="Delete" title="Delete" class="inputImageButton"></td>
		<td><img src="icons/nav-edit.gif" name="editInv" alt="Sheet Properties" title="Table Properties" onClick="properties()" class="inputImageButton"></td>
		<td><img src="icons/nav-reports_disabled.gif" name="viewReports" alt="Report" title="Report" class="inputImageButton"></td>
		<td><img src="icons/nav-print_disabled.gif" name="printReport" alt="Print" title="Print" class="inputImageButton"></td>
		<td><? include "lib/sheet_nav.php"; ?></td>
		<td><img src="icons/nav-help.gif" name="printReport" alt="HELP!" title="HELP!" onClick="help()" class="inputImageButton"></td>
	</tr>
	<?php } else { ?>
	<tr>
		<form action="inv_edit.php" target="editFrame">
		<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
		<td><? include "lib/searchFieldSelect.php"; ?></td>
		<td><input class="inputText" type="text" name="search" size="20" value="<?php echo "$search"; ?>" accesskey="w"></td>
		<td><input type="image" src="icons/nav-search.gif" name="searchRecords" alt="Search" title="Search" class="inputImageButton" accesskey="s"></td>
		</form>
		<td><img src="icons/nav-new.gif" name="newTruck" alt="New" title="New" onClick="newRecord()" class="inputImageButton"></td>
		<td><img src="icons/nav-delete.gif" name="deleteTruck" alt="Delete" title="Delete" onClick="deleteRecord()" class="inputImageButton"></td>
		<td><img src="icons/nav-edit.gif" name="editInv" alt="Sheet Properties" title="Table Properties" onClick="properties()" class="inputImageButton"></td>
		<td><img src="icons/nav-reports.gif" name="viewReports" alt="Report" title="Report" onClick="displayReport()" class="inputImageButton"></td>
		<td><img src="icons/nav-print.gif" name="printReport" alt="Print" title="Print" onClick="framePrint('editFrame')" class="inputImageButton"></td>
		<td><? include "lib/sheet_nav.php"; ?></td>
		<td><img src="icons/nav-help.gif" name="printReport" alt="HELP!" title="HELP!" onClick="help()" class="inputImageButton"></td>
	</tr>
	<?php }?>
</table>
</body>
</html>
<script type="text/html">