<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
		<div class="ltContainer ltFullWidth sizeChild">
			<div class="ltRow jsScrollContainer">
				<div class="link_step_back_holder">
					<a class="link_step_back" href="/<?=Funcs::$cdir?>/control/<?if($_GET['parent']):?><?=$_GET['parent']?>/<?elseif($site['parent']):?><?=$site['parent']?>/<?endif?>"></a>
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
										<td>Группа</td>
										<td>
											<select class="jsSelectStyled" name="parent">
												<option value="0"></option>
												<?foreach($groups as $item):?>
													<option value="<?=$item['id']?>" <?if($_GET['parent']==$item['id'] || $site['parent']==$item['id']):?>selected<?endif?>><?=$item['name']?></option>
												<?endforeach?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="name" value="<?=$site['name']?>"></div></td>
									</tr>
									<tr>
										<td>URL</td>
										<td><div class="input_text_holder"><input type="text" class="input_text" name="domain" value="<?=$site['domain']?>"></div></td>
									</tr>
									<tr>
										<td>Язык</td>
										<td>
											<select class="jsSelectStyled" name="lang">
												<?foreach($lang as $item):?>
													<option value="<?=$item['id']?>" <?if($site['lang']==$item['id']):?>selected<?endif?>><?=$item['name']?></option>
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
					<input type="hidden" name="id" value="<?=$site['id']?>">
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