<?php
	// temp
	$_GET['link'] = '';
	
	$web['host'] = base_url();
	$link = fix_link($_GET['link']);
	$user = $this->User_model->get_cookies();
	
	$param_comment['link'] = $link;
	$param_comment['is_publish'] = 1;
	$param_comment['sort'] = '[{"property":"comment_time","direction":"DESC"}]';
	$param_comment['limit'] = 10;
	$array_comment = $this->Comment_model->get_array($param_comment);
	/*	*/
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="icon shortcut" href="<?php echo base_url('static/img/favicon.png'); ?>" type="image/x-icon" />
	<script> var web = <?php echo json_encode($web); ?></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.js'); ?>"></script>
</head>
<body>
<style>
h3, div, hr, form, input, textarea { padding: 0px; margin: 0px; font: 12px Arial,Helvetica,sans-serif; }
.btn { padding: 2px 10px; font-weight: bold; border: 1px solid #C3C6C7; background: #FDFDFD; }

#cnt-shout h3 { font-weight: bold; padding: 0 0 10px 0; }
#cnt-shout .cnt-display { border-radius: 5px; border: 1px solid #C3C6C7; margin: 0 0 10px 0; padding: 10px; }
#cnt-shout .cnt-display hr { margin: 1px 0; }
#cnt-shout .cnt-display .item-right { float: right; }
#cnt-shout .cnt-form .message { padding: 0 2px 0 0; }
#cnt-shout .cnt-form .message textarea { width: 100%; height: 20px; padding: 2px 0px; resize: none; }
#cnt-shout .cnt-form .side-right { float: right; }
</style>

<div id="cnt-shout">
	<h3>Chat Box</h3>
	<div class="cnt-display">
		<div class="item">
			<div class="item-right">07:23:00</div>
			<div>Mickey : Woooe</div>
		</div>
		<hr />
		<div class="item">
			<div class="item-right">07:23:00</div>
			<div>Mickey : Woooe</div>
		</div>
		<hr />
		<div class="item">
			<div class="item-right">07:23:00</div>
			<div>Mickey : Woooe</div>
		</div>
		<hr />
		<div class="item">
			<div class="item-right">07:23:00</div>
			<div>Mickey : Woooe</div>
		</div>
	</div>
	
	<div class="cnt-form">
		<div class="message"><textarea></textarea></div>
		<div class="side-right"><input type="submit" name="submit" value="Sent" class="btn" /></div>
		<div class="side-left"><input type="button" name="set_name" value="Set Name" class="btn" /> <span>Anonymouse</span></div>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#cnt-shout .cnt-form textarea').keydown(function(e) {
		if (e.keyCode == 13) {
			$(this).val('');
			return false;
		}
	});
	
	/*
	
	$('#commentform').submit(function() {
		var param = Site.Form.GetValue('commentform');
		Func.ajax({ url: web.host + 'comment/comment/action', param: param, callback: function(result) {
			if (result.status) {
				window.location.reload();
			}
		} });
		
		return false;
	});
	/*	*/
});
</script>

</body>
</html>