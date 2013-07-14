<?php
	sleep(2);
?>

<?php foreach ($post['array_link_source'] as $array) { ?>
<div><a href="<?php echo $array['link']; ?>"><?php echo $array['base_name']; ?></a></div>
<?php } ?>