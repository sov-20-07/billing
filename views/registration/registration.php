<div class="right-block-content" >
	<?CrumbsWidget::run()?>
	<h1><?=$name?></h1>
	<form method="post" action="/registration/registration/" id="simpleform">
		<table class="cabinet noborder ">
			<tr>
				<td>Контактное лицо</td>
				<td><input class="text change-input required" type="text" name="name" value="<?=$iuser['name']?>" /></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input class="text change-input required" type="text" name="email" value="<?=$iuser['email']?>" /></td>
			</tr>
			<tr>
				<td>Контактный телефон</td>
				<td><input class="text change-input required" type="text" name="phone" /></td>
			</tr>
			<tr>
				<td>Адрес</td>
				<td><input class="text change-input required" type="text" name="address" /></td>
			</tr>
			<tr>
				<td>Новый пароль</td>
				<td><input class="text change-input" type="password" id="pass" name="pass" /></td>
			</tr>
			<tr>
				<td>Новый пароль еще раз</td>
				<td><input class="text change-input" type="password" id="pass2" name="pass2" /></td>
			</tr>
		</table>
		<a href="javascript:;" onclick="return checkForm();" class="save-data" style="margin-top: 15px;margin-bottom: 10px;"></a><br>
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