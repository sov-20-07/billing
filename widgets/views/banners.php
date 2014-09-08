<?foreach($list as $item):?>
	<div class="left-content">
	   <?=$item['description']?>
	</div>
<?endforeach?>
<?if(count($sales)>0):?>
	<h4>Цены ниже!</h4>
	<div class="left-coll-products">
		<?foreach($sales as $item): ?>
		<div class="product">
			<div class="annotation">
				<a href="<?=$item['path']?>" class="sm-pic" style="background: url('/of/1<?=$item['pics'][0]['path']?>')"></a>
				<div class="text">
					<a href="<?=$item['path']?>"><?=$item['name']?></a><br/>
					<span class="old-price"><?=number_format($item['oldprice'],0,'',' ')?> Р</span><br/>
					<span class="price rub14"><?=number_format($item['price'],0,'',' ')?> </span>
				</div>
			</div>
			<div class="hover">
				<div class="buttons">
					<div class="compare to-click add_to_compare" ids="<?=$item['id']?>"></div>
					<div class="in-basket to-click add_to_basket" path="popup" num="1" ids="<?=$item['id']?>"></div>
				</div>
			</div>
		</div>
		<?endforeach?>
	</div>
<?endif?>