<?php
include "$root/include/lesnet_api.php";
include "$root/config.php";
function widget_timeout_lesbalance() {
	return 60;
}
function widget_title_lesbalance() {
	return "les.net balance";
}
function widget_data_lesbalance() {
	static $balance=null;
	if($balance===null) {
		$result=lesnet_api("account/balance","{}",TRUE);
		$balance=$result? (json_decode($result)->balance) : "failed";
	}
	return $balance;
}
function widget_html_lesbalance() {
	global $les_max;
	$balance=widget_data_lesbalance();
	$balance_percent=min($balance/($les_max?$les_max:100), 1)*100;
	return "<div class='has-bar' data-icon='&#9742'><span class='bargraph' style='width:$balance_percent%'></span><span class='money'>$balance</span></div>";
}
function widget_status_lesbalance() {
	global $les_critical;
	global $les_warn;
	$balance=widget_data_lesbalance();
	if($balance=="failed") {
		return "dead";
	}
	else if($balance<=$les_critical) {
		return "critical";
	}
	else if($balance<=$les_warn) {
		return "warn";
	}
	else {
		return "good";
	}
}
