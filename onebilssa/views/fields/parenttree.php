<select name="parent" class="select_wide-tree">
<?foreach($tree as $item):?>
	<?if($_GET['id']!=$item['id']):?>
		<option value="<?=$item['id']?>" <?if($_GET['parent']==$item['id']):?>selected<?endif?>><?=$item['name']?></option>
		<?if(count($item['sub'])>0):?>
			<?=View::getRenderEmpty('fields/parentbranch',array('tree'=>$item['sub'],'left'=>1))?>
		<?endif?>
	<?endif?>
<?endforeach?>
</select>