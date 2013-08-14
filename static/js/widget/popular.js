(function(){
	if (web == null) {
		var base_url = 'http://suekarea.com/';
	} else if (web.host == null) {
		var base_url = 'http://suekarea.com/';
	} else {
		var base_url = web.host;
	}
	
	var widget_link = base_url + 'widget/popular';
	document.write('<iframe id="popular_iframe" src="' + widget_link + '" style="width: 300px; height: 290px;" frameborder="0" scrolling="no"></iframe>');
})()