<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::ManagerMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Заказ № <?=str_repeat('0',5-count($id)).$id?></div>
		<table class="default designer_short_info designer_portfolio">
			<tr>
				<td class="pic">
					<img src="<?=$avatar?>" />
				</td>
				<td>
					<h3><?=$name?></h3>
					<span class="designer_name"><span class="light_gray">Телефон: </span> <?=$phone?></span>
					<span class="designer_name"><span class="light_gray">Email: </span> <a href="mailto:<?=$email?>"><?=$email?></a></span>
					<span class="designer_name"><span class="light_gray">Адрес: </span> <?=$address?></span>
					<span class="designer_name"><span class="light_gray">Доставка: </span> <?=$delivery?> (<?=$deliveryprice?> руб.)</span>
					<span class="designer_name"><span class="light_gray">Оплата: </span> <?=$payment?></span>
				</td>
			</tr>
		</table>
		<br /><br />
		<div class="head1">Состав заказа</div>
		<div class="lk_dashboard">
			<table class="default active_order_list">
				<tr class="head">
					<td class="number_head"></td>
					<td class="details_head">Информация о книге</td>
					<td class="stat_head">Цена</td>
					<td class="stat_head">Количество</td>
					<td class="stat_head">Сумма</td>
				</tr>
				<?foreach($goods as $item):?>
					<tr>
						<td><a href="/cabinet/books/<?=$item['id']?>/"><img src="/of/6<?=$item['files_gal'][0]['path']?>" /></a></td>
						<td>
							<span class="top"><a href="/cabinet/books/<?=$item['id']?>/"><?=$item['name']?></a></span>
							<span class="bot"><?=$item['parentname']?></span>
							<span class="bot"><?=$item['booksize']?></span>
							<span class="bot"><?=$item['private']?></span>
							<a href="<?=$item['filecover']['path']?>" class="bot" target="_blank"><?=$item['filecover']['name']?></a>
							<a href="<?=$item['filepages']['path']?>" class="bot" target="_blank"><?=$item['filepages']['name']?></a>
						</td>
						<td>
							<?=$item['price']?>  руб.<br />
							<?if($item['supprice']):?>
								<nobr>Выплата: <?=$item['supprice']?> руб.</nobr>
							<?endif?>
						</td>
						<td><?=$item['num']?> шт.</td>
						<td>
							<?=$item['total']?> руб.
							<?if($item['totalsupprice']):?>
								<nobr>Выплата: <?=$item['totalsupprice']?> руб.</nobr>
							<?endif?>
						</td>
					</tr>
				<?endforeach?>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right">Итого:</td>
					<td><?=$sum?> руб.</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td align="right" colspan="2"><b>Итого с учетом доставки:</b></td>
					<td><b><?=$sum+$deliveryprice?> руб.</b></td>
				</tr>
			</table>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>