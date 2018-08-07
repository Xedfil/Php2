
		<a href="<?=ROOT?>">Назад</a><br>
		<h2><?=$content[title]?></h2><br>
		<em><?=$content[login]?>, <?=date("d.m.y", strtotime($content[date_c]))?> </em>
		<hr>
		<?=nl2br($content[content]);?>
