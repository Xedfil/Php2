	<div class="col-sm-8 blog-main">
		
		<? foreach($list as $fname){ ?>
						<a href="<?=ROOT?>post/veiw?id=<?=$fname['id']?>">
							<?=$fname['title']?>
						</a><br>
						<?=$fname['content']?><br><br>
		<? } ?>
		
		
	</div>
	<div class="col-sm-3 col-sm-offset-1">
		<? if ($hidden) { ?>
			<a href="<?=ROOT?>user/login" class="btn btn-success">
				Авторизироваться
			</a>
			<br><br>
			<a href="<?=ROOT?>user/registration" class="btn btn-danger">
				Зарегестрироваться
			</a>
		<?} else {?>
			<p>Привет тебе, <?=$_SESSION['username']?>!</p>
			<a href="<?=ROOT?>post/add" class="btn btn-success">
				Добавить статью
			</a>
			<br><br>
			<a href="<?=ROOT?>user/login" class="btn btn-danger">
				Выход
			</a>
			<hr>
			<p>Твои статейки, <?=$_SESSION['username']?>!</p>
			<table>
			<? foreach($user_posts as $fname){ ?>
						<tr>
						<td>
							<a href="<?=ROOT?>post/veiw?id=<?=$fname['id']?>">
								<?=$fname['title']?>
							</a>
						</td>
						<td>
							<span style='padding-left:10px;'></span>	
							<a href="<?=ROOT?>post/edit?id=<?=$fname['id']?>" style="text-decoration: none;">
								<span class="glyphicon glyphicon-pencil"> Ред.</span>
							</a>
						</td>
						</tr>	
			<?php } ?>
			</table>
		<?} ?>
	</div>
	

 
        
	
	