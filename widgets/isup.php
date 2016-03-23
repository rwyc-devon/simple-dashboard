<?php
class isupWidget
{
	private $up;
	private $error;
	private $time;
	private $url="http://localhost/";
	private $title="localhost";
	private $interval=10;
	private $timeout=500;
	private $max=2000;
	private $warn=1600;
	function __construct ($options) {
		if(isset($options->url)) {
			$this->url=$options->url;
			if(preg_match('_^https?://([^/:]+)_', $this->url, $matches)) {
				$this->title=$matches[1];
			}
		}
		if(isset($options->title)) {
			$this->title=$options->title;
		}
		if(isset($options->interval)) {
			$this->interval=$options->interval;
		}
		if(isset($options->timeout)) {
			$this->timeout=$options->timeout;
		}
		if(isset($options->max)) {
			$this->max=$options->max;
			$this->warn=$options->max*0.8; #eh why not
		}
		if(isset($options->warn)) {
			$this->warn=$options->warn;
		}
	}
	public function value() {
		if($this->up===null) {
			$c=curl_init($this->url);
			curl_setopt($c, CURLOPT_FAILONERROR, true);
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT_MS, $this->timeout);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			$this->up=curl_exec($c);
			$this->error=curl_error($c);
			$this->status=curl_getinfo($c, CURLINFO_HTTP_CODE);
			$this->time=round(curl_getinfo($c, CURLINFO_TOTAL_TIME)*1000, 1);
			curl_close($c);
		}
		return $this->up;
	}
	public function timeout() {
		return $this->interval;
	}
	public function title() {
		return $this->title;
	}
	public function status() {
		$val=$this->value();
		if(!$val) {
			return "critical";
		}
		elseif($this->time>=$this->warn) {
			return "warn";
		}
		return "good";
	}
	public function html() {
		$icon=$this->value()? "&#11014;" : "&#11015;";
		if($this->value()) {
			$percent=min($this->time/$this->max, 1)*100;
			$time=($this->time>=1000)? (round($this->time/1000, 2)."<span class='unit'>s</span>") : "$this->time<span class='unit'>ms</span>";
			return "<div data-icon='$icon'><span>$time</span>\n</div>\n<span class='bargraph' style='width:$percent%'></span>";
		}
		if($this->status) {
			return "<div data-icon='$icon'>\n\t<span>$this->status</span>\n</div>";
		}
		else {
			return "<div data-icon='$icon'>\n\t<span class='error'>$this->error</span>\n</div>";
		}
	}
}
