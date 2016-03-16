<?php
function widget($index, $type="html")
{
	global $root;
	global $config;
	$name=$config->widgets[$index]->name;
	$options=isset($config->widgets[$index]->options)?$config->widgets[$index]->options:array();
	$class="${name}Widget";
	$widget=new $class($options);
	$title=$widget->title();
	if($type=="empty-html") {
		echo "<section tabindex='0' id='widget-$index' class='widget pending' data-timeout='0' data-widget='$index'><h2>$title</h2></section>";
	}
	else {
		$status=$widget->status();
		$timeout=$widget->timeout();
		if($type=="html") {
			$html=$widget->html();
			echo "<section tabindex='0' id='widget-$name' class='widget status-$status' data-timeout='$timeout' data-widget='$index'><h2>$title</h2>$html</section>";
		}
		else if($type=="json") {
			return json_encode(array(
				"name"     => $name,
				"class"    => $class,
				"data"     => $widget->value(),
				"status"   => $status,
				"title"    => $title,
				"timeout"  => $timeout
			));
		}
	}
}
?>
