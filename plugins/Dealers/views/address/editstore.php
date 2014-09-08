<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/stores/?id=<?=$dealer['id']?>"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Адрес</h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="title" value="<?=$data['title']?>"></div></td>
									</tr>
									<tr>
										<td>Статус</td>
										<td><div class="input_text_holder">
											<select name="status" class="input_text required">
												<option value="0"></option>
												<?foreach($statuses as $item):?>
													<option value="<?=$item['id']?>" <?if($data['status']==$item['id']):?> selected <?endif?> ><?=$item['name']?></option>
												<?endforeach?>
											</select>
										</div></td>
									</tr>
									<tr>
										<td>Регион</td>
										<td><div class="input_text_holder">
											<select name="region" class="input_text required">
												<?foreach($regions as $item):?>
													<option value="<?=$item['id']?>"
														<?if($item['id']==$data['region']):?>selected<?endif?>
													><?=$item['name']?></option>
												<?endforeach?>
											</select>
										</div></td>
									</tr>
									<tr>
										<td>Город</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="city" value="<?=$data['city']?>"></div></td>
									</tr>
									<tr>
										<td>Улица</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="street" value="<?=$data['street']?>"></div></td>
									</tr>
									<tr>
										<td>Дом</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="house" value="<?=$data['house']?>"></div></td>
									</tr>
									<tr>
										<td>Время работы</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="work_time" value="<?=$data['work_time']?>"></div></td>
									</tr>
									<tr>
										<td>Телефон</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="phone" value="<?=$data['phone']?>"></div></td>
									</tr>
									<tr>
										<td>Email</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="email" value="<?=$data['email']?>"></div></td>
									</tr>
									<tr>
										<td>Контактное лицо</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="contact" value="<?=$data['contact']?>"></div></td>
									</tr>
									<tr>
										<td>Телефон Контактного лица</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="contact_phone" value="<?=$data['contact_phone']?>"></div></td>
									</tr>
									<tr>
										<td>Описание</td>
										<td><div class="input_text_holder"><textarea type="text" class="input_text" name="comment"><?=$data['comment']?></textarea></div></td>
									</tr>
									<tr>
										<td>фото</td>
										<td><!--div class="input_text_holder"-->
											<?if(is_array($data['files'])):?>
												<?foreach($data['files'] as $item):?>
													<div id="file<?=$item['id']?>">
														<a href="<?=$item['path']?>"><?=$item['name']?></a><br>
														<img src='/of/6<?=$item['path']?>'>
														<span class="icon_remove" onclick="delFile('file<?=$item['id']?>'); return false;"></span>
														<input type="hidden" name="fileIds[]" value="<?=$item['id']?>" />
													</div>
												<?endforeach?>
											<?endif?>
											<div id="uploadfiles"></div>
											<a class="button-white" onclick="addFile(); return false;">+ добавить файл</a>
										<!--/div--></td>
									</tr>									
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$data['id']?>" />
					<input type="hidden" name="dealer" value="<?=$dealer['id']?>" />
					<span class="button button_save" onclick="checkForm();">Сохранить</span>
				</div>
			</div>
		</div>
	</form>
</div>
<script>


	$(document).ready( function(){
		( function(){
			var moscow = $("#register_moscow");
			var other = $("#register_other-city");
			var region  = $("#register_region");
			var region_select = $("#register_region_select");
			var city = $("#register_city");
			/*											
			other.on( "click", function(){
				region.fadeIn(400, "easeInOutQuart");
			});
			moscow.on( "click", function(){
				region.fadeOut(400, "easeInOutQuart");
				city.fadeOut(400, "easeInOutQuart");
			});
			*/
			region_select.on( "change", function(){
				getCities($(this).find('option:selected').val(),'register_city_div','');
				city.fadeIn(400, "easeInOutQuart");
			});
		})();										
	});
	function getCities(regionId,objId,city){
		var obj=$('#'+objId);
		$.ajax({
			type: "POST",
			url: "/onemfssa/dealers/getcities/",
			data: "id="+regionId+"&city="+city,
			success: function(msg){
				obj.html(msg);
			}
		});
	}
	function checkForm(){
		var f=0;
		$('#frm .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','1px solid red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		if (f==1){
			return false;
		}else{
			$('#frm').submit();
		}
	}
			$(document).ready(function(){
			getCities($("#register_region_select").find('option:selected').val(),'register_city_div','Курск');
		});
		
	var idFileInc=0;
	function addFile(){
		$('#uploadfiles').append('<div id="ifi'+idFileInc+'" class="upload_file_block"><span class="button-white" onClick="$(this).next().click();">Выбрать файл</span><input onChange="$(this).prev().text($(this).val())" class="input_file" type="file" name="upload[]" /><input class="input_text" type="text" name="filename[]" /> <span title="Удалить" class="icon_x" onclick="delFileInput('+idFileInc+')"></span></div>');
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
