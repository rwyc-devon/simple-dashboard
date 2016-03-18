<?php
function init()
{
	global $root, $baseURL, $config;

	#figure out root dir of site
	$root=dirname(dirname(__FILE__));

	#figure out the base URL of the site
	$docroot="${_SERVER["DOCUMENT_ROOT"]}/";
	$path=preg_replace(":^$docroot:", "", $root);
	$baseURL="${_SERVER["SERVER_NAME"]}/$path";

	#load and transform config
	$config=json_decode(file_get_contents("$root/config.json"));
	if(!isset($config->sections)) {
		$config->sections=[];
	}
	if(isset($config->widgets)) {
		$config->sections[0]=(object)[];
		$config->sections[0]->widgets=$config->widgets;
		unset($config->widgets);
	}
}
init();
#setup autoloading
spl_autoload_register( function($class) {
	global $root;
	include("$root/widgets/" . preg_replace('/Widget$/', '', $class) . ".php");
});
