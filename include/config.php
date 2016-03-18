<?php
function loadConfig()
{
	global $root, $config;
	$file="$root/config.json";

	$c=(object)[];

	if(is_readable($file)) {
		$c=json_decode(file_get_contents($file));
	}

	#set defalt preload setting
	if(!isset($c->preloadWidgets)) {
		$c->preloadWidgets=true;
	}

	#set defalt title
	if(!isset($c->title)) {
		$c->title="Dashboard";
	}
	
	#if there are no sections defined in the config, create an empty section
	if(!isset($c->sections)) {
		$c->sections=[];
	}
	#if widgets are defined at the root level (instead of in a section), add them as an unlabeled section
	if(isset($c->widgets)) {
		$section=(object)[];
		$section->widgets=$c->widgets;
		unset($c->widgets);
		array_unshift($c->sections, $section); 
	}
	#now that all the magic is done lets export our config!
	$config=$c;
}
