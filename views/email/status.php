<tr>
	<td style="color: #000000;font-size: 14px;text-transform: uppercase;text-align: center;font-weight: bold;padding-top: 7px;padding-bottom: 7px;">
		СТАТУС ЗАКАЗА
	</td>
</tr>
<tr>
	<td style="background: #fff;padding: 25px;">
		<table cellpadding="0" cellspacing="0" style="font-size: 13px;">
			<tr>
				<td>
					<p>
						Ваш заказ №<?=str_repeat('0',6-strlen($id)).$id?>
						<?if($status=='sort'):?>
							передан в сортировку.
						<?elseif($status=='delivery'):?>
							передан в доставку.
						<?elseif($status=='done'):?>
							выполнен.
						<?elseif($status=='pay'):?>
							ожидает оплаты.
						<?elseif($status=='post'):?>
							отложен.
						<?elseif($status=='cancel'):?>
							отменен.
						<?endif?>
					<p>
					<?if(Sendorder::$cabinet==true):?>
						<p>Более подробную информацию Вы можете узнать в <a href="http://<?=$_SERVER['HTTP_HOST']?>"> в личном кабинете</a></p>
					<?endif?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td style="color: #000000;font-size: 14px;text-transform: uppercase;text-align: center;font-weight: bold;padding-top: 7px;padding-bottom: 7px;">
		СТАТУС ЗАКАЗА
	</td>
</tr>