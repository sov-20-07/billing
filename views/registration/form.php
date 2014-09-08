<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
	</div></div>
	<div id="right_part">
		<div class="head1">Регистрация</div>
		<p>Здравствуйте, <?if($_SESSION['info']['name']['full_name']):?><?=$_SESSION['info']['name']['full_name']?><?else:?><?=$_SESSION['info']['name']['first_name']?> <?=$_SESSION['info']['name']['last_name']?><?endif?>!</p>
		<p>Вы еще не зарегистрированы или вошли под другим аккаунтом.</p>
		<p>Укажите адрес электронной почты, для создания новой учетной записи или объединения с уже существующи аккаунтом.</p>
		<p>После отправки на указанный Вами адрес электронной почты придет уведомление о регистрации.</p>
		<p>Пароль вы сможете изменить в личном кабинете.</p>
		<form method="post" action="/registration/account/" id="simpleform">
			<table class="default dialog_table"><tbody>
				<tr>
					<td class="label">Логин:</td>
					<td>
						<?if($_GET['error']['login']):?>
							<input type="text" class="text required no_valid" name="login">
							<div class="no_valid_text">Этот логин занят. Попробуйте ввести другой.</div>
						<?else:?>
							<input type="text" class="text required" name="login" value="<?=$_SESSION['info']['nickname']?>">
						<?endif?>
					</td>
				</tr>
				<tr>
					<td class="label">Ваш e-mail:</td>
					<td>
						<?if($_GET['error']['email']):?>
							<input type="text" class="text no_valid" name="login">
							<div class="no_valid_text">Этот e-mail зарегистрирован.</div>
						<?else:?>
							<input type="text" class="text required" name="email" value="" />
						<?endif?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<input type="image" class="input" src="/i/input.png" onclick="return checkForm()">
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
		<br clear="all" />
	</div>
</div>