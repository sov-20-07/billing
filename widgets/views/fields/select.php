<div class="field_block">
	<div class="field_name"><?=$name?></div>
	<div class="field">
		<select class="with_back" name="<?=$path?>">
			<?if($required==''):?>
				<option value="">Выберите категорию сообщения</option>
			<?endif?>
			<?foreach($options as $item):?>
				<option value="<?=$item?>"><?=$item?></option>
			<?endforeach?>
		</select>
	</div>
</div>