<ul class="edit_form_multiselect" style="margin-left: <?=$left*10?>px;">
	<?foreach($tree as $item):?>
		<?if(isset($user)):?>
			<li style="margin-left: <?=$item['left']*10?>px;">
				<label class="form_label jsPreviewToggle" style="margin-left: <?=$item['left']*10?>px;">
					<input type="checkbox" name="tree[]" value="<?=$item['id']?>" <?if(in_array($item['id'],$user['access']['tree'])):?>checked<?endif?> /><span class="form_label_text"><?=$item['name']?></span>
				</label>
				<?if(count($item['sub'])>0):?>
					<?=View::getRenderEmpty('user/labeltree',array('tree'=>$item['sub'],'left'=>$left+1,'user'=>$user))?>
				<?endif?>
			</li>
		<?else:?>
			<li>
				<label class="form_label jsPreviewToggle">
					<input type="checkbox" name="tree[]" value="<?=$item['id']?>" <?if(in_array($item['id'],$group['access']['tree'])):?>checked<?endif?> /><span class="form_label_text"><?=$item['name']?></span>
				</label>
				<?if(count($item['sub'])>0):?>
					<?=View::getRenderEmpty('user/labeltree',array('tree'=>$item['sub'],'left'=>$left+1,'group'=>$group))?>
				<?endif?>
			</li>
		<?endif?>
	<?endforeach?>
</ul>