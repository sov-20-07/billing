<div id="content"><div class="common_padds"><div class="inline_block">
	<div id="navigation">
		<a href="/basket/">Корзина</a><span class="icon right_arrow"></span>Оформление заказа
	</div>
	<div id="right_part" class="without_left"><div class="right_padds">
		<h1>Купить в один клик</h1>
		<form class="delivery_info buy_1click" method="post" id="simpleform" onsubmit="return checksimpleform();">
			<table class="default">
				<col width="320"><col>
				<tr>
					<td>
						<div class="head">Ваш заказ:</div>
						<span class="pseudo" onclick="$('div.basket').toggle();">Товаров <?=$order['count']?>.</span> Общая сумма заказа без учета доставки <br />
						<b><?=number_format($order['sum'],0,',',' ')?> руб.</b>
						<div class="basket" style="display:none;">
							<table class="default basket_goods">
								<col><col width="1">
								<?foreach($order['goods'] as $i=>$item):?>
								<tr>
									<td><div class="good_name"><a href="<?=$item['path']?>"><?=$item['name']?>"</a> <?if($item['num']>1):?><nobr>(<?=$item['num']?> шт.)</nobr><?endif?></div></td>
									<td><nobr class="is_black"><b><?=number_format($item['total'],0,',',' ')?> руб.</b></nobr></td>
								</tr>
								<?endforeach?>
							</table>
						</div>
						<div class="detailorder"><a href="/basket/" class="font_11">Уточнить заказ в корзине</a></div>
					</td>
					<td>
						<div class="register_1click">
							<div class="register_note">Введите имя получателя, email и контактный номер телефона. Наш менеджер перезвонит в ближайшее время и уточнит детали заказа.</div>
							<div class="head">Ваши данные:</div>
							<div class="field_block">
								<div class="field_name">Имя получателя</div>
								<div class="field"><input type="text" class="text required" name="name" value="<?=$_SESSION['mydata']['name']?>" /></div>
							</div>
							<div class="field_block">
								<div class="field_name">Email</div>
								<div class="field"><input type="text" class="text" name="email" value="<?=$_SESSION['mydata']['email']?>" /></div>
							</div>
							<div class="field_block">
								<div class="field_name">Номер телефона</div>
								<div class="field"><input type="text" class="text required" name="phone" value="<?=$_SESSION['mydata']['phone']?>" /></div>
							</div>
							<label class="i_agree"><input type="checkbox" onchange="if($(this).attr('checked')=='checked'){$('#sbmt1').attr('disabled',false)}else{$('#sbmt1').attr('disabled',true)}" />Я соглашаюсь на хранение и обработку моих персональных данных, <br />необходимых для выполнения заказов</label>
							<br />
							<input type="submit" id="sbmt1" class="is_button is_button2 with_shadow" value="Отправить заказ" disabled />
						</div>
					</td>
				</tr>
			</table>
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
		</form>
	</div></div>
</div></div></div>