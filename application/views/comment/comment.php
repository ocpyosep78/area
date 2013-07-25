<?php
	$web['host'] = base_url();
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
	<script type="text/javascript" src="<?php echo base_url('static/js/jquery.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/modernizr.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('static/js/utils.js'); ?>"></script>
	<script> var web = <?php echo json_encode($web); ?></script>
</head>

<body class="">

	
			
			<div id="post_content" class="post_content" role="main">
				<div id="comments" class="post_comments">
					<h3 class="comments_title">Comments</h3>
					<ol class="comment-list">
						<li class="comment">
							<div class="photo"><img src="<?php echo base_url('static/upload/b5a37fc.jpg'); ?>" height="106" width="106"></div>
							<div class="extra_wrap">
								<h5><a>admin</a></h5>
								<div class="comment_info">
									<div class="comment_date">June 2, 2013 at 6:38 am</div>
								</div>
								<div class="comment_content"><p>Test comment</p></div>
							</div>
						</li>
					</ol>
					<div id="respond">
						<h3 id="reply-title">Leave comment</h3>
						<form action="http://wpspace.net/wp-comments-post.php" method="post" id="commentform">
							<p class="comment-form-author">
								<input name="author" type="text" value="" size="30" />
								<label class="required">Name</label>
							</p>
							<p class="comment-form-email">
								<input name="email" type="text" value="" size="30" />
								<label class="required">Email</label>
							</p>
							<p class="comment-form-comment">
								<textarea id="comment" name="comment" cols="45" rows="8"></textarea>
							</p>
							<p class="form-submit">
								<input name="submit" type="submit" value="Post comment" />
							</p>
						</form>
					</div>
				</div>
			</div>
</body>
</html>