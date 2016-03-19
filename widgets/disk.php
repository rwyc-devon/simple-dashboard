<?php
class diskWidget extends cmdWidget
{
	protected $regex='_[^ ]\s+\d+\s+(\d+)\s+(\d+)_m';
	protected $title="Disk";
	private $available=0;
	private $warn=10;
	private $critical=1;
	public function __construct($options) {
		if(isset($options->disk)) {
			$this->command="df $options->disk";
			$this->title=basename($options->disk);
		}
		if(isset($options->title)) {
			$this->title=$options->title;
		}
		if(isset($options->warn)) {
			$this->warn=$options->warn;
		}
		if(isset($options->critical)) {
			$this->critical=$options->critical;
		}
	}
	protected function mapResults($results) {
		$this->max=$results[1]+$results[2];
		$this->result=$results[1];
		$this->available=$results[2]/1024/1024;
		$this->result_formatted=diskWidget::format($results[1]);
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
	public function timeout() {
		$status=$this->status();
		if($status=="critical") {
			return 1;
		}
		elseif($status=="warn") {
			return 5;
		}
		return 10;
	}
	public function status() {
		$this->value();
		if($this->available<=$this->critical) {
			return "critical";
		}
		elseif($this->available<=$this->warn) {
			return "warn";
		}
		return "normal";
	}
	public function title() {
		return $this->title;
	}
}
