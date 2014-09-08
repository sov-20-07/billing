<? 
	$orderData = Orders::getOrderById($id);
	$maxPrice = -1;
	$maxPriceArr = Array();
	for($ii = 0; $ii<count($orderData["items"]); $ii++)
	{
		if($maxPrice < $orderData["items"][$ii]["price"])
		{
			$maxPrice = $orderData["items"][$ii]["price"];
			$maxPriceArr = $orderData["items"][$ii];
		}
	}

	/* 
<tr>
	<td style="background: #fff;padding: 25px;">
		<table cellpadding="0" cellspacing="0" >
			<tr>
				<td>
					<p style="font-size: 13pt; font-family: Arial, sans-serif;">
						Здравствуйте, <?=$row["name"];?>!<br />
						Некоторое время назад Вы оформляли у нас заказ на <b><?=$maxPriceArr["name"]?></b>. Большое спасибо за Ваш заказ!
						 Будем благодарны, если Вы напишите о Ваших впечатлениях о покупке у нас на странице нашего магазина.
						С уважением, команда DVR-Group.ru<br/>
						<br />
					</p>
					<table style="display: table; width: 100%; height: 43px; text-align: center;">
						<tr>
						 	<td>&nbsp;</td>
							<td style="background: #0d4e91; background: -moz-linear-gradient(top, #0d9eec, #073d84);background: -webkit-linear-gradient(top, #0d9eec, #073d84);background: -o-linear-gradient(top, #0d9eec, #073d84); background: -ms-linear-gradient(top, #0d9eec, #073d84); background: linear-gradient(top, #0d9eec, #073d84);width: 130px;height: 43px;border-radius: 4px;text-decoration: none;vertical-align: middle;text-align: center;">
								<a style="text-decoration: none;  color: #FFFFFF; font-family: Tahoma, sans-serif; font-size: 12px; font-weight: bold;" href="<?=$row["yaopinions"];?>">Оставить отзыв</a>
							</td>
							<td>&nbsp;</td>
							</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>*/
?>

<tr>
	<td style="background: #fff;padding: 0px 25px 25px 25px;">
		<table cellpadding="0" cellspacing="0" >
			<tr>
				<td>
					<p style="font-size: 13pt; font-family: Arial, sans-serif;">
						 Здравствуйте, <?=$row["name"];?>!<br />
						<br/>
						Меня зовут Екатерина. Я менеджер магазина DVR-Group.ru, в котором Вы покупали товар <b><?=$maxPriceArr["name"]?></b>.<br/>
						<br/>
						Большое спасибо за Ваш заказ! Будем благодарны, если напишите Ваши впечатления о покупке в нашем магазина.<br/>
						<br/>
						Кроме того, каждому оставившему отзыв, мы дарим <span style="font-weight: bold; color: #052247;">200 рублей</span> на счет мобильного телефона. Для того, чтобы из получить нужно:<br/>
						- перейти по ссылке "Оставить отзыв" в этом письме ниже.<br/>
						 - оставить отзыв, указав своей имя в конце отзыва.<br/>
						 - прислать на на почту <a href="mailto:shop@dvr-group.ru">shop@dvr-group.ru</a> письмо с пометкой "отзыв". В нем напишите свое имя и номер мобильного телефона, на который нужно перевести 200 рублей.<br/>
						<br/>
						С уважением, команда DVR-Group.ru<br/>
						<br/>
					</p>
					<table style="display: table; width: 100%; height: 43px; text-align: center;">
						<tr>
						 	<td>&nbsp;</td>
							<td style="background: #0d4e91; background: -moz-linear-gradient(top, #0d9eec, #073d84);background: -webkit-linear-gradient(top, #0d9eec, #073d84);background: -o-linear-gradient(top, #0d9eec, #073d84); background: -ms-linear-gradient(top, #0d9eec, #073d84); background: linear-gradient(top, #0d9eec, #073d84);width: 130px;height: 43px;border-radius: 4px;text-decoration: none;vertical-align: middle;text-align: center;">
								<a style="text-decoration: none;  color: #FFFFFF; font-family: Tahoma, sans-serif; font-size: 12px; font-weight: bold;" href="http://<?=$_SERVER['HTTP_HOST']?>/orders/yandex/<?=$row["yaopinions"];?>/">Оставить отзыв</a>
							</td>
							<td>&nbsp;</td>
							</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>