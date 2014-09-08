<div class="right-block-content">
	<?CrumbsWidget::run()?>
	<h1>Поиск</h1>
	<?if(count($list)>0):?>
		<h4>Результаты поиска (<?=count($list)?>)</h4><br />
		<ul>
		<?foreach($list as $key=>$item):?>
			<li><b><a href="<?=$item['path']?>"><?=$item['name']?></a></b><br /></li>
		<?endforeach?>
		</ul>
	<?else:?>
		<div class="head2"><h2>Результаты поиска</h2></div>
		<div class="inline_block">
			<p>Ничего не найдено</p>
		</div>
	<?endif?>
</div>
<div class="left-block-content">
	<?MenuWidget::LeftMenu()?>
	<?BannersWidget::run()?>
</div>