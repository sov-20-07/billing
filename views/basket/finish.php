<div id="content">
	<?CrumbsWidget::run()?>
	<div class="basket">
		<div class="left-coll">
			<div class="steps">
				<h1>Ваш заказ принят</h1>
				<span class="print"><a href="?print" target="_blank">Версия для печати</a></span>
				<b class="is_dark">Номер заказа: <?=str_repeat('0',6-strlen($id)).$id?></b><br/>
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
						<thead><th></th><th>Описание</th><th>Цена</th><th>Количество</th><th>Скидка</th><th>Стоимость</th></thead>
						<?foreach($goods as $item):?>
							<tr>
								<td>
									<a href="<?=$item['path']?>"><img src="/of/1<?=$item['pics'][0]['path']?>"></a>
									<?/*?><?=trim($item['art'])==''?str_repeat('0',6-strlen($item['tree'])).$item['tree']:$item['art']?><?*/?>
								</td>
								<td><a href="<?=$item['path']?>"><?=$item['name']?></a></td>
								<td nowrap><b><?=number_format($item['price'],0,',',' ')?><span class="rub">a</span></b></td>
								<td nowrap><?=$item['num']?></td>
								<td nowrap><b><?=number_format($item['sale'],0,',',' ')?><span class="rub">a</span></b></td>
								<td nowrap><b><?=number_format($item['total'],0,',',' ')?><span class="rub">a</span></b></td>
							</tr>
						<?endforeach?>
					</table>
					<div class="left">
						Сумма без скидки: <?=number_format($sum+$sale,0,',',' ')?><span class="rub">a</span><br/>
						Скидка: <?=number_format($sale,0,',',' ')?><span class="rub">a</span><br/>
						Сумма к оплате без учета доставки: <?=number_format($sum,0,',',' ')?><span class="rub">a</span><br/>
						<b>Сумма к оплате: <?=number_format($sum+$deliveryprice,0,',',' ')?><span class="rub">a</span></b><br/>
						<a href="/catalog/" class="continue-shopping in-block"></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-29582884-1']);

_gaq.push(['_setDomainName', 'dvr-group.ru']);
_gaq.push(['_setAllowHash', false]);

_gaq.push(['_addOrganic', 'images.yandex.ru', 'q',true]);
_gaq.push(['_addOrganic', 'blogsearch.google.ru', 'q',true]);
_gaq.push(['_addOrganic', 'blogs.yandex.ru', 'text',true]);
_gaq.push(['_addOrganic', 'go.mail.ru', 'q']);
_gaq.push(['_addOrganic', 'nova.rambler.ru', 'query']);
_gaq.push(['_addOrganic', 'webalta.ru', 'q']);
_gaq.push(['_addOrganic', 'aport.ru', 'r']);
_gaq.push(['_addOrganic', 'poisk.ru', 'text']);
_gaq.push(['_addOrganic', 'km.ru', 'sq']);
_gaq.push(['_addOrganic', 'liveinternet.ru', 'ask']);
_gaq.push(['_addOrganic', 'quintura.ru', 'request']);
_gaq.push(['_addOrganic', 'search.qip.ru', 'query']);
_gaq.push(['_addOrganic', 'gde.ru', 'keywords']);
_gaq.push(['_addOrganic', 'gogo.ru', 'q']);
_gaq.push(['_addOrganic', 'ru.yahoo.com', 'p']);
_gaq.push(['_addOrganic', 'akavita.by', 'z']);
_gaq.push(['_addOrganic', 'tut.by', 'query']);
_gaq.push(['_addOrganic', 'all.by', 'query']);
_gaq.push(['_addOrganic', 'meta.ua', 'q']);
_gaq.push(['_addOrganic', 'bigmir.net', 'q']);
_gaq.push(['_addOrganic', 'i.ua', 'q']);
_gaq.push(['_addOrganic', 'online.ua', 'q']);
_gaq.push(['_addOrganic', 'a.ua', 's']);
_gaq.push(['_addOrganic', 'ukr.net', 'search_query']);
_gaq.push(['_addOrganic', 'search.com.ua', 'q']);
_gaq.push(['_addOrganic', 'search.ua', 'query']);
_gaq.push(['_addOrganic', 'search.ukr.net', 'search_query']);
_gaq.push(['_trackPageLoadTime']);


