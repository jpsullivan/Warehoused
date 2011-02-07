<?php

include ("lib/dbconnect.php");

$index = $_REQUEST["index"];
$sheet = $_REQUEST["sheet"];
$pic = $_REQUEST["pic"];

$picDisplay = "";
$int_max_images = 7;

$sql = "select `year`, `make`, `model` from inventory where `index` = $index";
$result = mysql_query($sql, $connection);
list($year, $make, $model) = mysql_fetch_row($result);
$vehicle = "$year $make $model";

//Delete Pictures

if(isset($pic)) {
	$delPic = "../resources/$index/" . $pic . "t.jpg";
	unlink($delPic);
	$delPic = "../resources/$index/" . $pic . "f.jpg";
	unlink($delPic);
}

// Upload Pictures

if(!empty($_FILES)) {
	$uploaddir = "../resources/$index/";

	if (!is_dir($uploaddir)) {
		mkdir($uploaddir);
	}

	for ($i=1; $i < 7; $i++) {
		$uploadedfile = $_FILES['picUpload'. $i]['tmp_name'];
		if ($uploadedfile != "") {
			$src = imagecreatefromjpeg($uploadedfile);
			list($width, $height) = getimagesize($uploadedfile);
	
			$fullsize = $uploaddir . $i . 'f.jpg';
			$newwidth = 800;
			$newheight = 600;
			$tmp = imagecreatetruecolor($newwidth, $newheight);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagejpeg($tmp, $fullsize, 100);
			imagedestroy($tmp);
	
			$thumbnail = $uploaddir . $i . 't.jpg';
			$newwidth = 167;
			$newheight = 125;
			$tmp = imagecreatetruecolor($newwidth, $newheight);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagejpeg($tmp, $thumbnail, 100);
			imagedestroy($tmp);
	
			imagedestroy($src);
		}
	}

}

//Display Pictures

for($i = 1; $i <= 6; $i++) {
	$filepath = "../resources/$index/";
	$fileThumbnail = $filepath . $i . 't.jpg';
	$fileFullsize = $filepath . $i . 'f.jpg';
	
	if(file_exists($fileThumbnail)) {
		$picDisplay .= "
			<td align='center'>
				<a href='$fileFullsize'><img src='$fileThumbnail' width='167' height='125' border='0'></a>
				<br>
				<input type='button' value='Delete' onclick=\"window.location='pic_edit.php?index=$index&sheet=$sheet&pic=$i'\">
			</td>\n
		";
	} else {
		$picDisplay .= "
			<td align='center'>
				<img src='../images/nopic2.gif' width='167' height='125' border='0' id='preview$i'>
				<br>
				<input type='button' value='Browse...' class='browseButton'><input type='file' name='picUpload$i' size='1' id='picUpload$i' class='picUpload' onchange=\"preview(this, 'preview$i')\">
			</td>\n
		";
	}
}

?>

<html>
	<head>
		<title>Manage Pictures</title>
		<link href="styles/inv_style.css" rel="stylesheet" type="text/css">
		<style>
			.picUpload {
				position: relative;
				text-align: right;
				-moz-opacity: 0 ;
				filter:alpha(opacity: 0);
				opacity: 0;
				z-index: 2;
			}
			.browseButton {
				position: absolute;
				width: 108px;
			}
			.deleteButton {
				width: 108px;
			}
		</style>
		<script type="text/javascript">
			function preview(what, where){
				document.getElementById(where).src=what.value;
			}
		</script>
	</head>
	<body>
		<br /><br />
		<form enctype="multipart/form-data" action="pic_edit.php" method="post">
			<input type="hidden" name="index" value="<? echo $index; ?>">
			<input type="hidden" name="sheet" value="<? echo $sheet; ?>">
			<table align="center">
				<tr>
					<td colspan="6" align="center"><h2><a href="inv_edit.php?searchField=index&search=<? echo $index; ?>&sheet=<? echo $sheet; ?>"><u><?php echo $vehicle; ?></u></a></h2></td>
				</tr>
				<tr>
					<?php echo $picDisplay; ?>
				</tr>
				<tr>
					<td colspan="6">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="6" align="center"><input type="submit" value="Upload and Save"></td>
				</tr>	
			</table>
		</form>
	</body>
</html>

<script type="text/html">