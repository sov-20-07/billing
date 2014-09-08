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
						<td class="form_param">Расписание</td>
						<td class="form_field">
							<table>
								<tr>
									<th>мин</th>
									<th>час</th>
									<th>день</th>
									<th>месяц</th>
									<th>дни нед.</th>
								</tr>
								<tr>
									<td><input type="text" name="timing[]" value="<?=$timing[0]?>" size="6" /></td>
									<td><input type="text" name="timing[]" value="<?=$timing[1]?>" size="6" /></td>
									<td><input type="text" name="timing[]" value="<?=$timing[2]?>" size="6" /></td>
									<td><input type="text" name="timing[]" value="<?=$timing[3]?>" size="6" /></td>
									<td><input type="text" name="timing[]" value="<?=$timing[4]?>" size="6" /></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="form_param">Комментарий</td>
						<td class="form_field">
							<textarea name="comment" style="width:100%;height:100px;"><?=$comment?></textarea>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<br />
	<input type="hidden" name="id" value="<?=$id?>" />
	<center><input type="submit" class="button save" value="Сохранить"></center>
	<br />
</form>
<br />
<div style="background: #f9dcc7;padding: 10px;">
	<h3>Информация</h3>
	23 */2 * * * //Выполняется в 0:23, 2:23, 4:23 и т. д.<br />
	5 4 * * 7 //Выполняется в 4:05 в воскресенье<br />
	0 0 1 1 * //С новым годом!<br />
	15 10,13 * * 1,4 //Эта надпись выводится в понедельник и четверг в 10:15 и 13:15<br />
	*/5 * * * * //каждые 5 минут<br />
</div>
<br /><br /><br />