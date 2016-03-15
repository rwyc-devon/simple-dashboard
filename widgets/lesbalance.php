<?php
include "$root/include/lesnet_api.php";
include "$root/config.php";
function widget_timeout_lesbalance($options) {
	return (widget_data_lesbalance($options)=="")?10:60; #Try more frequently if it fails.
}
function widget_title_lesbalance($options) {
	return "les.net balance";
}
function widget_data_lesbalance($options) {
	static $balance=null;
	if($balance===null) {
		$result=lesnet_api("account/balance","{}",TRUE,$options->apikey, $options->idkey);
		$balance=$result? (json_decode($result)->balance) : "";
	}
	return $balance;
}
function widget_html_lesbalance($options) {
	$balance=widget_data_lesbalance($options);
	$balance_percent=min($balance/($options->max?$options->max:100), 1)*100;
	return "<div class='has-bar' data-icon='&#9742'><span class='bargraph' style='width:$balance_percent%'></span><span class='money'>$balance</span></div>";
}
function widget_status_lesbalance($options) {
	$balance=widget_data_lesbalance($options);
	if($balance=="") {
		return "dead";
	}
	else if($balance<=$options->critical) {
		return "critical";
	}
	else if($balance<=$options->warn) {
		return "warn";
	}
	else {
		return "good";
	}
}
