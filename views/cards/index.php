<div class="fixed_width" id="content">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<?=$fields['fulltext']?>
		<?if($_SESSION['iuser']):?>
			<a class="is_button right_top_corner" href="/services/cards/choose/">оформить подарочную карту<span></span></a>
		<?endif?>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>