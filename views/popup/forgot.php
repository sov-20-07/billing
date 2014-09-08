<div class="head2 nopadding">Вход на сайт
	<a class="close" href="#" onclick="return parent.hs.close()"></a>
</div>
<div class="form_dialog">
<form method="post" action="/registration/forgot/" id="simpleform">
	<table class="default dialog_table"><tbody>
		<tr>
			<td class="label">Ваш e-mail:</td>
			<td><input type="text" class="text required" name="email" value="" /></td>
		</tr>
		<tr>
			<td></td>
			<td align="right">
				<span class="is_button right_top_corner" onclick="return checkForm();" style="margin-right: 15px;">отправить<span></span></span>
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