<?php
class uptimeWidget extends cmdWidget
{
	protected $file="/proc/uptime";
	protected $regex='/^(\d+(\.\d+)?)/';
	protected $icon="&#9201;";
	function __construct($options) {
		if(isset($options->goal) && is_numeric($options->goal)) {
			$this->max=$options->goal*3600*24;
		}
	}
	public function title() {
		return "uptime";
	}
	public function status() {
		return $this->value()>=$this->max? "good" : "normal";
	}
	public function timeout() {
		return $this->value()>=(3600*24)? 60:1;
	}
	static protected function format($in) {
		$sec=$in%60;
		$min=floor($in/60)%60;
		$hr=floor($in/3600)%24;
		$day=floor($in/(3600*24));
		$format='%4$d<span class=\'unit\'>s</span>';
		if($day && $day>10) {
			$format='%1$d<span class=\'unit\'>d</span> %2$0<span class=\'unit\'>h</span>';
		}
		elseif($day) {
			$format='%1$d<span class=\'unit\'>d</span> %2$02d<span class=\'unit\'>:</span>%3$02d';
		}
		elseif($hr || $min) {
			$format='%2$d<span class=\'unit\'>:</span>%3$02d<span class=\'unit\'>:</span>%4$02d';
		}
		return sprintf($format, $day, $hr, $min, $sec);
	}
}
