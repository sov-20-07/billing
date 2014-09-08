<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Корзина</div>
		<table class="basket">
			<col width="1"><col><col><col><col><col>
			<tr><th colspan="6"></th></tr>
			<tr>
				<td colspan="6"><div class="head2">Покупочные карты</div></td>
			</tr>
			<tr class="card_tr">
				<td style="padding:3px;"><span class="icon ic_delete" title="Удалить из корзины" ids="57"></span></td>
				<td style="padding:3px;"><img src="/i/card.jpg"/></td>
				<td style="padding:3px;"><?=$_SESSION['card']['title']?></td>
				<td style="padding:3px;"><?=$_SESSION['card']['message']?></td>
				<td class="price"  style="padding:3px;"><?=$_SESSION['card']['price']?> руб.</td>
			</tr>
		</table>
		<div class="itogo">Итого: <span class="price"><font id="itogo"><?=$_SESSION['card']['price']?></font> руб.</span></div>
		<div class="shopping_choice"><span class="is_button right_top_corner" onclick="$('#oform').show();$(this).parent().hide()"><ins class="icon ic_make_order"></ins>Оформить заказ<span></span></span></div>
		<div class="form_error" id="error"></div>
		<form method="post" id="oform" style="display:none;">
			<div id="payment" class="delivery_terms">
				<div class="head2">Оплата</div>
				<label id="pay2"><input type="radio" name="payment" value="2" checked />Кредитная карта</label>
				<span id="code_field"></span>
				<br/><br/><br/>
				<div class="continue"><span class="is_button right_top_corner" onclick="$('#oform').submit();"><ins class="icon ic_make_order"></ins>Оформить<span></span></span></div>
			</div>
			<a href="/deliv/spots/?popup" id="pickup"></a>
			<div id="hids"></div>
		</form>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>