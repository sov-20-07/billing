<h3><?=$title?></h3>
<form enctype="multipart/form-data" method="post" action="/<?=Funcs::$cdir?>/<?=Funcs::$uri[1]?>/<?=$formpath?>/" id="frm">
	<div class="error"></div>
	<div id="frm">
		<div id="slider0" class="slider">
			<table id="workingset" width="100%">
				<tbody>
					<tr>
						<td class="form_param">Название</td>
						<td class="form_field">
							<input type="text" name="name" class="text" value="<?=$name?>" />
						</td>
					</tr>
					<tr>
						<td class="form_param">Путь</td>
						<td class="form_field">
							<input type="text" name="path" class="text" value="<?=$path?>" />
						</td>
					</tr>
					<tr>
						<td class="form_param">Сообщение</td>
						<td class="form_field">
							<textarea name="value" style="width:100%;height:100px;"><?=$value?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<br />
	<input type="hidden" name="id" value="<?=$id?>" />
	<input type="hidden" name="parent" value="<?=$parent?>" />
	<center><input type="submit" class="button save" value="Сохранить"></center>
	<br />
</form>
<br /><br /><br /><br />