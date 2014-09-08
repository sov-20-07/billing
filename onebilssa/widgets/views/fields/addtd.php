<div class="edit_form_section_options">
	<span onclick="if(confirm('Удалить объект?')){$(this).parent().parent().detach();};return false;" class="icon_remove"></span>
	<?if(Funcs::$prop['fieldsort']==0):?>
		<span class="icon_move jsMoveDrag"></span>
	<?endif?>
	<input type="hidden" class="text" value="<?=$id?>" name="fieldid[]">
</div>