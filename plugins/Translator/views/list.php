<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Переводы
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="ltCell cell_page-content_control-panel">
				<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/add/" class="button button_add-element">Добавить перевод</a>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="<?=Funcs::$uri[1]?>" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">ID</span>
								</div>
							</th>
							<?foreach(Translator::getLanguage() as $item):?>
								<th class="sections_table_cell">
									<div class="sections_table_caption-holder jsFixedY">
										<span class="sections_table_caption"><?=$item['name']?></span>
									</div>
								</th>
							<?endforeach?>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $items):?>
							<tr class="sections_table_row jsMoveElement" <?if($items['last']):?>style="background: #FFBBBB"<?endif?>>
								<?foreach($items['sub'] as $i=>$item):?>
									<?if($i==0):?>
										<td class="sections_table_cell"><?=$item['id']?></td>
									<?endif?>
									<td class="sections_table_cell"><?=$item['text']?></td>
								<?endforeach?>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edit/<?=$item['parent']?>/" class="icon icon_edit"></a>
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/del/<?=$item['parent']?>/" onclick="return confirm('Удалить запись?')" class="icon icon_remove"></a>
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