<?php
class memoryWidget extends cmdWidget
{
	protected $command="free -b";
	protected $regex='/:\s*(\d+)\s+(\d+)/m';
	protected $icon="m";
	private $warn=70;
	private $critical=85;
	public function __construct($options) {
		if(isset($options->warn)) {
			$this->warn=$options->warn;
		}
		if(isset($options->critical)) {
			$this->critical=$options->critical;
		}
	}
	protected function mapResults($results) {
		$this->result=$results[2];
		$this->result_formatted=$this->format($results[2]);
		$this->max=$results[1];
	}
	static private function format($n) {
		$suffixes=array("B", "KiB", "MiB", "GiB", "TiB", "PiB");
		$threshold=800;
		foreach($suffixes as $suffix) {
			if($n<$threshold) {
				return sprintf("%0.1f", round($n, 1)) . "<span class='suffix'>$suffix</span>";
			}
			$n/=1024;
		}
	}
	public function title() {
		return "memory";
	}
	public function status() {
		$this->value();
		$percent=$this->result/$this->max;
		if($percent > $this->critical) {
			return "critical";
		}
		if($percent > $this->warn) {
			return "warn";
		}
		return "good";
	}
}
