<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Баланс <?=$dealer['company']?>: <?=$balance?>
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="ltCell cell_page-content_control-panel">
				<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/addbalance/?id=<?=$dealer['id']?>" class="button button_add-element">Добавить Операцию</a>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="link_step_back_holder">
				<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/"></a>
			</div>			
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
									<span class="sections_table_caption">Операция</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сумма</span>
								</div>
							</th>							
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell">
									<?$date = DateTime::createFromFormat('Y-m-d H:i:s', $item['cdate'])?>
									<?=$date->format('d.m.Y');?>
								</td>
								<td class="sections_table_cell"><?=$item['comment']?></td>
								<td class="sections_table_cell"><?=$item['sum']?></td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/editbalance/?id=<?=$item['id']?>" class="icon icon_edit"></a>
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdelbalance/?id=<?=$item['id']?>&dealer=<?=$dealer['id']?>" onclick="return confirm('Удалить?')" class="icon icon_remove"></a>
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
