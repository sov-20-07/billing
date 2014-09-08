<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head><body>
<h1>Заказ №<?=$id?> от <?=date("d.m.Y H:i",strtotime($cdate))?></h1>
<table class="goods" cellpadding="3" border="1" style="border-collapse: collapse;">
	<tr><th>Артикуль</th><th></th><th>Товар</th><th>Размер</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr>
	<?foreach($goods as $item):?>
		<tr>
			<td><?if($item['art']['value']):?><?=$item['art']['value']?><?else:?><?=str_repeat('0',6-strlen($item['id'])).$item['id']?><?endif?></td>
			<td><img src="/of/<?=$item['info']['pics'][0]['path']?>?w=50&h=50" alt="<?=$item['name']?>"></td>
			<td><?=$item['name']?></td>
			<td><?=$item['size']?></td>
			<td align="right"><?=$item['price']?></td>
			<td align="right"><?=$item['num']?></td>			
			<td align="right"><?=$item['num']*$item['price']?> руб.</td>
		</tr>
	<?endforeach?>
	<tr>
		<td colspan="6" align="right">Общая стоимость</td>
		<td colspan="2" align="right">
			<strong><?=number_format($sum,0,',',' ')?> руб.</strong>
		</td>
	</tr>
	<tr>
		<td colspan="6" align="right">
			Скидка (<?=$sale?> руб., <?=$saleperc?>%)<br>
			<i><?=$saletype?></i>
		</td>
		<td colspan="2" align="right" valign="top"><?=$sum/100*$saleperc?> руб.</td>
	</tr>
	<tr class="plugin_orders_table_goods_result-row">
		<td colspan="6">
			Использование бонусов (всего <strong><?=$client['bonuses']?> бон.</strong>)<br>
			<i><?if($bonusesinfo['out']['amount']):?><?=$bonusesinfo['out']['reason']?> <?=$bonusesinfo['out']['amount']?> бон.<?endif?></i>
		</td>
		<td colspan="2" align="right" valign="top"><?=$bonusesamount?> бон.</td>
	</tr>
	<tr>
		<td colspan="6" style="font-weight: bold;" align="right">Итого</td>
		<td colspan="2" align="right" valign="top">
			<strong><?=number_format($sum-$sum/100*$saleperc-$bonusesamount,0,',',' ')?> руб.</strong>
		</td>
	</tr>
	<tr>
		<td colspan="6" align="right">Стоимость доставки</td>
		<td colspan="2" align="right" valign="top"><strong><?=$deliveryprice?> руб.</strong></td>
	</tr>
	<tr>
		<td colspan="6" align="right">Использовать личный счет (всего <strong><?=$client['balance']?> руб.</strong>):</td>
		<td colspan="2" align="right" valign="top"><?=$balanceamount?> руб.</td>
	</tr>
	<tr>
		<td colspan="6" style="font-weight: bold;" align="right">К оплате</td>
		<td colspan="2" align="right" valign="top"><strong><?=number_format($sum+$deliveryprice-$sum/100*$saleperc-$bonusesamount-$balanceamount,0,',',' ')?> руб.</strong></td>
	</tr>
	<tr>
		<td colspan="6" align="right">
			Начисление бонусов (<?=$bonusesinfo['in']['amount']?> бон., <?=$bonusesinfo['in']['perc']?>%):<br>
			<i><?=$bonusesinfo['in']['reason']?></i>
		</td>
		<td colspan="2" align="right" valign="top">
			<?=floor(($sum-$sum/100*$saleperc)/100*$bonusesinfo['in']['perc'])?> бон.
		</td>
	</tr>
</table>
<h3>Клиент:</h3>
<table cellpadding="3" style="border-collapse: collapse;">
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
		<td valign="top"><b>Адрес</b></td>
		<td><?=$address['address']?></td>
	</tr>
	<tr>
		<td valign="top"><b>Доставка</b></td>
		<td>
			<?=$delivery?><br>
			<?=$deliveryoptions?>
		</td>
	</tr>
	<tr>
		<td><b>Цена доставки</b></td>
		<td><?=$deliveryprice?> руб.</td>
	</tr>
	<tr>
		<td><b>Дополнительная информация</b></td>
		<td><?=$info?></td>
	</tr>
	<?if($message):?>
		<tr>
			<td><b>Комментарий</b></td>
			<td><?=nl2br($message)?></td>
		</tr>
	<?endif?>
</table>
<?if($address):?>
		<h2>Доставить заказ сюда</h2>
		<div class="map-contacts">
			<div class="map-center">
				<div class="yandex-map" id="yamap" style="width:650px;height:500px;">
			   		<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU"></script>
					<script type="text/javascript">
						ymaps.ready(init);			
						function init () {
							ymaps.geocode("<?=$address['address']?>", { results: 1 }).then(function (res) {
								// Выбираем первый результат геокодирования
								var object = res.geoObjects.get(0);
	
								// Создаём карту.
								// Устанавливаем центр и коэффициент масштабирования.
								map = new ymaps.Map("yamap", {
									center: object.geometry.getCoordinates(),
									zoom: 15,
								}),
								/*myGeoObject = new ymaps.GeoObject({
									// Геометрия.
									geometry: {
										type: "Point",
										coordinates: object.geometry.getCoordinates()
									}
								});*/
								placemark = new ymaps.Placemark(object.geometry.getCoordinates(), {
									// Свойства
									//iconContent: 'Щелкни по мне',
									balloonContentHeader: "",
									balloonContentBody: '<?=$address['address']?>',
									//balloonContentFooter: 'Подвал'
								}, {
									preset: 'twirl#blueStretchyIcon'
									//iconImageHref: '/i/baloon.png', // картинка иконки
				                    //iconImageSize: [38, 39], // размеры картинки
				                    //iconImageOffset: [-10, -35] // смещение картинки
								});
				
								// Добавляем метки на карту
								map.geoObjects.add(placemark);
								map.controls.add('zoomControl').add('typeSelector').add('mapTools').add('trafficControl');
							}, function (err) {
								// Если геокодирование не удалось,
								// сообщаем об ошибке
								alert(err.message);
							})
						}
					</script>
				</div>
				<div class="map-left"></div>
				<div class="map-right"></div>
			</div>
		</div>
	<?endif?>
</body></html>