<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::ManagerMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1">Главная</div>
		<div class="lk_dashboard">
			<table class="default designer_short_info designer_portfolio">
				<tr>
					<td class="pic">
						<img src="/i/no_photo80.jpg" />
					</td>
					<td>
						<h3><?=$_SESSION['user']['name']?></h3>
						<?/*?><div class="messages"><span><a class="message" href="#">Новых сообщений</a>(5)</span></div><?*/?>
					</td>
				</tr>
			</table>
			<div class="dotted_line marg15 margtop15"></div>
			<div class="active_order padbot">
				<div class="active_order_name">Активные Заказы</div>
				<div class="inner_order">
					<table class="default active_order_list">
						<tr class="head">
							<td class="number_head">Номер и дата заказа</td>
							<td class="details_head">Детали заказа</td>
							<td class="stat_head">Статус заказа</td>
							<td class="action_head">Действия</td>
						</tr>
						<?foreach($orders as $item):?>
							<?if($item['what']=='tree'):?>
								<tr>
									<td>
										<span class="top">K<?=$item['tree']?></span>
										<span class="bot"><?=date('d.m.Y',strtotime($item['mdate']))?></span>
									</td>
									<td>
										<span class="top"><?=number_format($item['price'],0,'',' ')?> руб.</span>
										<a href="<?=$item['filecover']['path']?>" class="bot" target="_blank"><?=$item['filecover']['name']?></a>
										<a href="<?=$item['filepages']['path']?>" class="bot" target="_blank"><?=$item['filepages']['name']?></a>
									</td>
									<td>
										<?StatusWidget::run($item)?>
									</td>
									<td class="last">
										<div style="margin-bottom: 15px;margin-right:15px">
											<?if($item['status']=='salereq'):?>
												<a href="/manager/tosale/?id=<?=$item['tree']?>" onclick="return confirm('Выставить на продажу?')" class="is_button right_top_corner"><span></span>На продажу&nbsp;</a>
												<a href="/popup/reject/?id=<?=$item['tree']?>&act=tosale" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" class="is_button right_top_corner"><span></span>отклонить</a>
											<?else:?>
												<a href="/manager/confirm/?id=<?=$item['tree']?>" onclick="return confirm('Подтвердить книгу?')" class="is_button right_top_corner"><span></span>утвердить&nbsp;</a>
												<a href="/popup/reject/?id=<?=$item['tree']?>" onclick="hs.htmlExpand( this, { objectType: 'iframe', outlineWhileAnimating: true, preserveContent: false, width: 370, height: 270,contentId: 'highslide-html', cacheAjax: false } ); return false;" class="is_button right_top_corner"><span></span>отклонить</a>
											<?endif?>
										</div>
										<div class="order_button">
											<div class="active_order_type">Состав заказа</div>
											<div class="order_box">
												<table align="center">
													<tr>
														<td>
															<img src="/of/6<?=$item['files_gal'][0]['path']?>" />
															<div class="annotation">
																<span class="name"><?=$item['name']?></span>
																<span><?=Funcs::$referenceId['binding'][$item['binding']]['name']?> <?=$item['countbook']?> шт.</span>
																<span><?=Funcs::$referenceId['paper'][$item['paper']]['name']?> <?=$item['countpage']?> шт.</span>
																<span class="price"><?=$item['price']?> руб.</span>
															</div>
														</td>
														<td>&nbsp;</td>
													</tr>
												</table>
											</div>
										</div>
									</td>
								</tr>
							<?else:?>
								<tr>
									<td>
										<span class="top"><?=str_repeat('0',6-strlen($item['id'])).$item['id']?></span>
										<span class="bot"><?=date('d.m.Y',strtotime($item['cdate']))?></span>
									</td>
									<td>
										<span class="top"><?=number_format($item['price'],0,'',' ')?> руб.</span>
										<a href="<?=$item['filecover']['path']?>" class="bot" target="_blank"><?=$item['filecover']['name']?></a>
										<a href="<?=$item['filepages']['path']?>" class="bot" target="_blank"><?=$item['filepages']['name']?></a>
									</td>
									<td>
										<?StatusWidget::run($item)?>
									</td>
									<td class="last">
										<div style="margin-bottom: 15px;margin-right:15px">
											<?if($item['status']=='new'):?>
												<a href="/manager/toprint/?id=<?=$item['id']?>" onclick="return confirm('Отправить заказ в печать?')" class="is_button right_top_corner"><span></span>&nbsp;&nbsp;В печать&nbsp;&nbsp;</a>
											<?elseif($item['status']=='print'):?>
												<a href="/manager/todelivery/?id=<?=$item['id']?>" onclick="return confirm('Отправить в доставку?')" class="is_button right_top_corner"><span></span>В доставку</a>
											<?elseif($item['status']=='delivery'):?>
												<a href="/manager/todone/?id=<?=$item['id']?>" onclick="return confirm('Доставлен?')" class="is_button right_top_corner"><span></span>Доставлен</a>
											<?endif?>
											<a href="/manager/cancelorder/?id=<?=$item['id']?>" onclick="return confirm('Отклонить?')" class="is_button right_top_corner"><span></span>отклонить</a>
										</div>
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
															<span><?=Funcs::$referenceId['binding'][$goods['binding']]['name']?> <?=$goods['countbook']?> шт.</span>
															<span><?=Funcs::$referenceId['paper'][$goods['paper']]['name']?> <?=$goods['countpage']?> шт.</span>
															<span class="price"><?=$goods['price']?> руб.</span>
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
							<?endif?>
						<?endforeach?>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>