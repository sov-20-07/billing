<div class="right-block-content">
	<?CrumbsWidget::run()?>
	<h1>Отложенные товары</h1>
	<div class="catalog">
	<?foreach($list as $item):?>
		<div id="tr<?=$item['tree']?>" class="product">
			<div class="annotation">
				<a class="pic" href="<?=$item['path']?>" style="background-image: url(/of/2<?=$item['pics'][0]['path']?>)"></a>
				<a href="<?=$item['path']?>"><?=$item['name']?></a><br/>
				<span class="price rub14"><?=number_format($item['price'],0,'',' ')?> </span>
			</div>
			<div class="hover">
				<div class="buttons">
					<div class="delete to-click del_from_favorite" ids="<?=$item['tree']?>"></div>
					<div class="in-basket to-click add_to_basket" path="popup" ids="<?=$item['tree']?>" num="1"></div>
				</div>
			</div>
		</div>
	<?endforeach?>
	</div>
</div>
<div class="left-block-content">
	<?BannersWidget::run()?>
</div>
<?/* ?>
<div id="content"><div class="common_padds"><div class="inline_block">
	<?CrumbsWidget::run()?>
	<div id="right_part" class="without_left"><div class="right_padds">
		<h1>Отложенные товары (<span id="h1favorite"><?=count($list)?></span>)</h1>
		<div class="basket wishlist">
			<table class="default basket_goods">
				<col width="1"><col><col width="202"><col width="212"><col width="162"><col width="21">
				<tr><th colspan="2">Описание</th><th>Цена</th><th>Наличие</th><th></th><th></th></tr>
				<?foreach($list as $item):?>
					<tr id="tr<?=$item['tree']?>">			
						<td class="good_img"><img src="/of/1<?=$item['files_gal'][0]['path']?>" width="86" height="66" /></td>
						<td><div class="good_name"><a href="<?=$item['path']?>"><?=$item['name']?></a></div></td>
						<td><?=number_format($item['price'],0,'',' ')?> руб.</td>
						<td><?if($item['available']==1):?>На складе<?else:?>Нет на складе<?endif?></td>
						<td><span class="is_button with_shadow popup_atb add_to_basket del_from_favorite" basket="yes" ids="<?=$item['tree']?>" num="1" onclick="$('#atbframe').attr('src','/popup/atb/?id=<?=$item['tree']?>')" <?if($item['available']==0):?>disabled<?endif?>>Купить</span></td>
						<td><span class="button_delete del_from_favorite" ids="<?=$item['tree']?>" title="Удалить из отложенных" onclick="return confirm('Удалить из отложенных?');" ></span></td>
					</tr>
				<?endforeach?>
			</table>
			<script>
				$(document).ready(function(){
					if($('.default.basket_goods tr').length==1){
						$('.default.basket_goods').detach();
					}
				});
			</script>
		</div>
		<div class="recommended">
			<div class="pattern_head wide"><div class="padds">Также рекомендуем</div></div>
			<div class="catalog_shifts"><table class="default catalog">
				<col width="20%"><col width="20%"><col width="20%"><col width="20%"><col width="20%">
				<tr>
				<?foreach($recommended as $item):?>
					<?=View::getRenderEmpty('catalog/listmodel',$item)?>
				<?endforeach?>
				</tr>
			</table></div>
		</div>
	</div></div>
</div></div></div>
<?*/?>