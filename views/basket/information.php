<div class="page">
	<table class="steps-nav">
		<tr>
			<td class="active">Персональные данные</td>
			<?if($_SESSION['mydata']['name']):?>
				<td class="passed"><a href="/basket/delivery/">Способ доставки</a></td>
			<?else:?>
				<td>Способ доставки</td>
			<?endif?>
			<?if($_SESSION['mydata']['delivery']):?>
				<td class="passed"><a href="/basket/payment/">Метод оплаты</a></td>
			<?else:?>
				<td>Метод оплаты</td>
			<?endif?>
			<td>Подтверждение</td>
		</tr>
	</table>
	<div class="steps">
		<h1>Персональные данные</h1>
		<div class="left-coll">
			<h6>Ваш заказ</h6>
			<ul class="products" style="margin-top: 15px;">
			<?foreach($order['goods'] as $i=>$item):?>
				<li>
					<a href="<?=$item['path']?>"><?=$item['name']?> <?if($item['num']>1):?><nobr>(<?=$item['num']?> шт.)</nobr><?endif?></a>
					<span class="price"><b><?=number_format($item['total'],0,',',' ')?><span class="rub">a</span></b></span>
				</li>
			<?endforeach?>
			</ul>
			<div class="hr"></div>
			<ul class="products">
				<li>
					<b>Сумма без скидки</b>
					<span class="price"><b><?=number_format($order['sum']+$order['sale'],0,',',' ')?><span class="rub">a</span></b></span>
				</li>
				<li>
					<b>Скидка</b>
					<span class="price"><b><?=number_format($order['sale'],0,',',' ')?><span class="rub">a</span></b></span>
				</li>
				<li>
					<b>Товаров <?=$order['count']?>.</b>Общая сумма заказа без учета стоимости доставки<br/>
					<a href="/basket/" class="font11">Изменить заказ в корзине</a>
					<span class="price"><b><?=number_format($order['sum'],0,',',' ')?><span class="rub">a</span></b></span>
				</li>
			</ul>
		</div>
		<div class="right-coll">
			<h6>Ваши данные</h6>
			<form class="delivery_info" method="post" id="simpleform" onsubmit="return checksimpleform()">
				<table class="default steps-table">
					<tr>
						<td>Ваше имя</td>
						<td><input type="text" class="text required" name="name" value="<?if($_SESSION['mydata']['name']):?><?=$_SESSION['mydata']['name']?><?else:?><?=$_SESSION['iuser']['name']?><?endif?>"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" class="text" name="email" value="<?if($_SESSION['mydata']['email']):?><?=$_SESSION['mydata']['email']?><?else:?><?=$_SESSION['iuser']['email']?><?endif?>"></td>
					</tr>
					<tr>
						<td>Телефон</td>
						<td><input type="text" class="text required" name="phone" value="<?if($_SESSION['mydata']['phone']):?><?=$_SESSION['mydata']['phone']?><?else:?><?=$_SESSION['iuser']['phone']?><?endif?>"></td>
					</tr>
					<tr>
						<td>Сообщение</td>
						<td><textarea type="text" class="text" name="message" style="width:240px;max-width: 240px;height:100px;"><?=$_SESSION['mydata']['message']?></textarea></td>
					</tr>
					<?/*?>
					<tr>
						<td></td>
						<td>
							<label class="label_check">
								<input type="checkbox" name="who" onclick="if($(this).prop('checked')==true){$('#hiddenyur').fadeIn();}else{$('#hiddenyur').fadeOut();}">
								Юридическое лицо
							</label><br/>
						</td>
					</tr>
					<tbody id="hiddenyur" style="display:none">
						<tr>
							<td>Компания</td>
							<td><input type="text" class="text"></td>
						</tr>
						<tr>
							<td>ИНН</td>
							<td><input type="text" class="text"></td>
						</tr>
					</tbody>
					<?*/?>
					<tr>
						<td></td>
						<td><input type="submit" onclick class="next-but"><br /><br /><br /></td>
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
				<div class="yellow-block">
					Испытываете затруднение при заполнении?<br/>Обратитесь в службу по работе с клиентами:<br/>
					<span class="phone"><?=Funcs::$conf['settings']['phone']?></span><br/>
					Наши специалисты с удовольствием Вам помогут
				</div>
				<div class="yellow-block" style="top:210px;">
					<label class="label_check">
						<input type="checkbox" name="registration" value="1" <?if(isset($_SESSION['mydata']['registration'])):?><?=$_SESSION['mydata']['registration']?><?else:?>checked<?endif?> />
						Зарегистрироваться автоматически
					</label><br/>
					<label class="label_check">
						<input type="checkbox" name="emailreport" value="1" <?if(isset($_SESSION['mydata']['emailreport'])):?><?=$_SESSION['mydata']['emailreport']?><?else:?>checked<?endif?> />
						Получать уведомления
						о статусе заказа на email
					</label><br/>
					<label class="label_check">
						<input type="checkbox" name="smsreport" value="1" <?if(isset($_SESSION['mydata']['smsreport'])):?><?=$_SESSION['mydata']['smsreport']?><?endif?> />
						Получать SMS-уведомления о статусе заказа
					</label>
				</div>
			</form>
		</div>
		<div class="line"></div>
		<div class="clear"></div>
	</div>
