<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">	
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					<?=$name?>
				</h1><br><br>
				<b>Баланс &mdash; <?=number_format($balance,0,'',' ')?> Р</b>
			</div>
		</div>
		<div class="ltRow">
			<div class="cell_page-content_control-panel">		
				<div class="jsTabs">
					<form>
						Период
						<div class="input_text_label widget_time"><input type="text" name="from" class="input_text" style="width:155px;" placeholder="от" value="<?=$_GET['dfrom']?>" /></div>
						<div class="input_text_label widget_time"><input type="text" name="to" class="input_text" style="width:155px;" placeholder="до" value="<?=$_GET['dto']?>" /></div>
						<div class="input_text_label"><input type="text" name="q" placeholder="Название или ID товара" class="input_text" value="<?=$_GET['goods']?>" /></div>
						<div class="input_text_label"><input type="text" name="q" placeholder="Автор" class="input_text" value="<?=$_GET['q']?>" /></div>
						<span class="button-white" onClick="$(this).parent().submit();">Показать</span>
						<a class="button-white" href="/<?=Funcs::$cdir?>/selling/authors/">Сбросить</a>
					</form>
				</div>
			</div>
		</div>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="<?=Funcs::$uri[1]?>" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">ID
										<?if(($_GET['sort']=='code' || $_GET['sort']=='') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='code' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=code<?if($_GET['sort']=='code' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Дата
										<?if($_GET['sort']=='cdate' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='cdate' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=cdate<?if($_GET['sort']=='cdate' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Название товара
										<?if($_GET['sort']=='name' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='name' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=name<?if($_GET['sort']=='name' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Цена
										<?if(($_GET['sort']=='price') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='price' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=price<?if($_GET['sort']=='price' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Статус оплаты</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Автор
										<?if(($_GET['sort']=='iuser') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='iuser' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=iuser<?if($_GET['sort']=='iuser' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell"><?=$item['id']?></td>
								<td class="sections_table_cell"><?=date('d.m.Y H:i',strtotime($item['cdate']))?></td>
								<td class="sections_table_cell"><?=$item['goodsname']?></td>								
								<td class="sections_table_cell"><?=$item['iuserprice']?> P</td>
								<td class="sections_table_cell"><?=$item['paid']==1?'Оплачен':'Ожидает'?></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/selling/authors/<?=$item['author']?>/"><?=$item['iusername']?></a></td>
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