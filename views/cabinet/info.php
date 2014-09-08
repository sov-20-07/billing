<div class="right-block-content" >
	<h1>Личный кабинет</h1>
	<?if($_SESSION['iuser']['role']==''):?>
		<table class="cabinet noborder ">
			<tr>
				 <td>Имя</td>
				 <td><b><?=$_SESSION['iuser']['name']?></b></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><b><?=$_SESSION['iuser']['email']?></b></td>
			</tr>
			<tr>
				<td>Контактный телефон</td>
				<td><b><?=$_SESSION['iuser']['phone']?></b></td>
			</tr>
			<tr>
				<td>Адрес</td>
				<td><b><?=$_SESSION['iuser']['address']?></b></td>
			</tr>
		</table>
	<?else:?>
		<table class="cabinet noborder ">
			<tr>
				 <td>Название компании</td>
				 <td><b><?=$_SESSION['iuser']['comapny']?></b></td>
			</tr>
			<tr>
				<td>Контактное лицо</td>
				<td><b><?=$_SESSION['iuser']['name']?></b></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><b><?=$_SESSION['iuser']['email']?></b></td>
			</tr>
			<tr>
				<td>Контактный телефон</td>
				<td><b><?=$_SESSION['iuser']['phone']?></b></td>
			</tr>
			 <tr>
				<td>Адрес</td>
				<td><b><?=$_SESSION['iuser']['address']?></b></td>
			</tr>
		</table>
	<?endif?>
	<a href="/cabinet/profile/" class="change-data" style="margin-top: 15px;margin-bottom: 10px;"></a><br>
	<span class="viewed in-block dotted" onclick="$('.change-pass').fadeToggle(200)">Быстрая смена пароля</span>
	<div class="change-pass">
		<form method="post" action="/registration/setpass/" id="chpass">
			<table class="cabinet noborder ">
				<?/* ?>
					<tr>
						<td>Старый пароль</td>
						<td><input class="text required" type="password" id="oldpass" name="oldpass"></td>
					</tr>
				<?*/?>
				<tr>
					<td>Новый пароль</td>
					<td><input class="text required" type="password" id="pass" name="pass"></td>
				</tr>
				<tr>
					<td>Новый пароль еще раз</td>
					<td><input class="text required" type="password" id="pass2" name="pass2"></td>
				</tr>
			</table>
		</form>
		<a href="javascript:;" onclick="return checkFormChpass()" class="save-pas" style="margin-top: 15px;"></a><br>
		<script>
			function checkFormChpass(){
				var f=0;
				$('#chpass .required').each(function(){
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
					$('#chpass').submit();
				}
			}
		</script>
	</div>
</div>
<div class="left-block-content">
	<div class="left-content">
		<div class="logined">
			Здравствуйте,<br/>
			<b style="font-size: 15px;"><?=$_SESSION['iuser']['name']?></b><br/>
			<a href="/registration/logout/" class="exit"></a>
		</div>
		<?MenuWidget::CabinetMenu();?>
	</div>
</div>