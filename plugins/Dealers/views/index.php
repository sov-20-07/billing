<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Управление дилерами
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<?=View::getPluginEmpty('menu')?>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="<?=Funcs::$uri[1]?>" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Салон</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Статус</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Магазины</span>
								</div>
							</th>							
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">КГП</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Заказы</span>
								</div>
							</th>

							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Баланс</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Файлы</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Последний вход</span>
								</div>
							</th>							
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
							
								<td class="sections_table_cell"><?=$item['company']?></td>
								
								<td class="sections_table_cell"><?=$item['statusname']?></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/stores/?id=<?=$item['id']?>">(<?=$item['stores_cnt']?>)</a></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/listcons/?id=<?=$item['id']?>">(<?=$item['consignee_cnt']?>)</a></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/orders/?id=<?=$item['id']?>">(<?=$item['orders']?>)</a></td>

								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/balance/?id=<?=$item['id']?>">(<?=floatval($item['balance'])?>)</a></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/files/?id=<?=$item['id']?>">(<?=$item['files']?>)</a></td>

								<td class="sections_table_cell"><?=$item['lastlogin']?></td>

								
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edit/?id=<?=$item['id']?>" class="icon icon_edit"></a>
										<span class="icon icon_publish visible <?if($item['visible']):?>active<?endif?>" tab="<?=Funcs::$uri[1]?>" ids="<?=$item['id']?>"></span>
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdel/?id=<?=$item['id']?>" onclick="return confirm('Удалить?')" class="icon icon_remove"></a>
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
				<?=PaginationWidget::run($pagination)?>
			</div>
		</div>
	</div>
</div>
