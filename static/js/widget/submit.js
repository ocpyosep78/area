(function(){
	if (typeof(web) == 'undefined') {
		var base_url = 'http://suekarea.com/';
	} else if (typeof(web.host) == 'undefined') {
		var base_url = 'http://suekarea.com/';
	} else {
		var base_url = web.host;
	}
	
	var widget_link = base_url + 'widget/submit?link=' + escape(window.location.href);
	document.write('<iframe id="popular_iframe" src="' + widget_link + '" style="width: 60px; height: 15px;" frameborder="0" scrolling="no"></iframe>');
})()