<tr>
	<td style="background: #fff;">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td style="font-size: 20px;background: #e5f2ff;padding-left: 20px;padding-right: 20px;padding-top: 10px;">
					Здравствуйте, <?=$_SESSION['mydata']['name']?>!
				</td>
			</tr>
			<tr>
				<td style="color:#4d9900;font-weight: bold;padding-top: 5px; background: #e5f2ff;padding-left: 20px;padding-right: 20px; ">
					Ваш заказ №<?=str_repeat('0',6-strlen($id)).$id?> принят
				</td>
			</tr>
			<tr>
				<td  style="padding-bottom: 15px;background: #e5f2ff;padding-left: 20px;padding-right: 20px;" >
					После обработки с Вами свяжется менеджер магазина для уточнения статуса заказа.
					Так же будет отправлено письмо на указанный Вами адрес электронной почты.
				</td>
			</tr>
			<tr>
				<td style="padding-left: 20px;padding-right: 20px;font-size: 14px;">
					<table cellpadding="0" cellspacing="0" style="width: 100%">
						<tr>
							<td style="font-size: 20px;padding-bottom: 10px;padding-top: 15px;">Вы заказали:</td>
						</tr>
						<tr>
							<td>
								<table cellpadding="0" cellspacing="0" style="width: 100%;font-size: 14px;">
									<tr>
										<td colspan="2" style="border-bottom: 1px solid #e5f2ff;font-size: 13px;color: #666666;padding-bottom: 5px;">Описание</td>
										<td style="border-bottom: 1px solid #e5f2ff;font-size: 13px;color: #666666;padding-bottom: 5px;">Цена</td>
										<td style="border-bottom: 1px solid #e5f2ff;font-size: 13px;color: #666666;padding-bottom: 5px;">Количество</td>
										<td style="border-bottom: 1px solid #e5f2ff;font-size: 13px;color: #666666;padding-bottom: 5px;">Стоимость</td>
									</tr>
									<?foreach($goods as $i=>$item):?>
										<tr>
											<td style="vertical-align: top;padding-right: 5px;padding-top: 5px;padding-bottom: 5px;border-bottom: 1px solid #e5f2ff;">
												<a href="http://<?=$_SERVER['HTTP_HOST']?><?=$item['path']?>"><img src="http://<?=$_SERVER['HTTP_HOST']?>/of/1<?=$item['pics'][0]['path']?>"></a>
											</td>
											<td style="vertical-align: top;padding-right: 5px;padding-top: 10px;padding-bottom: 10px;border-bottom: 1px solid #e5f2ff;">
												<a href="http://<?=$_SERVER['HTTP_HOST']?><?=$item['path']?>" style="color: #0080ff;font-size: 14px;"><?=$item['name']?></a>
											</td>
											<td nowrap style="vertical-align: top;padding-right: 5px;padding-top: 10px;padding-bottom: 10px;border-bottom: 1px solid #e5f2ff;"><b><?=number_format($item['price'],0,',',' ')?> руб.</b></td>
											<td style="vertical-align: top;padding-right: 10px;padding-top: 10px;padding-bottom: 10px;border-bottom: 1px solid #e5f2ff;"><?=$item['num']?></td>
											<td nowrap style="vertical-align: top;padding-right: 5px;padding-top: 10px;padding-bottom: 10px;border-bottom: 1px solid #e5f2ff;"> <b><?=number_format($item['total'],0,',',' ')?> руб.</b></td>
										</tr>
									<?endforeach?>
								</table>
							</td>
						</tr>
						<tr>
							<td style="padding-top: 20px;">
								<table cellpadding="0" cellspacing="0" style="font-size: 14px;">
									<tr>
										<td style="vertical-align: top;width: 170px;padding-right: 20px;">
											Получатель:<br/>
											<?=$_SESSION['mydata']['name']?><br/><br/>
											Email:<br/>
											<a href="mailto:<?=$_SESSION['mydata']['email']?>" style="color: #2389ff"><?=$_SESSION['mydata']['email']?></a><br/><br/>
											Телефонный номер:<br/>
											<?=$_SESSION['mydata']['phone']?>
										</td>
										<td style="vertical-align: top;width: 170px;padding-right: 30px;">
											Адрес:<br/>
											<?=$_SESSION['mydata']['address']?><br/><br/>
											Способ доставки:<br/>
											<?if ($_SESSION['mydata']['city_name']=='Москва'){?><?=$_SESSION['mydata']['delivery']?><?}?>
										</td>
										<td style="vertical-align: top;">
											Сумма заказа: <?=number_format($sum,0,',',' ')?> руб<br/>
											Скидка: <?=number_format($sale,0,',',' ')?> руб<br/>
											<?/* ?>Доставка: <?if($deliveryprice==0):?>БЕСПЛАТНО<?else:?><?=number_format($deliveryprice,0,',',' ')?><?endif?><br/><br/><?*/?>
											<b>Общая сумма заказа:  <?=number_format($sum+$deliveryprice,0,',',' ')?> руб</b>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td style="font-size: 20px;padding-bottom: 15px;padding-top: 20px;">Также вас могут заинтересовать:</td>
						</tr>
						<tr>
							<td style="padding-bottom: 20px;">
								<table cellpadding="0" cellspacing="0">
									<tr>
									<?foreach($hits as $i=>$item):?>
										<?if($i<3):?>
											<td style="vertical-align: top;padding-right: 15px;">
												<a href="http://<?=$_SERVER['HTTP_HOST']?><?=$item['path']?>"><img src="http://<?=$_SERVER['HTTP_HOST']?>/of/2<?=$item['pics'][0]['path']?>" /></a><br/>
												<a style="color: #2389ff" href="http://<?=$_SERVER['HTTP_HOST']?><?=$item['path']?>"><?=$item['name']?></a><br/>
												<?=number_format($item['price'],0,'',' ')?> руб.
											</td>
										<?endif?>
									<?endforeach?>
									</tr>
								</table>
							</td>
						</tr>
						<?/*?>
						<tr>
							<td style="background: url(http://<?=$_SERVER['HTTP_HOST']?>/i/mail-bot-bg.jpg) no-repeat;height: 92px;text-align: center">
								<a href="http://<?=$_SERVER['HTTP_HOST']?>"><img src="http://<?=$_SERVER['HTTP_HOST']?>/i/mail-but.jpg" /></a><br/>
								<b>Подпишитесь на нашу рассылку и оставайтесь в курсе всех акций и новинок!</b>
							</td>
						</tr>
						<?*/?>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td style="color: #000000;font-size: 20px;text-align: center;padding-top: 7px;padding-bottom: 7px;">
		Cпасибо за покупку!
	</td>
</tr>