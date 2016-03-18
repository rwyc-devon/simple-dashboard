<?php
class memoryWidget extends cmdWidget
{
	protected $file="/proc/meminfo";
	protected $regex=['/MemTotal:\s+(?P<total>\d+)/', '/MemFree:\s+(?P<free>\d+)/', '/Buffers:\s+(?P<buffers>\d+)/', '/Cached:\s+(?P<cache>\d+)/', '/Slab:\s+(?P<slab>\d+)/'];
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
		$used=$results["total"]-$results["free"]-$results["buffers"]-$results["cache"]-$results["slab"];
		$this->result=$used;
		$this->result_formatted=memoryWidget::format($used);
		$this->max=$results['total'];
	}
	static protected function format($n) {
		$units=["KiB", "MiB", "GiB", "TiB", "PiB"];
		$threshold=800;
		foreach($units as $unit) {
			if($n<$threshold) {
				return sprintf("%0.1f", round($n, 1)) . "<span class='unit'>$unit</span>";
			}
			$n/=1024;
		}
	}
	public function title() {
		return "memory";
	}
	public function status() {
		$this->value();
		$percent=$this->result/$this->max*100;
		if($percent >= $this->critical) {
			return "critical";
		}
		if($percent >- $this->warn) {
			return "warn";
		}
		return "good";
	}
}
