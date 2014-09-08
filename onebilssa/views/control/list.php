<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Сайты
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="ltCell cell_page-content_control-panel">
				<?if(Funcs::$uri[2]==''):?>
					<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/addgroup/" class="button button_add-section">Добавить группу</a>
				<?endif?>
				<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/add/<?if(Funcs::$uri[2]):?>?parent=<?=Funcs::$uri[2]?><?endif?>" class="button button_add-element">Добавить сайт</a>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="<?=Funcs::$uri[1]?>" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сайт</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">URL</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Язык</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<?if($item['domain']):?>
								<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
									<td class="sections_table_cell">
										<div class="sections_table_row-header sections_table_row-header">
											<a class="sections_table_link" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edit/?id=<?=$item['id']?>"><?=$item['name']?></a>
										</div>
									</td>
									<td class="sections_table_cell">
										<?=$item['domain']?>
									</td>
									<td class="sections_table_cell">
										<?=$item['lname']?>
									</td>
									<td class="sections_table_cell">
										<div class="sections_table_control-panel">
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edit/?id=<?=$item['id']?>" class="icon icon_edit"></a>
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdel/?id=<?=$item['id']?>" onclick="return confirm('Удалить пользователя?')" class="icon icon_remove"></a>
										</div>
									</td>
								</tr>
							<?else:?>
								<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
									<td class="sections_table_cell">
										<div class="sections_table_row-header sections_table_row-header_catalog">
											<a class="sections_table_link" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$item['id']?>/"><?=$item['name']?></a>
										</div>
									</td>
									<td class="sections_table_cell"></td>
									<td class="sections_table_cell"></td>
									<td class="sections_table_cell">
										<div class="sections_table_control-panel">
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/editgroup/?id=<?=$item['id']?>" class="icon icon_edit"></a>
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdelgroup/?id=<?=$item['id']?>" onclick="return confirm('Удалить элемент?')" class="icon icon_remove"></a>
										</div>
									</td>
								</tr>
							<?endif?>
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