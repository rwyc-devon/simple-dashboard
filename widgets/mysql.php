<?php
class mysqlWidget
{
	private $status;
	private $user="";
	private $pass="";
	private $host="localhost";
	private $port;
	private $socket;
	private $qps=false;
	private $error=false;
	private $max=100;
	private $warn=80;
	private $critical=150;
	function __construct ($options) {
		$this->port=ini_get("mysqli.default_port");
		$this->socket=ini_get("mysqli.default_socket");
		if(isset($options->user)) {
			$this->user=$options->user;
		}
		if(isset($options->pass)) {
			$this->pass=$options->pass;
		}
		if(isset($options->host)) {
			$this->host=$options->host;
		}
		if(isset($options->port)) {
			$this->port=$options->port;
		}
		if(isset($options->socket)) {
			$this->socket=$options->socket;
		}
		if(isset($options->warn)) {
			$this->warn=$options->warn;
		}
		if(isset($options->critical)) {
			$this->critical=$options->critical;
		}
		if(isset($options->max)) {
			$this->max=$options->max;
		}
	}
	public function value() {
		if(!isset($this->status)) {
			$connection=@new mysqli($this->host, $this->user, $this->pass, "", $this->port, $this->socket);
			$this->error=$connection->connect_error;
			if($this->error===null) {
				$status=$connection->stat();
				preg_match("/Queries per second avg:\s*([\d\.]+)/", $status, $matches);
				$this->qps=sprintf('%.2f', $matches[1]);
			}
		}
		return $this->qps;
	}
	public function timeout() {
		return 5;
	}
	public function title() { #widget title. Have it be lowercase because the CSS transforms the case.
		return "mysql";
	}
	public function status() {
		$this->value();
		if($this->error) {
			return "dead";
		}
		elseif($this->qps>=$this->critical) {
			return "critical";
		}
		elseif($this->qps>=$this->warn) {
			return "warn";
		}
		return "normal";
	}
	public function html() {
		$qps=$this->value();
		$percent=round($qps/$this->max*100, 2);
		if($this->error) {
			return "<div>\n\t<span class='error'>$this->error</span>\n</div>";
		}
		else {
			return "<div class='has-bar' data-icon='&#9751'>\n\t<span class='bargraph' style='width:$percent%'></span>\n\t<span>$qps<span class='unit'>q/s</span></span>\n</div>";
		}
	}
}
