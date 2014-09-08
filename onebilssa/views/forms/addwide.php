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
							<input type="text" name="name" class="text" value="<?=$lang['name']?>" />
						</td>
					</tr>
					<tr>
						<td class="form_param">Значение</td>
						<td class="form_field">
							<input type="text" name="value" class="text" value="<?=$lang['value']?>" />
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<br />
	<input type="hidden" name="id" value="<?=$lang['id']?>" />
	<center><input type="submit" class="button save" value="Сохранить"></center>
	<br />
</form>
<br /><br /><br /><br />