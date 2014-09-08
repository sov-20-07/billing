<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text"><?=$title?></h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<?foreach($fields as $path=>$item):?>
										<tr>
											<td><?=$item['name']?></td>
											<td>
													<?if($item['type']=='string'):?>
													<div class="input_text_holder">
														<input type="text" class="input_text <?if($item['required']==1):?>required<?endif?>" name="<?=$path?>" value="<?=$iuser[$path]?>" <?if($item['unique']==1):?>onchange="checkUnique('<?=$path?>')"<?endif?>>
														<?if($item['unique']==1):?><span id="<?=$path?>" class="error" style="color:#FF0000;display:none;">Значение не уникальное</span><?endif?>
													</div>
													<?elseif($item['type']=='date'):?>
														<div class="widget_time input_text_holder"><input type="text" class="input_text <?if($item['required']==1):?>required<?endif?>" name="<?=$path?>" value="<?=$iuser[$path]?>" name="<?=$path?>"></div>
													<?elseif($item['type']=='text'):?>
													<div class="input_text_holder">
														<textarea name="<?=$path?>" class="input_text"><?=$iuser[$path]?></textarea>
													</div>
													<?elseif($item['type']=='soc_string'):?>
													<div class="input_text_holder">
														<?=$iuser[$path]?>
														<input type="hidden" name="<?=$path?>" value="<?=$iuser[$path]?>">
													</div>
													<?elseif($item['type']=='label'):?>
														<?=$iuser[$path]?>
													<?elseif($item['type']=='bool'):?>
													<div class="input_text_holder">
														<input type="hidden" name="<?=$path?>" value="0">
														<input type="checkbox" class="input_text" name="<?=$path?>" value="1" <?if($iuser[$path]==1):?>checked<?endif?>>
													</div>
													<?elseif($item['name']=='Статус'):?>
													<div class="jsTabs">
														<section class="onetabs">
															<header class="onetabs_links">
																<span class="jsTabsLink onetabs_link">Стандартный</span>
																<span class="jsTabsLink onetabs_link">Специальный</span>
															</header>
														</section>
														<section class="jsTabsContent onetabs_content">
															<div class="jsTabsTab">
																<div class="onetabs_tab">
																	<div class="fixSelect_big_holder">
																		<select class="jsSelectStyled" name="<?=$path?>">
																			<option value=""></option>
																			<?foreach($statuses as $item):?>
																				<option value="<?=$item['id']?>" <?if($item['id']==$iuser[$path]):?>selected<?endif?>><?=$item['name']?></option>
																			<?endforeach?>
																		</select>
																	</div>
																</div>					
															</div>
															<div class="jsTabsTab">
																<div class="onetabs_tab">
																	<div class="input_text_label input_text_label_mr">
																		Название <input type="text" class="input_text" name="statusname" value="<?=$status['name']?>">
																	</div>
																	<div class="input_text_label input_text_label_mr">
																		Скидка <input type="text" class="input_text" name="statussale" value="<?=$status['sale']?>">
																	</div>										
																	<div class="input_text_label input_text_label_mr">
																		Бонус <input type="text" class="input_text" name="statusbonus" value="<?=$status['bonus']?>">
																	</div>
																	<div class="input_text_label input_text_label_mr">
																		Реферал <input type="text" class="input_text" name="statusref" value="<?=$status['ref']?>">
																	</div>
																	<div class="input_text_label input_text_label_mr">
																		Основание <input type="text" class="input_text" name="statusreason" value="<?=$status['reason']?>">
																	</div>
																</div>		
															</div>
														</section>
														<input type="hidden" class="jsTabsValue" value="0">
													</div>
													<?elseif($item['type']=='password'):?>
													<div class="input_text_holder">
														<input type="text" name="<?=$path?>" class="input_text" id="<?=$path?>" value="">
													</div>
													<a onclick="generatePass('<?=$path?>'); return false;">Сгенерировать</a>
													<?endif?>
												</div>
											</td>
										</tr>
									<?endforeach?>
									<?if(!empty($groups)):?>
										<tr>
											<td>Группы</td>
											<td>
												<ul class="edit_form_multiselect">
												<select name="igroup">
													<option></option>
													<?foreach($groups as $item):?>
														<option value="<?=$item['id']?>" <?if($item['id']==$iuser['igroup']):?>selected<?endif?>><?=$item['name']?></option>
													<?endforeach?>
												</select>
												</ul>
											</td>
										</tr>
									<?endif?>
									<tr>
										<td>Добавить Файлы</td>
										<td>
											<?if(is_array($iuser['files'])):?>
												<?foreach($iuser['files'] as $item):?>
													<div id="file<?=$item['id']?>">
														<a href="<?=$item['path']?>"><?=$item['name']?></a>
														<span class="icon_remove" onclick="delFile('file<?=$item['id']?>'); return false;"></span>
														<input type="hidden" name="fileIds[]" value="<?=$item['id']?>" />
													</div>
												<?endforeach?>
											<?endif?>
											<div id="uploadfiles"></div>
											<a class="button-white" onclick="addFile(); return false;">+ добавить файл</a>
										</td>
									</tr>
									<?foreach(OneSSA::$iuserStandartAdds as $title=>$items):?>
										<tr>
											<td colspan="2"><strong><?=$title?></strong></td>
										</tr>
										<?foreach($items as $path=>$item):?>
											<tr>
												<td><?=$item['name']?></td>
												<td>
													<?if($item['type']=='string' || $item['type']=='integer'):?>
														<?if($item['main']==1):?>
															<?=$iuser[$path]?>
														<?else:?>
														<div class="input_text_holder">
															<input type="text" name="<?=$path?>" class="input_text <?if($item['required']==1):?>required<?endif?>" value="<?=$iuser[$path]?>" <?if($item['unique']==1):?>onchange="checkUnique('<?=$path?>')"<?endif?>>
															<?if($item['unique']==1):?><span id="<?=$path?>" class="error" style="color:#FF0000;display:none;">Значение не уникальное</span><?endif?>
														</div>
														<?endif?>
													<?elseif($item['type']=='date'):?>
														<div class="widget_time input_text_holder"><input type="text" class="input_text <?if($item['required']==1):?>required<?endif?>" name="<?=$path?>" value="<?=$iuser[$path]?>" name="<?=$path?>"></div>
													<?elseif($item['type']=='text'):?>
														<div class="input_text_holder">
															<textarea name="<?=$path?>" class="input_text"><?=$iuser[$path]?></textarea>
														</div>
													<?elseif($item['type']=='bool'):?>
														<label><input type="radio" name="<?=$path?>" id="<?=$path?>" value="1" <?if($iuser[$path]==1):?>checked<?endif?> /> Да</label> 
														<label><input type="radio" name="<?=$path?>" id="<?=$path?>" value="0" <?if($iuser[$path]!=1):?>checked<?endif?> /> Нет</label>
													<?elseif($item['type']=='select'):?>
														<select name="<?=$path?>">
															<option value=""></option>
															<?foreach(Funcs::$regions as $region):?>
																<option value="<?=$region['name']?>" <?if($region['name']==$iuser[$path]):?>selected<?endif?>><?=$region['name']?></option>
															<?endforeach?>
														</select>
													<?endif?>
												</td>
											</tr>
										<?endforeach?>
									<?endforeach?>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$iuser['id']?>" />
					<span class="button button_save" onclick="checkForm()">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function generatePass(name){
		var obj=$('#'+name);
		$.ajax({
			type: "GET",
			url: "/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/generatepass/",
			data: "id=0",
			success: function(msg){
				obj.val(msg);
			}
		});
	}
	function checkUnique(name){
		var obj=$('#'+name);
		var value=$('[name='+name+']').val();
		var id=$('[name=id]').val();
		$.ajax({
			type: "POST",
			url: "/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/checkfield/",
			data: "name="+name+"&value="+value+"&id="+id,
			success: function(msg){
				if(msg){
					obj.show();
				}else{
					obj.hide();
				}
			}
		});
	}
	function checkForm(){
		var f=0;
		$('#frm .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','solid 1px red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		$('#frm .error').each(function(){
			if (jQuery.trim($(this).val())!=''){
				f=1;
			}
		});
		if(f==1){
			 return false;
		}else{
			$('#frm').submit();
		}
	}
	var idFileInc=0;
	function addFile(){
		$('#uploadfiles').append('<div id="ifi'+idFileInc+'" class="rounded_inline-block"><span class="button-white" onClick="$(this).next().click();">Выбрать файл</span><input onChange="$(this).prev().text($(this).val())" class="input_file" type="file" name="upload[]" /><input class="input_text" type="text" name="filename[]" /> <span title="Удалить" class="icon_x" onclick="delFileInput('+idFileInc+')"></span></div>');
		idFileInc++;;
		resizeContent();
	}	
	function delFileInput(id){
		$('#ifi'+id).detach();
		resizeContent();
	}
	function delFile(id){
		$('#'+id).detach();
		resizeContent();
	}
</script>