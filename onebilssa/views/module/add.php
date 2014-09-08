<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/module/<?=$path?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/module/"></a>
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
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=$item['name']?>"></div></td>
									</tr>
									<tr>
										<td>Алиас</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="path" value="<?=$item['path']?>"></div></td>
									</tr>
									<tr>
										<td>Тип модуля</td>
										<td>
											<select class="jsSelectStyled" name="type">
												<option value="" <?if($item['type']==''):?>selected<?endif?>></option>
												<option value="spage" <?if($item['type']=='spage'):?>selected<?endif?>>Страницы</option>
												<option value="epage" <?if($item['type']=='epage'):?>selected<?endif?>>Элементы</option>
												<option value="cat" <?if($item['type']=='cat'):?>selected<?endif?>>Каталог</option>
												<?if(Funcs::$uri[2]=='showedit'):?>
													<option value="struct" <?if($item['type']=='struct'):?>selected<?endif?>>Каталог разделы</option>
												<?endif?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Дополнительно</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="params" value="<?=$item['params']?>"></div></td>
									</tr>
									<tr>
										<td>Поведение каталога</td>
										<td>
											<select class="jsSelectStyled" name="moduleCatalog">
												<option value="0"></option>
												<?foreach($modules as $module):?>
													<option value="<?=$module['id']?>" <?if($item['catalog']==$module['id']):?>selected<?endif?>><?=$module['name']?></option>
												<?endforeach?>
											</select>
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
					<input type="hidden" name="id" value="<?=$item['id']?>" />
					<span class="button button_save" onclick="checkform();">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function checkform(o){
		var f=0
		$('#frm input:text').each(function(){
			if($(this).attr('name')=='name' || $(this).attr('name')=='path'){
				if (jQuery.trim($(this).val())==''){
					$(this).css('border','solid 1px red');
					f=1;
				}else{
					$(this).css('border','');
				}
			}
		});
		if (f==1){
			$('.error').text('Не все поля заполнены');
			 return false;
		}else{
			$('#frm').submit();
		}
	}
</script>