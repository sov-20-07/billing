<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::CabinetMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Корзина</div>
		<?if(count($order['goods'])>0):?>
			<form method="post" id="simpleform">
				<table class="basket">
					<col width="28"><col width="1"><col><col><col><col>
					<tr>
						<th></th>
						<th></th>
						<th>Информация о книге</th>
						<th>Тип бумаги</th>
						<th>Кол-во</th>
						<th>Цена</th>
					</tr>
					<tr>
						<td colspan="6"><div class="head2">Фотокниги из книжного магазина</div></td>
					</tr>
					<?foreach($order['goods'] as $i=>$item):?>
						<tr class="tr<?=$item['tree']?>">
							<td class="del_pos"><span class="icon ic_delete delgoods" ids="<?=$item['tree']?>" title="Удалить из корзины"></span></td>
							<td class="book_img">
								<a href="/cabinet/books/<?=$item['id']?>/" class="book_cover wh_57x85" style="background: url(/of/6<?=$item['files_gal'][0]['path']?>) no-repeat;" alt="<?=$item['files_gal'][0]['name']?>"><div class="is_cover"></div><div class="shadow"></div></a>
							</td>
							<td>
								<a href="/cabinet/books/<?=$item['id']?>/"><?=$item['name']?></a><br />
								Автор <a href="/cabinet/books/<?=$item['id']?>/" class="light_gray font_11"><?=$item['author']?></a><br />
								<?=$item['countpage']?> страницы<br />
								<a href="/cabinet/books/<?=$item['id']?>/" class="light_gray"><?=Funcs::$referenceId['binding'][$item['binding']]['name']?></a>
							</td>
							<td><?=Funcs::$referenceId['paper'][$item['paper']]['name']?></td>
							<td>
								<div class="basket_clicker_area">
									<div class="clicker" id="number_book"><input value="<?=$item['num']?>" id="num<?=$item['tree']?>" name="countbook" value="<?=$item['num']?>"><div class="up plus ic_plus_basket" ids="<?=$item['tree']?>"></div><div class="down ic_minus_basket" ids="<?=$item['tree']?>" <?if($item['num']==1):?>disabled<?endif?>></div></div>
								</div>
							</td>
							<td><nobr><span id="tdprice<?=$item['tree']?>"><?=number_format($item['total'],0,',',' ')?></span> руб.</nobr></td>
						</tr>
					<?endforeach?>
				</table>
				<div class="itogo">Итого, без учета стоимости доставки: <span class="price"><span id="itogo"><?=number_format($order['sum'],0,',',' ')?></span> руб.</span></div>
				<div class="shopping_choice"><div class="continue"><a href="/cabinet/basket/delivery/" class="is_button right_top_corner"><ins class="icon ic_make_order"></ins>Оформить заказ<span></span></a></div></div>
				<div class="shopping_choice"><a href="/cabinet/books/">Продолжить покупки</a></div>
			</form>
		<?else:?>
			Ваша корзина пуста
		<?endif?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>