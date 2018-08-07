
<?=$msg ?>
<form method="post">
	Название<br>
	<input type="text" name="title" value="<?="$title"?>" class="form-control"><br>
	Контент<br>
	<textarea name="content" cols="70" rows="25" class="form-control"><?="$content"?></textarea><br>
	<input type="submit" value="Добавить" class="btn btn-success">
</form>
