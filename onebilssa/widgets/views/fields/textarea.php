<li class="edit_form_section edit_form_section_description">
	<?=View::widget('fields/addtd')?>
	<header class="edit_form_section_header">
		<?if($name):?>
			<strong><?=$name?></strong>
		<?else:?>
			<div class="new-field_layout">
				<span class="new-field_name">Имя поля</span>
				<input type="text" class="input_text" onfocus="$(this).next().fadeIn(400);" onblur="$(this).next().fadeOut(400);" onkeyup="keypressMe($(this))" />
				<div style="position:absolute;display:none;background: #FFFFFF;border:1px solid #999999;padding:3px;">
					<?foreach($select as $item):?>
						<a href="javascript:;" onclick="selectMe($(this))"><?=$item?></a><br />
					<?endforeach?>
				</div>
			</div>
		<?endif?>
	</header>
	<div class="ckeditor_layout">
		<div class="input_text_holder"><textarea class="input_text sethere" name="data[<?=$path?>]"><?=$value?></textarea></div>
		<input type="hidden" class="text" value="text" name="fieldtypes[]">
	</div>
</li>