<?php
function widget($section, $index, $type="html")
{
	global $root;
	global $config;
	$widgetConfig=$config->sections[$section]->widgets[$index];
	$name=$widgetConfig->name;
	$options=isset($widgetConfig->options)?$widgetConfig->options:[];
	$class="${name}Widget";
	$widget=new $class($options);
	$title=$widget->title();
	if($type=="empty-html") {
		echo "<li tabindex='0' id='widget-$widget' class='widget pending' data-timeout='0' data-section='$section' data-widget='$index'><h2>$title</h2></li>";
	}
	else {
		$status=$widget->status();
		$timeout=$widget->timeout();
		if($type=="html") {
			$html=$widget->html();
			echo "<li tabindex='0' id='widget-$name' class='widget status-$status' data-timeout='$timeout' data-section='$section' data-widget='$index'><h2>$title</h2>$html</li>";
		}
		else if($type=="json") {
			return json_encode([
				"name"     => $name,
				"value"    => $widget->value(),
				"status"   => $status,
				"title"    => $title,
				"timeout"  => $timeout
			]);
		}
	}
}
function section($index)
{
	global $config;
	static $id=0;
	$section=$config->sections[$index];
	$label=isset($section->label)? $section->label : false;
	$widgets=isset($section->widgets)? $section->widgets : false;
	$fid=sprintf("toggle-%03d", $id);
	echo "<section>";
	if($label) {
		echo "<input class='toggle' type='checkbox' id='$fid' /><label tabindex='0' for='$fid'>$label</label>";
	}
	echo "<ol>";
	if($widgets) {
		foreach($widgets as $i=>$widget) {
			widget($index, $i, $config->ajaxOnFirstLoad? "empty-html" : "html");
		}
	}
	echo "</ol></section>";
	$id++;
}
