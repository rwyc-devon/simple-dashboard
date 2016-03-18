<?php
include "include/base.php";
include "include/dashboard.php";
if(isset($_GET["widget"])) {
	widget($_GET["section"], $_GET["widget"]);
}
else { ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<title><?php echo $config->title?></title>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<h1><?php echo $config->title?></h1>
		<main>
<?php
	prindent(3);
	if(isset($config->sections)) {
		foreach($config->sections as $index=>$section) {
			$label=isset($section->label)? $section->label : false;
			section($index);
		}
	}
	else {
		section($config->widgets);
	}
?>
		</main>
		<script src='ajax_stuff.js'></script>
	</body>
</html>
<?php }?>
