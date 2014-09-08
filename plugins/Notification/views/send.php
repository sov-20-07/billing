<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?if($parent!=0):?><?=$parent?>/<?endif?>"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Рассылка</h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Тема</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="subject" value="<?=$subject?>"></div></td>
									</tr>
									<tr>
										<td colspan="2">
											Текст</br>
											<textarea name="body" id="editor" <?if($type=='text'):?>disabled<?endif?>><?=$body?></textarea>
											<script language="javascript">
												$(document).ready( function(){	
													initEditor($("#editor"));
												});
											</script>
										</td>
									</tr>
									<tr>
										<td>Отправить</td>
										<td>
											<ul class="edit_form_multiselect">
												<?foreach(Notification::$emaillist as $name=>$item):?>
												<li>												
													<label class="form_label jsPreviewToggle">
														<input type="checkbox" value="<?=$name?>" name="users[]"><span class="form_label_text"><?=$item?></span>
													</label>
												</li>
												<?endforeach?>
												<?foreach($groups as $k=>$v):?>
													<li>
														<label class="form_label jsPreviewToggle">
															<input type="checkbox" value="<?=$v['id']?>" name="users[]"><span class="form_label_text"><?=$v['name']?></span>
														</label>
													</li>
												<?endforeach?>
											</ul>
										</td>
									</tr>
									<tr>
										<td>Добавочные email адреса</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="email" value="<?=$email?>"></div></td>
									</tr>
									<tr>
										<td>Email отправителя</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="emailfrom" value="<?=$emailfrom?>"></div></td>
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
					<input type="hidden" name="parent" value="<?=$parent?>" />
					<span class="button button_save" onclick="$('#frm').submit()">Отправить</span>
				</div>
			</div>
		</div>
	</form>
</div>