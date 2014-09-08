<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title><?=Funcs::$seo_title?></title>
		<meta name="description" content="<?=Funcs::$seo_description?>" />
		<meta name="keywords" content="<?=Funcs::$seo_keywords?>" /> 
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link href="/css/style.css" rel="stylesheet" type="text/css">
		<link href="/css/add.css" rel="stylesheet" type="text/css">
		<script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<link href="/css/jquery-ui-1.8.23.custom.css" rel="stylesheet" type="text/css" />
		<script src="/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>		
		<link href="/css/highslide.css" rel="stylesheet" type="text/css" />
		<script src="/js/highslide-full.js" type="text/javascript"></script>
		<script src="/js/jcarousellite.js"></script>
		<script src="/js/perfectpixel.js" type="text/javascript"></script>
		<script src="/js/basket.js" type="text/javascript"></script>
		<script src="/js/common.js" type="text/javascript"></script>		
		<script src="/js/application.js" type="text/javascript"></script>
		<link href="/js/AlertBox.css" rel="stylesheet" type="text/css" /> 
    	<script src="/js/AlertBox.js" type="text/javascript"></script> 
		<script type="text/javascript">
			langu="";
			hs.graphicsDir = "/js/graphics/";
			hs.outlineType = "rounded-white";
			hs.wrapperClassName = "draggable-header";
			hs.dimmingOpacity = 0.80;
			hs.align = "center";
			$(document).ready(function(){
				$(".pop_img").each(function(){
					this.parentNode.className="highslide";
					$(this.parentNode).click(function(){
						return hs.expand(this,
							{wrapperClassName: 'borderless floating-caption',
								dimmingOpacity: 0.75,
								minHeight: 1200,
								align: 'center'})
					});
	
				});
			})
		</script>
	</head>
	<body class="body" style="background: none;">
		<div class="page">
			<div class="steps">
				<h1>Номер заказа: <?=str_repeat('0',6-strlen($id)).$id?></h1>
				<span class="in-block" style="margin-bottom: 10px;">
					После обработки с Вами свяжется менеджер магазина для уточнения статуса заказа.<br/>
					Также будет отправлено письмо на указанный Вами адрес электронной почты.
				</span>
				<div class="data">
					<div class="top-block">
						<h6>Ваши данные</h6>
						<p>
							<?=$name?>, <?if($email):?><a href="mailto:<?=$email?>"><?=$email?></a><?endif?><br/>
							<?=$phone?>
						</p>
					</div>
					<div class="top-block">
						<h6>Доставка</h6>
						<p>
							<?if ($city_name=='Москва'){?><b><?=$delivery?> (<?if($deliveryprice==0):?>бесплатно<?else:?><?=$deliveryprice?> руб.<?endif?>)</b><br/><?}?>
							<?=$address?>
						</p>
					</div>
					<div class="top-block">
						<h6>Оплата</h6>
						<p><b><?=$payment?></b></p>
					</div>
					<div class="clear"></div>
					<h6 style="margin-bottom: 10px;">Ваш заказ</h6>
					<table class="basket-table">
						<thead><th>Артикул</th><th>Описание</th><th>Цена</th><th>Количество</th><th>Скидка</th><th>Стоимость</th></thead>
						<?foreach($goods as $item):?>
							<tr>
								<td><?=trim($item['art'])==''?str_repeat('0',6-strlen($item['tree'])).$item['tree']:$item['art']?></td>
								<td><a href="<?=$item['path']?>"><?=$item['name']?></a></td>
								<td nowrap><b><?=number_format($item['price'],0,',',' ')?> <span class="rub">руб.</span></b></td>
								<td nowrap><?=$item['num']?></td>
								<td nowrap><b><?=number_format($item['sale'],0,',',' ')?> <span class="rub">руб.</span></b></td>
								<td nowrap><b><?=number_format($item['total'],0,',',' ')?> <span class="rub">руб.</span></b></td>
							</tr>
						<?endforeach?>
					</table>
					<div class="left">
						Сумма без скидки: <?=number_format($sum+$sale,0,',',' ')?><span class="rub">руб.</span><br/>
						Скидка: <?=number_format($sale,0,',',' ')?><span class="rub">руб.</span><br/>
						Сумма к оплате без учета доставки: <?=number_format($sum,0,',',' ')?><span class="rub">руб.</span><br/>
						<b>Сумма к оплате: <?=number_format($sum+$deliveryprice,0,',',' ')?><span class="rub">руб.</span></b><br/>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>