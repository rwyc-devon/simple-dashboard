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
	private $error=false;
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
		if($this->balance===null) {
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
		return ($this->balance===null || $this->error)?10:60; #Try more frequently if connecting fails.
	}
	public function title() {
		return "les.net balance";
	}
	public function status() {
		$this->value();
		if($this->balance===null) {
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
		$balance=$this->value();
		$error=$this->error;
		if(!$this->error && $balance===null) {
			$error="Connection failed";
		}
		else {
			$error=$this->error;
		}
		if($error) {
			return "<div><span class='error'>$error</span></div>";
		}
		else {
			$percent=$this->max? min(1, $balance/$this->max)*100 : 0;
			return "<div class='has-bar' data-icon='&#9742'><span class='bargraph' style='width:$percent%'></span><span class='money'>$balance</span></div>";
		}
	}
}
