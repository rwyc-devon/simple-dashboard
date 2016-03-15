<?php
function widget_timeout_load($options) {
	return 10;
}
function widget_title_load($options) {
	return "load avg";
}
function widget_data_load($options) {
	static $load = null;
	if($load===null) {
		$load=sys_getloadavg()[0]*100;
	}
	return $load;
}
function widget_html_load($options) {
	$load=widget_data_load($options);
	$normload=widget_load_norm($options);
	return "<div class='has-bar' data-icon='&#9729'><span class='bargraph' style='width:$normload%'></span><span class='percent'>$load</span></div>"; #TODO: there's gotta be something better than a cloud symbol for load avg.
}
function widget_load_norm($options)
{
	global $load_cores;
	$cpus=isset($options->cpus)?$options->cpus:1;
	return widget_data_load($options)/$cpus;
}
function widget_status_load($options) {
	$critical=$options->critical;
	$warn=$options->warn;
	$normload=widget_load_norm($options);
	if($normload >= $critical) {
		return "critical";
	}
	else if($normload >= $warn) {
		return "warn";
	}
	else if(isset($normload)){
		return "good";
	}
	else {
		return "failed";
	}
}
