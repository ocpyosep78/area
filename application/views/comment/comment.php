<?php
	$web['host'] = base_url();
	$link = fix_link($_GET['link']);
	
	$param_comment['link'] = $link;
	$param_comment['is_publish'] = 1;
	$param_comment['sort'] = '[{"property":"comment_time","direction":"DESC"}]';
	$param_comment['limit'] = 10;
	$array_comment = $this->Comment_model->get_array($param_comment);
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
	<meta charset="UTF-8" />
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="stylesheet" type="text/css" media="all" id="primetime-style-css" href="<?php echo base_url('static/css/style.css'); ?>" />
	<link rel="stylesheet" type="text/css" media="all" id="responsive-css" href="<?php echo base_url('static/css/responsive.css'); ?>" />
	<link rel="icon shortcut" href="<?php echo base_url('static/img/favicon.png'); ?>" type="image/x-icon" />
	<script> var web = <?php echo json_encode($web); ?></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.js'); ?>"></script>
	<script type='text/javascript' src="<?php echo base_url('static/js/jquery.validate.js'); ?>"></script>
	<script type='text/javascript' src="<?php echo base_url('static/js/common.js'); ?>"></script>
</head>
<body>
<div id="post_content" class="post_content" role="main">
	<div id="comments" class="post_comments">
		<h3 class="comments_title">Comments</h3>
		<ol class="comment-list">
			<?php foreach ($array_comment as $comment) { ?>
			<li class="comment">
				<div class="photo"><img src="<?php echo base_url('static/img/no_user.png'); ?>" height="106" width="106" style="border: 1px solid #CCCCCC;" /></div>
				<div class="extra_wrap">
					<h5><a><?php echo $comment['user_fullname']; ?></a></h5>
					<div class="comment_info">
						<div class="comment_date"><?php echo GetFormatDate($comment['comment_time'], array( 'FormatDate' => 'd F Y, H:i' )); ?></div>
						
					</div>
					<div class="comment_content"><p><?php echo $comment['comment']; ?></p></div>
				</div>
			</li>
			<?php } ?>
		</ol>
		
		<div id="respond">
			<h3 id="reply-title">Leave comment</h3>
			<form method="post" id="commentform">
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="link" value="<?php echo $link; ?>" />
				
				<p class="comment-form-author">
					<input name="name" type="text" value="" size="30" />
					<label class="required">Name</label>
				</p>
				<p class="comment-form-email">
					<input name="email" type="text" value="" size="30" />
					<label class="required">Email</label>
				</p>
				<p class="comment-form-comment">
					<textarea name="comment" cols="45" rows="8"></textarea>
				</p>
				<p class="form-submit">
					<input name="submit" type="submit" value="Post comment" />
				</p>
			</form>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	$("#commentform").validate({
		rules: {
			name: { required: true, minlength: 4 },
			email: { required: true, email: true },
			comment: { required: true }
		},
		messages: {
			name: { required: 'Silahkan mengisi field ini', minlength: '4 minimal karakter' },
			email: { required: 'Silahkan mengisi field ini', email: 'Email anda tidak valid' },
			comment: { required: 'Silahkan mengisi field ini' }
		}
	});
	
	$('#commentform').submit(function() {
		if (! $("#commentform").valid()) {
			return false;
		}
		
		var param = Site.Form.GetValue('commentform');
		Func.ajax({ url: web.host + 'comment/comment/action', param: param, callback: function(result) {
			if (result.status) {
				window.location.reload();
			}
		} });
		
		return false;
	});
});
</script>
</body>
</html>