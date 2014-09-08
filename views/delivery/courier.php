<div id="content" class="fixed_width">
	<div id="left_part"><div class="inner_block">
		<?MenuWidget::LeftMenu()?>
	</div></div>
	<div id="right_part">
		<div class="head1"><?=$name?></div>
		<div id="delivery">
			<div class="head">
				<a href="/delivery/calc/" class="bookmark">Почта России</a><span class="bookmark active" style="text-decoration: none">Доставка курьером</span><a href="/delivery/calc/" class="bookmark">Самовывоз</a>
			</div>
			<div class="city_block">
				<?=$fields['fulltext']?>
			</div>
		</div>
	</div>
	<?MenuWidget::BottomMenu()?>
	<br clear="all" />
</div>