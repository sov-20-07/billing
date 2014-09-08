<div class="top_block fixed_width">
	<div id="navigation">
		<span class="icon right_arrow"></span><a href="/" class="icon ic_home" title="На главную"></a><span class="icon right_arrow"></span>Ваш кабинет
	</div>
</div>
<div class="content fixed_width"><div class="padds10"><div class="inline_block">
	<div id="left_part"><div class="inline_block"><div class="padds10">
		<?MenuWidget::CabinetMenu()?>
	</div></div></div>
	<div id="right_part"><div class="padds020"><div class="inline_block">
		<h1>История заказов</h1>
		<table class="default cabinet_history">
			<col width="75"><col width="140"><col width="170"><col><col width="150">
			<tr>
				<th><b>№</b></th>
				<th>Дата</th>
				<th>Сумма</th>
				<th>Адрес</th>
				<th>Статус</th>
			</tr>
		</table>
		<?foreach($list as $i=>$item):?>
			<div class="order_block">
				<table class="default cabinet_history">
					<col width="75"><col width="145"><col width="170"><col><col width="150">
					<tr>
						<td><span class="pseudo p_num sliding" id="detailing_block<?=$i?>"><?=str_repeat('0',6-strlen($item['id'])).$item['id']?></span></td>
						<td>
							<?=date("d.m.Y H:i",strtotime($item['cdate']))?>
						</td>
						<td>
							<span class="rur14_normal"><?=number_format($item['price'],0,'',' ')?></span><br />
							<span class="rur12_gray">+<?=number_format($item['deliveryprice'],0,'',' ')?></span> (доставка)
						</td>
						<td><?=$item['address']?></td>
						<td>
							<?if($item['status']=='new'):?>
								<span class="is_dark">в обработке</span>
							<?elseif($item['status']=='work'):?>
								<span class="is_dark">в доставке</span><br />
								с <?=date("d.m.Y H:i",strtotime($item['wdate']))?>
							<?elseif($item['status']=='done'):?>
								<span class="is_dark">доставлен</span><br />
								<?=date("d.m.Y H:i",strtotime($item['fdate']))?>
							<?else:?>
								<span class="is_dark">отменен</span><br />
								<?=date("d.m.Y H:i",strtotime($item['fdate']))?>
							<?endif?>
						</td>
					</tr>
				</table>
				<div class="order_detailed sliding_detailing_block<?=$i?>">
					<table class="default cabinet_history basket">
						<col><col width="125"><col width="100"><col width="115"><col width="105"><col width="165">
						<tr><th>Описание</th><th>Опции</th><th>Стоимость</th><th>Количество</th><th>Сумма</th><th></th></tr>
						<?foreach($item['items'] as $ii=>$goods):?>
							<tr>
								<td <?if(count($goods['options'])>1):?>rowspan="2"<?endif?>>
									<?if($goods['path']):?>
										<a href="<?=$goods['path']?>" class="font_13"><?=$goods['name']?></a><br />
										<?/*?><b>Артикул:</b> #<?=$goods['art']?><?*/?>
									<?else:?>
										<span class="font_13"><?=$goods['name']?></span>
									<?endif?>
								</td>
								<td>
									<?if(count($goods['options'])>1):?>
										<span class="icon down_arrow_red auto_icon sliding" id="block<?=$ii+1?>"><span class="pseudo">Развернуть<br />список</span></span>
									<?else:?>
										<b>Размер:</b> <?=$goods['options'][0][0]?><br />
										<b>Цвет:</b> <?=$goods['options'][0][1]?>
									<?endif?>
								</td>
								<td><span class="rur14_normal"><?=number_format($goods['price'],0,'',' ')?></span></td>
								<td><span class="font_14"><?=$goods['num']?></span></td>
								<td><b class="rur14"><?=number_format($goods['price']*$goods['num'],0,'',' ')?></b></td>
								<td>
									<?if($goods['path']):?>
										<span class="icon ic_add_to_basket auto_icon" onclick="$('#popup_basket').attr('src','/popup/atb/?id=<?=$goods['tree']?>')"><span class="pseudo is_dark">в корзину</span></span></td>
									<?else:?>
										Нет в наличии
									<?endif?>
							</tr>
							<?if(count($goods['options'])>1):?>
								<tr class="add_options">
									<td colspan="5">
										<div class="add_options_block sliding_block<?=$ii+1?>">
											<table class="default basket">
												<col width="125"><col width="100"><col width="115"><col width="105"><col width="165">
												<?foreach($goods['options'] as $opts):?>
													<tr>
														<td>
															<b>Размер:</b> <?=$opts[0]?><br />
															<b>Цвет:</b> <?=$opts[1]?>
														</td>
														<td><span class="rur14_normal"><?=$goods['price']?></span></td>
														<td><span class="font_14"><?=$opts[2]?></span></td>
														<td><span class="rur14_normal"><?=number_format($opts[2]*$goods['price'],0,'',' ')?></span></td>
														<td>
															<?if($goods['path']):?>
																<span class="icon ic_add_to_basket auto_icon" onclick="$('#popup_basket').attr('src','/popup/atb/?id=<?=$goods['tree']?>')"><span class="pseudo is_dark">в корзину</span></span>
															<?else:?>
																Нет в наличии
															<?endif?>
														</td>
													</tr>
												<?endforeach?>
											</table>
										</div>
									</td>
								</tr>
							<?endif?>
						<?endforeach?>
					</table>
				</div>
			<?endforeach?>
		</div>
	</div></div></div>
</div></div></div>