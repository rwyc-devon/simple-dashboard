<?php
function widget($index, $type="html")
{
	global $root;
	global $config;
	$widget=$config->widgets[$index];
	$name=$widget->name;
	$options=isset($widget->options)?$widget->options:null;
	require_once("$root/widgets/$name.php");
	$title=("widget_title_$name")($options);
	if($type=="empty-html") {
		echo "<section tabindex='0' id='widget-$index' class='widget pending' data-timeout='0' data-widget='$index'><h2>$title</h2></section>";
	}
	else {
		$status=("widget_status_$name")($options);
		$timeout=("widget_timeout_$name")($options);
		if($type=="html") {
			$html=("widget_html_$name")($options);
			echo "<section tabindex='0' id='widget-$name' class='widget status-$status' data-timeout='$timeout' data-widget='$index'><h2>$title</h2>$html</section>";
		}
		else if($type=="json") {
			$html=("widget_data_$name")($options);
			return json_encode(array(
				"name"     => $name,
				"class"    => $class,
				"data"     => $data,
				"status"   => $status,
				"title"    => $title,
				"timeout"  => $timeout
			));
		}
	}
}
?>
