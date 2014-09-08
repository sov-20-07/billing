<header class="edit_form_section_header">
	<strong>Доставка</strong>
</header>
<table class="edit_form_table plugin_orders_custom-table">
	<?if(!$address):?>
		<tr>
			<td>Нет адреса</td>
			<td><a href="/<?=Funcs::$cdir?>/iuser/popupaddress/?iuserid=<?=$iuser?>&orderid=<?=Funcs::$uri[3]?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 500, height: 500,contentId: 'highslide-html', cacheAjax: false } ); return false;">Добавить</a></td>
		</tr>
	<?else:?>
		<tr>
			<td>Название адреса пользователя:</td>
			<td>
				<a href="/<?=Funcs::$cdir?>/iuser/popupaddress/?iuserid=<?=$iuser?>&orderid=<?=Funcs::$uri[3]?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 500, height: 500,contentId: 'highslide-html', cacheAjax: false } ); return false;"><?=$address['name']?></a>
			</td>
		</tr>
		<tr>
			<td>Адрес:</td>
			<td><?=$address['address']?></td>
		</tr>
		<tr>
			<td>Способы доставки</td>
			<td>
				<ul>
					<li class="order_form_item" onclick="setDeliveryPrice2(<?=$data['courier']['price']?>)">
						<label class="form_label">
							<input class="form_radio" name="delivery" type="radio" value="Самовывоз" <?if($delivery=='Самовывоз'):?>checked<?endif?>>
							Самовывоз
						</label>
						<div class="form_label_additional-text">
							Бесплатно, следующий рабочий день
						</div>
					</li>
					<?if($address['city']=='Москва'):?>
						<li class="order_form_item" onclick="setDeliveryPrice2(<?=$data['courier']['price']?>)">
							<label class="form_label">
								<input class="form_radio" name="delivery" type="radio" value="Курьером по Москве" <?if($delivery=='Курьером по Москве'):?>checked<?endif?>>
								Курьером по Москве
							</label>
							<div class="form_label_additional-text">
								<?=$data['courier']['cost']?> Р, следующий рабочий день
							</div>
						</li>
					<?elseif($address['region']=='42'):?>
						<li class="order_form_item" onclick="setDeliveryPrice2(<?=$data['couriermo']['price']?>)">
							<label class="form_label">
								<input class="form_radio" name="delivery" type="radio" value="Курьером по Москвовской области" <?if($delivery=='Курьером по Москвовской области'):?>checked<?endif?>>
								Курьером по Москвовской области
							</label>
							<div class="form_label_additional-text">
								<?=$data['couriermo']['cost']?> Р, следующий рабочий день
							</div>
						</li>
					<?else:?>
						<?foreach($data['multiship'] as $key=>$item):?>
							<?if($key!='pickup'):?>
								<li class="order_form_item">
									<label class="form_label" onclick="setDeliveryPrice2(<?=$item['cost']?>)">
										<input class="form_radio" name="delivery" type="radio" value="Доставка от <?=$item['delivery_name']?>" <?if($delivery=='Доставка от '.$item['delivery_name']):?>checked<?endif?>>
										Доставка от <?=$item['delivery_name']?>
									</label>
									<div class="form_label_additional-text">
										<?=$item['cost']?> Р,  <?=$item['deliver_orient_day']?><br>
									</div>
								</li>
							<?endif?>
						<?endforeach?>
						<?foreach($data['multiship']['pickup'] as $key=>$items):?>
								<li class="order_form_item">
									<label class="form_label" onclick="setDeliveryPrice2(<?=$items[0]['cost']?>)">
										<input class="form_radio" name="delivery" type="radio" value="Пункты выдачи заказа <?=$items[0]['delivery_name']?>" <?if($delivery=='Пункты выдачи заказа '.$items[0]['delivery_name']):?>checked<?endif?>>
										Пункты выдачи заказа <?=$items[0]['delivery_name']?>
									</label>
									<div class="form_label_additional-text">
										<?=$items[0]['cost']?> Р,  <?=$items[0]['deliver_orient_day']?><br>
									</div>
									<ul class="plugin_orders_icheck-inner">
									<?foreach($items as $item):?>
										<li>
											<label class="form_label">
												<input name="pickup" type="radio" value="<?=$item['id']?>" <?if($deliveryoptions==$item['address']):?>checked<?endif?>>
												<?=$item['address']?>,
												<div class="form_label_additional-text" style="margin-top: 10px;"><?=$item['instruction']?></div>
											</label>
										</li>
									<?endforeach?>
									</ul>
								</li>
						<?endforeach?>
					<?endif?>
					<li class="order_form_item" onclick="setDeliveryPrice2(0)">
						<label class="form_label">
							<input class="form_radio" name="delivery" type="radio" value="Другой" <?if($delivery=='Другой'):?>checked<?endif?>>
							Другой
						</label>
						<div class="form_label_additional-text">
							<textarea name="pickup"><?=$deliveryoptions?></textarea>
						</div>
					</li>
				</ul>
			</td>
		</tr>
		<?/*?>
		<tr>
			<td>Опции доставки</td>
			<td><div id="additional"><?=$deliveryoptions?></div></td>
		</tr>
		<?*/?>
		<tr>
			<td>Цена доставки</td>
			<td><input type="text" class="input_text" id="deliveryprice" name="deliveryprice" value="<?=$deliveryprice?>" onblur="recalculateTotal()"> руб.</td>
		</tr>
		<tr>
			<td>Первый расчет доставки</td>
			<td><?=$deliveryprice?> руб.</td>
		</tr>
		<tr>
			<td>Информация почтового отправления</td>
			<td>
				<div id="postal">
				<?if(is_array($postal)):?>
					<?foreach(Delivery::$postal as $key=>$item):?>
						<?if($postal[$key]):?>
							<b><?=$item?> </b><?if(strpos($postal[$key],'http://')!==false):?><a href="<?=$postal[$key]?>" target="_blank"><?=$postal[$key]?></a><?else:?><?=$postal[$key]?><?endif?><br />
						<?endif?>
					<?endforeach?>
				<?else:?>
					<input class="input_text" type="text" name="postal" value="<?=$postal?>" />
				<?endif?>
				</div>
			</td>
		</tr>
		<tr>
			<td>Дата доставки/отправки</td>
			<td><input class="input_text" type="text" name="postaldate" value="<?if($postaldate!='0000-00-00'):?><?=date('Y-m-d',strtotime($postaldate))?><?else:?><?=date('Y-m-d')?><?endif?>" /></div></td>
		</tr>
	<?endif?>
</table>
<script>
	function setDeliveryPrice2(price) {
		$('#deliveryprice').val(price);
		recalculateTotal()
	}
	/*function getDeliveryPrice(what) {
		$.ajax({
			type: "POST",
			url: "/<?=ONESSA_DIR?>/orders/getdeliveryprice/",
			data: "id=<?=Funcs::$uri[3]?>&delivery="+what+"&region="+region+"&zip="+zip,
			success: function(msg){
				$('#deliveryprice').val(msg);
				$('#newdeliveryprice').val(msg);
			}
		});
	}
	function setDeliveryPrice(){
		var deliveryprice=$('#deliveryprice').val();
		$.ajax({
			type: "POST",
			url: "/<?=Funcs::$cdir?>/orders/setdeliveryprice/",
			data: "id=<?=Funcs::$uri[3]?>&deliveryprice="+deliveryprice,
			success: function(msg){
				
			}
		});
	}*/
</script>