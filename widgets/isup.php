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
		return $this->value()? "good" : "critical";
	}
	public function html() {
		$icon=$this->value()? "&#11014;" : "&#11015;";
		if($this->value()) {
			return "<div data-icon='$icon'>\n\t<span>$this->time<span class='unit'>ms</span></span>\n</div>";
		}
		if($this->status) {
			return "<div data-icon='$icon'>\n\t<span>$this->status</span>\n</div>";
		}
		else {
			return "<div data-icon='$icon'>\n\t<span class='error'>$this->error</span>\n</div>";
		}
	}
}
