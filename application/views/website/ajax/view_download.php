<?php
// 	sleep(2);
?>

<?php foreach ($post['array_download'] as $array) { ?>
<?php if (is_valid_link($array['link'])) { ?>
	<?php if (empty($array['base_name'])) { ?>
	<div><a href="<?php echo $array['link']; ?>" target="_blank"><?php echo $array['link']; ?></a></div>
	<?php } else { ?>
	<div><a href="<?php echo $array['link']; ?>" target="_blank"><?php echo $array['base_name']; ?></a></div>
	<?php } ?>
<?php } else { ?>
<div><?php echo $array['link'].' '.@$array['base_name']; ?>&nbsp;</div>
<?php } ?>
<?php } ?>