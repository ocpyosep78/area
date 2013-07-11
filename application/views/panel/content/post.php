<?php
	$array_js[] = base_url('static/panel/content/post.js');
?>

<?php $this->load->view( 'panel/common/meta' ); ?>
<?php $this->load->view( 'panel/common/loader', array( 'array_js' => $array_js ) ); ?>

<div class="wi">
	<div class="x-hidden">
		<iframe name="iframe_thumbnail" src="<?php echo base_url('panel/upload?callback_name=post_thumbnail'); ?>"></iframe>
	</div>
	
	<div id="x-cnt">
		<div id="grid-member"></div>
	</div>
</div>

<?php $this->load->view( 'panel/common/footer' ); ?>