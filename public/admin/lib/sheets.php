<?

include "dbconnect.php";

if (!isset($search)) {
	$search = "";
}

//Construct sheet table based on database table design
if (isset($sheet)) {
	$values = array('id');
	$rows = array('id' => 0);
	$colNames = array();
	$i = 0;
	
	$sql = "describe $sheet";
	$result = mysql_query($sql, $connection);
	$row = mysql_fetch_array($result);

	$tablename = $sheet;
	$title = ucfirst($sheet);
	$uploaddirPics = "../images/$sheet/pics/";
	$uploaddirMaps = "../images/$sheet/maps/";

	while ($row = mysql_fetch_array($result)) {
		$field = $row['Field'];
		$length = between_last("(", ")", $row['Type']);
	
		$values[] = $field;
		
		if ($length == "") {
			$length = 50;
		}
	
		$rows["$field"] = "$length";
		
		$length = $length + 2;
		$colName = substr($field, 0, $length); 
		$colName = strtoupper($colName);
		$colNames["$field"] = "$colName"; 
	}

	//MD Truck Only - Default sorting per request
	if ($sheet == "engines") {
		$sort = "make`, `model`, `hp";
		$desc = "yes";
	} elseif ($sheet == "hoods") {
		$sort = "make`, `model";
		$desc = "yes";
	}

	$where = "where status != 'S'";
}

function after_last ($this, $inthat) {
	if (!is_bool(strrevpos($inthat, $this)))
	return substr($inthat, strrevpos($inthat, $this)+strlen($this));
};

function before_last ($this, $inthat) {
       return substr($inthat, 0, strrevpos($inthat, $this));
};

function between_last ($this, $that, $inthat) {
	return after_last($this, before_last($that, $inthat));
};

function strrevpos($instr, $needle) {
	$rev_pos = strpos (strrev($instr), strrev($needle));
	if ($rev_pos===false) return false;
	else return strlen($instr) - $rev_pos - strlen($needle);
};

?>
