(function(){
	var base_url = (web != null && web.host != null) ? web.host : 'http://suekarea.com/';
	
	var widget_link = base_url + 'comment/comment?link=' + escape(window.location.href);
	document.write('<iframe id="comment_iframe" src="' + widget_link + '" style="width: 100%" frameborder="0" scrolling="no"></iframe>');
	
	setInterval(function() {
		document.getElementById('comment_iframe').style.height = document.getElementById('comment_iframe').contentWindow.document.body.scrollHeight + 'px';
	}, 1000);
})()