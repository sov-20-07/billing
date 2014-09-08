<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/reference/<?if($parent!=0):?><?=$parent?>/<?endif?>"></a>
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
									<tr>
										<td>Сменить родителя</td>
										<td>
											<select name="parent" class="select_wide-tree">
											<option value="0" <?if($_GET['parent']==0):?>selected<?endif?>>Корень</option>
											<?foreach($tree as $item):?>
												<option value="<?=$item['id']?>" <?if($_GET['parent']==$item['id']):?>selected<?endif?>><?=str_repeat('&nbsp;',3)?><?=$item['name']?></option>
												<?if(count($item['sub'])>0):?>
													<?=View::getRenderEmpty('fields/parentbranch',array('tree'=>$item['sub'],'left'=>2))?>
												<?endif?>
											<?endforeach?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=$name?>"></div></td>
									</tr>
									<tr>
										<td>Алиас</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="path" value="<?=$path?>"></div></td>
									</tr>
									<tr>
										<td>
											<label><input type="radio" name="type" value="text" <?if($type=='text' || $type==''):?>checked<?endif?>> текст</label><br><br>
											<label><input type="radio" name="type" value="editor" <?if($type=='editor'):?>checked<?endif?>> редактор</label>
										</td>
										<td <?if($type=='editor'):?>style="display:none;"<?endif?> class="texted">
											<div class="input_text_holder"><textarea class="input_text" name="text"><?=$value?></textarea></div>
										</td>
										<td <?if($type=='text' || $type==''):?>style="display:none;"<?endif?> class="editored">
											<textarea name="editor" id="editor"><?=$value?></textarea>
											<script language="javascript">
												$(document).ready( function(){	
													initEditor($("#editor"));
													$('.iradio').on('ifChecked',function(){
														if($(this).find('input').val()=='editor'){
															$('.texted').hide().find('textarea').prop('disabled',true);$('.editored').show();
														}else{
															$('.editored').hide().prop('disabled',true);$('.texted').show().find('textarea').prop('disabled',false);
														}
													});
												});
											</script>
										</td>
									</tr>
									<tr>
										<td>Добавить файлы</td>
										<td>
											<?if(is_array($files)):?>
												<?foreach($files as $item):?>
													<div id="file<?=$item['id']?>">
														<?if($item['info']['type']=='image'):?>
															<a href="<?=$item['path']?>" target="_blank"><img src="/of/<?=$item['path']?>?h=30&w=30" title="<?=$item['name']?>"></a>
														<?else:?>
															<a href="<?=$item['path']?>" target="_blank"><?=$item['name']?></a>
														<?endif?>
														<span class="icon_remove" onclick="delFile('file<?=$item['id']?>'); return false;"></span>
														<input type="hidden" name="fileIds[]" value="<?=$item['id']?>" />
													</div>
												<?endforeach?>
											<?endif?>
											<div id="uploadfiles"></div>
											<a class="button-white" onclick="addFile(); return false;">+ добавить файл</a>
										</td>
									</tr>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$id?>" />
					<?/*?><input type="hidden" name="parent" value="<?=$parent?>" /><?*/?>
					<span class="button button_save" onclick="$('#frm').submit()">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	var idFileInc=0;
	function addFile(){
		$('#uploadfiles').append('<div id="ifi'+idFileInc+'" class="rounded_inline-block"><span class="button-white" onClick="$(this).next().click();">Выбрать файл</span><input onChange="$(this).prev().text($(this).val())" class="input_file" type="file" name="upload[]" style="display:none" /><input class="input_text" type="text" name="filename[]" /> <span title="Удалить" class="icon_x" onclick="delFileInput('+idFileInc+')"></span></div>');
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
