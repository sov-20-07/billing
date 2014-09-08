<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/module/<?=$path?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/module/fieldlist/?module=<?=$_GET['module']?>"></a>
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
										<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=$field['name']?>"></div></td>
									</tr>
									<tr>
										<td>Алиас</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="path" value="<?=$field['path']?>"></div></td>
									</tr>
									<tr>
										<td>Тип поля</td>
										<td>
											<select class="jsSelectStyled" name="type">
												<option value=" "></option>
												<?foreach(Fields::$types as $item):?>
													<option value="<?=$item['path']?>" <?if($field['type']==$item['path']):?>selected<?endif?>><?=$item['name']?> (<?=$item['path']?>)</option>
												<?endforeach?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Параметры</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="params" value="<?=$field['params']?>"></div></td>
									</tr>
									<tr>
										<td>Обязательное</td>
										<td>
											<label class="form_label">
												<input class="sethere" type="hidden" name="required" value="0">
												<input class="sethere" type="checkbox" name="required" value="1" <?if($field['required']=='1'):?>checked<?endif?>>
											</label>
										</td>
									</tr>
								</table>
							</li>
						</ul>
						<div style="background: #f9dcc7;padding: 10px;">
							<strong>Информация</strong><br>
							Поле select - module-id-name (Алиас модуля - Поле значение - Поле название)<br />
							Поле select - module-category-id-name (Алиас модуля - Категория - Поле значение - Поле название)<br />
							Поле multiselect - module-name (Алиас модуля - Поле название) * поле id всегда<br />
							Поле multiselect - module-category-name (Алиас модуля - Категория - Поле значение - Поле название)  * поле id всегда<br />
						</div>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="outerf" value="1">
					<input type="hidden" name="innerf" value="1">
					<input type="hidden" name="id" value="<?=$field['id']?>" />
					<input type="hidden" name="module" value="<?=$_GET['module']?>" />
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