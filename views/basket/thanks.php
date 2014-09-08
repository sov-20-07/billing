<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
	<?if(Funcs::$uri[0]=='cabinet'):?>
		<?MenuWidget::CabinetMenu()?>
	<?else:?>
		<?MenuWidget::LeftMenu()?>
	<?endif?>
	</div></div>
	<div id="right_part">
		<div class="head1">Благодарим вас за заказ!</div>
		<div class="order_done">
			<span class="head">Вы можете отслеживать статус этого заказа разделе <a href="/cabinet/orders/">Мои заказы</a>. </span>
			<table class="default">
				<tr>
					<td>Номер Вашего заказа:</td>
					<td class="numbers"><?=str_repeat('0',6-strlen($_SESSION['orderId'])).$_SESSION['orderId']?></td>
				</tr>
				<tr>
					<td>Дата заказа:</td>
					<td class="numbers"><?=date('d.m.Y')?></td>
				</tr>
				<tr>
					<td>Сумма заказа:</td>
					<td class="numbers"><?=number_format($_SESSION['sum']+$_SESSION['deliveryprice'],0,',',' ')?> руб.</td>
				</tr>
			</table>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>