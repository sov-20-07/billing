<div class="ltCell cell_page-content sizeParent">
	<div class="ltContainer ltFullWidth sizeChild">
		<div class="ltRow">
			<div class="ltCell cell_page-content_header">
				<h1 class="cell_page-content_header_text"><?=$name?></h1>
				<a href="/<?=Funcs::$cdir?>/work/showedit/?id=<?=$id?><?if($parent!=0):?>&parent=<?=$parent?><?endif?>" class="icon_header-edit"></a>
			</div>
		</div>
		<div class="ltRow">
			<div class="ltCell cell_page-content_control-panel">
				<?if($module['type']=='struct'):?>
					<a href="/<?=Funcs::$cdir?>/work/showadd/?module=<?=$module['id']?>&tree=new&parent=<?=Funcs::$uri[2]?>" class="button button_add-section">Добавить раздел</a>
					<a href="/<?=Funcs::$cdir?>/work/showadd/?module=<?=Module::getIdElementModule($module['id'])?>&tree=new&parent=<?=Funcs::$uri[2]?>" class="button button_add-section">Добавить элемент</a>
				<?else:?>
					<a href="/<?=Funcs::$cdir?>/work/showadd/?module=<?=$moduleraz['id']?>&tree=new&parent=<?=Funcs::$uri[2]?>" class="button button_add-section">Добавить элемент</a>
				<?endif?>
				
				<?if(@array_key_exists('module',$_SESSION['user']['access'])):?>
				<div class="widget_module-list">
					<select id="ModuleList" class="jsSelectStyled" onchange="getModuleItems()">
						<option value=""></option>
						<?foreach(Module::getModules() as $item):?>
							<option value="<?=$item['id']?>" <?if($module['id']==$item['id']):?>selected<?endif?>><?=$item['name']?></option>
						<?endforeach?>
					</select>
					
					<a class="widget_module-list_link" id="bindmodule" href="" style="display:none;">Привязать элемент к дереву</a>
					<?if($module['id']):?>
						<a class="widget_module-list_link" id="addmodule" href="" style="display:none;">Привязать раздел к дереву</a>
						<?/*?><a id="editmodule" href="/<?=Funcs::$cdir?>/work/showedit/?module=<?=$module['id']?>&tree=<?=$id?><?if($parent!=0):?>&parent=<?=$parent?><?endif?>">Редактировать</a><?*/?>
					<?else:?>
						<a class="widget_module-list_link" id="addmodule" href="" style="display:none;">Привязать раздел к дереву</a>
					<?endif?>
					Элемент: <b><?=$module['name']?></b> | Каталог: <b><?=$moduleraz['name']?></b>
					<script>
						function getModuleItems(){
							if($('#ModuleList option:selected').val()!=''){
								$('#bindmodule').attr("href","/<?=Funcs::$cdir?>/work/bind/?module="+$('#ModuleList').val()+"&tree=<?=$id?><?if($id!=0):?>&parent=<?=$id?><?endif?>");
								$('#addmodule').attr("href","/<?=Funcs::$cdir?>/work/bindraz/?module="+$('#ModuleList').val()+"&tree=<?=$id?><?if($id!=0):?>&parent=<?=$id?><?endif?>&id=0");
								$('#bindmodule').show();
								$('#addmodule').show();
							}else{
								$('#bindmodule').hide();
								$('#addmodule').hide();
							}
						}
					</script>
				</div>
				<?endif?>
				
			</div>
		</div>		
		<div class="ltRow jsScrollContainer">
			<div class="jsScrollWrapper">
				<div class="sections_settings_holder">
					<div class="sections_table_caption sections_settings jsIcon jsSectionsSettingsToggle"><span class="icon_settings"></span></div>
				</div>
				<div class="jsScroll whiteOverflow sections_container">
					<table class="sections_table jsMoveContainerTR" tab="tree" page="<?=$_GET['p']?>">
						<tr class="sections_table_caption_row jsMoveFixed">
							<?foreach(Fields::getOutFieldsByTree() as $i=>$item):?>
								<th class="sections_table_cell  outtd outtd<?=$item['path']?>" path="<?=$item['path']?>" <?if($i!=='tree_name'):?>style="display:none;"<?endif?>>
									<div class="sections_table_caption-holder jsFixedY">
										<span class="sections_table_caption">
											<?=$item['name']?>
											<?if($_GET['sort']==str_replace('tree_','',$i) && !isset($_GET['desc'])):?><span class="icon_sort_up"></span><?endif?>
											<?if($_GET['sort']==str_replace('tree_','',$i) && isset($_GET['desc'])):?><span class="icon_sort_down"></span><?endif?>
										</span>
										<?if(!is_numeric($i)):?>
											<span class="sections_table_caption jsIcon"><a href="?sort=<?=str_replace('tree_','',$i)?><?if($_GET['sort']==str_replace('tree_','',$i) && !isset($_GET['desc'])):?>&desc=on<?endif?>" class="icon_sort"></a></span>
										<?endif?>
									</div>
								</th>
							<?endforeach?>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY"></div>
							</th>
							<th class="sections_table_cell">
								<div class="sections_table_caption-holder jsFixedY">
									<span class="sections_table_caption jsIcon"><a href="/<?=implode('/',Funcs::$uri)?>/" class="icon_sort"></a></span>
								</div>
							</th>
						</tr>
						<?foreach($list as $item):?>
							<tr class="sections_table_row jsMoveElement" id="row<?=$item['id']?>">
								<?foreach(Fields::getOutFieldsByTree() as $i=>$field):?>
									<?if($i==='tree_name'):?>
										<td class="sections_table_cell outtd outtd<?=$field['path']?>">
											<div class="sections_table_row-header <?if(strpos($item['module']['type'],'struct')!==false):?>sections_table_row-header_catalog<?endif?>">
												<a class="sections_table_link editable" href="/<?=Funcs::$cdir?>/<?=$item['id']?>/"><?=$item[$field['path']]?></a>
												<input class="editstr" type="text" value="<?=$item[$field['path']]?>" style="display:none;" field="<?=substr($i,5,strlen($i))?>" tree="<?=$item['id']?>" tab="tree">
												<span class="icon_section-settings jsSectionSettingsToggle" data-popup-id="<?=$item['id']?>"></span>
												<?if(@array_key_exists('module',$_SESSION['user']['access'])):?><i><?=$item['module']['name']?></i><?endif?>
											</div>
										</td>
									<?elseif(!is_numeric($i)):?>
										<td class="sections_table_cell outtd outtd<?=$field['path']?>" style="display:none;">
											<?if($field['path']=='udate'):?>
												<?=date("Y-m-d H:i",strtotime($item[$field['path']]))?>
											<?else:?>
												<span class="editable"><?=$item[$field['path']]?></span>
												<input class="editstr" type="text" value="<?=$item[$field['path']]?>" style="display:none;" field="<?=substr($i,5,strlen($i))?>" tree="<?=$item['id']?>" tab="tree">
											<?endif?>
										</td>
									<?else:?>
										<td class="sections_table_cell outtd outtd<?=$field['path']?>" style="display:none;">
											<?if(is_numeric($item['fields'][$field['path']])):?>
												<span class="editable"><?=$item['fields'][$field['path']]?></span>
												<input class="editstr" type="text" value="<?=$item['fields'][$field['path']]?>" style="display:none;" field="<?=$field['path']?>" tree="<?=$item['id']?>" tab="catalog">
											<?elseif(in_array($field['type'],array('string','integer','float'))):?>
												<span class="editable"><?=$item['fields'][$field['path']]?></span>
												<input class="editstr" type="text" value="<?=$item['fields'][$field['path']]?>" style="display:none;" path="<?=$field['path']?>" field="<?=Fields::$types[$field['type']]['type']?>" tree="<?=$item['id']?>" tab="data">
											<?else:?>
												<?=$item['fields'][$field['path']]?>
											<?endif?>
										</td>
									<?endif?>
								<?endforeach?>
								<td class="sections_table_cell">
									<div class="sections_table_control-panel">
										<span class="icon icon_publish visible <?if($item['visible']):?>active<?endif?>" tab="tree" ids="<?=$item['id']?>" title="Видимость на сайте"></span>
										<span class="icon icon_tomenu menu <?if($item['menu']):?>active<?endif?>" tab="tree" ids="<?=$item['id']?>" title="Участвовать в меню"></span>
										<span class="icon_search search <?if($item['search']):?>active<?endif?>" tab="tree" ids="<?=$item['id']?>" title="Участвовать в поиске"></span>
										<?if(strpos($moduleraz['path'],'struct_')!==false && Funcs::$prop['yamarket']==0):?>
											<span class="icon icon_tomarket market<?if(Extra::getMarket($item['id'])==1):?>active<?endif?>" ids="<?=$item['id']?>"></span>
										<?endif?>
									</div>
								</td>
								<td class="sections_table_cell">
									<div class="sections_table_move-panel">
										<input class="sections_input_order input_text" value="<?=$item['num']?>" onblur="if($(this).val()!=<?=$item['num']?>){defineSortNum(<?=$item['id']?>,'tree',$(this).val());}">
										<span class="icon_move jsMoveDrag"></span>
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
				<?=PaginationWidget::run()?>
				<div class="sections_footer_options">
					<form method="POST" id="importForm" enctype="multipart/form-data" action="/<?=Funcs::$cdir?>/impexp/import/<?=end(Funcs::$uri)?>/">
						<a href="/<?=Funcs::$cdir?>/impexp/export/<?=end(Funcs::$uri)?>/" class="button-white">Экспорт</a>
						<span class="button-white" id="importButton" onclick="$('#upload').click();">Импорт</span>
						<img class="imgwait" src="/<?=Funcs::$cdir?>/i/wait18.gif" style="display:none;">
						<input type="file" name="upload" id="upload" style="display: none;" onchange="$('#importButton').hide();$('.imgwait').show();$('#importForm').submit();">
					</form>
				</div>
			</div>
		</div>
	</div>
	<section class="popup popup_sections-settings jsSectionsSettingsPopup">
		<div class="ltContainer ltFullWidth">
			<div class="ltRow">
				<header class="popup_sections-settings_header">
					<span class="button_select-all jsSelectAll">Выбрать все</span> <span class="button_clear-all jsClearAll">Очистить</span>
				</header>
			</div>
			<div class="ltRow jsScrollContainer">
				<div class="jsScrollWrapper">
					<div class="jsScroll beigeOverflow">
						<ul class="popup_sections-settings_list">
						<?foreach(Fields::getOutFieldsByTree() as $key=>$item):?>
							<li class="popup_sections-settings_option">
								<label class="form_label selectColumn">
									<input type="checkbox" class="selectColumnCheckbox <?if($key==='tree_name'):?>selectColumnCheckboxName<?endif?>" value="<?=$item['path']?>" <?if(in_array($item['path'],Funcs::getUserOptions())):?>checked<?endif?> <?if($key==='tree_name'):?>checked disabled<?endif?>><span class="form_label_text"><?=$item['name']?></span>
								</label>
							</li>						
						<?endforeach?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<script>
	$(document).ready(function(){
		$('.selectColumnCheckbox').on('ifToggled',function(){
			if($(this).prop('checked')==true){
	   			$('.outtd'+$(this).val()).show();
	   		}else{
	   			$('.outtd'+$(this).val()).hide();
	   		}
	   		setuseroptions();
		});
		$('.jsSelectAll').click(function(){
			$('.outtd').show();
			setuseroptions();
		});
		$('.jsClearAll').click(function(){
			$('.outtd').hide();
			$('.outtdname').show();
			$('.selectColumnCheckboxName').prop('checked',true);
			$('.selectColumnCheckboxName').parent().addClass('checked');
			setuseroptions();
		});
		$('.selectColumnCheckbox').each(function(){
			if($(this).prop('checked')==true){
				$('.outtd'+$(this).val()).show();
			}
		});
	});
	function setuseroptions(){
		var data='';
		$('th.outtd').each(function(){
			if($(this).css('display')!='none'){
				data+="rows[]="+$(this).attr('path')+"&";
			}
		});
		data+="tree=<?=Funcs::$uri[2]?>";
		$.ajax({
			type: "POST",
			url: onessapath+"tree/setuseroptions/",
			data: data,
			success: function(msg){
				resizeContent();
			}
		});
	}
</script>