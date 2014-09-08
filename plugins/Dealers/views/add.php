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
									<tr>
										<td>Название *</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text required" name="company" value="<?=$company?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Статус</td>
										<td>
											<div class="input_text_holder">
											<select name="status" class="input_text">
												<option></option>
												
												<?foreach($statuses as $item):?>
												
													<option value="<?=$item['id']?>"<?if($item['id']==$status):?>selected<?endif?>><?=$item['name']?></option>
												<?endforeach?>												
											</select>
											</вшм>
										</td>
									</tr>
									<tr>
										<td>ФИО *</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text required" name="name" value="<?=$name?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Должность</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" name="job" value="<?=$job?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Телефон *</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text required" name="phone" value="<?=$phone?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Email (он же логин администратора) *</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text required" name="email" value="<?=$email?>" onchange="checkUnique('email')">
												<span id="email" class="error" style="color:#FF0000;display:none;">Значение не уникальное</span>
											</div>
										</td>
									</tr>
									<tr>
										<td>Пароль администратора</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" id="pass" name="pass" value="">
												<span class="pseudo" onclick="generatePass('pass')">Сгенерировать</span>
											</div>
										</td>
									</tr>
									<tr>
										<td>Логин менеджера</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text required" name="manager" value="<?=$manager?>" onchange="checkUnique('manager')">
												<span id="manager" class="error" style="color:#FF0000;display:none;">Значение не уникальное</span>
											</div>
										</td>
									</tr>
									<tr>
										<td>Пароль менеджера</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" id="passman" name="passman" value="">
												<span class="pseudo" onclick="generatePass('passman')">Сгенерировать</span>
											</div>
										</td>
									</tr>
									<tr>
										<td>Email уведомлений (можно много через ",")</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" name="emailreport" value="<?=$emailreport?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Город</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" name="city" value="<?=$city?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Аватар</td>
										<td>
											<img src="/of/10<?=UPLOAD_DIR.'images/dealers_avatar/'.$id?>.png">
											<div class="input_text_holder"><input type="file" class="input_text" name="avatar" value="">
											<label><input type="checkbox" name="delete_avatar" value="kill"> Удалить Аватар</label>
											</div></td>
									</tr>									
									<tr>
										<td>Бренды</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" name="brands" value="<?=$brands?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Комментарий администратора</td>
										<td>
											<div class="input_text_holder">
												<textarea class="input_text" name="comment"><?=$comment?></textarea>
											</div>
										</td>
									</tr>
									<tr>
										<td>Код</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" name="code" value="<?=$code?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Начисление %</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" name="balance" value="<?=$balance?>">
											</div>
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
					<span class="button button_save" onclick="checkForm()">Сохранить</span>
					<?if(intval($id)>0):?>
						<a href="/onemfssa/dealers/files/?id=<?=$id?>" class="button" style="float:right;">Файлы</a>
						<a href="/onemfssa/dealers/balance/?id=<?=$id?>" class="button" style="float:right;">Баланс</a>
						<a href="/onemfssa/dealers/orders/?id=<?=$id?>" class="button" style="float:right;">Заказы</a>
						<a href="/onemfssa/dealers/listcons/?id=<?=$id?>" class="button" style="float:right;">КГП</a>
						<a href="/onemfssa/dealers/stores/?id=<?=$id?>" class="button" style="float:right;">Магазины</a>
					<?endif?>
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
		$('#uploadfiles').append('<span id="ifi'+idFileInc+'" ><input type="file" name="upload[]" /> <input type="text" name="filename[]" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span onclick="delFileInput('+idFileInc+')" class="pseudo">[X]</span><br /></span>');
		idFileInc++;
	}	
	function delFileInput(id){
		$('#ifi'+id).detach();
	}
	function delFile(id){
		$('#'+id).detach();
	}
</script>
