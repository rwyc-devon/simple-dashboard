<?php
class loadWidget
{
	private $load;
	private $normload;
	private $warn=50;
	private $critical=75;
	private $cpus=1;
	function __construct ($options) {
		if(isset($options->warn)) {
			$warn=$options->warn;
		}
		if(isset($options->critical)) {
			$critical=$options->critical;
		}
		if(isset($options->cpus)) {
			$cpus=$options->cpus;
		}
	}
	public function value() {
		if($this->load===null) {
			$this->load=sys_getloadavg()[0]*100;
			$this->normload=$this->load/$this->cpus;
		}
		return $this->load;
	}
	public function timeout() {
		return "10";
	}
	public function title() {
		return "load avg";
	}
	public function status() {
		$this->value();
		if($this->normload >= $this->critical) {
			return "critical";
		}
		else if($this->normload >= $this->warn) {
			return "warn";
		}
		else if(isset($this->normload)){
			return "good";
		}
		else {
			return "failed";
		}
	}
	public function html() {
		$this->value();
		return "<div class='has-bar' data-icon='&#9729'><span class='bargraph' style='width:$this->normload%'></span><span class='percent'>$this->load</span></div>"; #TODO: there's gotta be something better than a cloud symbol for load avg.
	}
}
