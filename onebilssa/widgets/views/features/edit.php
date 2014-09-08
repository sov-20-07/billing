<tr>
	<td>
		Группа:<br>
		<select class="jsSelectStyled" name="featuresgroup[<?=$num?>]">
			<option value="0">&nbsp;</option>
			<?foreach(Fields::getFeaturesGroups() as $item):?>
				<option value="<?=$item['id']?>" <?if($parent==$item['id']):?>selected<?endif?>><?=$item['name']?></option>
			<?endforeach?>
		</select>
	</td>
	<td>
		Имя поля:<br>
		<input type="text" class="input_text" name="featuresname[<?=$num?>]" value="<?=$name?>" />
	</td>
	<td>
		Алиас:<br>
		<input type="text" class="input_text" name="featurespath[<?=$num?>]" value="<?=$path?>" />
	</td>
	<td>
		Тип:<br />
		<select class="jsSelectStyled" name="featurestype[<?=$num?>]">
			<?foreach(Fields::$features as $key=>$item):?>
				<option value="<?=$item['path']?>" <?if($type==$key):?>selected<?endif?>><?=$item['name']?> (<?=$item['path']?>)</option>
			<?endforeach?>
		</select>
	</td>
	<td>
		Фильтр:<br />
		<input type="checkbox" class="input_text sethere" value="1" name="featuresfilter[<?=$num?>]" <?if($filter==1):?>checked<?endif?> />
	</td>
	<td>
		Вид фильтра:<br />
		<select class="jsSelectStyled" name="featuresfiltertype[<?=$num?>]">
			<option value="">&nbsp;</option>
			<?foreach(OneSSA::$filterTypes as $key=>$item):?>
				<option value="<?=$key?>" <?if($filtertype==$key):?>selected<?endif?>><?=$item['name']?></option>
			<?endforeach?>
		</select>
	</td>
	<td>
		Описание:<br />
		<textarea class="input_text" name="featurescomment[<?=$num?>]"><?=$comment?></textarea>
	</td>
	<td class="features_table_remove">
		<a class="icon_remove" title="Удалить" onclick="if(confirm('Удалить объект?')){$(this).parent().parent().detach();};resizeContent();return false;" href="javascript:;"></a>
		<div class="mover" src="/<?=Funcs::$cdir?>/i/ic_move.gif" alt="Переместить" title="Переместить" style="cursor: move;"></div>
		<input type="hidden" value="<?=$id?>" name="featuresid[<?=$num?>]" />
	</td>
</tr>