<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Управление магазинами дилера <?=$dealer['company']?>
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<?=View::getPluginEmpty('address/menu',array('dealer'=>$dealer['id']))?>
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
									<span class="sections_table_caption">Название</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Адрес</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Город</span>
								</div>
							</th>							
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Статус</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Контактное лицо</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
							
								<td class="sections_table_cell"><?=$item['title']?></td>
								
								<td class="sections_table_cell">
								   г. <?=$item['city']?>  ул. <?=$item['street']?> д. <?=$item['house']?>
								</td>
								<td class="sections_table_cell"><?=$item['city']?></td>
								
								<td class="sections_table_cell"><?=$item['statusname']?></td>
								<td class="sections_table_cell">
									<?=$item['contact']?>
									<a href="mailto:<?=$item['contact_phone']?>"><?=$item['email']?></a>
								</td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/editstore/?id=<?=$item['id']?>" class="icon icon_edit"></a>
										<?if($item['visible']):?>
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/hidestore/?id=<?=$item['id']?>&dealer=<?=$dealer['id']?>" class="icon icon_publish active"></a>
										<?else:?>
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/showstore/?id=<?=$item['id']?>&dealer=<?=$dealer['id']?>" class="icon icon_publish"></a>
										<?endif?>
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdelstore/?id=<?=$item['id']?>&dealer=<?=$dealer['id']?>" onclick="return confirm('Удалить?')" class="icon icon_remove"></a>
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
