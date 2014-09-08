<?if($name):?>
	<div class="product sm">
		<div class="annotation">
			<a class="pic" href="<?=$path?>" style="background-image: url('/of/1<?=$pics[0]['path']?>')"></a>
			<a href="<?=$path?>" class="name"><?=$name?></a><br/>
			<span class="price">
				<?=$price?><span class="rub">a</span><br/>
				<?if($sale>0):?><span class="sale">скидка <?=$sale?> <span class="rub">a</span></span><?endif?>
			</span>
		</div>
		<div class="hover">
			<div class="buttons">
				<span class="stars st<?=$rating?>"></span><a href="<?=$path?>#comment">Отзывы</a><span>(<?=$report?>)</span>
				<?if($available==1):?><span class="buy-sm-but add_to_basket" path="action" ids="<?=$tree?>" num="1"></span><?endif?>
			</div>
		</div>
	</div>
<?endif?>