<?php
function widget($name, $type="html")
{
	global $root;
	require_once("$root/widgets/$name.php");
	$title=call_user_func("widget_title_$name");
	if($type=="empty-html") {
		echo "<section tabindex='0' id='widget-$name' class='widget pending' data-timeout='0' data-widgetname='$name'><h2>$title</h2></section>";
	}
	else {
		$status=call_user_func("widget_status_$name");
		$timeout=call_user_func("widget_timeout_$name");
		if($type=="html") {
			$html=call_user_func("widget_html_$name");
			echo "<section tabindex='0' id='widget-$name' class='widget status-$status' data-timeout='$timeout' data-widgetname='$name'><h2>$title</h2>$html</section>";
		}
		else if($type=="json") {
			$html=call_user_func("widget_data_$name");
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
