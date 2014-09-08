<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::ManagerMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Управление книгами</div>
		<div class="lk_dashboard">
			<table class="default active_order_list">
				<tr class="head">
					<td class="number_head"></td>
					<td class="details_head">Информация о книге</td>
					<td class="stat_head">Статус</td>
					<td class="action_head">Действия</td>
				</tr>
				<?foreach($list as $item):?>
					<tr>
						<td>
							<a href="/cabinet/books/<?=$item['id']?>/"><img src="/of/6<?=$item['files_gal'][0]['path']?>" /></a>
						</td>
						<td>
							<span class="top"><a href="/cabinet/books/<?=$item['id']?>/"><?=$item['name']?></a></span>
							<span class="bot"><?=$item['price']?> руб.</span>
							<span class="bot"><?=$item['parentname']?></span>
							<span class="bot"><?=$item['booksize']?></span>
							<span class="bot"><?=$item['private']?></span>
							<a href="<?=$item['filecover']['path']?>" class="bot" target="_blank"><?=$item['filecover']['name']?></a>
							<a href="<?=$item['filepages']['path']?>" class="bot" target="_blank"><?=$item['filepages']['name']?></a>
						</td>
						<td>
							<?StatusWidget::run($item)?>
						</td>
						<td>
							<?if($item['status']=='salereq'):?>
								<a href="/manager/tosale/?id=<?=$item['tree']?>&redirect=/manager/books/" onclick="return confirm('Выставить на продажу?')" class="is_button right_top_corner"><span></span>На продажу&nbsp;</a>
								<a href="/popup/reject/?id=<?=$item['tree']?>&act=tosale" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" class="is_button right_top_corner"><span></span>отклонить</a>
							<?else:?>
								<a href="/manager/confirm/?id=<?=$item['tree']?>&redirect=/manager/books/" onclick="return confirm('Подтвердить книгу?')" class="is_button right_top_corner"><span></span>утвердить&nbsp;</a>
								<a href="/popup/reject/?id=<?=$item['tree']?>&redirect=/manager/books/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" class="is_button right_top_corner"><span></span>отклонить</a>
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