<div class="head2 nopadding">Сообщение
	<a class="close" href="#" onclick="return parent.hs.close()"></a>
</div>
<div class="form_dialog">
<form method="post" action="/popup/sendmessage/" id="simpleform">
	Введите текст:<br />
	<textarea type="text" class="required" name="message" style="width:415px;height:240px;"></textarea>
	<input type="hidden" name="touser" value="<?=$_GET['touser']?>" />
	<a class="is_button right_top_corner" href="javascript:;" onclick="checkForm()" style="float:right;margin-right: 20px;"><span></span>Отправить</a>
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