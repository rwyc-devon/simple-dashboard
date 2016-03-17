<?php
require_once("$root/include/lesnet_api.php");
class lesBalanceWidget
{
	private $balance;
	private $apikey="";
	private $idkey="";
	private $max=100;
	private $warn=40;
	private $critical=20;
	private $error="";
	function __construct ($options) {
		if(isset($options->balance)) {
			$this->balance=$options->balance;
		}
		if(isset($options->apikey)) {
			$this->apikey=$options->apikey;
		}
		if(isset($options->idkey)) {
			$this->idkey=$options->idkey;
		}
		if(isset($options->max)) {
			$this->max=$options->max;
		}
		if(isset($options->warn)) {
			$this->warn=$options->warn;
		}
		if(isset($options->critical)) {
			$this->critical=$options->critical;
		}
	}
	public function value() {
		if(!isset($this->balance)) {
			$result=lesnet_api("account/balance", "{}", true, $this->apikey, $this->idkey);
			if($result) {
				$result=json_decode($result);
				if($result->status=="error") {
					$this->error="$result->error: $result->error_detail";
				}
				else {
					$this->balance=$result->balance;
				}
			}
		}
		return $this->balance;
	}
	public function timeout() {
		return (isset($this->balance))?10:60; #Try more frequently if it fails.
	}
	public function title() {
		return "les.net balance";
	}
	public function status() {
		$this->value();
		if(!isset($this->balance)) {
			return "dead";
		}
		else if($this->balance<=$this->critical) {
			return "critical";
		}
		else if($this->balance<=$this->warn) {
			return "warn";
		}
		else {
			return "good";
		}
	}
	public function html() {
		$this->value();
		if($this->error) {
			return "<div><span class='error'>$this->error</span></div>";
		}
		else {
			$percent=$this->max? min(1, $this->balance/$this->max)*100 : 0;
			return "<div class='has-bar' data-icon='&#9742'><span class='bargraph' style='width:$percent%'></span><span class='money'>$this->balance</span></div>";
		}
	}
}
