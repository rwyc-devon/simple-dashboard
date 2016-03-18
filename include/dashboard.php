<?php
function indent($level, $text)
{
	$tabs=str_repeat("\t", $level);
	return $tabs . implode("\n$tabs", explode("\n", $text));
}
function prindent($increment, $text=false, $after=0)
{
	static $level=0;
	$level+=$increment;
	if($text) {
		echo indent($level, $text) . "\n";
	}
	$level+=$after;
}
function widget($section, $index, $type="html")
{
	global $root;
	global $config;
	$out="";
	$widgetConfig=$config->sections[$section]->widgets[$index];
	$name=$widgetConfig->name;
	$options=isset($widgetConfig->options)?$widgetConfig->options:[];
	$class="${name}Widget";
	$widget=new $class($options);
	$title=$widget->title();
	if($type=="empty-html") {
		prindent(0,"<li tabindex='0' id='widget-$widget' class='widget pending' data-timeout='0' data-section='$section' data-widget='$index'><h2>$title</h2></li>");
	}
	else {
		$status=$widget->status();
		$timeout=$widget->timeout();
		if($type=="html") {
			$html=$widget->html();
			prindent(0, "<li tabindex='0' id='widget-$name' class='widget status-$status' data-timeout='$timeout' data-section='$section' data-widget='$index'>");
			prindent(1, "<h2>$title</h2>\n$html");
			prindent(-1, "</li>");
		}
		else if($type=="json") {
			echo json_encode([
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
	$checked=(isset($section->hidden)? $section->hidden : false)? " checked" : "";
	prindent(0, "<section>", 1);
	if($label) {
		prindent(0, "<input class='toggle' type='checkbox' id='$fid' $checked/>");
		prindent(0, "<label tabindex='0' for='$fid'>$label</label>");
	}
	prindent(0, "<ol>", 1);
	if($widgets) {
		foreach($widgets as $i=>$widget) {
			widget($index, $i, $config->ajaxOnFirstLoad? "empty-html" : "html");
		}
	}
	prindent(-1, "</ol>");
	prindent(-1, "</section>");
	$id++;
}
