<div class="right-block-content" >
	<h1><?=$name?></h1>
	<table class="basket-table">
		<thead><th>Артикул</th><th>Описание</th><th>Цена</th><th>Колличество</th><th>Скидка</th><th>Стоимость</th></thead>
		<?foreach($goods as $item):?>
			<tr>
				<td><?=str_repeat('0',6-strlen($item['id'])).$item['id']?></td>
				<td class="annotation">
					<a href="<?=$item['path']?>" class="pic"><img src="/of/1<?=$item['pics'][0]['path']?>" /></a>
					<a href="<?=$item['path']?>"><?=$item['name']?></a>
				</td>
				<td nowrap><b><?=number_format($item['price'],0,',',' ')?><span class="rub">a</span></b></td>
				<td style="text-align: center"><?=$item['num']?></td>
				<td nowrap><b><?=number_format($item['sale'],0,',',' ')?><span class="rub">a</span></b></td>
				<td nowrap><b><?=number_format($item['total'],0,',',' ')?><span class="rub">a</span></b></td>
			</tr>
		<?endforeach?>
	</table>
	<div  class="cabinet right">
		Сумма без скидки: <?=number_format($sum+$sale,0,',',' ')?><span class="rub">a</span><br/>
		Скидка: <?=number_format($sale,0,',',' ')?><span class="rub">a</span><br/>
		Доставка: <?=number_format($deliveryprice,0,',',' ')?><span class="rub">a</span><br/>
		<b>Общая сумма: <?=number_format($sum+$deliveryprice,0,',',' ')?><span class="rub">a</span></b><br/>
	</div>
	<span class="back-link">
		<a href="/cabinet/orders/">Вернуться назад</a>
	</span>
</div>
<div class="left-block-content">
	<div class="left-content">
		<div class="logined">
			Здравствуйте,<br/>
			<b style="font-size: 15px;"><?=$_SESSION['iuser']['name']?></b><br/>
			<a href="/registration/logout/" class="exit"></a>
		</div>
		<?MenuWidget::CabinetMenu();?>
	</div>
</div>