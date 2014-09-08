<div class="top-menu">
	<div class="wrap">
		<ul>
		<?foreach($list as $i=>$item):?>
			<?if($item['selected'] && $i<5):?>
				<li>
					<a href="<?=$item['path']?>" class="active"><span class="border">
						<span class="light"><?=$item['name']?><span class="light-right"></span></span>
					</span></a>
					<span class="hover"></span>
				</li>
			<?else:?>
				<li>
					<a href="<?=$item['path']?>"><span class="border">
						<span class="light"><?=$item['name']?><span class="light-right"></span></span>
					</span></a>
					<span class="hover"></span>
				</li>
			<?endif?>
		<?endforeach?>
		</ul>
		<div class="more">
			<div class="more-box">
				<div class="top"></div>
				<?foreach($list as $i=>$item):?>
					<?if($i>4):?><a href="<?=$item['path']?>"><?=$item['name']?></a><?endif?>
				<?endforeach?>
			</div>
		</div>
	</div>
</div>

<?/* ?>
<div class="head-menu">
	<ul>
		<li class="catalog-list">
			<div class="first">
				<span>Все категории</span>
				<div class="list-category" style="clear: both;">
					<ul>
					<?foreach($list as $i=>$item):?>
						<?if(count($item['sub'])>0):?>
							<li><div class="second">
								<a href="<?=$item['path']?>"><span><?=$item['name']?></span></a>
								<div class="list-category-second">
									<ul>
									<?foreach($item['sub'] as $sub):?>
										<li><a href="<?=$sub['path']?>"><span><?=$sub['name']?></span></a></li>
									<?endforeach?>
									</ul>
								</div>
							</div></li>
						<?else:?>
							<li><a href="<?=$item['path']?>"><span><?=$item['name']?></span></a></li>
						<?endif?>
					<?endforeach?>
					</ul>
				</div>
			</div>
		</li>
		<?foreach(Funcs::$reference['catalogmenu'] as $item):?>
			<li><a href="<?=$item['path']?>"><?=$item['name']?></a></li>
		<?endforeach?>
	</ul>
</div>
<?*/?>