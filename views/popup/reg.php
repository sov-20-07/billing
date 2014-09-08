<div class="head2 nopadding">Регистрация
	<a class="close" href="#" onclick="return parent.hs.close()"></a>
</div>
<div class="form_dialog">
<form method="post" action="/registration/registration/" id="simpleform">
	<?/*if(isset($_GET['ask'])):?><span style="">Создание новоко</span><?endif*/?>
	<table class="default dialog_table"><tbody>
		<tr>
			<td class="label">Имя:</td>
			<td>
				<input type="text" class="text required" name="fname" value="<?=$_SESSION['info']['fname']?>">
			</td>
		</tr>
		<tr>
			<td class="label">Фамилия:</td>
			<td>
				<input type="text" class="text required" name="lname" value="<?=$_SESSION['info']['lname']?>">
			</td>
		</tr>
		<tr>
			<td class="label">Ваш e-mail:</td>
			<td>
				<?if($_GET['error']['email']):?>
					<input type="text" class="text no_valid" name="login">
					<div class="no_valid_text">Этот e-mail зарегистрирован.</div>
				<?else:?>
					<input type="text" class="text required" name="email" value="<?=$_SESSION['info']['email']?>" />
				<?endif?>
			</td>
		</tr>
		<tr>
			<td class="label">Пароль:</td>
			<td><input type="password" class="text required" id="pass" name="pass" value="" /></td>
		</tr>
		<tr class="last">
			<td class="label">Повторите пароль:</td>
			<td><input type="password" class="text required" id="pass2" name="pass2" value="" /></td>
		</tr>
		<tr>
			<td></td>
			<td align="right"><br />
				<span class="is_button right_top_corner" onclick="return checkForm();" style="margin-right: 15px;">Зарегистрироваться<span></span></span>
			</td>
		</tr>
	</tbody></table>
</form>
<script>
	function checkForm(){
		var f=0;
		$('#simpleform .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','solid 1px red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		if($('#pass').val()!=$('#pass2').val() || jQuery.trim($('#pass').val())==''){	
			$('#pass').css('border','solid 1px red');
			$('#pass2').css('border','solid 1px red');
			f=1;
		}else{
			$('#pass').css('border','');
			$('#pass2').css('border','');
		}
		if(f==1){
			 return false;
		}else{
			$('#simpleform').submit();
		}
	}
</script>