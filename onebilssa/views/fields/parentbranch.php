<?foreach($tree as $item):?>
	<?if($_GET['id']!=$item['id']):?>
		<option value="<?=$item['id']?>" <?if($_GET['parent']==$item['id']):?>selected<?endif?>><?=str_repeat('&nbsp;',$left*3)?><?=$item['name']?></option>
		<?if(count($item['sub'])>0):?>
			<?=View::getRenderEmpty('fields/parentbranch',array('tree'=>$item['sub'],'left'=>$left+1))?>
		<?endif?>
	<?endif?>
<?endforeach?>