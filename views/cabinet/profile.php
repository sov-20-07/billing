<div class="right-block-content" >
	<h1><?=$name?></h1>
	<form method="post" action="/cabinet/profilesave/" id="profile">
		<?if($_SESSION['iuser']['role']==''):?>
			<table class="cabinet noborder ">
				<tr>
					<td>Контактное лицо</td>
					<td><input class="text change-input required" type="text" name="name" value="<?=$_SESSION['iuser']['name']?>" /></td>
				</tr>
				<tr>
					<td>Контактный телефон</td>
					<td><input class="text change-input required" type="text" name="phone" value="<?=$_SESSION['iuser']['phone']?>" /></td>
				</tr>
				<tr>
					<td>Адрес</td>
					<td><input class="text change-input required" type="text" name="address" value="<?=$_SESSION['iuser']['address']?>" style="width:400px;" /></td>
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
		<a href="javascript:;" onclick="return checkFormProfile();" class="save-data" style="margin-top: 15px;margin-bottom: 10px;"></a><br>
	</form>
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
<script>
	function checkFormProfile(){
		var f=0;
		$('#profile .required').each(function(){
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
			$('#profile').submit();
		}
	}
</script>