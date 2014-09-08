<div id="content">
	<?CrumbsWidget::run()?>
	<div class="basket">
		<div class="left-coll">
			<h1 style="margin-top:-10px; ">Ваша корзина</h1>
			<table class="basket-table">
			<?foreach($order['goods'] as $i=>$item):?>
				<tr class="tr<?=$item['tree']?>">
					<td class="pic"><?if($item['pics'][0]['path']):?><a href="<?=$item['path']?>"><img src="/of/1/<?=$item['pics'][0]['path']?>" alt="<?=$item['pics'][0]['name']?>" /></a><?endif?></td>
					<td class="annotation"><a href="<?=$item['path']?>"><?=$item['name']?></a></td>
					<td class="price-td">
						<span class="price"><?=number_format($item['price'],0,',',' ')?><span class="rub">a</span></span>
						<?if($item['realprice']!=$item['price']):?>
							<br/><span class="sale" style="color:#B20000;text-decoration: line-through">
							<?=number_format($item['realprice'],0,',',' ')?><span class="rub">a</span></span><br />
						<?endif?>
					</td>
					<td class="number-of">
						<div class="number">
							<span class="minus-but <?/*?>inactive<?*/?> ic_minus_basket" ids="<?=$item['tree']?>" <?if($item['num']==1):?>disabled<?endif?>></span><input type="text" class="text updowninput" iname="<?=$item['tree']?>" value="<?=$item['num']?>" id="num<?=$item['tree']?>"/><span class="plus-but ic_plus_basket" ids="<?=$item['tree']?>"></span>
						</div>
					</td>
					<td class="sum">
						<span class="price"><span id="tdtotal<?=$item['tree']?>"><?=number_format($item['total'],0,',',' ')?></span><span class="rub">a</span></span>
						<?if($item['sale']>0):?>
							<br/><span class="sale">скидка <span id="tdsale<?=$item['tree']?>"><?=number_format($item['sale'],0,',',' ')?></span> <span class="rub">a</span></span>
						<?endif?>
					</td>
					<td class="del">
						<span class="del-but delgoods" ids="<?=$item['tree']?>"></span>
					</td>
				</tr>
			<?endforeach?>
			</table>
			<?/*if(count($order['accessories'])>0):?>
				<h3 class="hits">Закажи и получи скидку</h3>
				<table class="sale-table">
				<?foreach($order['accessories'] as $items):?>
					<?foreach($items as $i=>$item):?>
						<tr>
							<td class="pic">
								<?if($item['pics'][0]['path']):?><a href="<?=$item['path']?>"><img src="/of/1/<?=$item['pics'][0]['path']?>" alt="<?=$item['pics'][0]['name']?>" /></a><?endif?>
							</td>
							<td class="annotation">
								<a href="<?=$item['path']?>"><?=$item['name']?></a></br>
								<span><?=$item['description']?></span>
							</td>
							<td class="price-td">
								<span class="price"><?=number_format($item['supprice'],0,',',' ')?><span class="rub">a</span></span>
								<br/><span class="sale">скидка <?=number_format($item['price']-$item['supprice'],0,',',' ')?> <span class="rub">a</span></span>
							</td>
							<td class="buy">
								<span class="buy-sm-but add_to_basket" path="click" ids="<?=$item['tree']?>" num="1" sale="<?=md5('saleme'.$item['tree'])?>"></span>
							</td>
						</tr>
					<?endforeach?>
				<?endforeach?>
				</table>
			<?endif*/?>
		</div>
		<div class="right-coll">
			<div class="buy-block">
				<span style="display: inline-block; margin-bottom: 10px;">общая сумма</span><br/>
				<span class="price"><span id="itogo"><?=number_format($order['sum'],0,',',' ')?></span><span class="rub" style="font-size: 28px">a</span></span><br/>
				<a href="/basket/purchase/" class="checkout-but"></a><br/>
				<?/*?><img src="/i/visa.png" /><?*/?>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?/* ?>
<div class="basket">
	<?CrumbsWidget::run()?>
	<h1><?=$name?></h1>
	<table class="basket-table">
		<thead>
			<th>Артикул</th>
			<th colspan="2">Описание</th>
			<th>Цена</th>
			<th>Колличество</th>
			<th>Скидка</th>
			<th>Стоимость</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</thead>
		<?foreach($order['goods'] as $i=>$item):?>
			<tr class="tr<?=$item['tree']?>">
				<td><?=trim($item['art'])==''?str_repeat('0',6-strlen($item['tree'])).$item['tree']:$item['art']?></td>
				<td>
					<?if($item['pics'][0]['path']):?><a href="<?=$item['path']?>" class="pic" style="border:none;"><img src="/of/1/<?=$item['pics'][0]['path']?>" alt="<?=$item['pics'][0]['name']?>" /></a><?endif?>
				</td>
				<td class="annotation" style="vertical-align: middle">
					<a href="<?=$item['path']?>"><?=$item['name']?></a>
				</td>
				<td nowrap>
					<?if($item['realprice']!=$item['price']):?>
						<span style="color:#B20000;text-decoration: line-through"><?=number_format($item['realprice'],0,',',' ')?>р</span><br />
					<?endif?>
					<b><span id="tdprice<?=$item['tree']?>"><?=number_format($item['price'],0,',',' ')?></span><span class="rub">a</span></b>
				</td>
				<td>
					<div class="buy-box">
						<div class="number"><input class="number-input updowninput" iname="<?=$item['tree']?>" type="text" value="<?=$item['num']?>" id="num<?=$item['tree']?>"></div>
						<div class="buy-plus to-click ic_plus_basket" ids="<?=$item['tree']?>"></div>
						<div class="buy-minus to-click ic_minus_basket" ids="<?=$item['tree']?>" <?if($item['num']==1):?>disabled<?endif?>></div>
					</div>
				</td>
				<td nowrap><b><span id="tdsale<?=$item['tree']?>"><?=number_format($item['sale'],0,',',' ')?></span><span class="rub">a</span></b></td>
				<td nowrap><b><span id="tdtotal<?=$item['tree']?>"><?=number_format($item['total'],0,',',' ')?></span><span class="rub">a</span></b></td>
				<td><span class="dotted add_to_favorite" favorite="yes" ids="<?=$item['tree']?>">Отложить</span></td>
				<td class="delete"><div class="close-big delgoods" ids="<?=$item['tree']?>"></div></td>
			</tr>
		<?endforeach?>
	</table>
	<div class="right">
		Сумма: <span id="itogo"><?=number_format($order['sum'],0,',',' ')?></span><span class="rub">a</span><br/>
		Скидка: <span id="sale"><?=number_format($order['sale'],0,',',' ')?></span><span class="rub">a</span><br/>
		<b>Сумма к оплате без учета доставки: <span id="result"><?=number_format($order['result'],0,',',' ')?></span><span class="rub">a</span></b><br/>
		<span class="back-link in-block"><a href="/catalog/" >Вернуться к каталог</a></span><a href="/basket/information/" class="checkout in-block"></a>
	</div>
</div>
<?*/?>