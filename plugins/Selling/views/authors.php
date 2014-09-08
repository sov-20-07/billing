<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">	
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Авторы
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<div class="cell_page-content_control-panel">		
				<div class="jsTabs">
					<form>
						Поиск пользователя
						<div class="input_text_label"><input type="text" name="q" placeholder="Имя или ID" class="input_text" value="<?=$_GET['q']?>" /></div>
						Баланс
						<div class="input_text_label"><input type="text" name="from" placeholder="от" class="input_text" value="<?=$_GET['from']?>" /></div>
						<div class="input_text_label"><input type="text" name="to" placeholder="до" class="input_text" value="<?=$_GET['to']?>" /></div>
						<span class="button-white" onClick="$(this).parent().submit();">Показать</span>
						<a class="button-white" href="/<?=Funcs::$cdir?>/selling/authors/">Сбросить</a>
					</form>
					<a class="button" href="/<?=Funcs::$cdir?>/selling/export/authors/">Экспорт</a>
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
									<span class="sections_table_caption">Имя
										<?if($_GET['sort']=='name' && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='name' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=name<?if($_GET['sort']=='name' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Баланс
										<?if(($_GET['sort']=='balance') && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
										<?if($_GET['sort']=='balance' && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
									</span>
									<span class="sections_table_caption jsIcon"><a href="?sort=balance<?if($_GET['sort']=='balance' && !isset($_GET['desc'])):?>&desc=on<?endif?><?=Funcs::getFG(array('sort','desc'),'&');?>" class="icon_sort"></a></span>
								</div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell"><?=$item['code']?></td>
								<td class="sections_table_cell"><a href="/<?=Funcs::$cdir?>/selling/authors/<?=$item['id']?>/"><?=$item['name']?></a></td>
								<td class="sections_table_cell"><?=$item['balance']?> P</td>
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