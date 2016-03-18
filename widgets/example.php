<?php
#THIS IS PROBABLY A GOOD STARTING POINT IF YOU WANT TO MAKE UR OWN WIDGET

#the class name should be ${name_of_your_widget}Widget. The file name should be ${name_of_your_widget}.php.

class exampleWidget
{
	private $time;
	function __construct ($options) {

	}
	public function value() { #return the data you want printed. In this case it's the time which is about the lamest thing ever.
	#this might get called multiple times per page load, so if there's any cost to the operation at all, or any chance of race condition, do yourself a favor and use class properties and stuff to cache the result using class properties or, if you're terrible, static variables.
	
		if(!isset($this->value)) {
			$this->time=date("H:i:s");
		}
		return $this->time;
	}
	public function timeout() {
		return 1; #How often to refresh in seconds. -1 means never reload. 0 means spam the server like crazy (don't set it to 0).
		#A cool trick is that this is called on every refresh, and the client javascript updates the interval for each refresh.
		#So you could programmatically set this based on when it next needs to reload.
		#An example is a "now playing" widget that sets the timeout based on how much is left in the song.
		#Or maybe some expensive process, so you set the update frequency based on system load so you don't hog resources. have fun!
	}
	public function title() { #widget title. Have it be lowercase because the CSS transforms the case.
		return "example";
	}
	public function status() { #return either "dead", "good", "normal", "warn", or "critical". "dead" just means "the widget isn't working right now". The rest should be self-explanatory
		return "normal";
	}
	public function html() {
		#return the html that'll go in your widget. NOTE: the wrapper and header are already supplied (now you know what the title function is for!)
		#if you want fancy things like a bar graph or an icon, wrap everything in an outer element, like a <div> and read on!
		#for a bar, give the <div> a 'has-bar' class, and create a <span> with a class of 'bargraph', and style the width as a percentage. I mean really just look at the exampe below.
		#for an icon, set the attribute 'data-icon' to the unicode symbol for the icon you want, or a letter or something I guess. Some day I'll add an icon font so there's more options than just Unicode's "misc symbols".
		#there are CSS classes for .money and .percent. They just use ::before and ::after stuff to add a $ or % symbol in a lighter color. Note that it conflicts with the icon thing, so make sure not to give the same element a data-icon attribute and one of these classes.
		$time=$this->value(); #NEVER assume that $this->time (or whatever variable you use for caching) is set. ALWAYS call the value() method.
		$percent=round(date("s")/59*100, 2);
		return "<div class='has-bar' data-icon='&#9760'>\n\t<span class='bargraph' style='width:$percent%'></span>\n\t<span>$time</span>\n</div>";
	}
}
