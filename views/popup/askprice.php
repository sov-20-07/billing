<div class="head2 nopadding">На продажу
	<a class="close" href="#" onclick="return parent.hs.close()"></a>
</div>
<div class="form_dialog">
	<b><?=$name?></b><br />
	Цена печати: <b><?=$price?> руб.</b><br /><br />
	<form method="post" action="/popup/setaskprice/" id="simpleform">
		<table class="default dialog_table"><tbody>
			<tr>
				<td class="label" style="vertical-align: top;">Ваша цена:</td>
				<td>
					<input type="text" class="required" name="supprice" style="width:270px;" value="<?=$supprice?>" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="hidden" name="id" value="<?=$_GET['id']?>">
					<a class="is_button right_top_corner" href="javascript:;" onclick="checkForm()"><span></span>Выставить на продажу</a>
				</td>
			</tr>
		</tbody></table>
	</form>
	<script>
		function checkForm(){
			var f=0;
			$('#simpleform .required').each(function(){
				if (jQuery.trim($(this).val())=='' || jQuery.trim($(this).val())=='0'){
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
</div>