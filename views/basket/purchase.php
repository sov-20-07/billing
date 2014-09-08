<div id="content">
	<?CrumbsWidget::run()?>
	<div class="purchase">
		<div class="left-coll">
			<div class="order-box">
				<h3 style="padding-left: 16px;">Ваш заказ</h3>
				<ul class="products">
					<?foreach($order['goods'] as $i=>$item):?>
						<li <?if(($i+1)%2==1):?>class="gr"<?endif?>>
							<a href="<?=$item['path']?>"><?=$item['name']?></a>
							<span class="number"><?if($item['num']>1):?>x<?=$item['num']?><?endif?></span>
							<span class="price"><b><?=number_format($item['total'],0,',',' ')?><span class="rub" style="font-size: 12px;">a</span></b></span>
						</li>
					<?endforeach?>
					<li class="sum border">
						Сумма заказа без учёта доставки
						<span class="price"><?=number_format($order['sum'],0,',',' ')?><span class="rub" style="font-size: 12px;">a</span></span>
					</li>
					<?/*?>
						<li id="delivery"  class="sum border">
							Стоимость доставки
							<span class="price">300<span class="rub" style="font-size: 12px;">a</span></span>
						</li>
						<li class="sum">
							<b>Итого к оплате
							<span class="price"><?=number_format($order['sum']+$order['deliveryprice'],0,',',' ')?><span class="rub" style="font-size: 12px;">a</span></span>
							</b>
						</li>
					<?*/?>
				</ul>
			</div>
		</div>
		<div class="right-coll">
			<h1>Оформление заказа</h1>
			<form method="post" id="simpleform" onsubmit="return checksimpleform()">
				<div class="border-block" style="background-image: url('/i/man.jpg')">
					<h3>Персональные данные</h3>
					<label class="data-label"><span class="name">Имя получателя</span><input name="name" type="text" class="text required"/></label><br/>
					<label class="data-label">
						<span class="name">Email</span><input name="email" type="text" class="text"/><br/>
						<span class="more">По данному адресу будет высылаться информация о текущем статусе заказа</span>
					</label><br/>
					<label class="data-label"><span class="name">Номер телефона</span><input name="phone" type="text" class="text required"/></label><br/>
				</div>
				<div class="border-block" style="background-image: url('/i/point.jpg')">
					<h3>Адрес и способ доставки</h3>
					<div class="data-label textarea">
					<span class="name" style="position: relative;top:0;">Город</span>
					<label class="label_radio r_on">
							<input onclick="$('#other_city').hide();$('#other_city input').prop('disabled',true); $('#deliv').show();" class="" type="radio" name="city" value="Москва" checked />Москва<br/>
					</label><br/>
					<label class="label_radio r_on">
							<input onclick="$('#other_city').show();$('#other_city input').prop('disabled',false); $('#deliv').hide();" class="" type="radio" name="city" value="2" />Другой<br/>
					</label>
					<div id="other_city" <?if ($_POST['city']!=2){?>style="display: none;"<?}?>>
					<span class="more" style="margin-left: 0px;">Введите город</span>
					<input name="city" type="text" class="text" disabled /><br/>
					</div>
					</div><br/>
					
					<label class="data-label textarea"><span class="name" style="position: relative;top:0;">Адрес доставки</span><textarea name="address" class="text required"></textarea></label><br/>
					<div id="deliv">
					<?$i=0?>
					<?foreach(Funcs::$reference['delivery'] as $item):?>
						<label class="label_radio r_on">
							<input class="" type="radio" name="delivery" value="<?=$item['name']?>" <?if($i==0):?>checked<?endif?> />
							<?=$item['name']?><br/>
							<span class="grey"><?=$item['value']?></span>
						</label>
						<?if($i<count(Funcs::$reference['delivery'])-1):?><div class="hr" style="width: 388px; margin-left: 18px;margin-bottom: 10px;"></div><?endif?>
						<?$i++?>
					<?endforeach?>
					</div>
				</div>
				<div class="border-block"<?/*?> style="background-image: url('/i/pay.jpg')"<?*/?>>
					<h3>Метод оплаты</h3>
					<?$i=0?>
					<?foreach(Funcs::$reference['payment'] as $item):?>
						<label class="label_radio r_on">
							<input class="" type="radio" name="payment" value="<?=$item['name']?>" <?if($i==0):?>checked<?endif?>>
							<?=$item['name']?> <?=$item['value']?>
						</label>
						<?if($i<(count(Funcs::$reference['payment'])-1)):?><div class="hr" style="width: 388px; margin-left: 18px;margin-bottom: 10px;"></div><?endif?>
						<?$i++?>
					<?endforeach?>
				</div>
				<div style="padding-left: 39px; margin-top: -20px;">
					<label class="label_check c_on">
						<input id="checkme" type="checkbox" checked />
						<span class="grey"> Я соглашаюсь на хранение и обработку моих персональных данных,
						необходимых для выполнения заказов</span>
					</label><br/>
					<label class="label_check c_on">
						<input type="checkbox" checked />
						<span class="grey"> Присылать информацию о новинках, акциях и ценах</span>
					</label><br/>
					<input type="submit" class="send-but" onclick="return $('#checkme').prop('checked');" style="margin-top: 6px;">
					<script>
						function checksimpleform(){
							var f=0
							$('#simpleform .required').each(function(){
								if (jQuery.trim($(this).val())==''){
									$(this).css('border','solid 1px red');
									f=1;
								}else{
									$(this).css('border','');
								}
							});
							if (f==1){
								 return false;
							}else return true;
						}
					</script>
				</div>
			</form>
		</div>
	</div>
	<div class="clear"></div>
</div>