</div>



<?/* ?>
<div class="fixed_width">
	<div id="navigation">Оформление заказа</div>
	<div class="basket">
		<h1>Оформление заказа</h1>
		<div class="inline_block b_i">
			<div class="order_short">
				<b>Ваш заказ:</b><br />
				<span class="pseudo is_dark" onclick="$('div.smallbasket').toggle();">Товаров: <?=$order['count']?>.</span><br />
				<div class="smallbasket" style="display:none;">
					<table class="default basket_goods">
						<col><col width="1">
						<?foreach($order['goods'] as $i=>$item):?>
						<tr>
							<td><div class="good_name"><a href="<?=$item['path']?>"><?=$item['name']?></a> <?if($item['num']>1):?><nobr>(<?=$item['num']?> шт.)</nobr><?endif?></div></td>
							<td><nobr class="is_black"><b><?=number_format($item['total'],0,',',' ')?> руб.</b></nobr></td>
						</tr>
						<?endforeach?>
					</table>
					<br />
				</div>
				<span class="is_dark">Общая сумма заказа без учета доставки </span><br />
				<span class="rur12_bold"><?=number_format($order['sum'],0,',',' ')?></span><br />
				<a href="/basket/">Уточнить заказ в корзине</a>
			</div>
			<div class="blue_border"><div class="buyer_info">
				<div class="buyer_note"><div class="note_padds">
					Введите имя получателя, email и контактный номер телефона. Укажите точный адрес с индексом. Наш менеджер перезвонит в ближайшее время и уточнит детали заказа.<br />
					Если у Вас возникли вопросы, Вы можете получить на них ответ, позвонив по телефону<br />
					<b class="font_18"><?=Funcs::$conf['settings']['phone']?></b>
				</div></div>
				<form class="delivery_info" method="post" id="simpleform" onsubmit="return checksimpleform()">
					<b>Ваши данные:</b>
					<div class="field_block">
						<div class="field_name">Имя получателя</div>
						<div class="field"><input type="text" class="required" name="name" value="<?=$_SESSION['mydata']['name']?>" /></div>
					</div>
					<div class="field_block">
						<div class="field_name">Email</div>
						<div class="field"><input type="text" name="email" value="<?=$_SESSION['mydata']['email']?>" /></div>
					</div>
					<div class="field_block">
						<div class="field_name">Номер телефона</div>
						<div class="field"><input type="text" class="required" name="phone" value="<?=$_SESSION['mydata']['phone']?>" /></div>
					</div>
					<div class="field_block">
						<div class="field_name">Адрес доставки</div>
						<div class="field"><textarea rows="5" name="address"><?=$_SESSION['mydata']['address']?></textarea></div>
					</div>
					<label class="i_agree"><input type="checkbox"  onchange="if($(this).attr('checked')=='checked'){$('#sbmt1').attr('disabled',false)}else{$('#sbmt1').attr('disabled',true)}" />Я соглашаюсь на хранение и обработку моих персональных данных,<br />необходимых для выполнения заказов</label>
					<br />
					<input type="submit" id="sbmt1" value="" class="is_button send" disabled />
				</form>
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
			</div></div>
		</div>
	</div>
</div>
<?*/?>