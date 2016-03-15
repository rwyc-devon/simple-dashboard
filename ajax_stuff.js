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
	var widget=e.getAttribute("data-widgetname");
	var xhr=new XMLHttpRequest();
	xhr.addEventListener("load", function(){
		var element=new DOMParser().parseFromString(this.response, "text/html").body.childNodes[0];
		updateHtml(e,element);
	});
	xhr.open("GET", "?widget="+widget);
	e.classList.add("pending");
	xhr.send();
}
function updateHtml(oldWidget, newWidget)
{
	oldWidget.parentNode.replaceChild(newWidget, oldWidget);
	enqueueWidget(newWidget);
}
(function(){
	var widgets=document.getElementsByTagName("section");
	for(var i=0; i<widgets.length; i++) {
		enqueueWidget(widgets[i]);
	}
})();
