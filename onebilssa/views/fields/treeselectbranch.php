<ul class="treeselect_list" style="display:none;">
<?foreach($sub as $item):?>
	<li class="treeselect_item">
		<div class="treeselect_branch_header jsBranchHeader">
			<input type="checkbox" name="data[<?=$path?>][]" value="<?=$item['value']?>" <?=$item['checked']?>>
			<span class="treeselect_branch_toggle <?if(count($item['sub'])>0):?>jsBranchToggle treeselect_branch_toggle_hover<?endif?> <?if($item['gal'][0]['path']):?>imgover<?endif?>"> 
				<span class="treeselect_label"><?=$item['name']?></span> <?if($item['admin']):?>(<?=$item['admin']?>)<?endif?>
				<?if($item['gal'][0]['path']):?><img src="/of/<?=$item['gal'][0]['path']?>?h=100&w=100&c=1" /><?endif?> 
			</span>
		</div>
		<?=View::getRenderEmpty('fields/treeselectbranch',$item)?>
	</li>
<?endforeach?>
</ul>