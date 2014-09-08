<div class="right-block-content" >
	<h1>Авторизация</h1>
	<?if($_SESSION['info']):?>
		<p>Для добавления аккаунта к вашей учетной записи введите email и пароль</p>
	<?endif?>
	<?if(isset($_GET['error'])):?>
		<p style="color:#FF0000">Неправильно введена пара логин и пароль</p>
	<?endif?>
	<form method="post" action="/registration/login/" id="simpleform">
		<table class="cabinet noborder ">
			<tr>
				<td>Email</td>
				<td><input class="text change-input required" type="text" name="email" value="<?=$iuser['email']?>" /></td>
			</tr>
			<tr>
				<td>Пароль</td>
				<td><input class="text change-input required" type="password" id="pass" name="pass" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><a href="javascript:;" onclick="return checkForm();" class="login-button" style="margin-top: 15px;margin-bottom: 10px;"></a><br></td>
			</tr>
		</table>
		
	</form>
</div>
<div class="left-block-content">
	<?BannersWidget::run()?>
</div>
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
		if(f==1){
			 return false;
		}else{
			$('#simpleform').submit();
		}
	}
</script>