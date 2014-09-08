<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::ManagerMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Управления заказами</div>
		<div class="lk_dashboard">
			<div class="stat">
				Отфильтровать по статусу:
				<select class="styled" onchange="document.location.href='?status='+$(this).find('option:selected').val()">
					<option value="all">Все</option>
					<option value="new" <?if($_GET['status']=='new'):?>selected<?endif?>>В обработке</option>
					<option value="print" <?if($_GET['status']=='print'):?>selected<?endif?>>В печати</option>
					<option value="delivery" <?if($_GET['status']=='delivery'):?>selected<?endif?>>В доставке</option>
					<option value="done" <?if($_GET['status']=='done'):?>selected<?endif?>>Исполнен</option>
					<option value="cancel" <?if($_GET['status']=='cancel'):?>selected<?endif?>>Аннулирован</option>
				</select>
			</div>
			<div class="dotted_line marg15 margtop15"></div>
			<div class="inner_order">
				<table class="default active_order_list my_order">
					<tr class="head">
						<td class="number_head">Номер и дата заказа</td>
						<td class="details_head">Детали заказа</td>
						<td class="stat_head">Статус заказа</td>
						<td class="action_head">Действия</td>
					</tr>
					<?foreach($list as $item):?>
						<tr>
							<td>
								<span class="top"><?=str_repeat('0',6-strlen($item['id'])).$item['id']?></span>
								<span class="bot"><?=date('d.m.Y',strtotime($item['cdate']))?></span>
							</td>
							<td>
								<span class="top"><?=number_format($item['price'],0,'',' ')?> руб.</span>
								<?/*?>
									<span class="bot">наличный расчет курьерская доставка</span>
								<?*/?>
							</td>
							<td>
								<?StatusWidget::run($item)?>
							</td>
							<td class="last">
								<?if($item['status']!='done' && $item['status']!='cancel'):?>
									<div style="text-align: left;margin-bottom: 3px;">
										<?if($item['status']=='new'):?>
											<a href="/manager/toprint/?id=<?=$item['id']?>&redirect=/manager/orders/" onclick="return confirm('Отправить заказ в печать?')" class="is_button right_top_corner"><span></span>&nbsp;&nbsp;В печать&nbsp;&nbsp;</a>
										<?elseif($item['status']=='print'):?>
											<a href="/manager/todelivery/?id=<?=$item['id']?>&redirect=/manager/orders/" onclick="return confirm('Отправить в доставку?')" class="is_button right_top_corner"><span></span>В доставку</a>
										<?elseif($item['status']=='delivery'):?>
											<a href="/manager/todone/?id=<?=$item['id']?>&redirect=/manager/orders/" onclick="return confirm('Доставлен?')" class="is_button right_top_corner"><span></span>Доставлен</a>
										<?endif?>
										<a href="/manager/cancelorder/?id=<?=$item['id']?>&redirect=/manager/orders/" onclick="return confirm('Отклонить?')" class="is_button right_top_corner"><span></span>отклонить</a>
									</div>
								<?endif?>
								<div class="order_button">
								
									<div class="active_order_type">Состав заказа</div>
									<div class="order_box">
										<table align="center"><tr>
										<?foreach($item['goods'] as $i=>$goods):?>
											<?if($i%2==0):?></tr><tr><?endif?>
											<td>
												<a href="/cabinet/books/<?=$goods['id']?>/"><img src="/of/6<?=$goods['files_gal'][0]['path']?>" /></a>
												<div class="annotation">
													<span class="name"><?=$goods['name']?></span>
													<span><?=Funcs::$referenceId['binding'][$goods['binding']]['name']?> <?=$goods['num']?> шт.</span>
													<span><?=Funcs::$referenceId['paper'][$goods['paper']]['name']?> <?=$goods['countpage']?> шт.</span>
													<span class="price"><?=number_format($goods['price'],0,',',' ')?> руб.</span>
													<?if($goods['supprice']):?>
														<span class="price">Выплата продавцу: <?=$goods['supprice']?> руб.</span>
													<?endif?>
												</div>
											</td>
										<?endforeach?>
										</tr></table>
										<br /><br />
										<div class="bottom" style="margin-bottom: 10px;">
											<a href="/manager/orders/<?=$item['id']?>/">Подробнее &hellip;</a>
											<span class="price">Сумма:<span class="font_18"><?=number_format($item['sum'],0,',',' ')?> руб.</span><br />
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?endforeach?>
				</table>
				<?PaginationWidget::run()?>
			</div>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>