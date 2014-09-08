<li class="edit_form_section edit_form_section_other">
	<?=View::widget('fields/addtd')?>
	<table class="edit_form_table">
		<tr>
			<td><?=$name?></td>
			<td>
				<select class="jsSelectStyled" name="data[<?=$path?>]">
					<?if($required==0):?>
						<option value=""></option>
					<?endif?>
					<?foreach($list as $item):?>
						<option value="<?=$item['value']?>" <?=$item['selected']?>><?=$item['name']?></option>
					<?endforeach?>
				</select>
				<input type="hidden" class="text" value="select" name="fieldtypes[]">
			</td>
		</tr>
	</table>											
</li>