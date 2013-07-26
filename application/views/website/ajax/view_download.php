<?php
	sleep(2);
?>

<?php foreach ($post['array_link_source'] as $array) { ?>
<?php if (is_link($array['link'])) { ?>
<div><a href="<?php echo $array['link']; ?>"><?php echo $array['base_name']; ?></a></div>
<?php } else { ?>
<div><?php echo $array['link'].' '.@$array['base_name']; ?></div>
<?php } ?>
<?php } ?>