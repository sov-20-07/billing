<h1>Заказ №<?=$id?> от <?=date("d.m.Y H:i",strtotime($cdate))?></h1>
<table class="goods" cellpadding="3" border="1">
	<tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr>
	<?foreach($items as $item):?>
		<tr>
			<td><b><?=$item['name']?></b></td>
			<td><b><?=$item['price']?></b></td>
			<td><?=$item['num']?></td>			
			<td><?=$item['num']*$item['price']?></td>
		</tr>
	<?endforeach?>
	<tr><td colspan="3" style="text-align: right">Итого:</td><td><span id="itogo"><?=$price?></span></td></tr>
</table>
<h3>Клиент:</h3>
<table class="goods" cellpadding="3">
	<tr>
		<td><b>Имя</b></td>
		<td><?=$name?></td>
	</tr>
	<tr>
		<td><b>Телефон</b></td>
		<td><?=$phone?></td>
	</tr>
	<tr>
		<td><b>Email</b></td>
		<td><?=$email?></td>
	</tr>
	<tr>
		<td><b>Адрес</b></td>
		<td><?=$address?></td>
	</tr>
	<tr>
		<td><b>Доставка</b></td>
		<td><?=$delivery?></td>
	</tr>
	<tr>
		<td><b>Цена доставки</b></td>
		<td><?=$deliveryprice?></td>
	</tr>
	<tr>
		<td><b>Дополнительная информация</b></td>
		<td><?=$info?></td>
	</tr>
	<tr>
		<td><b>Комментарий</b></td>
		<td><?=nl2br($message)?></td>
	</tr>
</table>