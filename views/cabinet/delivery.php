






<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::CabinetMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Корзина</div>
		<?if(count($order['goods'])>0):?>
			<form method="post" id="simpleform" action="/cabinet/basket/">
				<a href="javascript:;" onclick="$(this).next().next().slideToggle();">Товаров: <?=count($order['goods'])?></a><br />
				<div style="display:none;">
					<?foreach($order['goods'] as $i=>$item):?>
						<a href="/cabinet/books/<?=$item['id']?>/"><?=$item['name']?></a> (<?=$item['num']?>)<br />
					<?endforeach?>
				</div>
				Cтоимость, без учета  доставки: <span class="is_black"><?=number_format($order['sum'],0,',',' ')?> руб.</span><br />
				<a href="/cabinet/basket/">Проверить корзину</a>
				<!-- условия доставки -->
				<div class="delivery_terms">
					<div class="head2">условия доставки</div>
					<div class="light_gray">Способ доставки: </div>
					<label><input type="radio" class="delivery" name="delivery" what="mail" price="<?=$delivery?>" value="mail" checked />Почта России<div class="small_price"><span id="delivery"><?=$delivery?></span> руб.</div></label><br />
					<label><input type="radio" class="delivery" name="delivery" what="moscow" price="<?=Funcs::$reference['delivery']['moscow']['value']?>" value="moscow" />Курьерская доставка по Москве<div class="small_price"><?=Funcs::$reference['delivery']['moscow']['value']?> руб.</div></label><br />
					<label><input type="radio" class="delivery" name="delivery" what="mo" price="<?=Funcs::$reference['delivery']['mo']['value']?>" value="mo" />Курьерская доставка по Московской области<div class="small_price"><?=Funcs::$reference['delivery']['mo']['value']?> руб.</div></label><br />
					<label><input type="radio" class="delivery" name="delivery" what="pickup" price="<?=Funcs::$reference['delivery']['pickup']['value']?>" value="pickup" />Самовывоз<div class="small_price">бесплатно</div></label><br />
					<input type="hidden" id="deliveryprice" name="deliveryprice" value="<?=$delivery?>" /> 
					<input type="hidden" id="sumprice" value="<?=$order['sum']?>" /> 
					<div class="delivery_addr">
						<span>Укажите адрес доставки</span><input type="text" class="text" name="address" id="address" value="<?=$_SESSION['iuser']['address']?>" />*
					</div>
					<?/* ?><div class="continue"><span class="is_button right_top_corner"><ins class="icon ic_make_order"></ins>Продолжить<span></span></span></div><?*/?>
					<div class="dotted_line"></div>
					<div class="head2">условия оплаты</div>
					<div class="order_price">Цена заказа с учетом доставки составляет: <span class="is_black"><span id="allprice"><?=$order['sum']+$delivery?></span> руб.</span><?/* ?> (Экономия: <span class="is_black">899 руб.</span>)<?*/?></div>
					<div class="paymentdiv">
						<label style="display:none"><input type="radio" class="payment nal" what="mail" name="payment" value="Наличные" />Наличные</label>
						<label><input type="radio" class="payment nplat" name="payment" value="Наложенный платеж" checked />Наложенный платеж</label>
						<label><input type="radio" class="payment crcard" name="payment" value="Кредитная карта" />Кредитная карта</label>
						<label><input type="radio" class="payment term" name="payment" value="Терминалы" />Терминалы</label>
						<label><input type="radio" class="payment emoney" name="payment" value="Электронные деньги" />Электронные деньги</label>
					</div>
					<?/*?>
					<div class="promo-code">
						<span>Введите промо-код или код подарочной карты</span><input type="text" class="text" name="card" /><span class="pseudo">Активировать</span>
					</div>
					<?*/?>
					<div class="continue"><span class="is_button right_top_corner" onclick="if (jQuery.trim($('#address').val())==''){$('#address').css('border','1px solid #FF0000');return false;}else{$('#address').css('border','');$('#simpleform').submit();}"><ins class="icon ic_make_order"></ins>Оформить заказ<span></span></span><?/*?><span class="is_button right_top_corner"><ins class="icon ic_make_order"></ins>Продолжить<span></span></span><?*/?></div>
					<script>
						$(document).ready(function(){
							$('.delivery').click(function(){
								$('.payment').prop('checked',false);
								if($('.delivery:checked').attr('what')=='mail'){
									$('.payment.nplat').prop('checked',true);
									$('.payment.nplat').parent().show();
									$('.payment.nal').parent().hide();
								}else{
									$('.payment.nal').prop('checked',true);
									$('.payment.nal').parent().show();
									$('.payment.nplat').parent().hide();
								}
								var sum=$('.delivery:checked').attr('price')*1+$('#sumprice').val()*1;
								$('#allprice').text(sum);
								$('#deliveryprice').val($('.delivery:checked').attr('price'));
							});
						});
					</script>
				</div>
			</form>
		<?else:?>
			Ваша корзина пуста
		<?endif?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>