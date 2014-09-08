<div class="head2 nopadding">Причина отказа
	<a class="close" href="#" onclick="return parent.hs.close()"></a>
</div>
<div class="form_dialog">
<form method="post" action="/popup/setreject/" id="simpleform">
	<table class="default dialog_table"><tbody>
		<tr>
			<td class="label" style="vertical-align: top;">Причина отказа:</td>
			<td>
				<textarea type="text" class="required" name="rejected" style="height:150px;width:270px;"></textarea>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="hidden" name="id" value="<?=$_GET['id']?>" />
				<input type="hidden" name="act" value="<?=$_GET['act']?>" />
				<a class="is_button right_top_corner" href="javascript:;" onclick="checkForm()"><span></span>отклонить</a>
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