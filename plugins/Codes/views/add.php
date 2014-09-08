<div class="ltCell cell_page-content sizeParent">
	<form enctype="multipart/form-data" method="post" id="frm">
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
										<td>Название</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text required" name="name" value="<?=$name?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Дата от</td>
										<td><div class="widget_time input_text_holder"><input type="text" class="input_text" value="<?=date('d.m.Y H:i',strtotime($row['fromdate']))?>" name="fromdate"></div></td>
									</tr>
									<tr>
										<td>Дата до</td>
										<td><div class="widget_time input_text_holder"><input type="text" class="input_text" value="<?=date('d.m.Y H:i',strtotime($row['todate']))?>" name="todate"></div></td>
									</tr>
									<tr>
										<td>Тип</td>
										<td>
											<select name="type" id="type" onchange="selectType()">
												<option></option>
												<?foreach(Codes::$type as $key=>$item):?>
													<option value="<?=$key?>" <?if($key==$ctype):?>selected<?endif?>><?=$item?></option>
												<?endforeach?>
											</select>
										</td>
									</tr>
									<tr>
										<td>Множественное использование</td>
										<td>
											<div class="form_label">
												<input type="hidden" name="multiple" value="0">
												<input type="checkbox" id="multiple" name="multiple" value="1" <?if($num>0):?>checked<?endif?>>
											</div>
										</td>
									</tr>
									<tr id="code" style="">
										<td>Код</td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text" name="code" value="<?=$code?>">
											</div>
										</td>
									</tr>
									<tr id="one" style="display:none">
										<td id="name"></td>
										<td>
											<div class="input_text_holder">
												<input id="inputText"  type="text" class="input_text" disabled name="value" value="<?=$value?>">
											</div>
										</td>
									</tr>
									<tr id="select" style="display:none">
										<td>Промо-код на статус</td>
										<td>
											<select id="inputSelect" name="value" disabled>
												<?foreach(Iuser::getStatusList() as $item):?>
													<option value="<?=$item['id']?>" <?if($item['id']==$value):?>selected<?endif?>><?=$item['name']?></option>
												<?endforeach?>
											</select>
										</td>
									</tr>
									<tr>
										<td><?if(Funcs::$uri[2]=='edit' && $ctype!='sales'):?>Добавить кодов<?else:?>Количество<?endif?></td>
										<td>
											<div class="input_text_holder">
												<input type="text" class="input_text required" name="num" value="<?=$num?>">
											</div>
										</td>
									</tr>
									<tr>
										<td>Комментарий</td>
										<td>
											<div class="input_text_holder">
												<textarea class="input_text" name="comment"><?=$comment?></textarea>
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
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function selectType(){
		var type=$('#type option:selected').val();
		if(type=='status'){
			$('#one').hide();
			$('#select').show();
			$('#inputSelect').prop('disabled',false);
			$('#inputText').prop('disabled',true);
		}else if(type!='status' && type!=''){
			$('#name').text($('#type option:selected').text());
			$('#select').hide();
			$('#one').show();
			$('#inputText').prop('disabled',false);
			$('#inputSelect').prop('disabled',true);
		}
		if($('#multiple').prop('checked')){
			$('#code').show();
		}else{
			$('#code').hide();
		}
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
		if(f==1){
			 return false;
		}else{
			$('#frm').submit();
		}
	}
	$(document).ready(function(){
		selectType();
		$('#multiple').next().click(function(){
			selectType();
		});
	});
</script>