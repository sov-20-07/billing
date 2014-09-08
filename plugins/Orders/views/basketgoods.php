<?if(count($items)>0):?>
	<table class="plugin_orders_table_goods">
		<tr><th>№</th><th></th><th>Название</th><th>Цвет</th><th>Размер</th><th>Кол-во</th><th>Цена</th><th></th></tr>
		<?foreach($items as $goods):?>
			<tr>
				<td><?=$goods['id']?></td>
				<td class="plugin_orders_table_img"><img src="/of/<?=$goods['pics'][0]['path']?>?w=50&h=50" alt="<?=$goods['name']?>"></td>
				<td><?=$goods['name']?></td>
				<td><?=$goods['color']?></td>
				<td>
					<select class="jsNewSelectStyled" id="size_<?=$goods['id']?>" onchange="$('#price_<?=$goods['id']?>').text($(this).closest('.cusel').find('.cuselActive').attr('price'));">
						<?foreach($goods['sizes'] as $item):?>
							<option value="<?=$item['id']?>" price="<?=$item['baseRetailPriceRUR']?>"><?=$item['name']?></option>
						<?endforeach?>
					</select>
				</td>
				<td><input class="input_text" type="text" value="1" size="5" id="num_<?=$goods['id']?>" /></td>
				<td><span id="price_<?=$goods['id']?>"><?=$goods['sizes'][0]['baseRetailPriceRUR']?></span> руб.</td>
				<td style="text-align: center;"><span class="button-white" onclick="go(<?=$goods['id']?>)">добавить</span></td>
			</tr>
		<?endforeach?>
	</table>
	<script>
		function go(tree){
			var num=document.getElementById('num_'+tree).value;
			var size=$('#size_'+tree+'').val();
			var str="/<?=Funcs::$cdir?>/orders/basketadd/?id=<?=$_POST['id']?>&num="+num+"&tree="+tree+"&size="+size;
			document.location.href=str;
		}
		
		$(document).ready( function(){
			cuSel({
				changedEl: ".jsNewSelectStyled",
				visRows: 5,
				scrollArrows: true
			});
		});
	</script>
<?endif?>