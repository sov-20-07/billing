<div class="popup">
	<div class="head">Заказ спецпредложения</div>
	<div class="form_padds">
		<div class="is_light">Укажите Ваши имя и номер телефона, и наши сотрудники свяжутся с Вами в ближайшее время</div>
		<form class="call_me" action='/popup/sendcallback/' method="post" id="callbackform" onsubmit="return checkForm();">
			<table>
				<col width="128"><col>
				<tr>
					<td class="inp_param">Контактное лицо *</td>
					<td><input type="text" class="text" name="name"/></td>
				</tr>
				<tr>
					<td class="inp_param">Номер телефона *</td>
					<td><input type="text" class="text required" name="phone" /></td>
				</tr>
				<tr>
					<td class="inp_param">Email</td>
					<td><input type="text" class="text required" name="email" /></td>
				</tr>
			</table>
			<label class="i_agree"><input type="checkbox" onchange="if($(this).attr('checked')=='checked'){$('#sbmt1').attr('disabled',false)}else{$('#sbmt1').attr('disabled',true)}" />Я соглашаюсь на хранение и обработку моих персональных данных, необходимых для выполнения заказов</label><br />
			<div class="button_block"><input type="submit" value="Отправить" class="send_button" id="sbmt1" disabled /></div>
		</form>
		<script>
			function checkForm(){
				var f=0;
				$('#callbackform .required').each(function(){
					if (jQuery.trim($(this).val())==''){
						$(this).css('border','solid 1px red');
						f=1;
					}else{
						$(this).css('border','');
					}
				});
				if (f==1){
					 return false;
				}else return true;
			}
		</script>
	</div>
</div>