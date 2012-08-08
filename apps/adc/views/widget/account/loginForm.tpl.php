

<?php
$url = $this->route->url('api', array('class'=>'account','method'=>'login', 'scheme' => 'http'));
?>
<form class="login-form glow form-stacked" method="post" id="login_form" action="<?=$url?>">
		<div class="error-container"></div>


	<fieldset>


		<legend><h3>Login</h3></legend>

		<div class="clearfix">
            <label for="email">Email Address</label>
            <div class="input">
				<input type="text" size="30" name="email" id="email" class="xlarge">
            </div>
		</div><!-- /clearfix -->

		<div class="clearfix">
            <label for="password">Password</label>
            <div class="input">
				<input type="password" size="30" name="password" id="password" class="xlarge">
            </div>
		</div><!-- /clearfix -->

		<div class="actions">
            <input type="submit" value="Sign-in" class="btn primary">
		</div>


	</fieldset>

</form>