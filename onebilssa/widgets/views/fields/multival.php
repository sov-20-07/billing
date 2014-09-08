<li class="edit_form_section edit_form_section_other clearfix">
	<?=View::widget('fields/addtd')?>
	<table class="edit_form_table">
		<tr>
			<td><?=$name?></td>
			<td>
				<ul class="edit_form_multiselect edit_form_multival">
				<?foreach($list as $key=>$item):?>
					<li>
						<label onclick="if($(this).find('input').prop('checked')==false){$('.multival<?=$key?>').prop('disabled',false);}else{$('.multival<?=$key?>').prop('disabled',true);}" class="form_label jsPreviewToggle" <?if($item['gal'][0]['path']):?>data-src="/of/<?=$item['gal'][0]['path']?>?h=100&w=100&c=1"<?endif?>>
							<input type="checkbox" name="data[<?=$path?>][]" value="<?=$item['value']?>" <?=$item['checked']?>><span class="form_label_text"><?=$item['name']?></span>
						</label>
						<div class="multival_inputs">
							<div class="input_text_holder"><input type="text" class="input_text multival<?=$key?>" name="multival[<?=$path?>][]" value="<?=$item['multival'][1]?>" <?if(!$item['checked']):?>disabled<?endif?>></div>
							<div class="input_text_holder"><input type="text" class="input_text multival<?=$key?>" name="multival[<?=$path?>][]" value="<?=$item['multival'][2]?>" <?if(!$item['checked']):?>disabled<?endif?>></div>
							<div class="input_text_holder"><input type="text" class="input_text multival<?=$key?>" name="multival[<?=$path?>][]" value="<?=$item['multival'][3]?>" <?if(!$item['checked']):?>disabled<?endif?>></div>
						</div>
					</li>
				<?endforeach?>
				</ul>
				<input type="hidden" class="text" value="empty" name="data[<?=$path?>][]">
				<input type="hidden" class="text" value="multiselect" name="fieldtypes[]">
				<input type="hidden" class="text" value="<?=$id?>" name="fieldrelations[<?=$path?>]">
			</td>
		</tr>
	</table>
</li>