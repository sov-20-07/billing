<div class="basket <?if(count($goods)==0):?>empty<?endif?>">
	<div class="open-basket-list">
	<?if(count($goods)==0):?>
		<span class="none">Корзина пуста</span>
	<?else:?>
		<span class="full">Ваша корзина</span>
	<?endif?>
	</div>
	<?if(count($goods)!=0):?>
		<span class="full-text">
			<? //<a href="/basket/">оформить заказ</a><br/>
			?>
			<a href="/basket/">товаров в корзине: <span><?=count($goods)?></span></a>
		</span>
	<?else:?>
		<span class="none-text">Космическия обезьяна<br/> недовольна пустой<br/> корзиной!</span>
	<?endif?>
	<?if(count($goods)!=0):?>
	<div class="basket-list">
		<div class="scroll-product">
			<div class="grad"></div>
			<div id="mcs2_container">
				<div class="customScrollBox">
					<div class="container">
						<div class="content">
							<ul class="basket-product-list">
							<?foreach($goods as $item):?>
								<li style="background: #fff">
									<a href="<?=$item['path']?>"><?=$item['name']?></a>
									<span class="price"><?=number_format($item['price'],0,',',' ')?><span class="rub">a</span></span>
								</li>
							<?endforeach?>
							</ul>
						</div>
					</div>
					<div class="dragger_container">
						<div class="dragger"></div>
					</div>
				</div>
			</div>
		</div>
		<a class="checkout-sm-but" href="/basket/purchase/"></a>
	</div>
	<?endif?>
</div>
<script>
$(document).ready(function(){
    $('.basket .open-basket-list').click(function(evt){
        evt.stopPropagation();
        openBasket();
    });
    $('.basket .basket-list').click(function(evt){
        evt.stopPropagation();
    });
    $('.in-basket-but,.buy-sm-but ').click(function(evt){
        evt.stopPropagation();
    })
    $("#mcs2_container").mCustomScrollbar("vertical",0,"easeOutCirc",1.05,"auto","yes");
});
</script>
<?/* ?>
<div class="basket-block">
	<a href="/basket/"><div class="icon-basket <?if($count>0):?>complete<?endif?>"></div></a>
	<div class="product-block">
		<?if($count>0):?>
			<?$i=0?>
			<?foreach($goods as $item):?>
				<?if($i<3):?>
					<div class="pr" style="background-image: url('/of/5<?=$item['pics'][0]['path']?>')">
						<div class="up"></div>
					</div>
				<?endif?>
				<?$i++?>
			<?endforeach?>
		<?endif?>
		<?if($count==0 || $count==1 || $count==2):?>
			<div class="pr"><div class="up"></div></div>
		<?endif?>
		<?if($count==0 || $count==1):?>
			<div class="pr"><div class="up"></div></div>
		<?endif?>
		<?if($count==0):?>
			<div class="pr"><div class="up"></div></div>
		<?endif?>
	</div>
	<?if($count==0):?>
		<span class="empty-bas">В вашей корзине<br/>пока ничего нет</span>
	<?else:?>
		<a href="/basket/information/" class="issue to-click"></a>
	<?endif?>
	<?if($count>3):?>
		<div class="counter-product">+<?=$count-3?></div>
	<?endif?>
</div>


<div class="basket_block">
	<div class="left_block float_block"><div class="padds">
		<p><span class="ic_basket"><a href="/basket/" class="is_blue">Ваша корзина</a></span>&nbsp;<b class="font_12 is_blue">(<span id="goods"><?=$row['goods']?></span>)</b></p>
		Сумма: <span id="sum"><?=number_format($row['sum'],0,',',' ')?></span> руб.
	</div></div>
	<div class="right_block float_block"><div class="padds">
		<p><a href="/viewed/" class="is_blue">Недавно просмотренные</a></p>
		<p class="is_blue"><a href="/favorite/" class="is_blue">Отложенные товары:</a> <span id="favorite"><?if($_COOKIE['favorite']!=''):?><?=count(explode(',',$_COOKIE['favorite']))?><?else:?>0<?endif?></span></p>
	</div></div>
</div>
<?*/?>

