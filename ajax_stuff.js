function enqueueWidget(e)
{
	var timeout=e.getAttribute("data-timeout");
	if(timeout>=0) {
		setTimeout(function(){reloadWidget(e)}, timeout*1000);
	}
	e.addEventListener("click", function(){reloadWidget(this)});
}
function reloadWidget(e)
{
	var widget=e.getAttribute("data-widget");
	var xhr=new XMLHttpRequest();
	xhr.addEventListener("load", function(){
		var newE=new DOMParser().parseFromString(this.response, "text/html").body.childNodes[0];
		e.parentNode.replaceChild(newE, e);
		enqueueWidget(newE);
	});
	xhr.open("GET", "?widget="+widget);
	e.classList.add("pending");
	xhr.send();
}
(function(){
	var widgets=document.getElementsByTagName("section");
	for(var i=0; i<widgets.length; i++) {
		enqueueWidget(widgets[i]);
	}
})();
