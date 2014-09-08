<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Редиректы 301
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<form id="redirectsForm" method="post">
				<div class="ltCell cell_page-content_header">
					<b>Добавить путь</b>
					<div class="input_text_holder">
						Источник (/test/)<input type="text" class="input_text" name="valfrom">
						Назначение (/test1/ или http://<?=$_SERVER['HTTP_HOST']?>/test1/ ) <input type="text" class="input_text" name="valto"><br><br>
						<button class="button" href="javascript;" onclick="$('#redirectsForm').submit();">Добавить</button>
					</div>
				</div>
			</form>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="modules" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Источник</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Назначение</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell">
									<a href="<?=$item['valfrom']?>" target="_blank"><?=$item['valfrom']?></a>
								</td>
								<td class="sections_table_cell">
									<?if(substr($item['valto'],0,7)=='http://'):?>
										<?=$item['valto']?>
									<?else:?>
										http://<?=$_SERVER['HTTP_HOST']?><?=$item['valto']?>
									<?endif?>
								</td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/delredirects/?id=<?=$item['id']?>" onclick="return confirm('Удалить запись?')" class="icon icon_remove"></a>
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