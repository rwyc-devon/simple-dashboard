<?php
class isupWidget
{
	private $up;
	private $url="http://localhost/";
	private $title="localhost";
	private $timeout=10;
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
		if(isset($options->timeout)) {
			$this->timeout=$options->timeout;
		}
	}
	public function value() {
		if($this->up===null) {
			$c=curl_init($this->url);
			curl_setopt($c, CURLOPT_FAILONERROR, true);
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT_MS, 500);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			$this->up=curl_exec($c);
			curl_close($c);
		}
		return $this->up;
	}
	public function timeout() {
		return $this->timeout;
	}
	public function title() {
		return $this->title;
	}
	public function status() {
		return $this->value()? "good" : "critical";
	}
	public function html() {
		$up=$this->value()? "up" : "down";
		$icon=$this->value()? "&#8679;" : "&#8681;";
		return "<div data-icon='$icon'>\n\t<span>$up</span>\n</div>";
	}
}
