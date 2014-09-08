<table width="100%" cellspacing="0" cellpadding="0" tab="tree">
	<?foreach($list as $item):?>
		<tr width="100%" id="row<?=$item['id']?>">
			<td width="100%">
				<a href="<?=$item['path']?>"><?=$item['name']?></a>
			</td>
		</tr>
	<?endforeach?>
</table>