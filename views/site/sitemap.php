<div class="fixed_width">
	<?CrumbsWidget::Run()?>
	<div class="content producers">
		<h1><?=$name ?></h1>
		<?foreach($sitemap as $item):?>
			<h3><a href="<?=$item['path']?>"><?=$item['name']?> (<?=$item['path']?>)</a></h3>
			<?if(count($item['sub'])>0):?>	
				<?=View::getRenderEmpty('site/sitemapbranch',array('sub'=>$item['sub'],'i'=>1)) ?>
			<?endif?>
		<?endforeach?>
	</div>
</div>