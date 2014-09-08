<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::CabinetMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1 nopadding"><?=$name?></div>
		<div class="author_social">
			<span class="author">Автор: <?=$author?></span>
		</div>
		<table class="default three_columns_table">
			<tr>
				<td rowspan="7" class="pic"><img src="/of/6<?=$files_gal[0]['path']?>"><a href="/cabinet/books/<?=$id?>/?preview">Полистать</a></td>
				<td class="center"><span class="light_gray">Цена:</span></td><td><span class="price"><?=$price?> руб.</span></td>
			</tr>
			<tr>
				<td class="center"><span class="light_gray">Категория:</span></td><td><?=$parentname?></td>
			</tr>
			<tr>
				<td class="center"><span class="light_gray">Размер:</span></td><td><?=$booksize?></td>
			</tr>
			<tr>
				<td class="center"><span class="light_gray">Бумага:</span></td><td><?=Funcs::$referenceId['paper'][$paper]['name']?></td>
			</tr>
			<tr>
				<td class="center"><span class="light_gray">Количество страниц:</span></td><td><?=$countpage?></td>
			</tr>
			<tr>
				<td class="center"><span class="light_gray">Слоган:</span></td><td><?=$phrase?></td>
			</tr>
			<tr>
				<td class="center"><span class="light_gray">Описание:</span></td>
				<td>
					<?=nl2br($description)?>
					<?if($visible==1):?>
						<div class="bay">
							 <span class="is_button book right_top_corner add_to_basket" ids="<?=$id?>" num="1">добавить в корзину<span></span></span>
						</div>
					<?endif?>
				</td>
			</tr>
		</table>
		<?/*?>
		<div class="rating_social">
			<div class="comments_stars"><span>Текущая оценка:  </span><div class="rating"><div class="stars3_5"></div></div></div>
			<span class="social_like"><img src="/i/social_like.png" /></span>
		</div>
		<div class="comments">
			<div class="comments_stars"><span>Оставьте комментарий и оценку:  </span><div class="rating"><div class="stars1_5"></div></div></div>
			<form method="post" action="#">
				<div class="send_comment">
					<div class="ava">
						<a href="#"><img src="/i/tmp/designer_userpic.jpg" /></a>
						<a href="#">Это я</a>
					</div>
					<div class="input">
						<textarea class="text"></textarea>
					</div>
					<div class="send">
						<input type="image" src="/i/send.png">
					</div>
				</div>
			</form>
			<div class="designer_comment">
				<div class="head_designer"><span>Отзывы о книге </span>(23 отзыва)</div>

				<div class="one_comment">
					<div class="ava">
						<a href="#"><img src="/i/tmp/designer_userpic.jpg" /></a>
						<a href="#">Отец Флавий</a>
					</div>
					<div class="comment">
						<div class="comment_st"></div>
						Поучительная летопись. Автор молодец. Ибо сказано в писании “Афтар жжот”. Не раз эти смелые ребята доказывали, что у них все пабратски. И вот наконец-то  один выбился в люди! Не люблю рознь межнациональную. Люблю делать подъем-переворот.
					</div>
					<div class="date_comment"><span class="light_gray">05.02.2012 в 16:20</span></div>
				</div>
				<div class="one_comment">
					<div class="ava">
						<a href="#"><img src="/i/tmp/designer_userpic.jpg" /></a>
						<a href="#">Отец Флавий</a>
					</div>
					<div class="comment">
						<div class="comment_st"></div>
						Заблуждаешься, человек божий! Чтишь единственно верным учение своё.
						Однако ничего окромя ущерба тебе оно не приносит. Думаешь, что я грешник,
						коль разрываю могилы по ночам? Отнюдь, падре, я просто прикалываюсь.
						Мне по приколу разрывать. Все детство в песочнице провел! И знаете, что, Флавий, вы и...
						<div class="read_more"><a href="#">Читать полностью...</a></div>
					</div>
					<div class="date_comment"><span class="light_gray">05.02.2012 в 16:20</span></div>
				</div>
				<div class="read_all_comments"><a href="#">Показать еще</a></div>
			</div>
		</div>
		<?*/?>
		<?AuthorBooksWidget::run($list)?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>