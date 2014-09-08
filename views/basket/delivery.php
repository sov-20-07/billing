<div class="page">
	<table class="steps-nav">
		<tr>
			<td class="passed"><a href="/basket/information/">Персональные данные</a></td>
			<td class="active">Способ доставки</td>
			<?if($_SESSION['mydata']['delivery']):?>
				<td class="passed"><a href="/basket/payment/">Метод оплаты</a></td>
			<?else:?>
				<td>Метод оплаты</td>
			<?endif?>
			<td>Подтверждение</td>
		</tr>
	</table>
	<div class="steps">
		<h1>Способы доставки</h1>
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
			<div class="hr"></div>
			<h6>Ваши данные</h6>
			<p>
				<?=implode(', ',Basket::getMyData())?><br />
				<a href="/basket/information/" class="font11">Изменить данные</a>
			</p>
		</div>
		<div class="right-coll">
			<form class="delivery_info" method="post" id="deliveryform">
				<h6>Адрес</h6>
				<table class="default steps-table">
					<tr>
						<td>Регион</td>
						<td>
							<div class="select" style="width: 200px;">
								<div class="select-val"><?=$region?></div>
								<input type="hidden" name="region" value="<?=$region?>">
								<div class="select-list" >
									<ul>
										<?/*?><li>&nbsp;</li><?*/?>
										<?foreach(Funcs::$referenceId['regions'] as $item):?>
											<li><?=$item['name']?></li>
										<?endforeach?>
									</ul>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td style="vertical-align: top;padding-top: 7px;">Адрес</td>
						<td><textarea name="address"><?if($_SESSION['mydata']['address']):?><?=$_SESSION['mydata']['address']?><?else:?><?=$_SESSION['iuser']['address']?><?endif?></textarea></td>
					</tr>
					<tr>
						<td style="vertical-align: top;padding-top: 7px;"></td>
						<td><label class="label_check"><input type="checkbox" name="save" value="1" /> сохранить новый адрес</label></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</table>
				<?/*?><div id="delivery" style="display:none;"><?*/?>
					<h6>Способы доставки</h6><br/>
					<label class="label_radio ">
						<input type="radio" name="rgr1" value="Курьером по москве" />
						Курьером по москве <br/>
						<span class="label-note">Стоимость доставки от 500<span class="rub">a</span></span>
					</label><br/>
					<label class="label_radio ">
						<input type="radio" name="rgr1" value="Самовывоз" />
						Самовывоз<br/>
						<span class="label-note">Со склада во Фрязино</span>
					</label><br/>
					<?/* ?>
					<label class="label_radio ">
						<input type="radio" name="rgr1" value="Почта России" />
						Почта России<br/>
						<span class="label-note">Автоматический расчет стоимости.<br/>
												Смотрите <a href="#">список регионов </a>
						</span>
					</label><br/>
					<?*/?>
					<label class="label_radio ">
						<input type="radio" name="rgr1" value="Почта России" />
						Почта России<br/>
						<?/* ?>	<span class="label-note">Для остальных регионов</span><?*/?>
					</label><br/>
					<?/* ?>
					<label class="label_radio ">
						<input type="radio" name="rgr1" value="Транспортная компания ПЭК" />
						Транспортная компания ПЭК<br/>
						<span class="label-note">Предоплата</span>
					</label><br/>					
					<label class="label_radio ">
						<input type="radio" name="rgr1" value="Курьерская служба доставки DPD" />
						Курьерская служба доставки DPD<br/>
					</label><br/>
					<label class="label_radio ">
						<input type="radio" name="rgr1" value="Самовывоз" />
						Самовывоз<br/>
						<span class="label-note"> Смотрите <a href="#">список складов</a></span>
					</label>
					<br/>
					<?*/?>
					<input type="button" class="next-but" onclick="return checkdeliveryformform()">
					
				<?/*?></div><?*/?>
			</form>
			<script>
				function checkdeliveryformform(){
					var f=0
					$('#deliveryform .required').each(function(){
						if (jQuery.trim($(this).val())==''){
							$(this).css('border','solid 1px red');
							f=1;
						}else{
							$(this).css('border','');
						}
					});
					if (f==1){
						return false;
					}else{
						$('#deliveryform').submit();
					}
				}
			</script>
			<div class="yellow-block">
				Испытываете затруднение при заполнении?<br/>Обратитесь в службу по работе с клиентами:<br/>
				<span class="phone"><?=Funcs::$conf['settings']['phone']?></span><br/>
				Наши специалисты с удовольствием Вам помогут
			</div>
		</div>
		<div class="line"></div>
		<div class="clear"></div>
	</div>
</div>


<?/* ?>
<div id="content"><div class="common_padds"><div class="inline_block">
	<div id="navigation">
		<a href="/basket/">Корзина</a><span class="icon right_arrow"></span>Доставка
	</div>
	<div id="right_part" class="without_left"><div class="right_padds">
		<div class="order_steps"><table class="default"><tr>
			<td width="25%">1. Авторизация</td>
			<td width="25%" class="current">2. Доставка</td>
			<td width="25%">3. Оплата</td>
			<td width="25%">4. Подтверждение</td>
		</tr></table></div>
		<h1>Информация о доставке</h1>
		<form class="delivery_info" method="post">
			<table class="default">
				<col width="34%"><col width="33%"><col width="33%">
				<tr>
					<td>
						<div class="head">Ваш заказ:</div>
						<span class="pseudo" onclick="$('div.basket').toggle();">Товаров <?=$order['count']?>.</span> Общая сумма заказа без учета доставки <br />
						<b><?=number_format($order['sum'],0,',',' ')?> руб.</b>
						<div class="basket smallbasket" style="display:none;">
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
						<div class="customer_info">
							<div class="head">Ваши данные:</div>
							<?=implode(', ',Basket::getMyData())?>
							<br />
							<a href="/basket/step1/" class="font_11">Изменить данные</a>
						</div>
					</td>
					<td>
						<div class="head">Выберите способ доставки:</div>
						<?foreach(Funcs::$infoblock['delivery'] as $item):?>
							<?=$item['description']?>
						<?endforeach?>
					</td>
					<td>
						<div class="delivery_note"><div class="d_padds">
							<p>
								Испытываете трудности при заполнении? <br />
								Вы можете обратиться в Службу по работе с&nbsp;клиентами по телефону
								<span class="phone_note"><?=Funcs::$conf['settings']['phone']?></span>
								<span class="pseudo popup_call">перезвоните мне</span>
							</p>
							<p>Выберите способ доставки. Обратите внимание, что доставка курьером возможна только для Москвы и Московской области.</p>
							<p>Доставка в другие города России осуществляется по Почте России или транспортной компанией. Доставка до транспортной компаниии в Москве и&nbsp;области бесплатная.</p>
						</div></div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="next_button"><input type="submit" class="is_button is_button2 with_shadow" value="Далее" /></td>
					<td></td>
				</tr>
			</table>
		</form>
	</div></div>
</div></div></div>
<?*/?>