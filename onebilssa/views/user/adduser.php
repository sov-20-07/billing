<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/user/user/"></a>
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
										<td>Имя</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=$user['name']?>"></div></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="email" value="<?=$user['email']?>"></div></td>
									</tr>
									<tr>
										<td>Телефон</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="phone" value="<?=$user['phone']?>"></div></td>
									</tr>
									<tr>
										<td>Логин</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="login" value="<?=$user['login']?>"></div></td>
									</tr>
									<tr>
										<td>Пароль</td>
										<td><div class="input_text_holder"><input type="password" class="input_text" name="pass" autocomplete="off"></div></td>
									</tr>
									<tr>
										<td>Группы</td>
										<td>
											<ul class="edit_form_multiselect">
											<?foreach($groups as $path=>$item):?>
												<li>
													<label class="form_label jsPreviewToggle">
														<input type="checkbox" name="groups[]" value="<?=$item['id']?>" <?if(in_array($item['id'],$user['groups'])):?>checked<?endif?>><span class="form_label_text"><?=$item['name']?></span>
													</label>
												</li>
											<?endforeach?>
											</ul>
										</td>
									</tr>
									<tr>
										<td>Доступ к модулям</td>
										<td>
											<ul class="edit_form_multiselect">
											<?foreach($modules as $path=>$item):?>
												<?if($item['name']):?>
													<li>
														<label class="form_label jsPreviewToggle">
															<input type="checkbox" name="modules[]" value="<?=$path?>" <?if(in_array($path,$user['access']['modules'])):?>checked<?endif?>><span class="form_label_text"><?=$item['name']?></span>
														</label>
													</li>
												<?endif?>
											<?endforeach?>
											</ul>
										</td>
									</tr>
									<tr>
										<td>Доступ к дереву</td>
										<td>
											<ul class="edit_form_multiselect">
											<?foreach($tree as $item):?>
												<li>
													<label class="form_label jsPreviewToggle" style="margin-left: <?=$item['left']*10?>px;">
														<input type="checkbox" name="tree[]" value="<?=$item['id']?>" <?if(in_array($item['id'],$user['access']['tree'])):?>checked<?endif?>><span class="form_label_text"><?=$item['name']?></span>
													</label>
													<?if(count($item['sub'])>0):?>
														<?=View::getRenderEmpty('user/labeltree',array('tree'=>$item['sub'],'left'=>1,'user'=>$user))?>
													<?endif?>
												</li>
											<?endforeach?>
											</ul>
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
					<input type="hidden" name="id" value="<?=$user['id']?>" />
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
			if($(this).attr('name')=='login'){
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