var refString = document.referrer;
var curString = document.location.host;
if (curString.substr(0,4)=="www.") {curString=curString.substring(4,curString.length)};
if ((refString.substr(7,25)== "yandex.ru/yandsearch?text")||(refString.substr(7,25)== "yandex.ru/yandsearch?clid") || ((refString.substr(7,22)== "yandex.ru/msearch?text")))
{_gaq.push(['_setCustomVar', 2, 'SearchPage',1,1]);} else
if (refString.match("yandex\.ru\/.*search.*p=")) {
_gaq.push(['_setCustomVar', 2, 'SearchPage',parseInt(refString.substr(refString.lastIndexOf("p=")+2,2))+1,1])} else
if (refString.match("google.*cd"))
{ var testvar= parseInt(refString.substr(refString.lastIndexOf("&cd=")+4,3));
_gaq.push(['_setCustomVar', 2, 'SearchPage',(testvar-testvar%10)/10+1,1]);
}else
if (!refString.match(curString))
{_gaq.push(['_setCustomVar', 2, 'SearchPage','none',1]);} else {};

if (refString.substr(7,16)== "market.yandex.ru")
_gaq.push(['_setCustomVar', 3, 'URL', refString, 2]);
 

_gaq.push(['_addTrans',
			'<?=$id?>',   
			'',
			'<?=$sum?>',        
			'0',
			'0',
			'Moscow',
			'Moskovskaya oblast',
			'Russia'
			]);
	<?foreach($goods as $i=>$item):?>

	_gaq.push(['_addItem',              
		'<?=$id?>',  
		'<?=$item['tree']?>',         
		'<?=$item['name']?>',  
		'<?=$item['name']?>',                  
		'<?=$item['price']?>',                                      
		'<?=$item['num']?>'                                          
		]); 
	
	<?endforeach?>
	
	_gaq.push(['_trackTrans']);


 
_gaq.push(['_trackPageview']);


(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

setTimeout('_gaq.push([\'_trackEvent\', \'NoBounce\', \'Over 15 seconds\'])',15000);
</script>


<?/* ?>
<div class="fixed_width">
	<div id="navigation">Оформление заказа</div>
	<div class="basket">
		<h1>Ваш заказ принят</h1>
		<b class="is_dark">Номер заказа: <?=str_repeat('0',6-strlen($id)).$id?></b>
		<p class="order_info">
			После обработки с Вами свяжется менеджер магазина для уточнения статуса заказа.<br />
			Также будет отправлено письмо на указанный Вами адрес электронной почты.
		</p>
		<b class="is_dark">Параметры заказа:</b>
		<table class="default short_info">
			<col width="50%"><col width="50%">
			<tr>
				<td>
					<b>Получатель:</b><br />
					<?=$name?>
				</td>
				<td>
					<b>Адрес:</b><br />
					<?=$address?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Email:</b><br />
					<?=$email?>
				</td>
				<td>
					<b>Телефонный номер:</b><br />
					<?=$phone?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Способ оплаты:</b><br />
					<?=$payment?>
				</td>
				<td>
					<b>Способ доставки:</b><br />
					<?=$delivery?> (<?if($deliveryprice==0):?>бесплатно<?else:?><?=$deliveryprice?> руб.<?endif?>
				</td>
			</tr>
		</table>
		<b class="is_dark b_padd">Состав заказа:</b>
		<table class="default mini_t">
			<col width="1"><col><col width="110"><col width="100"><col width="75">
			<tr><th colspan="2">Описание</th><th>Цена</th><th>Количество</th><th>Сумма</th></tr>
			<?foreach($goods as $item):?>
				<tr>
					<td><img src="/of/1<?=$item['files_gal'][0]['path']?>" alt="<?=$item['file_gal'][0]['anme']?>" /></td>
					<td class="good_descr">
						<a href="<?=$item['path']?>"><b><?=$item['name']?></b></a><br />
						Код товара: <?=str_repeat('0',5-strlen($item['tree']))?><?=$item['tree']?>
					</td>
					<td><span class="rur12"><?=number_format($item['price'],0,',',' ')?></span></td>
					<td><?=$item['num']?></td>
					<td><span class="rur12_bold"><?=number_format($item['total'],0,',',' ')?></span></td>
				</tr>
			<?endforeach?>
		</table>
		<div class="total_info">Общая сумма заказа без учета доставки: <span class="rur12_bold"><?=number_format($sum,0,',',' ')?></span></div>
		Доставка: <?if($deliveryprice==0):?>бесплатно<?else:?><?=number_format($deliveryprice,0,',',' ')?><?endif?><br />
		<b class="is_black">Общая сумма заказа: <?=number_format($sum+$deliveryprice,0,',',' ')?> руб.</b>
		Спасибо за покупку!
		<div class="back_padd"><a href="/catalog/" class="back_to">Продолжить покупки</a></div>
	</div>
</div>
<?*/?>