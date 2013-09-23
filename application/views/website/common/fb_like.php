<?php
	$href = (empty($href)) ? base_url() : $href;
	
	// hack
	$href = 'https://www.facebook.com/suekarea';
?>

<div class="fb-like" data-href="<?php echo $href; ?>" data-width="75" data-layout="button_count" data-show-faces="true"></div>