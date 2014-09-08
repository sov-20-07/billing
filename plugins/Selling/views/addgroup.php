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
								<h1 class="cell_page-content_header_text">Группы</h1>
							</div>
						</div>
						<div class="ltRow">
							<div class="ltCell cell_page-content_header">
								<?if(count($groups)>0):?>
									<ol>
									<?foreach($groups as $item):?>
										<li>
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/editgroup/?id=<?=$item['id']?>"><?=$item['name']?> (<?=$item['path']?>)</a>
											<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdelgroup/?id=<?=$item['id']?>" style="color:#FF0000" onclick="return confirm('Удалить группу?')" title="Удалить">[X]</a>
										</li>
									<?endforeach?>
									</ol>
								<?else:?>
									Группы не созданы
								<?endif?>
							</div>
						</div>
						<ul class="edit_form_layout jsMoveContainerLI">
							<li class="edit_form_section jsMoveFixed">
								<table class="edit_form_table">
									<tr>
										<td>Название</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="name" value="<?=$group['name']?>"></div></td>
									</tr>
									<tr>
										<td>Ключ</td>
										<td><div class="input_text_holder"><input type="text" class="input_text required" name="path" value="<?=$group['path']?>"></div></td>
									</tr>
								</table>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="ltRow">
				<div class="edit_footer">
					<input type="hidden" name="id" value="<?=$group['id']?>" />
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





<!--h3>Группы</h3>
<?if(count($groups)>0):?>
	<ol>
	<?foreach($groups as $item):?>
		<li>
			<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/editgroup/?id=<?=$item['id']?>"><?=$item['name']?> (<?=$item['path']?>)</a>
			<a href="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/actdelgroup/?id=<?=$item['id']?>" style="color:#FF0000" onclick="return confirm('Удалить группу?')" title="Удалить">[X]</a>
		</li>
	<?endforeach?>
	</ol>
<?else:?>
	Группы не созданы
<?endif?>
<h3><?=$title?></h3>
<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
	<div class="error"></div>
	<div id="frm">
		<div id="slider0" class="slider">
			<table id="workingset" width="100%">
				<tbody>
					<tr>
						<td class="form_param">Название</td>
						<td class="form_field">
							<input type="text" name="name" class="text required" value="<?=$group['name']?>" />
						</td>
					</tr>
					<tr>
						<td class="form_param">Ключ</td>
						<td class="form_field">
							<input type="text" name="path" class="text required" value="<?=$group['path']?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<br />
	<input type="hidden" name="id" value="<?=$group['id']?>" />
	<center><input type="button" onclick="checkForm()" class="button save" value="Сохранить"></center>
	<br />
	<script>
		function checkForm(){
			var f=0;
			$('#frm .required').each(function(){
				if(jQuery.trim($(this).val())==''){
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
	</script>
</form>
<br /><br /><br /><br /-->