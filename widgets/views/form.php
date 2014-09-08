<div class="border_top">
	<h2><?=$name?></h2>
	<form method="<?=$method?>" class="<?=$formclass?>" id="oneform<?=$id?>" onsubmit="return checkoneform<?=$id?>()" action="<?=$action==''?'/form/'.$id.'/':$action?>">
		{content}
		<?/* ?><label class="i_agree"><input type="checkbox" onchange="if($(this).attr('checked')=='checked'){$('#sbmt1').attr('disabled',false)}else{$('#sbmt1').attr('disabled',true)}" />Я соглашаюсь на хранение и обработку моих персональных данных, необходимых для выполнения заказов</label><?*/?>
		<input type="submit" value="Отправить сообщение" class="is_button is_button2 with_shadow" id="sbmt<?=$id?>" />
		<input type="hidden" name="theme" value="<?=$theme?>" />
		<input type="hidden" name="redirect" value="<?=$redirect?>" />
	</form>
</div>
<script>
	function checkoneform<?=$id?>(){
		var f=0;
		$('#oneform<?=$id?> .required').each(function(){
			if (jQuery.trim($(this).val())==''){
				$(this).css('border','solid 1px red');
				f=1;
			}else{
				$(this).css('border','');
			}
		});
		if (f==1){
			 return false;
		}else return true;
	}
</script>