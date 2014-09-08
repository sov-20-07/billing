<div class="filter see_goods">
	<?=$title?>
	<select name="<?=$name?>" id="shselect" onchange="shcatalog(this)">
		<option value="all">все</option>
		<?foreach($list as $key=>$item):?>
			<option value="<?=$item?>" <?if($_GET[$name]==$item):?>selected<?endif?>><?=$item?></option>
		<?endforeach?>
	</select>
</div>