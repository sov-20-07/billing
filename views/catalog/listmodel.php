<?if($name):?>
	<div class="product">
		<div class="annotation">
			<a class="pic" href="<?=$path?>" style="background-image: url('/of/2<?=$pics[0]['path']?>')">
			<?if($akcia=='1'){?>
			<span class="akcia" title="Акция"></span>
			<?}else{?>
				<?if($new==1):?>
					<span class="new" title="Новинка"></span>
				<?elseif($hit==1):?>
					<span class="hit" title="Хит"></span>
				<?elseif($rst==1):?>
					<span class="rst" title="РСТ"></span>
				<?endif?>
			<?}?>
			</a>
			<a href="<?=$path?>" class="name"><?=$name?></a>
			<span class="price"><?=number_format($price,0,'',' ')?><span class="rub">a</span> </span>
		</div>
		<div class="hover">
			<div class="buttons">
				<span class="stars st<?=$rating?>"></span><?if($report>0){?><a href="<?=$path?>#comment">Отзывы</a><span>(<?=$report?>)</span><?}?>
				<?if($available==1):?><span class="buy-sm-but add_to_basket" path="action" ids="<?=$tree?>" num="1"></span><?endif?>
			</div>
		</div>
	</div>
<?endif?>
<?/* ?>
<td>
	<div class="good_block"><div class="good_over"><div class="good_padds">
		<a href="<?=$path?>" class="good_img is_black">
			<div style="background: url( '/of/2<?=$files_gal[0]['path']?>' ) no-repeat center;">
				<?if($oldprice>$price):?><span class="sale_ic"></span><?endif?>
			</div>
			<span class="name_grad"><ins><?=$name?></ins><span class="grad"></span></span>
		</a>
		<div class="article">Артикул №<?=$art?></div>
		<a href="<?=$item['path']?>#bkm4" class="reviews_link">Отзывы (<?=$report?>)</a>
		<span class="stars s<?=$rating?>"></span>
		<div class="inline_block">
			<b class="price"><?=number_format($price,0,'',' ')?> руб.</b>
			<?if($available):?>
				<span class="is_button popup_atb add_to_basket" ids="<?=$tree?>" num="1" onclick="$('#atbframe').attr('src','/popup/atb/?id=<?=$tree?>')">Купить</span>
			<?else:?>
				<span class="unavailable">Нет на складе</span>
			<?endif?>
		</div>
	</div></div></div>
</td>
<?*/?>