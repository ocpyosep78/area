<?php
	// temp
	$_GET['shout_master_id'] = 1;
	
	$web['host'] = base_url();
	$user = $this->User_model->get_cookies();
	
	$param_shout['shout_master_id'] = $_GET['shout_master_id'];
	$param_shout['limit'] = 10;
	$array_shout = $this->Shout_Content_model->get_latest_shout($param_shout);
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="icon shortcut" href="<?php echo base_url('static/img/favicon.png'); ?>" type="image/x-icon" />
	<script> var web = <?php echo json_encode($web); ?></script>
	<script> var user = <?php echo json_encode($user); ?></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.js'); ?>"></script>
	<script type='text/javascript' src="<?php echo base_url('static/js/common.js'); ?>"></script>
</head>
<body>
<style>
h3, div, hr, form, input, textarea { padding: 0px; margin: 0px; font: 12px Arial,Helvetica,sans-serif; }
.btn { padding: 2px 10px; font-weight: bold; border: 1px solid #C3C6C7; background: #FDFDFD; cursor: pointer; }
.hidden { display: none; }

#cnt-shout h3 { font-weight: bold; padding: 0 0 10px 0; }
#cnt-shout .cnt-display { border-radius: 5px; border: 1px solid #C3C6C7; margin: 0 0 10px 0; padding: 10px; height: 235px; overflow: auto; }
#cnt-shout .cnt-display hr { margin: 1px 0; }
#cnt-shout .cnt-display .item-right { float: right; padding: 0 0 0 15px; }
#cnt-shout .cnt-form .message { padding: 0 2px 0 0; }
#cnt-shout .cnt-form .message textarea { width: 100%; height: 20px; padding: 2px 0px; resize: none; }
#cnt-shout .cnt-form .side-right { float: right; }
#cnt-shout .cnt-form .side-left .input-user_name input { width: 125px; }
</style>

<div id="cnt-shout">
	<h3>Sent your message here ....</h3>
	<div class="cnt-display">
		<?php foreach ($array_shout as $key => $shout) { ?>
		<div class="item" data-id="<?php echo $shout['id']; ?>">
			<div class="item-right"><?php echo $shout['shout_time_only']; ?></div>
			<div><?php echo $shout['user_name']; ?> : <?php echo $shout['message']; ?></div>
			<?php if ($key < (count($array_shout) - 1)) { ?>
			<hr />
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	
	<div class="cnt-form">
		<form>
			<input type="hidden" name="action" value="sent_shout" />
			<input type="hidden" name="shout_master_id" value="1" />
			<div class="message"><textarea name="message"></textarea></div>
			<div class="side-right"><input type="submit" name="submit" value="Sent" class="btn" /></div>
			<div class="side-left">
				<input type="button" name="set_name" value="Set Name" class="btn" />
				<span class="label-user_name">Anonymouse</span>
				<span class="input-user_name hidden"><input type="text" name="user_name" placeholder="Anonymouse" /></span>
			</div>
		</form>
	</div>
</div>

<script>
$(document).ready(function() {
	// shout library
	var shout = {
		set_bottom: function() {
			$("#cnt-shout .cnt-display").scrollTop($("#cnt-shout .cnt-display")[0].scrollHeight);
		},
		get_template: function(p) {
			// concate
			var html_raw = '';
			html_raw += '<hr />';
			html_raw += '<div class="item" data-id="' + p.id + '">';
			html_raw += '<div class="item-right">' + p.shout_time_only + '</div>';
			html_raw += '<div>' + p.user_name + ' : ' + p.message + '</div>'
			html_raw += '</div>';
			
			return html_raw;
		},
		get_last_id: function() {
			var id = 0;
			
			if ($('#cnt-shout .cnt-display .item').length > 0) {
				id = $('#cnt-shout .cnt-display .item').last().data('id');
			}
			
			return id;
		},
		generate: function(p) {
			var last_id = shout.get_last_id();
			for (var i = 0; i < p.array_shout.length; i++) {
				if (last_id < p.array_shout[i].id) {
					var content = shout.get_template(p.array_shout[i]);
					$('#cnt-shout .cnt-display').append(content);
					shout.set_bottom();
				}
			}
		},
		refresh: function() {
			var param = { action: 'refresh', last_id: shout.get_last_id() };
			Func.ajax({ url: web.host + 'shout/shout/action', param: param, callback: function(result) {
				// looping
				setTimeout(function() { shout.refresh(); }, 5000);
				
				if (result.status) {
					shout.generate({ array_shout: result.array_shout });
				}
			} });
		},
		submit: function() {
			// set param
			var param = Site.Form.GetValue('cnt-shout');
			param.last_id = shout.get_last_id();
			param.user_name = (param.user_name.length == 0) ? 'Anonymouse' : param.user_name;
			delete param.submit;
			delete param.set_name;
			
			Func.ajax({ url: web.host + 'shout/shout/action', param: param, callback: function(result) {
				if (result.status) {
					shout.generate({ array_shout: result.array_shout });
				}
			} });
		}
	}
	
	// update name
	$('[name="set_name"]').click(function() {
		// set display
		$('#cnt-shout .label-user_name').hide();
		$('#cnt-shout .input-user_name').show();
		
		// set guide
		$('[name="user_name"]').focus();
	});
	$('[name="user_name"]').blur(function() {
		// set name
		var value = $('[name="user_name"]').val();
		value = (value.length == 0) ? 'Anonymouse' : value;
		$('#cnt-shout .label-user_name').text(value);
		
		// set display
		$('#cnt-shout .input-user_name').hide();
		$('#cnt-shout .label-user_name').show();
	});
	$('[name="user_name"]').keydown(function(e) {
		if (e.keyCode == 13) {
			$(this).blur();
			return false;
		}
	});
	
	// event submit
	$('#cnt-shout .cnt-form textarea').keydown(function(e) {
		if (e.keyCode == 13) {
			// submit form
			shout.submit();
			
			// set default
			$('#cnt-shout .cnt-form textarea').val('');
			return false;
		}
	});
	$('#cnt-shout form').submit(function() {
		// submit form
		shout.submit();
		
		// set default
		$('#cnt-shout .cnt-form textarea').val('');
		return false;
	});
	
	// render display
	if (user.is_login) {
		$('#cnt-shout .side-left').hide();
	}
	
	// refresh shout
	shout.refresh();
	shout.set_bottom();
});
</script>

</body>
</html>