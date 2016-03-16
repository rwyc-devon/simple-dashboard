<?php
include "include/base.php";
include "include/dashboard.php";
if(isset($_GET["widget"]) && $_GET["widget"] >= 0 && $_GET["widget"] < count($config->widgets)) {
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
		<h1><?php echo $config->title?$config->title:"Dashboard"?></h1>
		<main>
			<?php
				foreach($config->widgets as $index=>$widget) {
					widget($index,$config->ajaxOnFirstLoad?"empty-html":"html");
?>

			<?php #to preserve indentation
				}?>
		</main>
		<script src='ajax_stuff.js'></script>
	</body>
</html>
<?php }?>
