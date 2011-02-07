<?

$db_name="doomforever";
$connection = mysql_connect("10.6.166.223", "doomforever", "D00mf0r3v3r") or die("Couldn't Connect.");
$db  = mysql_select_db($db_name, $connection) or die("Couldn't Select Database.");

$sheet = $_REQUEST['sheet'];
$searchField = $_REQUEST['searchField'];
$addColumn = $_REQUEST['addColumn'];
$deleteColumn = $_REQUEST['deleteColumn'];
$deleteTable = $_REQUEST['deleteTable'];
$editColumn = $_REQUEST['editColumn'];
$newTable = $_REQUEST['newTable'];
$addColumn = $_REQUEST['addColumn'];
$datatype = $_REQUEST['datatype'];
$size = $_REQUEST['size'];
$after = $_REQUEST['after'];
$newColumn = $_REQUEST['newColumn'];
$deleteThis = $_REQUEST['deleteThis'];
$deleteTableName = $_REQUEST['deleteTableName'];
$editCol = $_REQUEST['editCol'];
$newName = $_REQUEST['newName'];
$tablename  = $_REQUEST['tablename'];
$pic = $_REQUEST['pic'];
$newTable = $_REQUEST['newTable'];

?>
