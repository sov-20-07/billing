<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::CabinetMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Мои книги</div>
		<div class="my_books">
			<div class="sorting">
				<span class="show"> Показать: <a href="/cabinet/books/" <?if(!$_GET['show']):?>class="show_acvive"<?endif?>>все</a><a href="/cabinet/books/?show=public" <?if($_GET['show']=='public'):?>class="show_acvive"<?endif?>>Публичные</a><a href="/cabinet/books/?show=private" <?if($_GET['show']=='private'):?>class="show_acvive"<?endif?>>Приватные</a><a href="/cabinet/books/?show=sale" <?if($_GET['show']=='sale'):?>class="show_acvive"<?endif?>>В продаже</a></span>
			</div>
			<table class="my_books_table active_order_list">
				<thead>
					<td></td>
					<td>Информация о книге</td>
					<td>Статус</td>
					<td>Действия</td>
				</thead>
				<?foreach($list as $item):?>
					<tr>
						<td class="pic">
							<a href="/cabinet/books/<?=$item['id']?>/"><img src="/of/6<?=$item['files_gal'][0]['path']?>" /></a><br/>
							<div class="comments_stars">
								<span>Текущая оценка: </span>
								<div class="stars s<?=$item['rating']?>"></div>
							</div><br/>
							<img src="/i/icons/comment_2.png" alt="" class="comment" /><a href="/cabinet/books/<?=$item['id']?>/"><?=$item['rating']?></a><?/*?> (<a href="#">+3</a><?*/?>
						</td>
						<td class="info">
							<a href="/cabinet/books/<?=$item['id']?>/"><?=$item['name']?></a><br/>
							<?=$item['price']?> р.<br/>
							<?=$item['parentname']?><br/>
							<?=$item['booksize']?><br/>
							<?=$item['private']?> <a href="/cabinet/book/private/?id=<?=$item['tree']?>">(изменить)</a>
						</td>
						<td nowrap >
							<?StatusWidget::run($item)?>
						</td>
						<td nowrap class="activity">
							<a href="javascript:;" onclick="AlertBox(200,100,'Внимание','Удалить книгу?','удалить','/cabinet/books/del/<?=$item['id']?>/?redirect=/cabinet/books/','отмена','close');">Удалить</a><br/>
							<?if($item['cansale']==1 && !$item['status']):?>
								<a href="/popup/askprice/?id=<?=$item['tree']?>&redirect=/cabinet/books/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;">Выставить на продажу</a><br/>
							<?elseif($item['status']=='sale'):?>
								<a href="/cabinet/books/saleoff/?id=<?=$item['tree']?>&redirect=/cabinet/books/" >Снять с продажи</a><br/>
							<?endif?>
						</td>
					</tr>
				<?endforeach?>
			</table>
		</div>
		<?PaginationWidget::run()?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>