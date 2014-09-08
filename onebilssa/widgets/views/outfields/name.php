<tr>
	<td class="form_param"><?=$name?></td>
	<td class="form_field">
		<input type="text" class="text" value="<?=$value?>" name="data[<?=$path?>]">
		<input type="hidden" class="text" value="string" name="fieldtypes[]">
	</td>
	<td class="padd_5">
		<a title="удалить" onclick="if(confirm('Удалить объект?')){$(this).parent().parent().detach();};return false;" href="javascript:;"><img border="0" alt="удалить" src="/onessa/i/ic_trash.gif"></a>
		<div class="mover" src="/onessa/i/ic_move.gif" alt="Переместить" title="Переместить" style="cursor: move;"></div>
	</td>
</tr>