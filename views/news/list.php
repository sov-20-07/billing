<div class="right-block-content">
    <?CrumbsWidget::run()?>
	<h1><?=$name?></h1>
	<div class="news">
		<?foreach($list as $item):?>
		<div class="one-new">
			<span class="date"><?=Funcs::convertDate($item['udate'])?></span><br/>
			<a href="<?=$item['path']?>"><?=$item['name']?></a>
		</div>
		<?endforeach?>
	</div>
	<?PaginationWidget::run()?>
</div>
<div class="left-block-content">
	<?MenuWidget::LeftMenu()?>
	<?BannersWidget::run()?>
</div>