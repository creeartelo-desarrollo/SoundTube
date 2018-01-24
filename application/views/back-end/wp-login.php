<form name="loginform" id="loginform" action="<?= base_url('blog/wp-login.php') ?>" method="post" style="display: none;">
	<input type="text" name="log" id="user_login" class="input" value="admin" size="20">
	<input type="password" name="pwd" id="user_pass" class="input" value="s0undtub3" size="20">
	<input name="rememberme" type="checkbox" id="rememberme" value="forever">
	<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Acceder">
	<input type="hidden" name="redirect_to" value="<?= base_url('bloger') ?>">
	<input type="hidden" name="testcookie" value="1">
</form>
<script type="text/javascript" src="<?= base_url('public/libs/jQuery/js/jquery-2.2.3.min.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loginform").submit();
	})
</script>