<?php
#THIS IS PROBABLY A GOOD STARTING POINT IF YOU WANT TO MAKE UR OWN WIDGET

#These are the bare minimum functions. Change "example" in each function name to the name of your widget. so instead of widget_timeout_dummy it'd be widget_timemout_coffeemaker or whatever. Similarly, name the php file after your widget (has to be exact). So instead of dummy.php you'd call it coffeemaker.php or whatever. The name has to be exact.

function widget_timeout_dummy() {
	return -1; #How often to refresh in seconds. -1 means never reload. 0 means spam the server like crazy. Don't set it to 0.
	#A cool trick is that this is called on every refresh, and the client javascript updates the interval for each refresh.
	#So you could programmatically set this based on when it next needs to reload.
	#An example is a "now playing" widget that sets the timeout based on how much is left in the song.
	#Or maybe some expensive process, so you set the update frequency based on system load so you don't hog resources. idk have fun
}
function widget_title_dummy() { #widget title. Have it be lowercase because the CSS transforms it to be capitalized.
	#Don't trust programmers to have proper grammar
	return "test widget";
}
function widget_data_dummy() { #return the data you want printed. In this case it's the time which is about the lamest thing ever.
	#this might get called multiple times per page load, so if there's any cost to the operation at all, or any chance of race condition, do yourself a favor and use static variables and stuff to cache the result.
	static $result;
	if($result===null) {
		$result=date("H:i:s");
	}
	return $result;
}
function widget_status_dummy() { #return either "dead", "good", "normal", "warn", or "critical". Hopefully it's obvious when to return what. Except maybe "dead". That basically just means "the widget isn't working right", not "[important thing] is dead". Save that for "critical"
	return "dead";
}
function widget_html_dummy() { #return the html that'll go in your widget. NOTE: the wrapper and header are already supplied (now you know what the title_* function is for!)
	#if you want fancy things like a bar graph or an icon, have an outer element, like a <div> and read on!
	#for a bar, give the <div> a 'has-bar' class, and create a <span> with a class of 'bargraph', and style the width as a percentage. I mean really just look at the exampe below.
	#for an icon, set the attribute 'data-icon' to the unicode symbol for the icon you want, or a letter or something I guess. Sometime I'll add an icon font so there's more options than just Unicode's "misc symbols".
	$data=widget_data_dummy();
	$percent=35; #IRL you'd probably set this to something relevant
	return "<div class='has-bar' data-icon='&#9742'><span class='bargraph' style='width:$percent%'></span><span class='money'>$balance</span></div>";
}
