									<tbody id="body<?=$item['tree_id']?>" style="display:none">
									<?foreach($data as $item2):?>
										<?if(is_null($item2['price'])):?>
											<tr>
												<td colspan="9"><span class="tab">&nbsp;&nbsp;&nbsp;&nbsp;</span><?=$item2['name']?></td>
											</tr>
										<?else:?>
											<tr>
												<td><?=$item2['art']?></td>
												<td><?=$item2['name']?></td>
												<td></td>
												<td><?=$item2['size']?></td>
												<td><?=$item2['price']?></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										<?endif?>												
									<?endforeach?>
									</tbody>
