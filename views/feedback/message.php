<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<?if(isset($_GET['done'])):?>
			<p>Сообщение успешно отправлено!</p>
			<p>Наши специалисты свяжутся с вами в ближайшее время</p>
		<?else:?>
			<form action="" id="frm" method="post" enctype="multipart/form-data">
				<div class="inp" style="padding:3px; background-color:#c97383; color:#fff; display:none" id="error"></div>
				<table class="form_tab" width="100%"> 
					<col width="155"><col>
					<tr>
						<td>ФИО<sup>*</sup></td>
						<td><input type="text" name="fio" value="" class="inp required" /></td>
					</tr>
					<tr>
						<td>Ваш телефон<sup>*</sup></td>
						<td><input type="text" name="tel" value="" class="inp required" /></td>
					</tr>
					<tr>
						<td>Ваш email<sup>*</sup></td>
						<td><input type="text" name="email" value="" class="inp required" /></td>
					</tr>
					<tr>
						<td>Тема<sup>*</sup></td>
						<td><input type="text" name="theme" value="" class="inp required" /></td>
					</tr>
					<tr>
						<td>Сообщение<sup>*</sup></td>
						<td><textarea class="inp required" type="text" name="quest" cols="50" rows="10"></textarea></td>
					</tr>
					<tr>
						<td colspan="2"><label><input type="checkbox" style="width:auto" name="agree" id="agree" />&nbsp;Я соглашаюсь на хранение и обработку моих персональных данных, необходимых для выполнения обратной связи</label></td>
					</tr>
					<tr>
						<td align="right" colspan="2"><span onclick="if($('#agree').prop('checked')==true){return checkForm();}else{return false;}" class="is_button right_top_corner">отправить<span></span></span></td>
					</tr>
				</table>
			</form>
			<script>
				<?if($_POST):?>alert('Ошибка ввода символов с картинки');<?endif?>
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
					if (f==1){
						return false;
					}else {
						$('#frm').submit()
					}
				}
			</script>
		<?endif?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>