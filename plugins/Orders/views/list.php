<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">Заказы</h1>
			</div>
		</div>
		<?=View::getPluginEmpty('menu')?>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table sections_table_zebra">
						<tr class="sections_table_caption_row">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Дата <span class="icon_sort_down"></span></span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Номер</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сумма</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Доставка <?/*?><span class="icon_sort_up"></span><?*/?></span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Город <?/*?><span class="icon_sort_down"></span><?*/?></span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Телефон</span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">ФИО</span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
								</div>
							</th>
						</tr>
						<?foreach($list as $item): ?>
							<tr class="sections_table_row">
								<td class="sections_table_cell">
									<?=date("d.m.Y H:i",strtotime($item['cdate']))?><br />
									<?if($editpath!='edit'):?>
										в доставке с <?=date("d.m.Y H:i",strtotime($item['wdate']))?><br />
										<?if($item['status']=='done'):?>
											<span style="color:#009900">доставлено <?=date("d.m.Y H:i",strtotime($item['fdate']))?></span><br />
											Клиент лоялен: <?if($item['loyalty']==1):?>Да<?else:?>Нет<?endif?><br />
										<?elseif($item['status']=='cancel'):?>
											<span style="color:#FF0000">отменено <?=date("d.m.Y H:i",strtotime($item['fdate']))?></span><br />
										<?endif?>
									<?endif?>
									<?if($item['authoradd']['name']):?>Создал: <b><?=$item['authoradd']['name']?></b><br /><?endif?>
									<?if($item['authoredit']['name']):?>Редакт.: <b><?=$item['authoredit']['name']?></b><?endif?>
									<?/*?>Отзыв на маркете: <b><?if($item['opinion']):?>Да (<?=date('d.m.Y',strtotime($item['opinion']['cdate']))?>)<?else:?>Нет<?endif?></b><br /><?*/?>
									<?/*?>Отзыв о товаре: <b><?=$item['reports'][0]?> из <?=$item['reports'][1]?></b><?*/?>
								</td>
								<td class="sections_table_cell">
									<a class="sections_table_link" href="/<?=Funcs::$cdir?>/orders/<?=$editpath?>/<?=$item['id']?>/">C<?=date("dmY",strtotime($item['cdate']))?>-<?=$item['id']?></a>
								</td>
								<td class="sections_table_cell">
									<?/*<?=$item['payment']?><br>
									Оплата: <b><?=$item['paid']==0?'Нет':'Да'?></b><br>
									Заказ: <?=$item['price']?><br>
									Скидка: <?=$item['sale']?><br>
									Доставка: <?=$item['deliveryprice']?><br>*/?>
									<?=number_format($item['price']+$item['deliveryprice'],0,'',' ')?> р<br>
									<?if($item['paid']==1):?>оплачен<?endif?>
								</td>
								<td class="sections_table_cell">
									<?=$item['delivery']?><br>
									<?/*?><?=$item['deliveryoptions']?><?*/?>
									<?=$item['deliveryprice']?> Р
								</td>
								<td class="sections_table_cell">
									<?=$item['city']?>
								</td>
								<td class="sections_table_cell">
									<?=$item['phone']?>
								</td>
								<td class="sections_table_cell">
									<a href="/<?=ONESSA_DIR?>/iuser/edituser/?id=<?=$item['iuser']?>"><?=$item['fio']?></a>
								</td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/orders/printorder/?id=<?=$item['id']?>" target="_blank" class="icon icon_print"></a>
										<a href="/<?=Funcs::$cdir?>/orders/dodel/?id=<?=$item['id']?>" onclick="return confirm('Удалить объект?');" title="удалить" class="icon icon_remove"></a>
									</div>
								</td>
							</tr>
						<?endforeach?>
					</table>
				</div>
			</div>
		</div>
		<div class="ltRow">
			<div class="sections_footer clearfix">
				<?=PaginationWidget::run()?>
			</div>
		</div>
	</div>
</div>