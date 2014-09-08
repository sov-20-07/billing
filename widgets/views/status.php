<?if($status=='new'):?>
	<div class="stat width arrows">
		<span class="top">В обработке</span>
	</div>
<?elseif($status=='confirm'):?>
	<div class="stat width hand">
		<span class="top">Принят</span>
		<?if(Funcs::$uri[0]!='manager'):?>
			<a href="javascript:;" class="bot add_to_basket" ids="<?=$tree?>" num="1">в корзину</a>
		<?endif?>
	</div>
<?elseif($status=='cancel'):?>
	<div class="stat width cross">
		<span class="top">Аннулирован</span>
		<?if($what=='tree'):?>
			<a href="/popup/rejected/?id=<?=$tree?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" class="bot">причина</a>
		<?endif?>
	</div>
<?elseif($status=='print'):?>
	<div class="stat width print">
		<span class="top">В печати</span>
		<span class="bot">отправлен <?=date('d.m.Y',strtotime($pdate))?></span>
	</div>
<?elseif($status=='delivery'):?>
	<div class="stat width car">
		<span class="top">В доставке</span>
		<span class="bot">отправлен <?=date('d.m.Y',strtotime($ddate))?></span>
	</div>
<?elseif($status=='done'):?>
	<div class="stat width ok">
		<span class="top">Исполнен</span>
		<span class="bot"><?=date('d.m.Y',strtotime($fdate))?></span>
	</div>
<?endif?>
<?if($statusdop=='salereq'):?>
	<div class="stat width clock">
		<span class="top">Ожидает выставления на продажу</span>
		<span class="bot">Цена: <?=$supprice?> руб.</span>
	</div>
<?endif?>
<?if($statusdop=='sale'):?>
	<div class="stat width basket">
		<span class="top">Продается</span>
		<span class="bot">Ваша комиссия: <?=$supprice?> р.<br /><a href="/popup/askprice/?id=<?=$tree?>&redirect=/cabinet/books/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" style="top: 0;">Изменить</a></span>
	</div>
<?endif?>
<?if($statusdop=='salecancel'):?>
	<div class="stat width cross">
		<span class="top">Отказ в продаже</span>
		<?if($what=='tree'):?>
			<a href="/popup/rejected/?id=<?=$tree?>&act=tosale" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" class="bot">причина</a>
			<span class="bot">Ваша комиссия: <?=$supprice?> р.<br /><a href="/popup/askprice/?id=<?=$tree?>&redirect=/cabinet/books/" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" style="top: 0;">Повторить</a></span>
		<?endif?>
	</div>
<?endif?>