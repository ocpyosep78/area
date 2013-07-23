<div class="popup">
	<a href="#" class="close">&times;</a>
	
	<div class="content">
		<div class="title">Registration</div>
		<div class="form">
			<form method="post" id="form-register" class="validation">
				<input type="hidden" name="action" value="register"/>
				
				<div class="col1">
					<div class="field">
						<div class="label-wrap"><label class="required">Nick Name</label></div>
						<div class="input-wrap"><input type="text" name="fullname" /></div>
					</div>
				</div>
				<div class="col2">    
					<div class="field">
						<div class="label-wrap"><label class="required">Email</label></div>
						<div class="input-wrap"><input type="text" name="email" /></div>
					</div>
				</div>
				<div class="col1">
					<div class="field">
						<div class="label-wrap"><label class="required">Password</label></div>
						<div class="input-wrap"><input type="password" name="passwd" id="passwd" /></div>
					</div>
				</div>
				<div class="col2">
					<div class="field">
						<div class="label-wrap"><label class="required">Confirm Password</label></div>
						<div class="input-wrap"><input type="password" name="passwd_confirm" /></div>
					</div>
				</div>
				
				<div class="column button"><input type="submit" class="enter" value="Register" /></div>
				<div class="clearboth"></div>
				
				<div class="c_message hide">The Login field can't be empty</div>
			</form>
		</div>
	</div>
</div>