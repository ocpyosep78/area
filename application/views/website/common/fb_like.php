<?php
	$href = (empty($href)) ? base_url() : $href;
	
	// hack
	$href = 'https://www.facebook.com/suekarea';
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="<?php echo $href; ?>" data-width="75" data-layout="button_count" data-show-faces="true"></div>