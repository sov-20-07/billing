<div class="head1">Авторизация</div>
<p>Пройдите авторизацию или зарегистрируйте нового пользователя для выбора оплаты и доставки товара.</p>
<div class="head2 nopadding">Вход на сайт</div>
<div class="form_dialog">
	<form method="post" action="/registration/login/?oid=<?=$_GET['oid']?>" id="simpleform">
		<?if($_GET['error']=='yes'):?><span style="color:#FF0000;">Неправильный email и/или пароль</span><?endif?>
		<table class="default dialog_table"><tbody>
			<tr>
				<td class="label">Ваш логин или e-mail:</td>
				<td><input type="text" class="text required" name="email" value="<?=$row['EMAIL']?>" style="width:200px;" /></td>
			</tr>
			<tr class="last">
				<td class="label">Ваш пароль:</td>
				<td><input type="password" class="text required" name="pass" value="" style="width:200px;"  /></td>
			</tr>
			<tr>
				<td></td>
				<td align="right"><input type="image" class="input" src="/i/input.png" onclick="return checkForm();"></td>
			</tr>
			<tr>
				<td colspan="2">
					<span class="help"><a href="/payment/forgot/" style="margin-right:20px;">Забыли пароль?</a><a href="/payment/registration/">Зарегистрируйтесь</a></span>
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
			if(f==1){
				 return false;
			}else{
				$('#simpleform').submit();
			}
		}
	</script>
	<div class="socila_input">
		<div class="label">Войдите через один из следующих сайтов:</div><br />
		<script src="//loginza.ru/js/widget.js" type="text/javascript"></script>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/?oid='.$_GET['oid'])?>&provider=vkontakte" onclick="return openLoginza($(this))"><img src="/i/icons/vk.jpg" /></a>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/?oid='.$_GET['oid'])?>&provider=facebook" onclick="return openLoginza($(this))"><img src="/i/icons/face.jpg" /></a>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/?oid='.$_GET['oid'])?>&provider=twitter" onclick="return openLoginza($(this))"><img src="/i/icons/tw.jpg" /></a>
		<a href="https://loginza.ru/api/widget?token_url=<?=urlencode('http://'.$_SERVER['HTTP_HOST'].'/registration/login/?oid='.$_GET['oid'])?>&provider=google" onclick="return openLoginza($(this))"><img src="/i/icons/google.jpg" /></a>
		<script>
			function openLoginza(obj){
				window.open(obj.attr('href'),'','width=500,height=500');
				return false;
			}
		</script>
	</div>
</div>