<?php
require_once "include/base.php";
require_once "include/dashboard.php";
if(isset($_GET["widget"]) && in_array($_GET["widget"], $widgets)) {
	widget($_GET["widget"]);
}
else { ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1'>
		<link rel='stylesheet' type='text/css' href='style.css'>
	</head>
	<body>
		<h1><?php echo $title?$title:"Dashboard"?></h1>
		<main>
			<?php foreach($widgets as $widget){widget($widget,$ajaxOnFirstLoad?"empty-html":"html");}?>
		</main>
		<script src='ajax_stuff.js'></script>
	</body>
</html>
<?php }?>
