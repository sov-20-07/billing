<div class="page">
	<table class="steps-nav">
		<tr>
			<td class="passed"><a href="/basket/information/">Персональные данные</td>
			<td class="passed"><a href="/basket/delivery/">Способ доставки</a></td>
			<td class="active">Метод оплаты</td>
			<td>Подтверждение</td>
		</tr>
	</table>
	<div class="steps">
		<h1>Метод оплаты</h1>
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
			<div class="hr"></div>
			<h6>Доставка</h6>
			<ul class="products">
				<li>
					<?=$_SESSION['mydata']['delivery']?><br/>
					<?=$_SESSION['mydata']['address']?><br/>
					<a href="/basket/delivery/" class="font11">Изменить способ доставки</a>
					<?/*?><span class="price"><b> от 500<span class="rub">a</span></b></span><?*/?>
				</li>
			</ul>
		</div>
		<div class="right-coll">
			<h6>Методы оплаты</h6><br/>
			<form class="delivery_info" method="post" id="simpleform">
				<label class="label_radio ">
					<input type="radio" name="rgr2" value="Наличными при получении" />
					Наличными при получении
				</label><br/>
				<label class="label_radio ">
					<input type="radio" name="rgr2" value="On-line оплата" />
					On-line оплата<br/>
					<span class="label-note">Visa, MasterCard, Яндекс.Деньги, WebMoney</span>
				</label><br/>
				<label class="label_radio ">
					<input type="radio" name="rgr2" value="Банковским переводом" />
					Банковским переводом<br/>
					<span class="label-note">Для физических лиц</span>
				</label><br/>
				<label class="label_radio ">
					<input type="radio" name="rgr2" value="Банковским переводом" />
					Банковским переводом<br/>
					<span class="label-note">Для юридических лиц</span>
				</label><br/>
				<br/>
				<input type="submit" class="next-but">
			</form>
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
<div class="fixed_width">
	<div id="navigation">Способ оплаты</div>
	<div class="basket">
		<h1>Способ оплаты</h1>
		<div class="inline_block b_i">
			<div class="order_short">
				<b>Ваш заказ:</b><br />
				<span class="pseudo is_dark" onclick="$('div.smallbasket').toggle();">Товаров: <?=$order['count']?>.</span><br />
				<div class="smallbasket" style="display:none;">
					<table class="default basket_goods">
						<col><col width="1">
						<?foreach($order['goods'] as $i=>$item):?>
						<tr>
							<td><div class="good_name"><a href="<?=$item['path']?>"><?=$item['name']?>"</a> <?if($item['num']>1):?><nobr>(<?=$item['num']?> шт.)</nobr><?endif?></div></td>
							<td><nobr class="is_black"><b><?=number_format($item['total'],0,',',' ')?> руб.</b></nobr></td>
						</tr>
						<?endforeach?>
					</table>
					<br />
				</div>
				<span class="is_dark">Общая сумма заказа без учета доставки </span><br />
				<span class="rur12_bold"><?=number_format($order['sum'],0,',',' ')?></span><br />
				<a href="/basket/">Уточнить заказ в корзине</a><br /><br />	
				<b>Ваши данные:</b><br />
				<span class="is_dark">
					<?=implode(', ',Basket::getMyData())?>
				</span>
				<br />
				<a href="/basket/information/">Изменить данные</a>
			</div>
			<div class="blue_border"><div class="buyer_info">
				<div class="buyer_note"><div class="note_padds">
					Если у Вас возникли вопросы, Вы можете получить на них ответ, позвонив по телефону<br />
					<b class="font_18"><?=Funcs::$conf['settings']['phone']?></b>
				</div></div>
				<form class="delivery_info" method="post" id="simpleform">
					<b>Выберите способ оплаты:</b>
					<?foreach(Funcs::$infoblock['payment'] as $item):?>
						<?=$item['description']?>
					<?endforeach?>
					<input type="submit" value="" class="is_button send" />
				</form>
			</div></div>
		</div>
	</div>
</div>
<?*/?>