<?

include "lib/dbconnect.php";
include "lib/sheets.php";

$counter = 0;
$divisor = 1;
$colorCode = "";
$style = "";

$dateoutput = date('m/d/Y');

$rep_what = "";
$rep_where = "";
$rep_sort = "";

if (isset($rep_where_array)) {
	$rep_where  = "where ";
}

foreach ($rep_what_array as $value) {
	$rep_what .= "`$value`, ";
}

// Remove trailing "," from query
$rep_what = substr($rep_what, 0, -2);

if (isset($rep_where_array) && $rep_where_array != "") {
	foreach ($rep_where_array as $value) {
		$sign = "select-" . $value;
		$whereValue = "text-" . $value;
		$rep_where  .= "$value ${$sign} '${$whereValue}' and ";
	}
}

// Remove trailing "and " from query
$rep_where = substr($rep_where, 0, -4);

if (isset($orderBy01) && $orderBy01 != "") {
		$rep_sort = "order by `$orderBy01`";
}

if (isset($orderBy02) && $orderBy02 != "") {
	$rep_sort .= ", `$orderBy02`";
}

if (isset($orderBy03) && $orderBy03 != "") {
	$rep_sort .= ", `$orderBy03`";
}

$sql = "select $rep_what from $tablename $rep_where $rep_sort";
$result = mysql_query($sql,$connection) or die(mysql_error());
$row_count = mysql_num_rows($result);

$tableOutput = "\t\t<th></th>";

foreach($rep_what_array as $this) {
	foreach($colNames as $key => $value) {
		if ($this == $key) {
			$tableOutput .= "<th>$value</th>";
		}
	}
}

while ($row = mysql_fetch_array($result)) {
	$counter++;
	$divisor++;

	$tableOutput .= "\n\t</tr>\n\t<tr bgcolor='white'>\n\t\t<td align='center' nowrap bgcolor='$colorCode'><span class='$style'>$counter</span></td>\n";

	foreach ($rep_what_array as $what) {
		${$what} = $row[$what];
		foreach ($rows as $key => $value) {
			if ($what == $key) {
				$tableOutput .= "\t\t<td align='center' nowrap bgcolor='$colorCode'><span class='$style'><input type='text' value='${$key}' class='editOff' size='$value'></span></td>\n";
			}
		}
	}

	if($row_count > 30) {	
		if($divisor % 30 == 1) {
			$tableOutput .= "\t</tr>\n</table>\n\n<div class='break'></div>\n<br><h2><b>Maryland Truck - $title Inventory - $dateoutput</b></h2><br>\n\n<table cellpadding='2' cellspacing='1' border='0' bgcolor='000000' width=''>\n\t<tr bgcolor='F5F5F5'>\n\t\t<th></th>";
			foreach($rep_what_array as $this) {
				foreach($colNames as $key => $value) {
					if ($this == $key) {
						$tableOutput .= "<th>$value</th>";
					}
				}
			}
		}	
	}
}

?>

<html>

<head>
<title>Maryland Truck - <? echo $title; ?> Inventory Report</title>

<style type="text/css">
	body,td,p {font-family: verdana, helvetica, sans-serif; font-size: 8pt; color: 000000;}
	th {font-family: verdana, helvetica, sans-serif; font-size: 8pt; color: 000000;}
	.Dec {text-decoration: underline}
	.noDec {text-decoration: none}
	.editOff { border: 0px;	background-color: #FFFFFF; overflow: hidden; }
	input { text-align: center; font-size: 8pt; }
	.break { page-break-after: always; }
</style>

<style media="print">
  .noprint { display: none }
</style>

</head>
<body bgcolor="FFFFFF" text="000000" topmargin="0" margin="0">

<center>

<h2><b>Maryland Truck - <? echo $title; ?> Inventory - <?php echo "$dateoutput" ?></b></h2>
<br>

<table cellpadding="2" cellspacing="1" border="0" bgcolor="000000" width="">
	<tr bgcolor="F5F5F5">
<? echo "$tableOutput"; ?>
	</tr>
</table>

</center>
<br><br>
</body>
</html>
<script type="text/html">