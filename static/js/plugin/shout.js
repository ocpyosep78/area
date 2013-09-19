(function(){
	var base_url = (web != null && web.host != null) ? web.host : 'http://suekarea.com/';
	
	var widget_link = base_url + 'shout/shout?shout_master_id=' + escape(shout_master_id);
	document.write('<iframe id="comment_iframe" src="' + widget_link + '" style="width: 100%; height: 350px;" frameborder="0" scrolling="no"></iframe>');
})()