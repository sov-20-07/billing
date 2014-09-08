<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">	
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Заявки
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="cell_page-content_control-panel b_filter-row">		
				<div class="jsTabs">
					<form>
						<div class="b_filter-row_header">Период</div>
						<div class="input_text_label widget_time"><input type="text" name="from" class="input_text" style="width:155px;" placeholder="от" value="<?=$_GET['dfrom']?>" /></div>
						<div class="input_text_label widget_time"><input type="text" name="to" class="input_text" style="width:155px;" placeholder="до" value="<?=$_GET['dto']?>" /></div>
						<div class="input_text_label"><input type="text" name="q" placeholder="Имя или ID автора" class="input_text" value="<?=$_GET['q']?>" /></div>
						<div class="input_text_label">
							<select class="jsSelectStyled" name="paid">
								<option value="">Все</option>
								<option value="0" <?if($_GET['paid']==='0'):?>selected<?endif?>>Новая</option>
								<option value="1" <?if($_GET['paid']==='1'):?>selected<?endif?>>Обработана</option>
							</select>
						</div>
						<span class="button-white" onClick="$(this).parent().submit();">Показать</span>
						<a class="button-white" href="/<?=Funcs::$cdir?>/requests/">Сбросить</a>
					</form>	
					<a class="button" href="/<?=Funcs::$cdir?>/requests/export/">Экспорт</a>
					<a class="button" href="/<?=Funcs::$cdir?>/requests/history/">Журнал событий</a>
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
										<?if(($_GET['sort']=='request_id' || $_GET['sort']=='') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='request_id' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=request_id<?if($_GET['sort']=='request_id' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
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
									<span class="sections_table_caption">Автор
										<?if($_GET['sort']=='name' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='name' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=name<?if($_GET['sort']=='name' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Сумма запроса
										<?if(($_GET['sort']=='amount') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='amount' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=amount<?if($_GET['sort']=='amount' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Статус
										<?if(($_GET['sort']=='paid') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='paid' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=paid<?if($_GET['sort']=='paid' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell"><?=$item['request_id']?></td>
								<td class="sections_table_cell"><?=date('d.m.Y H:i:s',strtotime($item['cdate']))?></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/requests/<?=$item['id']?>/"><?=$item['name']?></a></td>
								<td class="sections_table_cell"><?=$item['amount']?> P</td>
								<td class="sections_table_cell">
									<?if($item['paid']==0):?>
										Новая
									<?else:?>
										Обработана<br>
										<?=date('d.m.Y H:i:s',strtotime($item['fdate']))?>
									<?endif?>
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