<div class="head2 nopadding">Сменить фото
	<a class="close" href="#" onclick="return parent.hs.close()"></a>
</div>
<div class="form_dialog">
<form method="post" action="/popup/avatarsave/" id="simpleform" enctype="multipart/form-data">
	<table class="default dialog_table"><tbody>
		<tr>
			<td class="label"><?if($_SESSION['iuser']['avatar']):?><img src="<?=$_SESSION['iuser']['avatar']?>" /><?else:?><img src="/i/no_photo80.jpg" /><?endif?></td>
			<td class="label">
				Загрузить фото (80x80):<br />
				<input type="file" name="upload" /><br />
				<input type="submit" value="Загрузить">
			</td>
		</tr>
		<tr>
			<td><a href="/popup/avatardel/">удалить [X]</a></td>
			<td></td>
		</tr>
	</tbody></table>
</form>