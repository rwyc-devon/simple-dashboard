<?php
	(function()
	{
		global $root, $baseURL;

		#figure out root dir of site
		$root=dirname(dirname(__FILE__));

		#figure out the base URL of the site
		$docroot="${_SERVER["DOCUMENT_ROOT"]}/";
		$path=preg_replace(":^$docroot:", "", $root);
		$baseURL="${_SERVER["SERVER_NAME"]}/$path";
	})();
#load config
$config=json_decode(file_get_contents("$root/config.json"));
