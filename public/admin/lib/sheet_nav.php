<?php

include "dbconnect.php";

$sheetSelect = "<option>Sheets</option>";

$result = mysql_list_tables($db_name);

while (list($sheet)= mysql_fetch_array($result)) {
	$sheetSelect .= "<option value='$sheet'>$sheet</option>";
}	

?>

<script>
	function changeSheet(s) {
		if(s != "") {
			var location = "inv_edit_nav.php?sheet=" + s;
			parent.frames['navFrame'].location.href=location;
			var location = "inv_edit.php?sheet=" + s;
			parent.frames['editFrame'].location.href=location;
		}
	}
</script>

<select name="sheet" onchange="changeSheet(this.value)" class="inputSelect">
	<? echo "$sheetSelect"; ?>
</select>