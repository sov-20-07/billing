<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Все авторизованные пользовател
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<?=View::getPluginEmpty('menu')?>
		</div>
		<fieldset>
			<legend>Фильтр</legend>
			Группа 
			<select id="groupselect" onchange="getUsersGroup()">
				<option value="all">Все</option>
				<?foreach($igroups as $item):?>
					<option value="<?=$item['id']?>" <?if($_GET['igroup']===$item['id']):?>selected<?endif?>><?=$item['name']?></option>
				<?endforeach?>
			</select>
			<br />
			Поиск &nbsp;<input type="text" id="q" value="<?=$_GET['q']?>" /> <input type="button" value="Найти" onclick="searchUsers()">
			<br /> 
			<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=Funcs::$uri[2]?>/">Сбросить все</a>
			<script>
				function getUsersGroup(){
					if($("#groupselect option:selected").val()=='all'){
						document.location.href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=Funcs::$uri[2]?>/";
					}else{
						document.location.href="?igroup="+$("#groupselect option:selected").val();
					}
				}
				function searchUsers(){
					if(jQuery.trim($("#q").val())!=''){
						document.location.href="?q="+$("#q").val();
					}
				}
			</script>
		</fieldset>
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="<?=Funcs::$uri[1]?>" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Имя</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Регистрация</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Email</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Телефон</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Компания</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption">Группа</span>
								</div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<td class="sections_table_cell">
									<div class="sections_table_row-header sections_table_row-header<?if($item['sub']):?>_catalog<?endif?>">
										<a class="sections_table_link" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edituser/?id=<?=$item['id']?>"><?=$item['name']?></a>
									</div>
								</td>
								<td class="sections_table_cell"><?=date('d.m.Y H:i',strtotime($item['cdate']))?></td>
								<td class="sections_table_cell"><a href="mailto:<?=$item['email']?>"><?=$item['email']?></a></td>
								<td class="sections_table_cell"><?=$item['phone']?></td>
								<td class="sections_table_cell"><?=$item['company']?></td>
								<td class="sections_table_cell"><?=$item['group']?></td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edituser/?id=<?=$item['id']?>" class="icon icon_edit"></a>
										<span class="icon icon_publish visible <?if($item['visible']):?>active<?endif?>" tab="<?=Funcs::$uri[1]?>" ids="<?=$item['id']?>"></span>
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdeluser/?id=<?=$item['id']?>" onclick="return confirm('Удалить?')" class="icon icon_remove"></a>
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