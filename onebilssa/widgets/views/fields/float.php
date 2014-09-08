<li class="edit_form_section edit_form_section_other">
	<?=View::widget('fields/addtd')?>
	<table class="edit_form_table">
		<tr>
			<td>
				<?if($name):?>
					<?=$name?>
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
			</td>
			<td>
				<div class="input_text_holder small">
					<input class="input_text sethere" value="<?=$value?>" name="data[<?=$path?>]" onblur="checknumfloat(this)" />
					<input type="hidden" class="text" value="float" name="fieldtypes[]" />
				</div>
			</td>
		</tr>
	</table>
</li>