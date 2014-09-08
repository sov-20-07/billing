<?if(count($list)>0):?>
	<div class="filter price">
		Тип
		<div class="manufacturers_list">
			<div class="ul_pos"><ul>
			<?foreach($list as $id=>$item):?>
				<li><label><input type="checkbox" name="in[]" value="<?=$item['id']?>" <?if(is_array($_GET['in'])):?><?if(in_array($item['id'],$_GET['in'])):?>checked<?endif?><?endif?> /><?=$item['name']?></label></li>
			<?endforeach?>
			</ul></div>
		</div>
		<br />
	</div>
<?endif?>