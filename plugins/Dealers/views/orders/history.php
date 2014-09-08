					<table>
						<tr>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Дата</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Действие</span>
								</div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell" style="white-space:nowrap;">
									<?$date = DateTime::createFromFormat('Y-m-d H:i:s', $item['cdate'])?>
									<?=$date->format('d.m.Y H:i:s');?>
								</td>
								<td class="sections_table_cell" style="white-space:nowrap;">
									<?if(!is_null($item['old_status'])):?>Смена статуса <?=$item['old_status']?>&nbsp;&rarr;&nbsp;<?endif?><?=$item['new_status']?>
								</td>
							</tr>
						<?endforeach?>
					</table>
