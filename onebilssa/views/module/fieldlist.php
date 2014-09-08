<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Управление полями
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="ltCell cell_page-content_control-panel">
				<a href="/<?=Funcs::$cdir?>/module/showfieldadd/?module=<?=$_GET['module']?>" class="button button_add-element">Добавить поле</a>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="fields" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Название</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Алиас</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Тип модуля</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Параметры</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell">
									<div class="sections_table_row-header sections_table_row-header_catalog">
										<a class="sections_table_link" href="/<?=Funcs::$cdir?>/module/showfieldedit/?module=<?=$_GET['module']?>&id=<?=$item['id']?>"><?=$item['name']?></a>
									</div>
								</td>
								<td class="sections_table_cell">
									<?=$item['path']?>
								</td>
								<td class="sections_table_cell">
									<?=$item['type']?>
								</td>
								<td class="sections_table_cell">
									<?=$item['params']?>
								</td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/module/showfieldedit/?module=<?=$_GET['module']?>&id=<?=$item['id']?>" class="icon icon_edit"></a>
										<a href="/<?=Funcs::$cdir?>/module/fielddel/?module=<?=$_GET['module']?>&id=<?=$item['id']?>" onclick="return confirm('Удалить поле?')" class="icon icon_remove"></a>
									</div>
								</td>
								<td class="sections_table_cell">
									<div class="sections_table_move-panel">
										<input class="sections_input_order input_text" value="<?=$item['num']?>" onblur="if($(this).val()!=<?=$item['num']?>){defineSortNum(<?=$item['id']?>,'fields',$(this).val());}">
										<span class="icon_move jsMoveDrag"></span>
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