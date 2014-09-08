<li class="edit_form_section edit_form_section_description jsMoveFixed">
	<?=View::widget('fields/addtd')?>
	<header class="edit_form_section_header">
		<?if($name):?>
			<strong><?=$name?></strong>
		<?else:?>
			<div class="new-field_layout">
				<span class="new-field_name">Имя поля</span>
				<input type="text" class="input_text" onfocus="$(this).next().fadeIn(400);" onblur="$(this).next().fadeOut(400);" onkeyup="keypressEditor($(this))" />
				<div style="position:absolute;display:none;background: #FFFFFF;border:1px solid #999999;padding:3px;">
					<?foreach($select as $item):?>
						<a href="javascript:;" onclick="selectEditor($(this))"><?=$item?></a><br />
					<?endforeach?>
				</div>
			</div>
		<?endif?>
	</header>
	<div class="ckeditor_layout">
		<textarea class="ckeditor_textarea input_text sethere" name="data[<?=$path?>]" id="data_<?=Funcs::Transliterate($path)?>"><?=$value?></textarea>
		<input type="hidden" class="text" value="editor" name="fieldtypes[]">
	</div>
	<script language="javascript">
		$(document).ready( function(){	
			initEditor($("#data_<?=Funcs::Transliterate($path)?>"));
		});
	</script>
</li>