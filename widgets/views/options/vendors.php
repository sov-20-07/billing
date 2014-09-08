<?if(count($list)>0):?>
	<div class="filter manufacturer">
		Производитель
		<div class="manufacturers_list">
			<div class="ul_pos"><ul>
			<?foreach($list as $id=>$item):?>
				<li><label><input type="checkbox" name="ve[]" value="<?=$item['id']?>" <?if(is_array($_GET['ve'])):?><?if(in_array($item['id'],$_GET['ve'])):?>checked<?endif?><?endif?> /><?=$item['name']?></label></li>
			<?endforeach?>
			</ul></div>
		</div><br />
	</div>
<?endif?>