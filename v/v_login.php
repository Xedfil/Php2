<?=$msg?>
<form method="post" class="form-signin">
	Login<br>
	<input type="text" name="login" value="<?=$login?>" class="form-control"><br>
	Password<br>
	<input type="password" name="password" class="form-control"><br>
	<input type="checkbox" name="remember"> Remember me <br><br>
	<input type="submit" value="ВАЙТИ!!!" class="btn btn-success form-control" > <br><br>
	<a href="<?=ROOT?>user/registration" class="btn btn-danger form-control">Зарегестрироваться</a>
</form>
