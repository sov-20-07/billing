<div class="filter manufacturer">
	<?=$title?>
	<div class="manufacturers_list">
		<div class="ul_pos"><ul>
		<?foreach($list as $id=>$item):?>
			<li><label><input type="checkbox" name="<?=$name?>[]" value="<?=$item?>" <?if(is_array($_GET[$name])):?><?if(in_array($item,$_GET[$name])):?>checked<?endif?><?endif?> /><?=$item?></label></li>
		<?endforeach?>
		</ul></div>
	</div><br />
</div>