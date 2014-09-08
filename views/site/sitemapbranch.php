<ul>
	<?foreach($sub as $item):?>
		<li>
			<a href="<?=$item['path']?>"><?=$item['name']?> (<?=$item['path']?>)</a>
			<?if(count($item['sub'])>0):?>	
				<?=View::getRenderEmpty('site/sitemapbranch',array('sub'=>$item['sub'],'i'=>$i+1))?>
			<?endif?>				
		</li>
	<?endforeach?>
</ul>