<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Управление промо-кодами
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
									<span class="sections_table_caption">Дата</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Название</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Тип</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Значение</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Кол-во</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Использовано</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell">
									<?=date('H:i d.m.Y',strtotime($item['cdate']))?><br>
									от <?=date('H:i d.m.Y',strtotime($item['fromdate']))?><br>
									до <?=date('H:i d.m.Y',strtotime($item['todate']))?>
								</td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$item['id']?>/"><?=$item['name']?></a></td>
								<td class="sections_table_cell">
									<?=Codes::$type[$item['ctype']]?> 
									<?if($item['num']>0):?><br><strong><?=$item['code']?></strong><?endif?>
								</td>
								<td class="sections_table_cell"><?=$item['value']?></td>
								<td class="sections_table_cell"><?if($item['num']>0):?><?=$item['num']?><?else:?><?=$item['count']?><?endif?></td>
								<td class="sections_table_cell"><?=$item['used']?></td>
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