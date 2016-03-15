<?php
function widget_timeout_load() {
	return 10;
}
function widget_title_load() {
	return "load avg";
}
function widget_data_load() {
	static $load = null;
	if($load===null) {
		$load=sys_getloadavg()[0]*100;
	}
	return $load;
}
function widget_html_load() {
	global $load_cores;
	$load=widget_data_load();
	$normload=widget_load_norm();
	return "<div class='has-bar' data-icon='&#9729'><span class='bargraph' style='width:$normload%'></span><span class='percent'>$load</span></div>"; #TODO: there's gotta be something better than a cloud symbol for load avg.
}
function widget_load_norm()
{
	global $load_cores;
	if(isset($load_cores)) {
		return widget_data_load()/$load_cores;
	}
	return widget_data_load();
}
function widget_status_load() {
	global $load_critical;
	global $load_warn;
	global $load_good;
	global $load_cores;
	$normload=widget_load_norm()/$load_cores;
	if($normload >= $load_critical) {
		return "critical";
	}
	else if($normload >= $load_warn) {
		return "warn";
	}
	else if(isset($normload)){
		return "good";
	}
	else {
		return "failed";
	}
}
