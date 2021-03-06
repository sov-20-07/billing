<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/files/?id=<?=$dealer['id']?>"></a>
				</div>
				<div class="jsScrollWrapper">
					<div class="jsScroll whiteOverflow edit_container">
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<h1 class="cell_page-content_header_text">Файл <?=$data['name']?></h1>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="filename[]" value="<?=$data['name']?>"></div>
										</td>
									</tr>
									<tr>
										<td>Комментарий</td>
										<td><div class="input_text_holder">
											<textarea class="input_text required" name="comment"><?=$data['comment']?></textarea></div></td>
									</tr>
									<tr>
										<td>Файл</td>
										<td>
											<?if(isset($data['path'])):?>
												<a href="/get<?=$data['path']?>">Скачать (<?=basename($data['path'])?>)</a>
												<div class="input_text_holder"><input type="file" class="input_text" name="upload[]"></div>
											<?else:?>
												<div class="input_text_holder"><input type="file" class="input_text required" name="upload[]"></div>
											<?endif?>
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
