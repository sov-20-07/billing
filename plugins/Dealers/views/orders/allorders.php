<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">		
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">Заказы</h1>
			</div>
			<div class="link_step_back_holder">
				<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/?id=<?=$dealer['id']?>"></a>
			</div>
		</div>
		<?=View::getPluginEmpty('orders/allmenu',array(
			'statuses'=>$statuses,
			'dealer' => $dealer,
			'dealers_list' => $dealers_list,
			'city_list' => $city_list,
		))?>
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
									<span class="sections_table_caption">Диллер</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Город <?/*?><span class="icon_sort_up"></span><?*/?></span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сумма <?/*?><span class="icon_sort_down"></span><?*/?></span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сумма к оплате</span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">ГП</span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Трекинг</span>
									<span class="sections_table_caption jsIcon"><span class="icon_sort"></span></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">History</span>
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
								</td>
								<td class="sections_table_cell">
									<a class="sections_table_link" href="/<?=Funcs::$cdir?>/dealers/editorder/?id=<?=$item['id']?>">D<?=date("dmY",strtotime($item['cdate']))?>-<?=$item['id']?></a>
									<?if($item['preorder']):?><br>Предзаказ<?endif?>
								</td>
								<td class="sections_table_cell">
									<?=$item['company']?>
								</td>				
								<td class="sections_table_cell">
									<?=$item['city']?>
								</td>
								<td class="sections_table_cell">
									<?=number_format($item['price']+$item['sale'],2,',',' ')?> $
								</td>
								<td class="sections_table_cell">
									<?=number_format($item['price'],2,',',' ')?> $
								</td>								
								<td class="sections_table_cell">
									<a href="/<?=Funcs::$cdir?>/dealers/editcons/?id=<?=$item['cons']?>"><?=$item['cons']?></a><br><br>
								</td>
								<td class="sections_table_cell">
									<?=$item['tracking']?>
								</td>
								<td class="sections_table_cell">
									<a href="/<?=ONESSA_DIR?>/dealers/orderhistory/?id=<?=$item['id']?>" onclick="return hs.htmlExpand(this, { objectType: 'ajax', width: 500 } )" class=" ">История заказа</a>									
								</td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/dealers/printorder/?id=<?=$item['id']?>" target="_blank" class="icon icon_print"></a>
										<a href="/<?=Funcs::$cdir?>/dealers/actdelorder/?id=<?=$item['id']?>&dealer=<?=$item['dealer']?>" onclick="return confirm('Удалить заказ? (это действие нельзя будет отменить)');" title="удалить" class="icon icon_remove"></a>
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
