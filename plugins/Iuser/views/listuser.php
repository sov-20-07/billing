<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text">
					Все авторизованные пользователи
				</h1>
			</div>
		</div>
		<div class="ltRow">
			<?=View::getPluginEmpty('menu')?>
		</div>
	<!--a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/">Вернуться</a>
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
	</fieldset-->
	<div class="ltRow">
			<div class="ltCell cell_page-content_control-panel">
						
						
				<div class="iuser_filter_block">									
					<div class="iuser_selection_selected">
						<?if($_SESSION['user']['filter']):?>
							<div>Выбран фильтр: <strong><?=$_SESSION['user']['filter']['name']?></strong></div>
							<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/filterclear/">Убрать фильтр</a>
						<?endif?>
					</div>
				</div>
				
				<div class="iuser_filter_block clearfix">
					<header class="iuser_filter_header">Фильтр</header>
					
					<div class="iuser_filter_inline">
						Группа 
						<select class="jsSelectStyled" id="groupselect" onchange="getUsersGroup()">
							<option value="all">Все</option>
							<?foreach($igroups as $item):?>
								<option value="<?=$item['id']?>" <?if($_GET['igroup']===$item['id']):?>selected<?endif?>><?=$item['name']?></option>
							<?endforeach?>
						</select>
					</div>
					
					<div class="iuser_filter_inline">
						Поиск &nbsp;<input type="text" class="input_text" id="q" value="<?=$_GET['q']?>" /> <span class="button-white" onclick="searchUsers()">Найти</span>
					</div>
					
					<div class="iuser_filter_inline">
						<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=Funcs::$uri[2]?>/">Сбросить все</a>
					</div>
				</div>
				
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
				
				
			</div>
		</div>
	
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
								<td class="sections_table_cell"><a href="mailto:<?=$item['email']?>"><?=$item['email']?></a></td>
								<td class="sections_table_cell"><?=$item['phone']?></td>
								<td class="sections_table_cell"><?=$item['company']?></td>
								<td class="sections_table_cell"><?=$item['i']?></td>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edituser/?id=<?=$item['id']?>" class="icon icon_edit"></a>
										<span class="icon icon_publish visible <?if($item['visible']):?>active<?endif?>" tab="iusers" ids="<?=$item['id']?>"></span>
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
	
	
	
	<!--form id="ids_post" method="post" action="/<?=Funcs::$cdir?>/data/one?path=cmode&amp;parent=&amp;page=&amp;cat=">
		<table cellspacing="0" cellpadding="0" width="100%" tab="<?=Funcs::$uri[1]?>" class="spisok">
			<thead>
				<tr>
					<th class="header">Имя</th>
					<th class="header">Логин</th>
					<th class="header">Email</th>
					<th class="header">Телефон</th>
					<th class="header">Компания</th>
					<th class="header">Группа</th>
					<th width="120" class="header" colspan="3">Действия</th>
				</tr>
			</thead>
			<tbody>
			<?foreach($list as $item):?>
				<tr id="row<?=$item['id']?>">
					<td><div class="doc_item"><?=$item['name']?></div></td>
					<td><?=$item['login']?></td>
					<td><a href="mailto:<?=$item['email']?>"><?=$item['email']?></a></td>
					<td><?=$item['phone']?></td>
					<td><?=$item['company']?></td>
					<td><?=$item['igroup']?></td>
					<td class="padd_5"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/edituser/?id=<?=$item['id']?>"><img height="16" width="15" title="Редактировать" alt="Редактировать" src="/<?=Funcs::$cdir?>/i/ic_edit.gif"></a></td>
					<td class="padd_5"><a href="javascript:;" class="visible" tab="iusers" ids="<?=$item['id']?>"><img id="eye2" width="16" height="18" title="Опубликовать" alt="Опубликовать" src="/<?=Funcs::$cdir?>/i/<?if($item['visible']):?>v<?else:?>i<?endif?>.gif"></a></td>
	        		<td class="padd_5"><a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdeluser/?id=<?=$item['id']?>" onclick="return confirm('Удалить объект?')" title="удалить"><img border="0" src="/<?=Funcs::$cdir?>/i/ic_trash.gif" alt="удалить"></a></td>
				</tr>
			<?endforeach?>
			</tbody>
		</table>
	</form>
	<div class="gray_line_navigation">
		<table width="100%"><tbody><tr>
			<td width="20%">&nbsp;</td>
			<td width="60%">
				<?=PaginationWidget::run($pagination)?>
			</td>
			<td width="20%">
				<span class="light_gray">Выводить </span>
				<form method="post" action="/<?=Funcs::$cdir?>/tree/perpage/" style="display:inline">
					<select class="small_select" onchange="this.parentNode.submit()" name="new_kol">
                    	<option value="10" <?if($_SESSION['user']['perpage']==10):?>selected<?endif?>>10</option>
                    	<option value="20" <?if($_SESSION['user']['perpage']==20):?>selected<?endif?>>20</option>
                    	<option value="50" <?if($_SESSION['user']['perpage']==50):?>selected<?endif?>>50</option>
                    	<option value="5000000" <?if($_SESSION['user']['perpage']==5000000):?>selected<?endif?>>все</option>
                    	
					</select>
				</form>
				<img height="1" width="130" src="./i/pix.gif">
			</td>
		</tr></tbody></table>
	</div-->
</div></div>