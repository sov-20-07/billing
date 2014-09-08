<?if($flag_delivery==1):?>
	<script>
		function makeb2clink(what,deliveryprice,sdp){
			$('#deliveryprice').val(deliveryprice);
			if(sdp)setDeliveryPrice();
			var b2clink="/<?=Funcs::$cdir?>/orders/getdeliveryb2c/?id=<?=$id?>&type=";
			var type='';
			if(what=='Курьерская доставка'){
				type='курьер';
			}else if(what=='пвз'){
				type='пвз';
			}
			$('#b2clink').attr('href',b2clink+type+"&deliveryprice="+deliveryprice);
		}
	</script>
	<?foreach($delivery_ways as $key=>$item):?>
		<label>
			<input name="deliveryoptions" type="radio" onclick="makeb2clink('<?=$item['Наименование']?>',<?=$item['Стоимость']?>,true)" <?=$item['checked']?> value="B2C <?=$item['Наименование']?>" /> <?=$item['Наименование']?><br />
			<span>
				<?if($item['Стоимость']):?>Стоимость: <?=$item['Стоимость']?><br /><?endif?>
				<?if($item['Расположение']):?>Расположение: <?=$item['Расположение']?><br /><?endif?>
				<?if($item['Адрес']):?>Адрес: <?=$item['Адрес']?><br /><?endif?>
				<?if($item['Время работы']):?>Время работы: <?=$item['Время работы']?><br /><?endif?>
			</span>
			<?if($item['checked']):?><script>makeb2clink('<?=$item['Наименование']?>',<?=$item['Стоимость']?>,false);</script><?endif?>
		</label>
	<?endforeach?>
	<br /><a id="b2clink" href="" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 780, height: 450,contentId: 'highslide-html', cacheAjax: false } ); return false;">Сформировать запрос</a>
<?else:?>
	Неправильно набран индекс или доставка в Ваш регион невозможна
<?endif?>