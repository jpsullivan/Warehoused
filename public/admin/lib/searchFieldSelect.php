<?php

$searchWhat = "<option value='all' style='text-align: center;'>ALL RECORDS</option>";

if (isset($colNames)) {
	foreach($colNames as $key => $value) {
		$searchWhat .= "<option value='$key' style='text-align: center;'>$value</option>";
	}
} else {
	$searchWhat = "<option>Search Field</option>";
}

?>

<select name="searchField" <? if($sheet == "") { echo "disabled"; } ?> class="inputSelect">
	<? echo "$searchWhat"; ?>
</select>

