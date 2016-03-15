<?php

#Global Settings
#===============

# title: sets page title
$title="My Cool Dashboard";
# $widgets: Supply an array of names of widgets to display, in the order you want them displayed
$widgets=array(
	"example",
	"lesbalance",
	"load",
);
# ajaxOnFirstLoad: when the user loads the page, should they page be pre-populated with data, or should the data be fetched with ajax?
# The advantage of using ajax right from the start is if one widget takes a long time to load the user sees the data right away.
# The disadvantage is that it takes a bunch of requests to load the page for the first time, whereas it might load a little faster if it's all sent at once.
# It will make very little difference for most situations, but it seems unfair to force my decision on you so here it is as a config option.
$ajaxOnFirstLoad=false;

#Widget Specific Settings
#========================

#les.net balance widget
#----------------------

$les_warn=40;
$les_critical=20;
$les_max=60;
$les_apikey	= '';
$les_idkey	= '';

#system load widget
#------------------

$load_warn=50;
$load_critical=75;
#Important! Set this to the number of CPU cores your server has. Otherwise the cute bar graph and the thresholds will be all off.
$load_cores=1;
