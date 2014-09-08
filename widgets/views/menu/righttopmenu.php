<div class="float_block right_block">
	<div class="menu2">
		<div class="menu_item first_b">Популярные бренды</div>
		<?foreach($vendors as $item):?>
			<div class="menu_item"><a href="/catalog/?ve[<?=$item['id']?>]=<?=$item['id']?>"><?=$item['name']?></a></div>
		<?endforeach?>
	</div>
	<div class="selected_good">
		<table class="default catalog">
			<tr>
				<td>
					<div class="good_block"><div class="good_over"><div class="good_padds">
						<a href="<?=$goods['path']?>" class="good_img is_black">
							<div style="background: #fff url( '/of/2<?=$goods['files_gal'][0]['path']?>' ) no-repeat center;"></div>
							<span class="name_grad"><ins><?=$goods['name']?></ins><span class="grad"></span></span>
						</a>
						<div class="article">Артикул №<?=$goods['art']?></div>
						<a href="#" class="reviews_link">Отзывы (<?=$goods['report']?>)</a>
						<span class="stars s<?=$goods['rating']?>"></span>
						<div class="inline_block">
							<b class="price"><?=number_format($goods['price'],0,'',' ')?> руб.</b>
							<span class="is_button popup_atb add_to_basket" ids="<?=$goods['tree']?>" num="1" onclick="$('#atbframe').attr('src','/popup/atb/?id=<?=$goods['tree']?>')">Купить</span>
						</div>
					</div></div></div>
				</td>
			</tr>
		</table>
	</div>
</div>