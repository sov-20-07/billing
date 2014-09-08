<tr>
	<td><?=$name?></td>
	<td>
		<label class="form_label">
			<input type="radio" name="features[<?=$path?>]" <?if($value==1):?>checked<?endif?> value="1">Да
		</label>
		<label class="form_label">
			<input type="radio" name="features[<?=$path?>]" <?if($value==0 || $value==''):?>checked<?endif?> value="0">Нет
		</label>
		<input type="hidden" class="text" value="fcheckbox" name="featurestype[]">
		<input type="hidden" class="text" value="<?=$id?>" name="featuresid[]">
	</td>
</tr>