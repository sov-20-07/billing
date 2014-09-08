<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$_GET['form']?>"></a>
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
										<td>Поле (name)</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="path" value="<?=$field['path']?>"></div></td>
									</tr>
									<tr>
										<td>Тип</td>
										<td>
											<select class="jsSelectStyled" name="type">
												<?foreach(Forms::$fieldsStandart as $key=>$item):?>
													<option value="<?=$key?>" <?if($field['type']==$key):?>selected<?endif?>><?=$item?></option>
												<?endforeach?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Параметры</td>
										<td>
											<div class="ckeditor_layout">
												<div class="input_text_holder"><textarea class="input_text sethere" name="options"><?=$field['options']?></textarea></div>
											</div>
										</td>
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
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="form" value="<?=$form?>" />
					<input type="hidden" name="id" value="<?=$field['id']?>" />
					<span class="button button_save" onclick="$('#frm').submit()">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>