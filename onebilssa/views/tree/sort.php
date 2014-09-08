<table class="spisok" width="100%" cellspacing="0" cellpadding="0" tab="tree">
	<?foreach($tree as $item):?>
		<tr width="100%" id="row<?=$item['id']?>">
			<td width="100%" style="padding-left:<?=$item['left']*10?>px">
				<?=$item['name']?>
				<span class="sortTree mover" ids="<?=$item['id']?>" tab="tree">&nbsp;&nbsp;&nbsp;</span>
			</td>
		</tr>
	<?endforeach?>
</table>