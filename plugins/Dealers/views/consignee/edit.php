<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/listcons/?id=<?=$dealer['id']?>"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Карточка Грузополучателя</h1>
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
										<td>Получатель</td>
										<td>
											<div class="input_text_holder">
												<input type="radio" name="form" id="yur" value="1" <?if(intval($data['form'])>0):?>checked<?endif?>>
												<label for="yur">Юридическое лицо</label>
											</div>	
											<div class="input_text_holder">
												<input type="radio" name="form" id="fiz" value="0" <?if(intval($data['form'])==0):?>checked<?endif?>>
												<label for="fiz">Физическое лицо</label>
											</div>
										</td>
									</tr>
									<tr>
										<td>Юридическое лицо</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="company" value="<?=$data['company']?>"></div></td>
									</tr>
									<tr>
										<td>Адрес</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="address" value="<?=$data['address']?>"></div></td>
									</tr>
									<tr>
										<td>Телефон</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="phone" value="<?=$data['phone']?>"></div></td>
									</tr>
									<tr>
										<td>ФИО</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="name" value="<?=$data['name']?>"></div></td>
									</tr>
									<tr>
										<td>Мобильный Телефон</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="mobile" value="<?=$data['mobile']?>"></div></td>
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
</script>
