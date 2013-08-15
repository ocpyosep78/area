(function(){
	if (typeof(web) == 'undefined') {
		var base_url = 'http://suekarea.com/';
	} else if (typeof(web.host) == 'undefined') {
		var base_url = 'http://suekarea.com/';
	} else {
		var base_url = web.host;
	}
	
	var widget_link = base_url + 'widget/popular';
	document.write('<iframe id="popular_iframe" src="' + widget_link + '" style="width: 300px; height: 290px;" frameborder="0" scrolling="no"></iframe>');
})()