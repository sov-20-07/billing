<ul class="neworder_list" <?if ($depth<3):?>style="display:block"<?endif?>>
<?foreach ($catalog as $item):?>
	<li class="neworder_item">
		<div class="neworder_header <?if ($depth<2):?>neworder_header_opened<?endif?>">
			<?	
				if($item['model']) {
					$price = $count = 0;
					foreach((array)$item['sub'] as $item2) {
						$price += $item2['fields']['basicDealerPriceUSD'] * intval($goods[$item2['tree_id']]['count']);
						$count += intval($goods[$item2['tree_id']]['count']);
					}
				} else {
					$price = $count = null;
				}
			?>
			<span class="neworder_header_text" style="margin-left: <?=$item['depth']*20?>px;"><?=$item['name']?>&nbsp;
				<?if(!is_null($count) && !is_null($price)):?>
					(<?=$count?>/<?=$price?>)
				<?endif?>
			</span>
		</div>
		<?if($item['model']):?>
			<ul class="neworder_list">
				<li class="neworder_item">
				<pre><?//print_r($item)?></pre>
			<table class="account_history-table">
				<tr>
					<th>Артикул</th>
					<th>Наименование</th>
					<th>Цвет</th>
					<th>Размер</th>
					<th>Цена</th>
					<th>Количество</th>
					<th>Наличие</th>
					<th>Сумма</th>
				</tr>
				<?foreach((array)$item['sub'] as $item2):?>
					<tr>
						<td><?=$item2['fields']['value']?></td>
						<td><?=$item['name']?></td>
						<td><?=$item['color']?></td>
						<td><?=$item2['name']?></td>
						<td>
							<?=$item2['fields']['basicDealerPriceUSD']?> $
							<input type="text" value="<?=$item2['fields']['basicDealerPriceUSD']?>" class="widget_quantity_input" name="prices[<?=$item2['tree_id']?>]">
						</td>
						<td>
							<div class="widget_quantity">
								<input type="text" value="<?=intval($goods[$item2['tree_id']]['count'])?>" class="widget_quantity_input" name="items[<?=$item2['tree_id']?>]">
							</div>
						</td>
						<td></td>
						<td><?=number_format($item2['fields']['basicDealerPriceUSD']*$goods[$item2['tree_id']]['count'],2,',',' ')?>$</td>
					</tr>			
				<?endforeach?>
			</table>
			</li></ul>
		<?else:?>
			<?if (isset($item['sub']) && !$item['model']):?>
				<?=View::getPluginEmpty('orders/editbranch',array('catalog' => $item['sub'],'goods'=>$goods,'depth'=>$depth+1))?>
			<?endif?>		
		<?endif?>
	</li>
	<?/*
	<ul class="neworder_list">
		<li class="neworder_header">
			<span class="neworder_header_text" style="margin-left: 0">Men's Jackets (3)</span>
		</li>
		
		
		<li class="neworder_item">
			<table class="account_history-table">
				<tr>
					<th>Артикул</th>
					<th>Наименование</th>
					<th>Цвет</th>
					<th>Размер</th>
					<th>Цена</th>
					<th>Количество</th>
					<th>Наличие</th>
					<th>Сумма</th>
				</tr>
				<tr>
					<td>20262-2011</td>
					<td><a href="#">Jkt, Rekon (13) Blk/Red SM</a></td>
					<td class="colors_inline">
						<span class="color_mini" style="background: red;"></span>
						<span class="color_mini" style="background: brown;"></span>
					</td>
					<td>SM</td>
					<td>400&nbsp;$</td>
					<td>
						<div class="widget_quantity">
							<span class="widget_quantity_button">-</span><input type="text" maxlength="2" value="4" class="widget_quantity_input"><span class="widget_quantity_button">+</span>
						</div>
					</td>
					<td>В&nbsp;наличии</td>
					<td>1&nbsp;600&nbsp;$</td>
				</tr>
				<tr>
					<td>20262-2011</td>
					<td><a href="#">Jkt, Rekon (13) Blk/Red SM</a></td>
					<td class="colors_inline">
						<span class="color_mini" style="background: red;"></span>
						<span class="color_mini" style="background: brown;"></span>
					</td>
					<td>SM</td>
					<td>400&nbsp;$</td>
					<td>
						<div class="widget_quantity">
							<span class="widget_quantity_button">-</span><input type="text" maxlength="2" value="4" class="widget_quantity_input"><span class="widget_quantity_button">+</span>
						</div>
					</td>
					<td>В&nbsp;наличии</td>
					<td>1&nbsp;600&nbsp;$</td>
				</tr>
			</table>
		</li>
	</ul>
	*/?>

<?endforeach?>
</ul>