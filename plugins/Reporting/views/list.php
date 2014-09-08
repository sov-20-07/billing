<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">	
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Отчетность
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="cell_page-content_control-panel">		
				<div class="jsTabs">
					<form>
						Период
						<div class="input_text_label widget_time"><input type="text" name="from" class="input_text" style="width:155px;" placeholder="от" value="<?=$_GET['dfrom']?>" /></div>
						<div class="input_text_label widget_time"><input type="text" name="to" class="input_text" style="width:155px;" placeholder="до" value="<?=$_GET['dto']?>" /></div>
						<span class="button-white" onClick="$(this).parent().submit();">Показать</span>
						<a class="button-white" href="/<?=Funcs::$cdir?>/reporting/">Сбросить</a>
					</form>	
					<a class="button" href="/<?=Funcs::$cdir?>/reporting/export/">Экспорт</a>
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
										<?if(($_GET['sort']=='payid' || $_GET['sort']=='') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='payid' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=payid<?if($_GET['sort']=='payid' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
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
									<span class="sections_table_caption">Пользователь
										<?if($_GET['sort']=='iusername' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='iusername' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=iusername<?if($_GET['sort']=='iusername' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Товар
										<?if($_GET['sort']=='goodsname' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='goodsname' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=goodsname<?if($_GET['sort']=='goodsname' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Цена
										<?if($_GET['sort']=='iuserprice' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='iuserprice' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=iuserprice<?if($_GET['sort']=='iuserprice' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Автор
										<?if($_GET['sort']=='authorname' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='authorname' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=authorname<?if($_GET['sort']=='authorname' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">% перечисления</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сумма перечисления</span>
								</div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell"><?=$item['payid']?></td>
								<td class="sections_table_cell"><?=date('d.m.Y H:i:s',strtotime($item['cdate']))?></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/selling/users/<?=$item['iuser']?>/"><?=$item['iusername']?></a></td>
								<td class="sections_table_cell"><?=$item['goodsname']?></td>
								<td class="sections_table_cell"><?=$item['iuserprice']?> P</td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/selling/authors/<?=$item['author']?>/"><?=$item['authorname']?></a></td>
								<td class="sections_table_cell"><?=$item['commision']?></td>
								<td class="sections_table_cell"><?=$item['iuserprice']-$item['authorprice']?> P</td>
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