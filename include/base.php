<?php
require_once "config.php";
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
	loadConfig();
}
init();
#setup autoloading
spl_autoload_register( function($class) {
	global $root;
	include("$root/widgets/" . preg_replace('/Widget$/', '', $class) . ".php");
});
